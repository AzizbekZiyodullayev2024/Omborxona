<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\TranslationController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('roles', RolesController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('products', ProductController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::apiResource('languages', LanguageController::class);
Route::apiResource('translations', TranslationController::class);