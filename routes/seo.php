<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Seo\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Seo\DashbordController;
use App\Http\Controllers\Seo\ProfileController;
use App\Http\Controllers\Seo\PageController;
use App\Http\Controllers\Seo\BlogController;
use App\Http\Controllers\Seo\CollectionController;
use App\Http\Controllers\Seo\ProductController;
use App\Http\Controllers\Seo\CategoryController;
use App\Http\Controllers\Seo\SchemaMarkupController;
use App\Http\Controllers\Seo\SitemapController;
use App\Http\Controllers\Seo\RobotsController;
use App\Http\Controllers\Seo\RedirectController;
use App\Http\Controllers\Seo\SuggestionController;
use App\Http\Controllers\Seo\MerchantController;
use App\Http\Controllers\Seo\TeamController;

Route::prefix('seo')->name('seo.')->group(function () {
    Route::middleware('seo.guest')->group(function () {
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [AuthenticatedSessionController::class, 'store']);
    });

    Route::middleware('auth:seo')->group(function () {
        // Dashboard
            Route::get('/dashboard', [DashbordController::class, 'index'])->name('dashboard');

      // Products Management - Add this section
        Route::controller(ProductController::class)->prefix('products')->name('products.')->group(function () {
            Route::get('/', 'index')->name('index')->middleware('can:View Collection,seo');
            Route::get('/create', 'create')->name('create')->middleware('can:Create Collection,seo');
            Route::post('/', 'store')->name('store')->middleware('can:Create Collection,seo');
            Route::get('/{product}', 'show')->name('show')->middleware('can:View Collection,seo');
            Route::get('/{product}/edit', 'edit')->name('edit')->middleware('can:Edit Collection,seo');
            Route::put('/{product}', 'update')->name('update')->middleware('can:Edit Collection,seo');
            Route::delete('/{product}', 'destroy')->name('destroy')->middleware('can:Delete Collection,seo');
            Route::patch('/{product}/status', 'updateStatus')->name('status')->middleware('can:Edit Collection,seo');
            Route::patch('/{product}/featured', 'updateFeatured')->name('featured')->middleware('can:Edit Collection,seo');
            Route::patch('/{product}/bestseller', 'updateBestseller')->name('bestseller')->middleware('can:Edit Collection,seo');
            Route::get('/api/categories', 'getCategories')->name('categories.api')->middleware('can:View Collection,seo');
        });
 // Categories Management - Updated with proper permissions
Route::controller(CategoryController::class)->prefix('categories')->name('categories.')->group(function () {
    Route::get('/', 'index')->name('index')->middleware('can:View Collection,seo');
    Route::get('/create', 'create')->name('create')->middleware('can:Create Collection,seo');
    Route::post('/', 'store')->name('store')->middleware('can:Create Collection,seo');
    Route::get('/{category}', 'show')->name('show')->middleware('can:View Collection,seo');
    Route::get('/{category}/edit', 'edit')->name('edit')->middleware('can:Edit Collection,seo');
    Route::put('/{category}', 'update')->name('update')->middleware('can:Edit Collection,seo');
    Route::delete('/{category}', 'destroy')->name('destroy')->middleware('can:Delete Collection,seo');
    Route::post('/{category}/status', 'updateStatus')->name('update-status')->middleware('can:Edit Collection,seo');
    Route::post('/{category}/featured', 'updateFeatured')->name('update-featured')->middleware('can:Edit Collection,seo');
});
        // Pages Management
        Route::controller(PageController::class)->prefix('pages')->name('pages.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{page}', 'show')->name('show');
            Route::get('/{page}/edit', 'edit')->name('edit');
            Route::put('/{page}', 'update')->name('update');
            Route::delete('/{page}', 'destroy')->name('destroy');
            Route::post('/{page}/duplicate', 'duplicate')->name('duplicate');
            Route::patch('/{page}/status', 'updateStatus')->name('status');
        });

        // Blogs Management
   Route::controller(BlogController::class)->prefix('blogs')->name('blogs.')->group(function () {
    Route::get('/', 'index')->name('index')->middleware('can:View Blogs,seo');
    Route::get('/create', 'create')->name('create')->middleware('can:Create Blogs,seo');
    Route::post('/', 'store')->name('store')->middleware('can:Create Blogs,seo');
    Route::get('/{blog}', 'show')->name('show')->middleware('can:View Blogs,seo');
    Route::get('/{blog}/edit', 'edit')->name('edit')->middleware('can:Edit Blogs,seo');
    Route::put('/{blog}', 'update')->name('update')->middleware('can:Edit Blogs,seo');
    Route::delete('/{blog}', 'destroy')->name('destroy')->middleware('can:Delete Blogs,seo');
    Route::post('/{blog}/duplicate', 'duplicate')->name('duplicate')->middleware('can:Create Blogs,seo');
    Route::patch('/{blog}/status', 'updateStatus')->name('status')->middleware('can:Edit Blogs,seo');
     Route::post('/{blog}/analyze-seo', 'analyzeSeo')->name('analyze-seo')->middleware('can:Edit Blogs,seo');
    Route::post('/preview-seo', 'previewSeo')->name('preview-seo')->middleware('can:Create Blogs,seo');
});

        // Collections Management
        Route::controller(CollectionController::class)->prefix('collections')->name('collections.')->group(function () {
            Route::get('/', 'index')->name('index')->middleware('can:View Collection,seo');
            Route::get('/categories', 'categories')->name('categories')->middleware('can:View Collection,seo');
            Route::get('/create', 'create')->name('create')->middleware('can:Create Collection,seo');
            Route::post('/', 'store')->name('store')->middleware('can:Create Collection,seo');
            Route::get('/{collection}', 'show')->name('show')->middleware('can:View Collection,seo');
            Route::get('/{collection}/edit', 'edit')->name('edit')->middleware('can:Edit Collection,seo');
            Route::put('/{collection}', 'update')->name('update')->middleware('can:Edit Collection,seo');
            Route::delete('/{collection}', 'destroy')->name('destroy')->middleware('can:Delete Collection,seo');
        });

        // Schema Markup
        Route::controller(SchemaMarkupController::class)->prefix('schema')->name('schema.')->group(function () {
            Route::get('/', 'index')->name('index')->middleware('can:View Schema Markup,seo');
            Route::get('/create', 'create')->name('create')->middleware('can:Create Schema Markup,seo');
            Route::post('/', 'store')->name('store')->middleware('can:Create Schema Markup,seo');
            Route::get('/{schema}', 'show')->name('show')->middleware('can:View Schema Markup,seo');
            Route::get('/{schema}/edit', 'edit')->name('edit')->middleware('can:Edit Schema Markup,seo');
            Route::put('/{schema}', 'update')->name('update')->middleware('can:Edit Schema Markup,seo');
            Route::delete('/{schema}', 'destroy')->name('destroy')->middleware('can:Delete Schema Markup,seo');
            Route::post('/validate', 'validate')->name('validate')->middleware('can:View Schema Markup,seo');
            Route::get('/template', [SchemaMarkupController::class, 'getTemplate'])->name('template')->middleware('can:View Schema Markup,seo');
        });
   Route::controller(SitemapController::class)
    ->prefix('sitemap')
    ->name('sitemap.')
    ->group(function () {
        Route::get('/', 'index')->name('index')->middleware('can:View Sitemap,seo');
        Route::get('/create', 'create')->name('create')->middleware('can:Create Sitemap,seo');
        Route::post('/store', 'store')->name('store')->middleware('can:Create Sitemap,seo');
        Route::get('/{sitemap}', 'show')->name('show')->middleware('can:View Sitemap,seo');
        Route::get('/{sitemap}/edit', 'edit')->name('edit')->middleware('can:Edit Sitemap,seo');
        Route::put('/{sitemap}', 'update')->name('update')->middleware('can:Edit Sitemap,seo');
        Route::delete('/{sitemap}', 'destroy')->name('destroy')->middleware('can:Delete Sitemap,seo');
        Route::post('/{sitemap}/status', 'updateStatus')->name('updateStatus')->middleware('can:Edit Sitemap,seo');
        Route::post('/generate', 'generate')->name('generate')->middleware('can:Edit Sitemap,seo');
        Route::get('/download/xml', 'download')->name('download')->middleware('can:View Sitemap,seo');
        Route::post('/submit-google', 'submitToGoogle')->name('submit-google')->middleware('can:Edit Sitemap,seo');
    });

        // Robots.txt
        Route::controller(RobotsController::class)->prefix('robots')->name('robots.')->group(function () {
            Route::get('/', 'index')->name('index')->middleware('can:View Robots,seo');
            Route::put('/', 'update')->name('update')->middleware('can:Edit Robots,seo');
            Route::post('/validate', 'validate')->name('validate')->middleware('can:View Robots,seo');
           Route::post('/{sitemap}/status', 'updateStatus')->name('status')->middleware('can:Edit Sitemap,seo');
        });

        // Redirect Manager
        Route::controller(RedirectController::class)->prefix('redirects')->name('redirects.')->group(function () {
            Route::get('/', 'index')->name('index')->middleware('can:View Redirect Manager,seo');
            Route::get('/create', 'create')->name('create')->middleware('can:Create Redirect Manager,seo');
            Route::post('/', 'store')->name('store')->middleware('can:Create Redirect Manager,seo');
            Route::get('/{redirect}/edit', 'edit')->name('edit')->middleware('can:Edit Redirect Manager,seo');
            Route::put('/{redirect}', 'update')->name('update')->middleware('can:Edit Redirect Manager,seo');
            Route::delete('/{redirect}', 'destroy')->name('destroy')->middleware('can:Delete Redirect Manager,seo');
            Route::post('/bulk-import', 'bulkImport')->name('bulk-import')->middleware('can:Create Redirect Manager,seo');
            Route::get('/export', 'export')->name('export')->middleware('can:View Redirect Manager,seo');
        });

        // 404 Suggestions
        Route::controller(SuggestionController::class)->prefix('suggestions')->name('suggestions.')->group(function () {
            Route::get('/', 'index')->name('index')->middleware('can:View 404 Suggestion,seo');
            Route::post('/{suggestion}/resolve', 'resolve')->name('resolve')->middleware('can:Create Redirect Manager,seo');
            Route::delete('/{suggestion}', 'destroy')->name('destroy')->middleware('can:Delete 404 Suggestion,seo');
            Route::post('/scan', 'scan')->name('scan')->middleware('can:Create 404 Suggestion,seo');
        });

        // Google Merchant Center
        Route::controller(MerchantController::class)->prefix('merchant')->name('merchant.')->group(function () {
            Route::get('/', 'index')->name('index')->middleware('can:seo view analytics,seo');
            Route::post('/sync-products', 'syncProducts')->name('sync-products')->middleware('can:seo view analytics,seo');
            Route::get('/feed', 'generateFeed')->name('feed')->middleware('can:seo view analytics,seo');
        });

        // Team Management
        Route::controller(TeamController::class)->prefix('team')->name('team.')->group(function () {
            Route::get('/', 'index')->name('index')->middleware('can:seo manage team,seo');
            Route::get('/create', 'create')->name('create')->middleware('can:seo invite members,seo');
            Route::post('/', 'store')->name('store')->middleware('can:seo invite members,seo');
            Route::get('/{member}/edit', 'edit')->name('edit')->middleware('can:seo manage team,seo');
            Route::put('/{member}', 'update')->name('update')->middleware('can:seo manage team,seo');
            Route::delete('/{member}', 'destroy')->name('destroy')->middleware('can:seo manage team,seo');
        });

        // Profile Management
        Route::controller(ProfileController::class)->group(function () {
            Route::get('/profile', 'edit')->name('profile.edit');
            Route::patch('/profile', 'update')->name('profile.update');
            Route::delete('/profile', 'destroy')->name('profile.destroy');
        });

        // Password Management
        Route::put('/password', [PasswordController::class, 'update'])->name('password.update');

        // Logout
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    });
});
