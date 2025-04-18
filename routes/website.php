<?php

use App\Http\Controllers\Website\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ArticleController;

/*
|--------------------------------------------------------------------------
| Website Routes
|--------------------------------------------------------------------------
|
| Here is where you can register website routes for your application.
|
*/

// Main Pages
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/tutorials', [PageController::class, 'tutorials'])->name('tutorials');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/articles', [PageController::class, 'articles'])->name('articles');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/hire-us', [PageController::class, 'hireUs'])->name('hire-us'); 
// Blog - Laravel-focused articles
Route::get('/blog', [PageController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [PageController::class, 'blogPost'])->name('blog.post');

// Tutorial articles by category
Route::get('/articles', [PageController::class, 'articles'])->name('articles');
Route::get('/article/{slug}', [PageController::class, 'show'])->name('article.show');
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::post('/article/pdf', [NewsletterController::class, 'pdf'])->name('newsletter.subscribe');
// Comment routes (with auth middleware)
Route::middleware(['auth'])->group(function () {
    Route::post('/article/{id}/comment', [ArticleController::class, 'storeComment'])->name('article.comment');
    Route::post('/comment/{id}/reply', [ArticleController::class, 'storeReply'])->name('comment.reply');
});


