<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\JobPosting;
use App\Models\Event;
use App\Models\JobApplication;
use App\Services\GithubService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(GithubService $githubService)
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $stats = [
                'total_users' => User::count(),
                'pending_jobs' => JobPosting::where('status', 'pending')->count(),
                'active_events' => Event::count(),
            ];
            return view('admin.dashboard', compact('stats'));
        } elseif ($user->role === 'institute') {
            $company = $user->company;
            $stats = [
                'my_jobs' => $company->jobPostings()->count(),
                'total_applicants' => JobApplication::whereIn('job_posting_id', $company->jobPostings()->pluck('id'))->count(),
                'scheduled_interviews' => JobApplication::whereIn('job_posting_id', $company->jobPostings()->pluck('id'))
                    ->where('status', 'interviewing')->count(),
            ];
            return view('institute.dashboard', compact('stats'));
        } else {
            $stats = [
                'my_applications' => $user->applications()->count(),
                'profile_completeness' => $user->cvData ? 100 : 20,
            ];
            
            $analysis = null;
            if ($user->cvData && $user->cvData->github_username) {
                $analysis = $githubService->analyze($user->cvData->github_username, $user->cvData->github_token);
            }
            
            return view('candidate.dashboard', compact('stats', 'analysis'));
        }
    }
}
