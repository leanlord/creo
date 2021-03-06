<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvatarUploadController;
use App\Http\Controllers\EmailVerifyController;
use App\Http\Controllers\FlatsController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FlatsController::class, 'index']);

Route::post('/', [MessageController::class, 'send']);

Route::middleware('auth')->group(function () {
    Route::prefix('/account')->group(function () {
        Route::name('account')->group(function () {
            Route::get('/', [HomepageController::class, 'index']);
            Route::post('/', [HomepageController::class, 'update']);
        });

        Route::post('/upload-avatar', [AvatarUploadController::class, 'upload']);

        Route::post('/save', [AvatarUploadController::class, 'save']);

        Route::get('/verify/send', [EmailVerifyController::class, 'send'])
        ->name('send.verification.email');
        Route::get('/verify', [EmailVerifyController::class, 'verify']);
    });
});

Route::middleware('guest')->group(function () {
    Route::name('login')->group(function () {
        Route::get('/login', [AuthController::class, 'index']);
        Route::post('/login', [AuthController::class, 'login']);
    });

    Route::name('register')->group(function () {
        Route::get('/register', [RegisterController::class, 'index']);
        Route::post('/register', [RegisterController::class, 'register']);
    });
});

Route::get('/logout', [AuthController::class, 'logout'])
    ->name('logout');
