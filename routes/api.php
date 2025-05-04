<?php

use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/helloworld', function() {
    return response()->json([
        "message" => "Hello World!"
    ]);
});

Route::post('/auth', [UserController::class, "authentication"]);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/checkin', [AttendanceController::class, 'checkIn']);
    Route::post('/checkout', [AttendanceController::class, 'checkOut']);
});