<?php
namespace App\Http\Controllers;

use App\Models\JobPosting;
use App\Models\Assessment;
use App\Models\Question;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function create(JobPosting $job)
    {
        return view('institute.assessments.create', compact('job'));
    }

    public function store(Request $request, JobPosting $job)
    {
        $assessment = Assessment::create([
            'job_posting_id' => $job->id,
            'title' => $request->title
        ]);

        foreach ($request->questions as $q) {
            $assessment->questions()->create($q);
        }

        return redirect()->route('institute.jobs.index')->with('success', 'Assessment created!');
    }

    public function show(JobPosting $job)
    {
        $assessment = Assessment::where('job_posting_id', $job->id)->with('questions')->first();
        return view('candidate.assessments.take', compact('job', 'assessment'));
    }

    public function submit(Request $request, JobPosting $job)
    {
        $assessment = Assessment::where('job_posting_id', $job->id)->with('questions')->first();
        $score = 0;
        foreach ($assessment->questions as $index => $question) {
            if ($request->answers[$index] == $question->correct_option) {
                $score++;
            }
        }

        auth()->user()->applications()->where('job_posting_id', $job->id)->update([
            'quiz_score' => $score
        ]);

        return redirect()->route('candidate.applications')->with('success', 'Assessment submitted! Score: ' . $score);
    }
}
