<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\BuilderController;
use App\Http\Controllers\DevelopmentController;
use App\Http\Controllers\FinancialEntryController;
use App\Http\Controllers\UnitController;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth'])->group(function () {

    Route::resource('clients', ClientController::class)->except(['show']);

    Route::resource('works', WorkController::class)->except(['show']);

    Route::resource('builders', BuilderController::class)->except(['show']);

    Route::resource('developments', DevelopmentController::class)->except(['show']);
    Route::get('developments/{development}', [DevelopmentController::class, 'show'])->name('developments.show');

    Route::resource('units', UnitController::class)->except(['show']);

    Route::get('contracts/{contract}/print', [ContractController::class, 'print'])->name('contracts.print');
    Route::resource('contracts', ContractController::class)->except(['show']);

    Route::resource('financial', FinancialEntryController::class);
});

require __DIR__ . '/settings.php';