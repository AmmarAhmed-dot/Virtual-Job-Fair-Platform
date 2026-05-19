<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    public function cvBuilder(Request $request): View
    {
        $cv = $request->user()->cvData ?? new \App\Models\CvData();
        return view('candidate.cv-builder', compact('cv'));
    }

    public function cvStore(Request $request): RedirectResponse
    {
        $request->validate([
            'summary' => 'required|string',
            'phone' => 'nullable|string',
            'location' => 'nullable|string',
            'linkedin_url' => 'nullable|string',
            'github_username' => 'nullable|string',
            'skills' => 'nullable|array',
            'experience' => 'nullable|array',
            'projects' => 'nullable|array',
            'education' => 'nullable|array',
            'languages' => 'nullable|array',
        ]);

        $request->user()->cvData()->updateOrCreate(
            ['user_id' => auth()->id()],
            $request->all()
        );

        return back()->with('success', 'CV updated successfully!');
    }
}
