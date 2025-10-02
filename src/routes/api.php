<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RoomController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/rooms', [RoomController::class, 'index']);
    Route::post('/rooms', [RoomController::class, 'store']);
//    Route::get('/rooms/{slug}', [RoomController::class, 'show']);
//    Route::post('/rooms/join', [RoomController::class, 'join']);
});
