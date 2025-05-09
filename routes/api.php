<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\SocialAuthController;
use App\Http\Controllers\API\EmailVerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes for Version 1.0
|--------------------------------------------------------------------------
|
| Register API routes for version 1.0 of your application here. These routes
| are loaded by the RouteServiceProvider within a group assigned the "api"
| middleware. Keep building great features!
|
*/

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('forgot-password', 'forgotPassword');
    Route::post('reset-password', 'resetPassword');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', 'logout');
    });
});

Route::prefix('social-auth')->controller(SocialAuthController::class)->group(function () {
    Route::post('/google', 'googleLogin');
});
