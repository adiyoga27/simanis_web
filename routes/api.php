<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DietController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/registration', [AuthController::class, 'registration']);
Route::post('auth/resend-verification', [AuthController::class, 'resendVerification']);
Route::resource('education', EducationController::class);
Route::post('education/{slug}', [EducationController::class, 'storeEducation']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('user', [AuthController::class, 'updateProfile'])->middleware('auth:sanctum');
Route::get('user', [UserController::class, 'index'])->middleware('auth:sanctum');
Route::get('diets/{amount}', [DietController::class, 'show']);
Route::post('auth/reset', [AuthController::class, 'resetPassword'])->middleware('auth:sanctum');
Route::post('auth/send-otp-forget', [AuthController::class, 'sendOtpForget']);
Route::post('auth/verify-otp', [AuthController::class, 'verifyOtpForget']);