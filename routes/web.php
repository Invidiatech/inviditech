<?php
use App\Http\Controllers\Seo\ImageGeneratorController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
Route::get('/optimize-clear', function () {
    Artisan::call('optimize:clear');
    return ' Cache cleared successfully!';
});

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return 'Storage link created successfully!';
});

Route::get('/blog-post-image-generator', [ImageGeneratorController::class, 'index'])->name('image.index');
require __DIR__.'/auth.php';
require __DIR__.'/website.php';
require __DIR__.'/seo.php';


