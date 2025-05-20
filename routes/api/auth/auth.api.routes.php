<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StafAuthController;

Route::prefix('staf')->group(function () {
    Route::post('/login', [StafAuthController::class, 'login'])
        ->name('api.staf.login');
    Route::post('/logout', [StafAuthController::class, 'logout'])
        ->middleware('auth:sanctum')
        ->name('api.staf.logout');

    // Reset Password
    Route::post('/forgot-password', [StafAuthController::class, 'forgotPassword'])
        ->name('api.staf.forgot-password');
    Route::post('/forgot-password/verify-otp', [StafAuthController::class, 'forgotPasswordVerifyOtp'])
        ->name('api.staf.forgot-password-verify-otp');
    Route::post('/forgot-password/reset', [StafAuthController::class, 'forgotPasswordReset'])
        ->name('api.staf.forgot-password-reset');

    // Check Auth Login Staf
    Route::get('/check-auth', [StafAuthController::class, 'checkAuth'])
        ->middleware('auth:sanctum')
        ->name('api.staf.check-auth');

});
