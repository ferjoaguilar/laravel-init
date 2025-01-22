<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Middleware\AuthMiddleware;

Route::apiResource('users', userController::class)->middleware([AuthMiddleware::class]);
Route::post('login', [userController::class, 'login']);