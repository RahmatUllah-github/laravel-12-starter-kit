<?php

use App\Http\Controllers\API\AuthController;
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

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', 'logout');
    });
});
