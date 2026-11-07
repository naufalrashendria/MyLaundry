<?php

use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'));

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin & karyawan
Route::middleware(['auth', 'role:admin,staff'])
    ->prefix('admin')->name('admin.')
    ->group(function () {
        Route::resource('services', ServiceController::class)->except('show');
        Route::resource('transactions', TransactionController::class)->except('show');
    });

// Pelanggan
Route::middleware(['auth', 'role:client'])
    ->prefix('client')->name('client.')
    ->group(function () {
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
        Route::patch('orders/{transaction}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    });

require __DIR__.'/auth.php';