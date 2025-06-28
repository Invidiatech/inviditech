<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Website\PageController;

/*
|--------------------------------------------------------------------------
| Website Routes
|--------------------------------------------------------------------------
| Routes for public pages only.
*/

/**
 * =======================
 * Public Main Pages
 * =======================
 */
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/tutorials', [PageController::class, 'tutorials'])->name('tutorials');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/hire-us', [PageController::class, 'hireUs'])->name('hire-us');
Route::get('/blog', [PageController::class, 'blog'])->name('blog');
Route::get('/articles', [PageController::class, 'articles'])->name('articles');
Route::get('/article/{slug}', [PageController::class, 'show'])->name('article.show');
