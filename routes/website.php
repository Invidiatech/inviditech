<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Website\PageController;
use App\Http\Controllers\Website\NewsletterController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Website\ArticleInteractionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Website Routes
|--------------------------------------------------------------------------
| Routes for public pages, articles, blog, interactions, and user dashboard.
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

/**
 * =======================
 * Blog Routes
 * =======================
 */
Route::get('/blog', [PageController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [PageController::class, 'blogPost'])->name('blog.post');

/**
 * =======================
 * Articles Routes
 * =======================
 */
Route::get('/articles', [PageController::class, 'articles'])->name('articles');
Route::get('/article/{slug}', [PageController::class, 'show'])->name('article.show');
Route::get('/articles/{slug}/pdf', [ArticleInteractionController::class, 'downloadPdf'])->name('articles.pdf');

/**
 * =======================
 * Newsletter
 * =======================
 */
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

/**
 * =======================
 * Article Interaction (Likes, Bookmarks, etc.)
 * =======================
 */
Route::middleware(['auth'])->group(function () {
    Route::post('/articles/like', [ArticleInteractionController::class, 'toggleLike'])->name('articles.like');
    Route::post('/articles/bookmark', [ArticleInteractionController::class, 'toggleBookmark'])->name('articles.bookmark');
    Route::post('/articles/follow', [ArticleInteractionController::class, 'toggleFollow'])->name('articles.follow');
    Route::post('/articles/comment', [ArticleInteractionController::class, 'addComment'])->name('articles.comment');
    Route::post('/articles/clap', [ArticleInteractionController::class, 'clap'])->name('articles.clap');

    // Comments and replies
    Route::post('/article/{id}/comment', [ArticleController::class, 'storeComment'])->name('article.comment');
    Route::post('/comment/{id}/reply', [ArticleController::class, 'storeReply'])->name('comment.reply');
});

/**
 * =======================
 * User Dashboard
 * =======================
 */
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
     Route::post('/articles/like', [ArticleInteractionController::class, 'toggleLike'])->name('articles.like');
    Route::post('/articles/bookmark', [ArticleInteractionController::class, 'toggleBookmark'])->name('articles.bookmark');
    Route::post('/articles/follow', [ArticleInteractionController::class, 'toggleFollow'])->name('articles.follow');
    Route::post('/articles/comment', [ArticleInteractionController::class, 'addComment'])->name('articles.comment');
    Route::post('/articles/clap', [ArticleInteractionController::class, 'clap'])->name('articles.clap');
});
// Main dashboard pages
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
Route::get('/dashboard/bookmarks', [DashboardController::class, 'bookmarks'])->name('dashboard.bookmarks');
Route::get('/dashboard/comments', [DashboardController::class, 'comments'])->name('dashboard.comments');
Route::get('/dashboard/settings', [DashboardController::class, 'settings'])->name('dashboard.settings');

// User profile and settings routes
Route::put('/user/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');
Route::put('/user/password', [UserController::class, 'updatePassword'])->name('user.password.update');
Route::put('/user/notifications', [UserController::class, 'updateNotifications'])->name('user.notifications.update');
Route::put('/user/preferences', [UserController::class, 'updatePreferences'])->name('user.preferences.update');
Route::delete('/user/account', [UserController::class, 'deleteAccount'])->name('user.account.delete');