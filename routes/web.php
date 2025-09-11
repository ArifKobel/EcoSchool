<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\ResultController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landingpage');
});

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/questionnaire', [QuestionnaireController::class, 'show'])->name('questionnaire.show');
    Route::post('/questionnaire', [QuestionnaireController::class, 'store'])->name('questionnaire.store');
    Route::post('/questionnaire/reset', [QuestionnaireController::class, 'reset'])->name('questionnaire.reset');
    Route::get('/questionnaire/progress', [QuestionnaireController::class, 'progress'])->name('questionnaire.progress');

    Route::get('/results/{result}', [ResultController::class, 'show'])->name('results.show');
});

Route::middleware('guest.access')->group(function () {
    Route::get('/guest/questionnaire', [QuestionnaireController::class, 'showGuest'])->name('guest.questionnaire.show');
    Route::post('/guest/questionnaire', [QuestionnaireController::class, 'storeGuest'])->name('guest.questionnaire.store');
    Route::post('/guest/questionnaire/reset', [QuestionnaireController::class, 'resetGuest'])->name('guest.questionnaire.reset');
    Route::get('/guest/questionnaire/progress', [QuestionnaireController::class, 'progressGuest'])->name('guest.questionnaire.progress');
    Route::get('/guest/results', [ResultController::class, 'showGuest'])->name('guest.results.show');
});

require __DIR__.'/auth.php';
