<?php

use App\Http\Controllers\BuilderController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientPortalController;
use App\Http\Controllers\ClientsReportController;
use App\Http\Controllers\CommunicationController;
use App\Http\Controllers\ConstructionModuleController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DevelopmentController;
use App\Http\Controllers\DevelopmentsReportController;
use App\Http\Controllers\DevelopmentPhotoController;
use App\Http\Controllers\DevelopmentStageController;
use App\Http\Controllers\FinancialEntryController;
use App\Http\Controllers\FinancialReportController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\WorksReportController;
use App\Http\Controllers\WorkStageController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('clients', ClientController::class)->except(['show']);

    Route::resource('works', WorkController::class)->except(['show']);

    Route::prefix('works/{work}/stages')->name('works.stages.')->group(function () {
        Route::get('/', [WorkStageController::class, 'index'])->name('index');
        Route::get('/create', [WorkStageController::class, 'create'])->name('create');
        Route::post('/', [WorkStageController::class, 'store'])->name('store');
        Route::get('/{stage}/edit', [WorkStageController::class, 'edit'])->name('edit');
        Route::put('/{stage}', [WorkStageController::class, 'update'])->name('update');
        Route::delete('/{stage}', [WorkStageController::class, 'destroy'])->name('destroy');
        Route::patch('/{stage}/status', [WorkStageController::class, 'updateStatus'])->name('status');
    });

    Route::resource('builders', BuilderController::class)->except(['show']);

    Route::resource('developments', DevelopmentController::class)->except(['show']);
    Route::get('developments/{development}', [DevelopmentController::class, 'show'])->name('developments.show');

    Route::prefix('developments/{development}')->name('developments.')->group(function () {
        Route::get('/stages', [DevelopmentStageController::class, 'index'])->name('stages.index');
        Route::get('/stages/create', [DevelopmentStageController::class, 'create'])->name('stages.create');
        Route::post('/stages', [DevelopmentStageController::class, 'store'])->name('stages.store');
        Route::get('/stages/{stage}/edit', [DevelopmentStageController::class, 'edit'])->name('stages.edit');
        Route::put('/stages/{stage}', [DevelopmentStageController::class, 'update'])->name('stages.update');
        Route::delete('/stages/{stage}', [DevelopmentStageController::class, 'destroy'])->name('stages.destroy');
        Route::patch('/stages/{stage}/status', [DevelopmentStageController::class, 'updateStatus'])->name('stages.status');

        Route::get('/communications', [CommunicationController::class, 'index'])->name('communications.index');
        Route::get('/communications/create', [CommunicationController::class, 'create'])->name('communications.create');
        Route::post('/communications', [CommunicationController::class, 'store'])->name('communications.store');
        Route::get('/communications/{communication}/edit', [CommunicationController::class, 'edit'])->name('communications.edit');
        Route::put('/communications/{communication}', [CommunicationController::class, 'update'])->name('communications.update');
        Route::delete('/communications/{communication}', [CommunicationController::class, 'destroy'])->name('communications.destroy');

        Route::get('/photos', [DevelopmentPhotoController::class, 'index'])->name('photos.index');
        Route::get('/photos/create', [DevelopmentPhotoController::class, 'create'])->name('photos.create');
        Route::post('/photos', [DevelopmentPhotoController::class, 'store'])->name('photos.store');
        Route::get('/photos/{photo}/edit', [DevelopmentPhotoController::class, 'edit'])->name('photos.edit');
        Route::put('/photos/{photo}', [DevelopmentPhotoController::class, 'update'])->name('photos.update');
        Route::delete('/photos/{photo}', [DevelopmentPhotoController::class, 'destroy'])->name('photos.destroy');
    });

    Route::prefix('construction')->name('construction.')->group(function () {
        Route::get('/stages', [ConstructionModuleController::class, 'stages'])->name('stages');
        Route::get('/communications', [ConstructionModuleController::class, 'communications'])->name('communications');
        Route::get('/photos', [ConstructionModuleController::class, 'photos'])->name('photos');
    });

    Route::get('/client-portal', [ClientPortalController::class, 'index'])->name('client-portal.index');

    Route::resource('units', UnitController::class)->except(['show']);

    Route::get('contracts/{contract}/print', [ContractController::class, 'print'])->name('contracts.print');
    Route::resource('contracts', ContractController::class)->except(['show']);

    Route::resource('financial', FinancialEntryController::class);

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/works', [WorksReportController::class, 'index'])->name('works');
        Route::get('/financial', [FinancialReportController::class, 'index'])->name('financial');
        Route::get('/clients', [ClientsReportController::class, 'index'])->name('clients');
        Route::get('/developments', [DevelopmentsReportController::class, 'index'])->name('developments');
    });
});

require __DIR__ . '/settings.php';