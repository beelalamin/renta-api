<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\api\auth\EmailVerification;
use App\Http\Controllers\api\auth\OAuthController;
use App\Http\Controllers\api\auth\ResetPassword;
use App\Http\Controllers\api\products\BrandController;
use App\Http\Controllers\api\products\CategoryController;
use App\Http\Controllers\api\products\VehicleController;
use App\Http\Controllers\api\Shop\BookingController;
use App\Http\Controllers\api\Shop\CustomerController;
use App\Http\Controllers\api\Shop\PaymentController;
use App\Http\Controllers\System\LocationController;
use Illuminate\Support\Facades\Route;

// Guest Routes
Route::middleware('throttle:api')->group(function () {

    // Guest Routes
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:register');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login');

    // Password Reset Routes
    Route::post('/forgot-password', [ResetPassword::class, 'sendPasswordResetToken'])->name('password.email');
    Route::post('/reset-password/{token}', [ResetPassword::class, 'resetPasswordHandler'])->name('password.reset');

    Route::get('/auth/{provider}', [OAuthController::class, 'redirectToProvider']);
    Route::get('/auth/{provider}/callback', [OAuthController::class, 'handleProviderCallback']);

    // Authenticated Routes
    Route::middleware('auth:sanctum')->group(function () {

        // Email Verification Notice
        Route::get('/email/verify', [EmailVerification::class, 'VerificationNotice'])->name('verification.verify');

        // Email Verification Handler
        Route::get('/email/verify/{id}/{hash}', [EmailVerification::class, 'EmailVerificationHandler'])->middleware(['auth', 'signed'])->name('verification.verify');

        // Resend Email Verification
        Route::post('/email/verification-notification', [EmailVerification::class, 'resendEmailVerification'])->middleware(['throttle:6,1']);

        // Logout
        Route::post('/logout', [AuthController::class, 'logout']);

    });



});

Route::middleware(['Localize'])->group(function () {
    Route::get('/vehicles', [VehicleController::class, 'index']);
    Route::get('/vehicles/{id}', [VehicleController::class, 'show']);

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/brands', [BrandController::class, 'index']);
    Route::get('/locations', [LocationController::class, 'index']);


    Route::get('/bookings/{id}', [BookingController::class, 'index']);
    Route::get('/bookings/detail/{id}', [BookingController::class, 'show']);
    Route::post('/booking/create', [BookingController::class, 'store']);


    // Route::get('/customer', [CustomerController::class, 'index']);
    Route::post('/customer/{id}/create', [CustomerController::class, 'store']);
    Route::put('/customer/{id}/update', [CustomerController::class, 'update']);

    Route::get('/payments/{id}', [PaymentController::class, 'index']);
    Route::post('/payment/create', [PaymentController::class, 'store']);

});
