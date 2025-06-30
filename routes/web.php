<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;

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
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/my', [TicketController::class, 'myTickets'])->name('tickets.my');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
});

require __DIR__.'/auth.php';