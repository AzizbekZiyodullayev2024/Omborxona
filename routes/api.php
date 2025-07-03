<?php

use App\Http\Controllers\RolesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('roles', RolesController::class);
Route::apiResource('users', UserController::class);
Route::apiResource('products', ProductController::class);
