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

    // Fragebogen-Routen
    Route::get('/questionnaire', [QuestionnaireController::class, 'show'])->name('questionnaire.show');
    Route::post('/questionnaire', [QuestionnaireController::class, 'store'])->name('questionnaire.store');
    Route::post('/questionnaire/reset', [QuestionnaireController::class, 'reset'])->name('questionnaire.reset');
    Route::get('/questionnaire/progress', [QuestionnaireController::class, 'progress'])->name('questionnaire.progress');

    // Ergebnis-Routen
    Route::get('/results/{result}', [ResultController::class, 'show'])->name('results.show');
});

require __DIR__.'/auth.php';
