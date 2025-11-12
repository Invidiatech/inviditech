<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Website\PageController;
use App\Http\Controllers\Website\ContactController;

/*
|--------------------------------------------------------------------------
| Website Routes
|--------------------------------------------------------------------------
| Routes for public pages only.
*/

/**
 * =======================
 * Public Main Pages (React Frontend)
 * =======================
 */
Route::get('/', [PageController::class, 'reactApp'])->name('home');
Route::get('/tutorials', [PageController::class, 'reactApp'])->name('tutorials');
Route::get('/services', [PageController::class, 'reactApp'])->name('services');
Route::get('/about', [PageController::class, 'reactApp'])->name('about');
Route::get('/contact', [PageController::class, 'reactApp'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/hire-us', [PageController::class, 'reactApp'])->name('hire-us');
Route::get('/blog', [PageController::class, 'reactApp'])->name('blog');
Route::get('/blog/{slug}', [PageController::class, 'reactApp'])->name('blog.show');
Route::get('/articles', [PageController::class, 'reactApp'])->name('articles');
Route::get('/article/{slug}', [PageController::class, 'reactApp'])->name('article.show');

/**
 * =======================
 * Legacy Blade Routes (if needed)
 * =======================
 */
Route::prefix('website')->name('website.')->group(function () {
    Route::get('/', [PageController::class, 'home'])->name('home');
    Route::get('/tutorials', [PageController::class, 'tutorials'])->name('tutorials');
    Route::get('/services', [PageController::class, 'services'])->name('services');
    Route::get('/about', [PageController::class, 'about'])->name('about');
    Route::get('/contact', [PageController::class, 'contact'])->name('contact');
    Route::get('/hire-us', [PageController::class, 'hireUs'])->name('hire-us');
    Route::get('/blog', [PageController::class, 'blog'])->name('blog');
    Route::get('/articles', [PageController::class, 'articles'])->name('articles');
    Route::get('/article/{slug}', [PageController::class, 'show'])->name('article.show');
});
