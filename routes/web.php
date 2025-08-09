<?php
use App\Http\Controllers\Seo\ImageGeneratorController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

Route::get('/optimize-clear', function () {
    Artisan::call('optimize:clear');
    return ' Cache cleared successfully!';
});

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return 'Storage link created successfully!';
});
Route::get('/run-migrate', function (Request $request) {
    $token = $request->query('token');

    if ($token !== env('MIGRATION_SECRET')) {
        abort(403, 'Unauthorized.');
    }

    Artisan::call('migrate', ['--force' => true]);
    return 'Migration executed successfully.';
});
Route::get('/blog-post-image-generator', [ImageGeneratorController::class, 'index'])->name('image.index');
use App\Http\Controllers\CatalogController;
Route::get('/coalationtech-task', [CatalogController::class,'index']);
Route::get('/fetch', [CatalogController::class,'fetch']);
Route::post('/store', [CatalogController::class,'store']);
Route::post('/update', [CatalogController::class,'update']);

// SEO Routes
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.index');
Route::get('/sitemap-pages.xml', [SitemapController::class, 'pages'])->name('sitemap.pages');
Route::get('/sitemap-articles.xml', [SitemapController::class, 'articles'])->name('sitemap.articles');
Route::get('/sitemap-categories.xml', [SitemapController::class, 'categories'])->name('sitemap.categories');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots.txt');

require __DIR__.'/auth.php';
require __DIR__.'/website.php';
require __DIR__.'/seo.php';


