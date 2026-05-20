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
            $chartData = [
                'applications_by_status' => JobApplication::selectRaw('status, count(*) as count')->groupBy('status')->pluck('count', 'status'),
                'jobs_by_category' => JobPosting::selectRaw('category_id, count(*) as count')->with('category')->groupBy('category_id')->get()->mapWithKeys(function ($item) { 
                    return [$item->category ? $item->category->name : 'Unknown' => $item->count]; 
                })
            ];
            return view('admin.dashboard', compact('stats', 'chartData'));
        } elseif ($user->role === 'institute') {
            $company = $user->company;
            $jobIds = $company->jobPostings()->pluck('id');
            $stats = [
                'my_jobs' => $jobIds->count(),
                'total_applicants' => JobApplication::whereIn('job_posting_id', $jobIds)->count(),
                'scheduled_interviews' => JobApplication::whereIn('job_posting_id', $jobIds)
                    ->where('status', 'interviewing')->count(),
            ];
            $chartData = [
                'applications_by_status' => JobApplication::whereIn('job_posting_id', $jobIds)
                    ->selectRaw('status, count(*) as count')->groupBy('status')->pluck('count', 'status'),
                'applications_by_job' => JobApplication::whereIn('job_posting_id', $jobIds)
                    ->selectRaw('job_posting_id, count(*) as count')->with('jobPosting')->groupBy('job_posting_id')->get()->mapWithKeys(function ($item) {
                        return [$item->jobPosting ? $item->jobPosting->title : 'Unknown' => $item->count];
                    })
            ];
            return view('institute.dashboard', compact('stats', 'chartData'));
        } else {
            $stats = [
                'my_applications' => $user->applications()->count(),
                'profile_completeness' => $user->cvData ? 100 : 20,
            ];
            
            $analysis = null;
            if ($user->cvData && $user->cvData->github_username) {
                $forceRefresh = request()->has('refresh');
                $analysis = $githubService->analyze($user->cvData->github_username, $user->cvData->github_token, $forceRefresh);
                if ($forceRefresh) {
                    return redirect()->route('dashboard')->with('success', 'GitHub profile analysis data synchronized!');
                }
            }
            
            return view('candidate.dashboard', compact('stats', 'analysis'));
        }
    }
}
