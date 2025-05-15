<?php

use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\ExcuseController;
use App\Http\Controllers\API\HistoryController;
use App\Http\Controllers\API\HolliDayController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/', [UserController::class, 'authentication']);
    Route::post('/reset-password', [UserController::class, 'resetPassword']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/profile', [UserController::class, 'getProfile']);
        Route::post('/logout', [UserController::class, 'deauthentication']);
        Route::post('/update-photo', [UserController::class, 'updatePhoto']);
        Route::post('/update-password', [UserController::class, 'updatePassword']);
    });

    Route::prefix('history')->group(function () {
        Route::get('/recent', [HistoryController::class, 'recent']);
        Route::get('/', [HistoryController::class, 'histories']);
    });

    Route::prefix('attendance')->group(function () {
        Route::get('/status', [AttendanceController::class, 'checkStatus']);
        Route::post('/checkin', [AttendanceController::class, 'checkIn']);
        Route::post('/checkout', [AttendanceController::class, 'checkOut']);
    });

    Route::prefix('excuse')->group(function () {
        Route::get('/', [ExcuseController::class, 'excuses']);
        Route::post('/request', [ExcuseController::class, 'requestExcuse']);
    });

    Route::get('/holliday', [HolliDayController::class, 'index']);
});