<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobPostingController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InterviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/jobs/{job}', [JobPostingController::class, 'show'])->name('jobs.show');
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/interview/{application}/room', [InterviewController::class, 'room'])->name('interviews.room');

    // Admin Routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/jobs', [JobPostingController::class, 'adminIndex'])->name('admin.jobs.index');
        Route::patch('/admin/jobs/{job}/approve', [JobPostingController::class, 'approve'])->name('admin.jobs.approve');
        Route::resource('/admin/categories', CategoryController::class)->names('admin.categories');
    });

    // Institute Routes
    Route::middleware('role:institute')->group(function () {
        Route::resource('/institute/jobs', JobPostingController::class)->names('institute.jobs');
        Route::get('/institute/applicants/{job?}', [JobPostingController::class, 'applicants'])->name('institute.applicants');
        Route::get('/institute/applicants/cv/{user}', [JobPostingController::class, 'viewCv'])->name('institute.applicants.cv');
        Route::get('/institute/applicants/github/{user}', [JobPostingController::class, 'viewGithub'])->name('institute.applicants.github');
        Route::patch('/institute/applications/{application}', [JobPostingController::class, 'updateApplicationStatus'])->name('institute.applications.update');
        Route::get('/institute/events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/institute/events', [EventController::class, 'store'])->name('events.store');
        Route::get('/institute/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('/institute/events/{event}', [EventController::class, 'update'])->name('events.update');
        Route::delete('/institute/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
        Route::get('/institute/company', [CompanyController::class, 'edit'])->name('institute.company.edit');
        Route::put('/institute/company', [CompanyController::class, 'update'])->name('institute.company.update');
        Route::get('/institute/jobs/{job}/assessment/create', [\App\Http\Controllers\AssessmentController::class, 'create'])->name('institute.assessments.create');
        Route::post('/institute/jobs/{job}/assessment', [\App\Http\Controllers\AssessmentController::class, 'store'])->name('institute.assessments.store');
    });

    // Candidate Routes
    Route::middleware('role:candidate')->group(function () {
        Route::get('/jobs', [JobPostingController::class, 'index'])->name('jobs.index');
        Route::post('/jobs/{job}/apply', [JobPostingController::class, 'apply'])->name('jobs.apply');
        Route::get('/jobs/{job}/assessment', [\App\Http\Controllers\AssessmentController::class, 'show'])->name('candidate.assessments.take');
        Route::post('/jobs/{job}/assessment', [\App\Http\Controllers\AssessmentController::class, 'submit'])->name('candidate.assessments.submit');
        Route::get('/my-applications', [JobPostingController::class, 'myApplications'])->name('candidate.applications');
        Route::get('/cv-builder', [ProfileController::class, 'cvBuilder'])->name('candidate.cv-builder');
        Route::post('/cv-builder', [ProfileController::class, 'cvStore'])->name('candidate.cv-store');
    });
});

require __DIR__.'/auth.php';
