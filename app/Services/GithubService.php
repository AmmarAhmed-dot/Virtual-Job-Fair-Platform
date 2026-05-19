<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class GithubService
{
    public function analyze($username, $token = null)
    {
        if (!$username) return null;

        $cacheKey = 'github_analysis_' . $username . '_' . md5($token ?? '');

        // Cache the analysis for 2 hours (7200 seconds) to avoid rate limits
        return Cache::remember($cacheKey, 7200, function () use ($username, $token) {
            $headers = [
                'Accept' => 'application/vnd.github+json',
                'User-Agent' => 'Laravel-Virtual-Job-Fair-Platform'
            ];

            if ($token) {
                $headers['Authorization'] = 'token ' . $token;
            }

            // 1. Fetch Profile info
            $profileResponse = Http::withHeaders($headers)->get("https://api.github.com/users/{$username}");
            if ($profileResponse->failed()) {
                return null;
            }
            $profile = $profileResponse->json();
            $followersCount = $profile['followers'] ?? 0;

            // 2. Fetch Repositories (if token provided, fetch user's repos to see private count)
            $reposUrl = $token 
                ? "https://api.github.com/user/repos?per_page=100&type=owner"
                : "https://api.github.com/users/{$username}/repos?per_page=100";

            $reposResponse = Http::withHeaders($headers)->get($reposUrl);
            
            $totalStars = 0;
            $totalForks = 0;
            $publicReposCount = 0;
            $privateReposCount = 0;
            $topLanguages = [];

            if ($reposResponse->successful()) {
                $repos = $reposResponse->json();
                if (is_array($repos)) {
                    foreach ($repos as $repo) {
                        $isPrivate = $repo['private'] ?? false;
                        if ($isPrivate) {
                            $privateReposCount++;
                        } else {
                            $publicReposCount++;
                        }

                        $totalStars += $repo['stargazers_count'] ?? 0;
                        $totalForks += $repo['forks_count'] ?? 0;

                        if (!empty($repo['language'])) {
                            $lang = $repo['language'];
                            $topLanguages[$lang] = ($topLanguages[$lang] ?? 0) + 1;
                        }
                    }
                }
            } else {
                // Fallback to profile counts if repos request fails
                $publicReposCount = $profile['public_repos'] ?? 0;
            }

            $reposCount = $publicReposCount + $privateReposCount;

            // 3. Fetch Contributions count (GraphQL with Token OR Scraping calendar fallback)
            $totalContributions = 0;
            $contributionsFetched = false;

            $createdAt = $profile['created_at'] ?? null;
            $startYear = $createdAt ? (int) date('Y', strtotime($createdAt)) : (int) date('Y');
            $endYear = (int) date('Y');
            // Cap at max 10 years back to prevent excessive requests
            $startYear = max($startYear, $endYear - 10);

            if ($token) {
                // Build dynamic GraphQL query with aliases for each year
                $aliasQueries = [];
                for ($y = $startYear; $y <= $endYear; $y++) {
                    $aliasQueries[] = "year{$y}: contributionsCollection(from: \"{$y}-01-01T00:00:00Z\", to: \"{$y}-12-31T23:59:59Z\") {
                        contributionCalendar {
                            totalContributions
                        }
                    }";
                }

                $queryStr = "query(\$username: String!) {
                    user(login: \$username) {
                        " . implode("\n                        ", $aliasQueries) . "
                    }
                }";

                // GraphQL API endpoint uses Bearer token authorization
                $graphqlResponse = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'User-Agent' => 'Laravel-Virtual-Job-Fair-Platform',
                    'Accept' => 'application/vnd.github+json'
                ])->post('https://api.github.com/graphql', [
                    'query' => $queryStr,
                    'variables' => ['username' => $username]
                ]);

                if ($graphqlResponse->successful()) {
                    $resData = $graphqlResponse->json();
                    if (isset($resData['data']['user'])) {
                        $totalContributions = 0;
                        foreach ($resData['data']['user'] as $yearData) {
                            $totalContributions += (int) ($yearData['contributionCalendar']['totalContributions'] ?? 0);
                        }
                        $contributionsFetched = true;
                    }
                }
            }

            if (!$contributionsFetched) {
                // Scrape fallback: loop and fetch public contributions calendar page for each year
                $totalContributions = 0;
                for ($y = $startYear; $y <= $endYear; $y++) {
                    $scrapeResponse = Http::withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
                    ])->get("https://github.com/users/{$username}/contributions?from={$y}-01-01&to={$y}-12-31");

                    if ($scrapeResponse->successful()) {
                        $html = $scrapeResponse->body();
                        if (preg_match('/([0-9,]+)\s+contributions/i', $html, $matches)) {
                            $totalContributions += (int) str_replace(',', '', $matches[1]);
                            $contributionsFetched = true;
                        }
                    }
                }
            }

            // Fallback Search APIs for commits and issues breakdown
            $totalCommits = 0;
            $commitsResponse = Http::withHeaders($headers)->get("https://api.github.com/search/commits", [
                'q' => "author:{$username}"
            ]);

            if ($commitsResponse->successful()) {
                $totalCommits = $commitsResponse->json()['total_count'] ?? 0;
            }

            $totalIssuesPrs = 0;
            $issuesResponse = Http::withHeaders($headers)->get("https://api.github.com/search/issues", [
                'q' => "author:{$username}"
            ]);

            if ($issuesResponse->successful()) {
                $totalIssuesPrs = $issuesResponse->json()['total_count'] ?? 0;
            }

            // If the scraped/GraphQL total contributions is somehow 0 or less than the REST API search sum,
            // fallback to the REST API sum.
            if ($totalContributions < ($totalCommits + $totalIssuesPrs)) {
                $totalContributions = $totalCommits + $totalIssuesPrs;
            }

            // 4. Compute real scoring algorithm (Max: 100)
            $contributionsScore = min(40, $totalContributions * 0.16); // max 40 points for 250+ contributions
            $reposScore = min(25, $reposCount * 2);       // max 25 points for 12+ repos
            $popularityScore = min(20, ($totalStars * 3) + ($totalForks * 2)); // max 20 points
            $followersScore = min(15, $followersCount * 1.5); // max 15 points for 10 followers

            $score = round($contributionsScore + $reposScore + $popularityScore + $followersScore);

            // Sort languages by count
            arsort($topLanguages);

            // 5. Generate Professional AI/Data-Driven Summary
            $summary = "Based on real GitHub profile analysis, this developer maintains {$reposCount} repositories";
            if ($token && $privateReposCount > 0) {
                $summary .= " (including {$privateReposCount} private repos)";
            }
            $summary .= " and has {$followersCount} followers. ";
            $summary .= "They have made a total of {$totalContributions} contributions ({$totalCommits} commits, {$totalIssuesPrs} PRs/issues) across tracked repositories. ";

            if (count($topLanguages) > 0) {
                $langsUsed = array_slice(array_keys($topLanguages), 0, 3);
                $summary .= "Their most used technologies are " . implode(', ', $langsUsed) . ". ";
            }

            if ($score >= 80) {
                $summary .= "This developer displays a stellar contribution record, exceptional coding frequency, and highly popular repositories.";
            } elseif ($score >= 50) {
                $summary .= "This developer shows consistent coding activity, healthy project counts, and solid programming experience.";
            } else {
                $summary .= "This is an emerging developer profile with active repositories and room to expand public/private code contributions.";
            }

            return [
                'username' => $username,
                'repos' => $reposCount,
                'public_repos' => $publicReposCount,
                'private_repos' => $privateReposCount,
                'followers' => $followersCount,
                'stars' => $totalStars,
                'forks' => $totalForks,
                'languages' => array_slice($topLanguages, 0, 3, true),
                'commits' => $totalCommits,
                'issues_prs' => $totalIssuesPrs,
                'contributions' => $totalContributions,
                'score' => $score,
                'summary' => $summary,
                'has_token' => !empty($token)
            ];
        });
    }
}
