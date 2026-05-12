<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Web\PageController;
use Illuminate\Support\Facades\Route;

// Landing page
Route::get('/', [PageController::class, 'landing'])->name('landing');

// Authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [PageController::class, 'login'])->name('login');
    Route::post('/login', [PageController::class, 'doLogin'])->name('login.post');
    Route::get('/register', [PageController::class, 'register'])->name('register');
    Route::post('/register', [PageController::class, 'doRegister'])->name('register.post');
    Route::get('/forgot-password', [PageController::class, 'forgotPassword'])->name('forgot-password');
    Route::get('/new-password', [PageController::class, 'newPassword'])->name('new-password');
});

// Email verification
Route::get('/success-verification', fn() => view('success-verification', ['user' => auth()->user()]))
    ->middleware('auth')->name('success-verification');
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('verification.verify');

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/home', [PageController::class, 'home'])->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Education
    Route::get('/education', [PageController::class, 'education'])->name('education');
    Route::get('/education/{slug}', [PageController::class, 'educationDetail'])->name('education.detail');
    Route::get('/education/{categorySlug}/{articleSlug}', [PageController::class, 'educationShow'])->name('education.show');

    // Blood Sugar
    Route::get('/blood-sugar', [PageController::class, 'bloodSugar'])->name('blood-sugar');
    Route::get('/blood-sugar/gdp', [PageController::class, 'bloodSugarGdp'])->name('blood-sugar.gdp');
    Route::get('/blood-sugar/gds', [PageController::class, 'bloodSugarGds'])->name('blood-sugar.gds');
    Route::get('/blood-sugar/tutorial', [PageController::class, 'bloodSugarTutorial'])->name('blood-sugar.tutorial');

    // Foot Screening
    Route::get('/foot-screening', [PageController::class, 'footScreening'])->name('foot-screening');
    Route::get('/foot-screening/survey', [PageController::class, 'footScreeningSurvey'])->name('foot-screening.survey');
    Route::post('/foot-screening/result', [PageController::class, 'footScreeningResult'])->name('foot-screening.result');

    // Nutrition Therapy
    Route::get('/tnt', [PageController::class, 'tnt'])->name('tnt');
    Route::post('/tnt/calculate', [PageController::class, 'tntCalculate'])->name('tnt.calculate');

    // Pharmacology
    Route::get('/pharmacology', [PageController::class, 'pharmacology'])->name('pharmacology');

    // Profile
    Route::get('/profile', [PageController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [PageController::class, 'profileEdit'])->name('profile.edit');
    Route::post('/profile/update', [PageController::class, 'profileUpdate'])->name('profile.update');
});

// Static pages (public)
Route::get('/tentang', [PageController::class, 'about'])->name('about');
Route::get('/privasi', [PageController::class, 'privacy'])->name('privacy');
Route::get('/kontak', [PageController::class, 'contact'])->name('contact');

// Webview pages
Route::get('/tutorial-check-gula-darah', fn() => view('webview.gula-darah'))->name('tutorial.gula-darah');
Route::get('/tutorial-cara-perawatan-hipoglekimia', fn() => view('webview.hipoglekimia'))->name('tutorial.hipoglekimia');
Route::get('/tutorial-cara-perawatan-hiperglikemia', fn() => view('webview.hiperglikemia'))->name('tutorial.hiperglikemia');
Route::get('/recomendasi-foot', [PageController::class, 'recommendationFoot'])->name('recommendation.foot');
