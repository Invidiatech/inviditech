<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\{
    ArticleController, CategoryController, TagController, 
    CommentController, HomeController
};
use Illuminate\Support\Facades\Route;



 
// Home Route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Articles
Route::resource('articles', ArticleController::class);
Route::get('articles/category/{category}', [ArticleController::class, 'category'])->name('articles.category');
Route::get('articles/tag/{tag}', [ArticleController::class, 'tag'])->name('articles.tag');

// Categories & Tags
Route::resource('categories', CategoryController::class);
Route::resource('tags', TagController::class);

// Portfolio
Route::resource('portfolio', PortfolioController::class);

// Services
Route::resource('services', ServiceController::class);

// Social Posts
Route::resource('social-posts', SocialPostController::class);

// Comments
Route::post('articles/{article}/comment', [CommentController::class, 'store'])->name('articles.comment.store');

 
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
