<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\MessageReadController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('messages', MessageController::class);
Route::resource('assets', AssetController::class);
Route::resource('message-reads', MessageReadController::class);
Route::resource('tickets', TicketController::class);
Route::resource('users', UserController::class);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [UserController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [UserController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
