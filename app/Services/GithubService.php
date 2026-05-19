<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;
class GithubService
{
    public function analyze($username)
    {
        if (!$username) return null;
        
        // Mocking GitHub API and AI analysis
        $response = Http::get("https://api.github.com/users/{$username}");
        
        if ($response->failed()) return null;
        
        $data = $response->json();
        
        // Mock AI analysis logic
        $score = min(100, ($data['public_repos'] * 5) + ($data['followers'] * 2));
        $summary = "Based on GitHub activity, this user has " . $data['public_repos'] . " public repositories and " . $data['followers'] . " followers. ";
        
        if ($score > 70) {
            $summary .= "Exceptional coding activity detected. Highly recommended for technical roles.";
        } elseif ($score > 40) {
            $summary .= "Moderate coding activity. Suitable for most development roles.";
        } else {
            $summary .= "Emerging developer with room for growth in public contributions.";
        }

        return [
            'username' => $username,
            'repos' => $data['public_repos'],
            'followers' => $data['followers'],
            'score' => $score,
            'summary' => $summary
        ];
    }
}
