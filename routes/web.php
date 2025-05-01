<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ArticleController;
Route::prefix('admin')->middleware(['auth', 'verified'])->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Categories
    Route::resource('categories', CategoryController::class);
    Route::get('categories/toggle/{id}', [CategoryController::class, 'toggle'])->name('categories.toggle');
    
    // Articles
    Route::resource('articles', ArticleController::class);
    Route::get('articles/toggle-featured/{id}', [ArticleController::class, 'toggleFeatured'])->name('articles.toggle-featured');
    Route::get('articles/toggle-premium/{id}', [ArticleController::class, 'togglePremium'])->name('articles.toggle-premium');
    Route::get('articles/toggle-status/{id}', [ArticleController::class, 'toggleStatus'])->name('articles.toggle-status');
});

require __DIR__.'/auth.php';
require __DIR__.'/website.php';