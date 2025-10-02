<?php

use App\Http\Controllers\RoomController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home/home');

Route::view('/home', 'home/home')
    ->middleware(['auth', 'verified'])
    ->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/rooms',[RoomController::class, 'index'])->name('rooms.index');
    Route::get('/rooms/create',[RoomController::class, 'create'])->name('rooms.create');
    Route::post('/rooms',[RoomController::class, 'store'])->name('rooms.store');
});

require __DIR__.'/auth.php';
