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
    
    // Articles
    Route::resource('articles', ArticleController::class);
});

require __DIR__.'/auth.php';
require __DIR__.'/website.php';