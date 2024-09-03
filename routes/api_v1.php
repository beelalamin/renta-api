<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\EmailVerification;
use App\Http\Controllers\Api\V1\Auth\OAuthController;
use App\Http\Controllers\Api\V1\Auth\ResetPassword;
use App\Http\Controllers\Api\V1\Products\BrandController;
use App\Http\Controllers\Api\V1\Products\CategoryController;
use App\Http\Controllers\Api\V1\Products\VehicleController;
use App\Http\Controllers\Api\V1\Shop\BookingController;
use App\Http\Controllers\Api\V1\Shop\FilterController;
use App\Http\Controllers\Api\V1\System\LocationController;
use App\Http\Controllers\V1\Shop\SubscriptionController;
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

        Route::get('/bookings', [BookingController::class, 'index']);
        Route::get('/booking/{id}', [BookingController::class, 'show']);
        Route::post('/booking/create', [BookingController::class, 'store']);

        Route::get('/subscriptions', [SubscriptionController::class, 'index']);
        Route::get('/subscription/{id}', [SubscriptionController::class, 'show']);

        // Route::get('/payments/{id}', [PaymentController::class, 'index']);
        // Route::post('/payment/create', [PaymentController::class, 'store']);

    });

});

Route::middleware(['Localize'])->group(function () {

    Route::get('/vehicles', [VehicleController::class, 'index']);
    Route::get('/vehicles/{id}', [VehicleController::class, 'show']);

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/brands', [BrandController::class, 'index']);
    Route::get('/filters', [FilterController::class, 'index']);
    Route::get('/locations', [LocationController::class, 'index']);

});
