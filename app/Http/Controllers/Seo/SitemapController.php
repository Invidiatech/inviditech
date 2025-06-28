<?php

namespace App\Http\Controllers\Seo;

use App\Http\Controllers\Controller;
use App\Models\Seo\SeoSitemap;
use App\Models\Product;
use App\Models\Category;
use App\Models\Seo\SeoBlog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SitemapController extends Controller
{
    /**
     * Display sitemap management page
     */
    public function index()
    {
        $sitemaps = SeoSitemap::with('creator')
            ->latest()
            ->paginate(15);

        // Statistics
        $stats = [
            'total' => SeoSitemap::count(),
            'active' => SeoSitemap::where('status', 'active')->count(),
            'submitted' => SeoSitemap::where('submitted_to_google', true)->count(),
            'total_urls' => SeoSitemap::sum('total_urls'),
        ];

        return view('seo.sitemap.index', compact('sitemaps', 'stats'));
    }

    /**
     * Show form to create new sitemap
     */
    public function create()
    {
        $sitemapTypes = SeoSitemap::SITEMAP_TYPES;
        $changeFrequencies = SeoSitemap::CHANGE_FREQUENCIES;

        // Get counts for each type
        $counts = [
            'pages' => $this->getStaticPagesCount(),
            'blogs' => SeoBlog::where('status', 'published')->count(),
            'products' => Product::count(),
            'categories' => Category::count(),
        ];

        return view('seo.sitemap.create', compact('sitemapTypes', 'changeFrequencies', 'counts'));
    }

    /**
     * Store new sitemap
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'type' => 'required|in:' . implode(',', array_keys(SeoSitemap::SITEMAP_TYPES)),
        'status' => 'required|in:active,inactive',
        'change_frequency' => 'required|in:' . implode(',', array_keys(SeoSitemap::CHANGE_FREQUENCIES)),
        'priority' => 'required|numeric|min:0|max:1',
        'custom_urls' => 'nullable|string',
    ]);

    try {
         $urls = $this->generateUrlsByType($validated['type'], $request->custom_urls);

        if (empty($urls)) {
            return redirect()->back()
                ->with('error', 'No URLs found for the selected type. Please check your data.')
                ->withInput();
        }

        $sitemap = SeoSitemap::create([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'urls' => $urls,
            'settings' => [
                'change_frequency' => $validated['change_frequency'],
                'priority' => $validated['priority'],
            ],
            'status' => $validated['status'],
            'total_urls' => count($urls),
            'created_by' => Auth::guard('seo')->id(),
        ]);

        // Generate the XML file
        $this->generateSitemapXML($sitemap);

        return redirect()->route('seo.sitemap.index')
            ->with('success', 'Sitemap created successfully with ' . count($urls) . ' URLs.');

    } catch (\Exception $e) {
        Log::error('Error creating sitemap: ' . $e->getMessage(), [
            'request_data' => $validated,
            'stack_trace' => $e->getTraceAsString()
        ]);
        return redirect()->back()
            ->with('error', 'Error creating sitemap: ' . $e->getMessage())
            ->withInput();
    }
}

    /**
     * Show sitemap details
     */
    public function show(SeoSitemap $sitemap)
    {
        $sitemap->load('creator');
        return view('seo.sitemap.show', compact('sitemap'));
    }

    /**
     * Show edit form
     */
    public function edit(SeoSitemap $sitemap)
    {
        $sitemapTypes = SeoSitemap::SITEMAP_TYPES;
        $changeFrequencies = SeoSitemap::CHANGE_FREQUENCIES;

        return view('seo.sitemap.edit', compact('sitemap', 'sitemapTypes', 'changeFrequencies'));
    }

    /**
     * Update sitemap
     */
    public function update(Request $request, SeoSitemap $sitemap)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:' . implode(',', array_keys(SeoSitemap::SITEMAP_TYPES)),
            'status' => 'required|in:active,inactive',
            'change_frequency' => 'required|in:' . implode(',', array_keys(SeoSitemap::CHANGE_FREQUENCIES)),
            'priority' => 'required|numeric|min:0|max:1',
            'custom_urls' => 'nullable|string',
        ]);

        try {
            // Generate URLs based on type
            $urls = $this->generateUrlsByType($validated['type'], $request->custom_urls);

            $sitemap->update([
                'name' => $validated['name'],
                'type' => $validated['type'],
                'urls' => $urls,
                'settings' => [
                    'change_frequency' => $validated['change_frequency'],
                    'priority' => $validated['priority'],
                ],
                'status' => $validated['status'],
                'total_urls' => count($urls),
            ]);

            // Regenerate the XML file
            $this->generateSitemapXML($sitemap);

            return redirect()->route('seo.sitemap.index')
                ->with('success', 'Sitemap updated successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating sitemap: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Delete sitemap
     */
    public function destroy(SeoSitemap $sitemap)
    {
        try {
            // Delete XML file if exists
            if ($sitemap->file_path && file_exists(public_path($sitemap->file_path))) {
                unlink(public_path($sitemap->file_path));
            }

            $sitemap->delete();

            return redirect()->route('seo.sitemap.index')
                ->with('success', 'Sitemap deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting sitemap.');
        }
    }

    /**
     * Update sitemap status
     */
    public function updateStatus(Request $request, SeoSitemap $sitemap)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,inactive'
        ]);

        $sitemap->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', 'Sitemap status updated successfully.');
    }

    /**
     * Generate sitemap XML file
     */
    public function generate(Request $request)
    {
        $request->validate([
            'sitemap_id' => 'required|exists:seo_sitemaps,id'
        ]);

        $sitemap = SeoSitemap::findOrFail($request->sitemap_id);

        try {
            // Regenerate URLs
            $urls = $this->generateUrlsByType($sitemap->type);
            $sitemap->update([
                'urls' => $urls,
                'total_urls' => count($urls)
            ]);

            // Generate XML
            $this->generateSitemapXML($sitemap);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Sitemap generated successfully',
                    'url_count' => count($urls)
                ]);
            }

            return redirect()->back()
                ->with('success', 'Sitemap generated successfully with ' . count($urls) . ' URLs.');

        } catch (\Exception $e) {
            Log::error('Error generating sitemap: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error generating sitemap: ' . $e->getMessage()
                ]);
            }

            return redirect()->back()
                ->with('error', 'Error generating sitemap: ' . $e->getMessage());
        }
    }

    /**
     * Download sitemap XML
     */
    public function download(Request $request)
    {
        $sitemap = SeoSitemap::findOrFail($request->get('sitemap_id'));

        if (!$sitemap->file_path || !file_exists(public_path($sitemap->file_path))) {
            return redirect()->back()->with('error', 'Sitemap file not found. Please generate first.');
        }

        return response()->download(public_path($sitemap->file_path));
    }

    /**
     * Submit sitemap to Google
     */
    public function submitToGoogle(Request $request)
    {
        $sitemap = SeoSitemap::findOrFail($request->sitemap_id);
        if (!$sitemap->file_path) {
            return response()->json([
                'success' => false,
                'message' => 'Please generate sitemap first'
            ]);
        }

        try {
            $sitemapUrl = url($sitemap->file_path);

            // Submit to Google Search Console (this is a simplified example)
            // In reality, you'd use Google Search Console API
            $response = Http::get('https://www.google.com/ping', [
                'sitemap' => $sitemapUrl
            ]);
               $sitemap->update([
                'submitted_to_google' => true,
                'google_submission_date' => now(),
                'google_submission_status' => $response->successful() ? 'success' : 'failed'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Sitemap submitted to Google successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error submitting to Google: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Generate URLs by type
     */
private function generateUrlsByType($type, $customUrls = null)
{
    $urls = [];
    try {
        switch ($type) {
            case 'pages':
                $urls = $this->getStaticPageUrls();
                break;
            case 'blogs':
                $blogs = SeoBlog::where('status', 'published')
                    ->where('is_indexed', true)
                    ->get();
                foreach ($blogs as $blog) {
                    try {
                        $urls[] = [
                            'loc' => route('blog.show', $blog->slug),
                            'lastmod' => $blog->updated_at->format('Y-m-d'),
                        ];
                    } catch (\Exception $e) {
                    }
                }
                break;

            case 'products':
                $products = Product::with('category')->get();
                foreach ($products as $product) {
                    try {
                        if (empty($product->slug)) {
                            continue;
                        }
                        $urls[] = [
                            'loc' => route('products.show', $product->slug),
                            'lastmod' => $product->updated_at->format('Y-m-d'),
                        ];
                    } catch (\Exception $e) {
                    }
                }
                break;

            case 'categories':
                $categories = Category::where('is_active', true)->get();
                foreach ($categories as $category) {
                    try {
                        $urls[] = [
                            'loc' => route('products') . '?category=' . $category->id,
                            'lastmod' => $category->updated_at->format('Y-m-d'),
                        ];
                    } catch (\Exception $e) {

                    }
                }
                break;
            case 'custom':
                if ($customUrls) {
                    $urlList = explode("\n", $customUrls);
                    foreach ($urlList as $url) {
                        $url = trim($url);
                        if (!empty($url)) {
                            // Validate URL format
                            if (filter_var($url, FILTER_VALIDATE_URL) ||
                                (strpos($url, '/') === 0) ||
                                (strpos($url, 'http') === 0)) {
                                $urls[] = [
                                    'loc' => $url,
                                    'lastmod' => now()->format('Y-m-d'),
                                ];
                            } else {
                            }
                        }
                    }
                }
                break;

            default:
                throw new \Exception("Unknown sitemap type: {$type}");
        }

    } catch (\Exception $e) {
        throw $e;
    }

    return $urls;
}

    /**
     * Get static page URLs
     */
 private function getStaticPageUrls()
{
    $urls = [];

    // Add routes that actually exist in your application
    $staticRoutes = [
        ['route' => '/', 'name' => 'Home Page'],
        ['route' => 'about', 'name' => 'About Page'],
        ['route' => 'contact', 'name' => 'Contact Page'],
    ];

    foreach ($staticRoutes as $routeData) {
        try {
            if ($routeData['route'] === '/') {
                $url = url('/');
            } else {
                // Check if named route exists
                if (\Route::has($routeData['route'])) {
                    $url = route($routeData['route']);
                } else {
                    $url = url('/' . $routeData['route']);
                }
            }

            $urls[] = [
                'loc' => $url,
                'lastmod' => now()->format('Y-m-d'),
            ];
        } catch (\Exception $e) {
            Log::warning('Could not generate static page URL', [
                'route' => $routeData['route'],
                'error' => $e->getMessage()
            ]);
        }
    }

    // Add products listing page if route exists
    try {
        if (\Route::has('products')) {
            $urls[] = [
                'loc' => route('products'),
                'lastmod' => now()->format('Y-m-d'),
            ];
        }
    } catch (\Exception $e) {
        Log::warning('Products route not found', ['error' => $e->getMessage()]);
    }

    return $urls;
}

/**
 * Get static pages count
 */
private function getStaticPagesCount()
{
    return count($this->getStaticPageUrls());
}

    /**
     * Generate XML sitemap file
     */
    private function generateSitemapXML(SeoSitemap $sitemap)
    {
        $xml = new \DOMDocument('1.0', 'UTF-8');
        $xml->formatOutput = true;

        $urlset = $xml->createElement('urlset');
        $urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        $xml->appendChild($urlset);

        foreach ($sitemap->urls as $urlData) {
            $url = $xml->createElement('url');

            $loc = $xml->createElement('loc', htmlspecialchars($urlData['loc']));
            $url->appendChild($loc);

            if (isset($urlData['lastmod'])) {
                $lastmod = $xml->createElement('lastmod', $urlData['lastmod']);
                $url->appendChild($lastmod);
            }

            if ($sitemap->settings) {
                if (isset($sitemap->settings['change_frequency'])) {
                    $changefreq = $xml->createElement('changefreq', $sitemap->settings['change_frequency']);
                    $url->appendChild($changefreq);
                }

                if (isset($sitemap->settings['priority'])) {
                    $priority = $xml->createElement('priority', $sitemap->settings['priority']);
                    $url->appendChild($priority);
                }
            }

            $urlset->appendChild($url);
        }

        // Save to public directory
        $filename = 'sitemap-' . $sitemap->type . '-' . $sitemap->id . '.xml';
        $filepath = 'sitemaps/' . $filename;

        // Create directory if it doesn't exist
        if (!file_exists(public_path('sitemaps'))) {
            mkdir(public_path('sitemaps'), 0755, true);
        }

        $xml->save(public_path($filepath));

        // Update sitemap record
        $sitemap->update([
            'file_path' => $filepath,
            'last_generated' => now()
        ]);
    }
}
