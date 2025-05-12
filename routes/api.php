<?php

use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\ExcuseController;
use App\Http\Controllers\API\HistoryController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/helloworld', function () {
    return response()->json([
        "message" => "Hello World!"
    ]);
});

Route::post('/user/reset-password', [UserController::class, 'resetPassword']);
Route::post('/auth', [UserController::class, "authentication"]);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/profile', [UserController::class, 'getProfile']);

    Route::post('/logout', [UserController::class, 'deauthentication']);

    Route::post('/user/update-photo', [UserController::class, 'updatePhoto']);
    Route::post('/user/update-password', [UserController::class, 'updatePassword']);

    Route::get('/history/recent', [HistoryController::class, 'recent']);
    Route::get('/history', [HistoryController::class, 'histories']);

    Route::get('/status', [AttendanceController::class, 'checkStatus']);
    Route::post('/checkin', [AttendanceController::class, 'checkIn']);
    Route::post('/checkout', [AttendanceController::class, 'checkOut']);

    Route::post('/excuse/request', [ExcuseController::class, 'requestExcuse']);
});
