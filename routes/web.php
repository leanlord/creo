<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\FlatsController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FlatsController::class, 'index']);

Route::post('/', [MessageController::class, 'send']);

Route::middleware('auth')->group(function () {
    Route::get('/account', [HomepageController::class, 'index'])->name('account');
    Route::post('/account', [HomepageController::class, 'update'])->name('account');
});

Route::match(['get', 'post'], '/login', [AuthController::class, 'login'])
    ->name('login');

Route::get('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::match(['get', 'post'], '/register', [RegisterController::class, 'register'])
    ->name('register');
