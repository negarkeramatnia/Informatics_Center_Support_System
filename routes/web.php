<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AssetController;

// Welcome Page Route (for guests)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Main Dashboard Route - NOW CORRECTLY POINTS TO YOUR CONTROLLER
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');
    
// All other routes that require a user to be logged in
Route::middleware('auth')->group(function () {

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ticket Management Routes
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/my', [TicketController::class, 'myTickets'])->name('tickets.my');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
});

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    // This middleware will ensure only users with the 'admin' role can access these pages.
    // You might need to create this middleware later if you don't have one.
    // For now, we will just define the routes.

    // User Management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    // Add routes for create, store, edit, update, destroy later
    // Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    // Route::post('/users', [UserController::class, 'store'])->name('users.store');
    // Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    // Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    // Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Asset Management
    Route::get('/assets', [AssetController::class, 'index'])->name('assets.index');
    // Add routes for asset CRUD operations later
});

require __DIR__.'/auth.php';