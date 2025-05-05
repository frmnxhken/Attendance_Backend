<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard.app');
});

Route::get('/login', [AdminController::class, 'login'])->name('login');
Route::post('/login', [AdminController::class, 'authentication']);

Route::middleware(['auth:admin'])->group(function() {
    Route::resource('/employee', UserController::class);
    Route::resource('/office', OfficeController::class);
    Route::get('/attendance', [AttendanceController::class, 'index']);
});
