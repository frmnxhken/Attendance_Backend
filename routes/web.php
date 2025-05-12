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

Route::middleware(['auth:admin'])->group(function() {
    Route::get('/', [DashboardController::class, 'index']);
    Route::post('/logout', [AdminController::class, 'deauthentication']);
    Route::resource('/employee', UserController::class);
    Route::resource('/office', OfficeController::class);
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance');
    Route::get('/excuse', [ExcuseController::class, 'index']);
    Route::get('/excuse/detail/{id}', [ExcuseController::class, 'show']);
    Route::post('/excuse/detail/{id}/approve', [ExcuseController::class, 'approve'])->name('approve');
    Route::post('/excuse/detail/{id}/cancel', [ExcuseController::class, 'cancel'])->name('cancel');
    Route::get('/editpassword', [AdminController::class, 'editPassword']);
    Route::put('/editpassword', [AdminController::class, 'updatePassword']);
});
