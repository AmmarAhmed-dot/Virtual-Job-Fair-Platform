<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    public function room(JobApplication $application)
    {
        $user = auth()->user();

        // Check authorization
        $isCandidate = $user->id === $application->user_id;
        $isEmployer = $user->role === 'institute' && $user->company->id === $application->jobPosting->company_id;

        if (!$isCandidate && !$isEmployer) {
            abort(403, 'Unauthorized to join this interview room.');
        }

        // Generate a unique room name for this interview
        $roomName = 'vjfp_interview_' . $application->id . '_' . md5($application->created_at);

        return view('interview.room', [
            'application' => $application,
            'roomName' => $roomName,
            'userName' => $user->name,
        ]);
    }
}
