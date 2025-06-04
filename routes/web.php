<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\HomeController;

// Authentication Routes
Auth::routes();

// Home Route (Fixed)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Public Routes
Route::get('/all-cars', [CarController::class, 'allCars'])->name('cars.all');
Route::get('/search-results', [CarController::class, 'searchResults'])->name('search.results');

// Authenticated Routes
Route::middleware('auth')->group(function () {

    Route::prefix('cars')->group(function () {

        Route::get('/{car}/edit', [CarController::class, 'edit'])->name('cars.edit');
        Route::put('/{car}', [CarController::class, 'update'])->name('cars.update');
        Route::get('/my-cars', [CarController::class, 'myCars'])->name('cars.my-cars');
        Route::get('/create', [CarController::class, 'createStep1'])->name('cars.create');
        Route::post('/create', [CarController::class, 'storeStep1']);
        Route::get('/create/{licensePlate}', [CarController::class, 'createStep2'])->name('cars.create.step2');
        Route::post('/create/{licensePlate}', [CarController::class, 'storeStep2']);
        Route::get('/create/{licensePlate}/step3', [CarController::class, 'createStep3'])->name('cars.create.step3');
        Route::post('/create/{licensePlate}/step3', [CarController::class, 'storeStep3']);
        Route::delete('/{id}', [CarController::class, 'destroy'])->name('cars.destroy');

    });

    // PDF Route
    Route::get('/generate-pdf/{id}', [PdfController::class, 'generatePdf'])->name('generate-pdf');
});

// Car Detail Route (Public)
Route::get('/cars/{id}', [CarController::class, 'show'])->name('cars.show');
