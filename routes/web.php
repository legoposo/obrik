<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WorkController;

use App\Http\Controllers\BuilderController;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');
    Route::put('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
    Route::resource('clients', ClientController::class)->except(['show']);
    Route::resource('works', WorkController::class)->except(['show']);
    Route::get('/builders', [BuilderController::class, 'index'])->name('builders.index');
    Route::get('/builders/create', [BuilderController::class, 'create'])->name('builders.create');
    Route::post('/builders', [BuilderController::class, 'store'])->name('builders.store');

    Route::get('/builders/{builder}/edit', [BuilderController::class, 'edit'])->name('builders.edit');
    Route::put('/builders/{builder}', [BuilderController::class, 'update'])->name('builders.update');

    Route::delete('/builders/{builder}', [BuilderController::class, 'destroy'])->name('builders.destroy');
});

require __DIR__.'/settings.php';
