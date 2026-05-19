<?php
namespace App\Http\Controllers;

use App\Models\JobPosting;
use App\Models\Category;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobPostingController extends Controller
{
    // List jobs based on role
    public function index(Request $request)
    {
        if (auth()->user()->role === 'candidate') {
            $query = JobPosting::where('status', 'approved')->with('company', 'category');
            
            if ($request->has('search')) {
                $query->where('title', 'like', '%' . $request->search . '%')
                      ->orWhere('description', 'like', '%' . $request->search . '%');
            }
            
            if ($request->has('location')) {
                $query->where('location', 'like', '%' . $request->location . '%');
            }

            $jobs = $query->get();
            return view('candidate.jobs.index', compact('jobs'));
        }
        $jobs = auth()->user()->company->jobPostings()->with('category')->get();
        return view('institute.jobs.index', compact('jobs'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('institute.jobs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required',
            'location' => 'required',
            'type' => 'required',
            'salary' => 'nullable',
        ]);

        auth()->user()->company->jobPostings()->create($request->all());

        return redirect()->route('institute.jobs.index')->with('success', 'Job posted successfully and is pending approval.');
    }

    public function show(JobPosting $job)
    {
        return view('candidate.jobs.show', compact('job'));
    }

    // Candidate: Apply for a job
    public function apply(Request $request, JobPosting $job)
    {
        JobApplication::create([
            'job_posting_id' => $job->id,
            'user_id' => auth()->id(),
            'status' => 'applied'
        ]);
        return back()->with('success', 'Applied successfully!');
    }

    // Admin: List all jobs
    public function adminIndex()
    {
        $jobs = JobPosting::with('company', 'category')->get();
        return view('admin.jobs.index', compact('jobs'));
    }

    public function approve(JobPosting $job)
    {
        $job->update(['status' => 'approved']);
        return back()->with('success', 'Job approved.');
    }

    public function myApplications()
    {
        $applications = auth()->user()->applications()->with('jobPosting.company')->get();
        return view('candidate.applications', compact('applications'));
    }

    // Institute: View applicants for a specific job
    public function applicants(JobPosting $job = null)
    {
        if ($job) {
            $applications = $job->applications()->with('user.cvData')->get();
        } else {
            $applications = JobApplication::whereIn('job_posting_id', auth()->user()->company->jobPostings()->pluck('id'))
                ->with('user.cvData', 'jobPosting')->get();
        }
        return view('institute.applicants.index', compact('applications', 'job'));
    }
    
    public function updateApplicationStatus(Request $request, JobApplication $application)
    {
        $data = [
            'status' => $request->status,
            'interview_at' => $request->status === 'interviewing' ? $request->interview_at : null,
            'meeting_link' => $request->status === 'interviewing' ? $request->meeting_link : null,
        ];
        $application->update($data);
        return back()->with('success', 'Application updated.');
    }

    public function destroy(JobPosting $job)
    {
        $job->delete();
        return back()->with('success', 'Job posting deleted.');
    }

    public function viewCv(\App\Models\User $user)
    {
        $cv = $user->cvData;
        if (!$cv) {
            return back()->with('error', 'Candidate has not built a CV yet.');
        }
        return view('institute.applicants.cv', ['candidate' => $user, 'cv' => $cv]);
    }
}
