<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\UserCategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


// Route::post('/categories', [UserCategoryController::class, 'store'])->name('categories.store');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');
    Route::get('/dashboard/category-summary', [DashboardController::class, 'categorySummary'])->name('dashboard.category-summary');

    Route::get('/record', [RecordController::class, 'create'])->name('record.create');
    Route::post('/record', [RecordController::class, 'store'])->name('record.store');

    Route::get('/categories', [UserCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [UserCategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{id}', [UserCategoryController::class, 'destroy'])->name('categories.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
