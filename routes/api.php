<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Middleware\AuthMiddleware;

/* Route::apiResource('users', userController::class)->middleware(AuthMiddleware::class); */

Route::get('users', [userController::class, 'index']);
Route::post('users', [userController::class, 'store']);
Route::get('users/{id}', [userController::class, 'show']);
Route::put('users/{id}', [userController::class, 'update'])->middleware(AuthMiddleware::class);
Route::delete('users/{id}', [userController::class, 'destroy'])->middleware(AuthMiddleware::class);

Route::post('login', [userController::class, 'login']);