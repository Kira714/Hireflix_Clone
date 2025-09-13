<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\SubmissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::get('/register/admin', [AuthController::class, 'showAdminRegister'])->name('register.admin');
Route::get('/register/candidate', [AuthController::class, 'showCandidateRegister'])->name('register.candidate');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('interviews.index');
    });
    
    Route::resource('interviews', InterviewController::class);
    Route::put('/interviews/{interview}', [InterviewController::class, 'update'])->name('interviews.update');
    Route::post('/interviews/{interview}/submit', [InterviewController::class, 'submit'])->name('interviews.submit');
    Route::post('/upload-video', [InterviewController::class, 'uploadVideo'])->name('upload.video');
    
    Route::get('/submissions/{submission}', [SubmissionController::class, 'show'])->name('submissions.show');
    Route::post('/submissions/{submission}/score', [SubmissionController::class, 'score'])->name('submissions.score');
});
