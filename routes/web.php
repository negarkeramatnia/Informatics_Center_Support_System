<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AssetController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;

// Welcome Page Route (for guests)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Main Dashboard Route
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
    Route::post('/tickets/{ticket}/assign', [TicketController::class, 'assign'])->name('tickets.assign');
    Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
    Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
    Route::post('/tickets/{ticket}/complete', [App\Http\Controllers\TicketController::class, 'complete'])->name('tickets.complete');
    Route::post('/tickets/{ticket}/messages', [App\Http\Controllers\MessageController::class, 'store'])->name('tickets.messages.store');
    Route::post('/tickets/{ticket}/rate', [App\Http\Controllers\TicketController::class, 'rate'])->name('tickets.rate');
    Route::post('/tickets/{ticket}/allocate-asset', [App\Http\Controllers\TicketController::class, 'allocateAsset'])->name('tickets.allocateAsset');
    Route::get('/knowledge-base', [App\Http\Controllers\Admin\ArticleController::class, 'kbIndex'])->name('knowledge-base.index');
    Route::get('/phonebook', [App\Http\Controllers\PhonebookController::class, 'index'])->name('phonebook.index');
    Route::get('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [App\Http\Controllers\NotificationController::class, 'markAllRead'])->name('notifications.readAll');
    Route::patch('/profile/theme', [ProfileController::class, 'updateTheme'])->name('profile.theme.update');
});

// Admin Route Group
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class)->except(['show']);
    // Route::resource('assets', AssetController::class)->except(['show']);
    Route::resource('assets', AssetController::class);
    Route::get('/reports/details', [ReportController::class, 'details'])->name('reports.details');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');
    Route::resource('articles', App\Http\Controllers\Admin\ArticleController::class);
    // Purchase Requests
    Route::resource('purchase-requests', App\Http\Controllers\Admin\PurchaseRequestController::class)
        ->name('index', 'purchase-requests.index');

    // Admin System Alerts
    Route::get('/admin/notifications/create', [App\Http\Controllers\NotificationController::class, 'createAlert'])->name('admin.notifications.create');
    Route::post('/admin/notifications/send', [App\Http\Controllers\NotificationController::class, 'sendAlert'])->name('admin.notifications.send');
});

require __DIR__.'/auth.php';
