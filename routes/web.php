<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\MainPageController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainPageController::class, 'index']);

// Для AJAX
Route::get('/flats', [MainPageController::class, 'showFlatsSection']);

Route::middleware('auth')->group(function () {
    Route::get('/account', [HomepageController::class, 'index']);
    Route::post('/account', [HomepageController::class, 'update']);
});

// ->name('login') для middleware('auth')
Route::match(['get', 'post'], '/login', [AuthController::class, 'login'])
    ->name('login');

Route::get('/logout', [AuthController::class, 'logout']);

Route::match(['get', 'post'], '/register', [RegisterController::class, 'register']);
