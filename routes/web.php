<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExcuseController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AdminController::class, 'login'])->name('login');
Route::post('/login', [AdminController::class, 'authentication']);

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::resource('/employee', UserController::class);
    Route::resource('/office', OfficeController::class);

    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AdminController::class, 'deauthentication']);
        Route::get('/edit-password', [AdminController::class, 'editPassword']);
        Route::put('/edit-password', [AdminController::class, 'updatePassword']);
    });


    Route::prefix('attendance')->group(function () {
        Route::get('/', [AttendanceController::class, 'index'])->name('attendance');
        Route::get('/export/{range}', [AttendanceController::class, 'exportExcel']);
        Route::post('/reset/photo', [AttendanceController::class, 'resetPhoto'])->name('resetPhoto');
        Route::post('/reset/all', [AttendanceController::class, 'resetAll'])->name('resetAll');
    });

    Route::prefix('excuse')->group(function () {
        Route::get('/', [ExcuseController::class, 'index']);
        Route::get('/detail/{id}', [ExcuseController::class, 'show']);
        Route::post('/detail/{id}/approve', [ExcuseController::class, 'approve'])->name('approve');
        Route::post('/detail/{id}/cancel', [ExcuseController::class, 'cancel'])->name('cancel');
    });
});