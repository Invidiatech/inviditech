<?php
use App\Http\Controllers\Seo\ImageGeneratorController;
use Illuminate\Support\Facades\Route;
Route::get('/blog-post-image-generator', [ImageGeneratorController::class, 'index'])->name('image.index');
require __DIR__.'/auth.php';
require __DIR__.'/website.php';
require __DIR__.'/seo.php';


