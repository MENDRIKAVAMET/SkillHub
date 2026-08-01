<?php

use App\Http\Controllers\HelpRequestController;
use App\Http\Controllers\LearningRequestController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\UserSkillController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users/{user}', [App\Http\Controllers\UserProfileController::class, 'show'])->name('users.show');

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('skills', SkillController::class);
    Route::resource('user-skills', UserSkillController::class);
    Route::resource('learning-requests', LearningRequestController::class);
    Route::get('learning-requests/match/{skill}', [LearningRequestController::class, 'match'])->name('learning-requests.match');
    Route::resource('help-requests', HelpRequestController::class);
    Route::post('help-requests/{helpRequest}/accept', [HelpRequestController::class, 'accept'])->name('help-requests.accept');
    Route::post('help-requests/{helpRequest}/refuse', [HelpRequestController::class, 'refuse'])->name('help-requests.refuse');
    Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::get('messages/{user}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('messages', [MessageController::class, 'store'])->name('messages.store');
    Route::delete('messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
});

require __DIR__.'/auth.php';
