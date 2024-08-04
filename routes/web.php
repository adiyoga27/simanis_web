<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Web\EducationController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('login', function () {
    return view('welcome');

});
Route::get('success-verification', function () {
    $user = auth()->user();
    return view('success-verification', compact('user'));

})->middleware(['auth']);
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('verification.verify');

Route::resource('educations', EducationController::class);
