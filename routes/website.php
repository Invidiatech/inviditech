<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Website\PageController;
use App\Http\Controllers\Website\ContactController;
use App\Http\Controllers\Website\DeveloperToolsController;

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
Route::get('/software-engineer', [PageController::class, 'reactApp'])->name('software-engineer');
Route::get('/case-studies', [PageController::class, 'reactApp'])->name('case-studies');
Route::get('/projects', [PageController::class, 'reactApp'])->name('projects');
Route::get('/resume', [PageController::class, 'reactApp'])->name('resume');
Route::get('/faq', [PageController::class, 'reactApp'])->name('faq');
Route::get('/services/laravel-development', [PageController::class, 'reactApp'])->name('services.laravel');
Route::get('/services/api-development', [PageController::class, 'reactApp'])->name('services.api');
Route::get('/services/performance-optimization', [PageController::class, 'reactApp'])->name('services.performance');

/**
 * =======================
 * Developer Tools
 * =======================
 */
Route::get('/tools/json-formatter', [PageController::class, 'reactApp'])->name('tools.json-formatter');
Route::get('/tools/base64-encoder-decoder', [PageController::class, 'reactApp'])->name('tools.base64-tool');
Route::get('/tools/hash-generator', [PageController::class, 'reactApp'])->name('tools.hash-generator');
Route::get('/tools/url-encoder-decoder', [PageController::class, 'reactApp'])->name('tools.url-encoder-decoder');
Route::get('/tools/timestamp-converter', [PageController::class, 'reactApp'])->name('tools.timestamp-converter');

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
    Route::get('/software-engineer', [PageController::class, 'reactApp'])->name('software-engineer');
    Route::get('/case-studies', [PageController::class, 'reactApp'])->name('case-studies');
    Route::get('/projects', [PageController::class, 'reactApp'])->name('projects');
    Route::get('/resume', [PageController::class, 'reactApp'])->name('resume');
    Route::get('/faq', [PageController::class, 'reactApp'])->name('faq');
    Route::get('/services/laravel-development', [PageController::class, 'reactApp'])->name('services.laravel');
    Route::get('/services/api-development', [PageController::class, 'reactApp'])->name('services.api');
    Route::get('/services/performance-optimization', [PageController::class, 'reactApp'])->name('services.performance');
});
