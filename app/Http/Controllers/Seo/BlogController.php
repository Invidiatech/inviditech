<?php
namespace App\Http\Controllers\Seo;

use App\Http\Controllers\Controller;
use App\Models\Seo\SeoBlog;
use App\Models\Category;
use App\Services\SeoAnalyzer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\Tag;

class BlogController extends Controller
{
    protected $seoAnalyzer;

    public function __construct()
    {
        // Make SeoAnalyzer optional in case it doesn't exist
        if (class_exists('App\Services\SeoAnalyzer')) {
            $this->seoAnalyzer = app('App\Services\SeoAnalyzer');
        }
    }

    /**
     * Display a listing of blogs
     */
    public function index(Request $request)
    {
        $query = SeoBlog::with(['category', 'tags']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('meta_description', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $blogs = $query->latest()->paginate(15);

        // Get categories that have blogs
        $categories = Category::whereHas('articles')->get();

        // SEO Analytics for all blogs
        $seoStats = [
            'total_blogs' => SeoBlog::count(),
            'published_blogs' => SeoBlog::where('status', 'published')->count(),
            'draft_blogs' => SeoBlog::where('status', 'draft')->count(),
            'avg_seo_score' => round(SeoBlog::where('seo_score', '>', 0)->avg('seo_score') ?? 0),
            'blogs_missing_meta' => SeoBlog::whereNull('meta_description')->orWhere('meta_description', '')->count(),
            'blogs_missing_focus_keyword' => SeoBlog::whereNull('focus_keyword')->orWhere('focus_keyword', '')->count(),
        ];
         return view('seo.blogs.index', compact('blogs', 'categories', 'seoStats'));
    }

    /**
     * Show the form for creating a new blog
     */
    public function create()
    {
        $categories = Category::select('id', 'name')
            ->where('is_active', true)
            ->orderBy('sort_order', 'desc')
            ->orderBy('name', 'asc')
            ->get();

        $tags = Tag::select('id', 'name')->orderBy('name')->get();

        return view('seo.blogs.create', compact('categories', 'tags'));
    }

   public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('seo_blogs', 'slug')],
            'excerpt' => 'nullable|string|max:500',
            'is_indexed' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'category' => 'required|exists:categories,id',
            'tags' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'featured_image_alt' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|min:30|max:60',
            'meta_description' => 'nullable|string|min:120|max:160',
            'focus_keyword' => 'nullable|string|max:100',
            'canonical_url' => 'nullable|url|max:255',
            'og_title' => 'nullable|string|max:60',
            'og_description' => 'nullable|string|max:160',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'twitter_title' => 'nullable|string|max:60',
            'twitter_description' => 'nullable|string|max:160',
            'schema_markup' => 'nullable|json',
            'status' => 'required|in:draft,published,scheduled',
            'published_at' => 'nullable|date|required_if:status,scheduled',
            'reading_time' => 'nullable|integer|min:1'
        ], [
            // Custom error messages
            'meta_title.min' => 'The meta title should be at least 30 characters for better SEO.',
            'meta_title.max' => 'The meta title should not exceed 60 characters.',
            'meta_description.min' => 'The meta description should be at least 120 characters for better SEO.',
            'meta_description.max' => 'The meta description should not exceed 160 characters.'
        ]);

        // Store tags separately (not part of the blog table)
        $tagsInput = $validated['tags'] ?? null;
        unset($validated['tags']); // Remove tags from validated data to prevent SQL error

        // Set created_by
        $validated['created_by'] = auth('seo')->id();

        try {
            // Auto-generate slug if not provided
            if (empty($validated['slug'])) {
                $validated['slug'] = Str::slug($validated['title']);

                // Ensure slug is unique
                $originalSlug = $validated['slug'];
                $counter = 1;
                while (SeoBlog::where('slug', $validated['slug'])->exists()) {
                    $validated['slug'] = $originalSlug . '-' . $counter;
                    $counter++;
                }
            }

            // Handle featured image upload
            if ($request->hasFile('featured_image')) {
                $validated['featured_image'] = $request->file('featured_image')->store('seo/blogs/featured', 'public');
            }

            // Handle OG image upload
            if ($request->hasFile('og_image')) {
                $validated['og_image'] = $request->file('og_image')->store('seo/blogs/og', 'public');
            }

            // Auto-generate meta fields if not provided
            if (empty($validated['meta_title'])) {
                $validated['meta_title'] = Str::limit($validated['title'], 60);
            }

            if (empty($validated['excerpt'])) {
                $validated['excerpt'] = Str::limit(strip_tags($validated['content']), 150);
            }

            if (empty($validated['meta_description'])) {
                $validated['meta_description'] = Str::limit(strip_tags($validated['content']), 160);
            }

            // Calculate reading time if not provided
            if (empty($validated['reading_time'])) {
                $wordCount = str_word_count(strip_tags($validated['content']));
                $validated['reading_time'] = max(1, round($wordCount / 200));
            }

            // Set publish date based on status
            if ($validated['status'] === 'published') {
                $validated['publish_date'] = now();
            } elseif ($validated['status'] === 'scheduled' && isset($validated['published_at'])) {
                $validated['publish_date'] = $validated['published_at'];
            }

            // Set default values for boolean fields
            $validated['is_indexed'] = $request->boolean('is_indexed', true);
            $validated['is_featured'] = $request->boolean('is_featured', false);

            // Create blog
            $blog = SeoBlog::create($validated);

            // Handle tags if provided
            if (!empty($tagsInput)) {
                $tagNames = array_map('trim', explode(',', $tagsInput));
                $tagIds = [];

                foreach ($tagNames as $tagName) {
                    if (!empty($tagName)) {
                        $tag = Tag::firstOrCreate(
                            ['slug' => Str::slug($tagName)],
                            [
                                'name' => $tagName,
                                'slug' => Str::slug($tagName),
                                'meta_title' => $tagName . ' - ' . config('app.name'),
                                'meta_description' => 'Learn about ' . $tagName . ' with our comprehensive guides.'
                            ]
                        );
                        $tagIds[] = $tag->id;
                    }
                }

                // Attach tags to the blog post
                $blog->tags()->sync($tagIds);
            }

            // Perform SEO analysis if service exists
            $successMessage = 'Blog created successfully!';
            if ($this->seoAnalyzer) {
                try {
                    $seoData = $this->seoAnalyzer->analyzeBlog($blog);

                    if (is_array($seoData) && isset($seoData['score'])) {
                        $blog->update([
                            'seo_score' => $seoData['score'],
                            'seo_analysis' => isset($seoData['analysis']) ? json_encode($seoData['analysis']) : null
                        ]);
                        $successMessage = 'Blog created successfully with SEO score: ' . $seoData['score'] . '%';
                    }
                } catch (\Exception $seoException) {
                    Log::warning('SEO analysis failed for blog ID ' . $blog->id . ': ' . $seoException->getMessage());
                }
            }

            return redirect()->route('seo.blogs.index')
                ->with('success', $successMessage);

        } catch (\Exception $e) {
            Log::error('Error creating blog: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error creating blog: ' . $e->getMessage())
                ->withInput();
        }
    }


    /**
     * Update the specified blog
     */
public function update(Request $request, $id)
{
    $blog = SeoBlog::findOrFail($id);
    
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'slug' => ['nullable', 'string', 'max:255', Rule::unique('seo_blogs', 'slug')->ignore($blog->id)],
        'content' => 'required|string',
        'excerpt' => 'nullable|string|max:500',
        'category' => 'required|exists:categories,id',
        'tags' => 'nullable|string',
        'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'featured_image_alt' => 'nullable|string|max:255',
        'meta_title' => 'nullable|string|max:60',
        'meta_description' => 'nullable|string|max:160',
        'focus_keyword' => 'nullable|string|max:100',
        'canonical_url' => 'nullable|url|max:255',
        'og_title' => 'nullable|string|max:60',
        'og_description' => 'nullable|string|max:160',
        'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'twitter_title' => 'nullable|string|max:60',
        'twitter_description' => 'nullable|string|max:160',
        'schema_markup' => 'nullable|json',
        'status' => 'required|in:draft,published,scheduled',
        'published_at' => 'nullable|date',
        'reading_time' => 'nullable|integer|min:1',
        'is_indexed' => 'nullable|boolean',
        'is_featured' => 'nullable|boolean'
    ]);

    // Store tags separately (not part of the blog table)
    $tagsInput = $validated['tags'] ?? null;
    unset($validated['tags']); // Remove tags from validated data to prevent SQL error

    // Handle featured image upload
    if ($request->hasFile('featured_image')) {
        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }
        $validated['featured_image'] = $request->file('featured_image')->store('seo/blogs/featured', 'public');
    }

    // Handle OG image upload
    if ($request->hasFile('og_image')) {
        if ($blog->og_image) {
            Storage::disk('public')->delete($blog->og_image);
        }
        $validated['og_image'] = $request->file('og_image')->store('seo/blogs/og', 'public');
    }

    // Update reading time if content changed
    if (($validated['content'] !== $blog->content) && empty($validated['reading_time'])) {
        $wordCount = str_word_count(strip_tags($validated['content']));
        $validated['reading_time'] = max(1, round($wordCount / 200));
    }

    // Set publish date based on status changes
    if ($validated['status'] === 'published' && $blog->status !== 'published') {
        $validated['publish_date'] = now();
    } elseif ($validated['status'] === 'scheduled' && isset($validated['published_at'])) {
        $validated['publish_date'] = $validated['published_at'];
    }

    // Set boolean values
    $validated['is_indexed'] = $request->boolean('is_indexed', true);
    $validated['is_featured'] = $request->boolean('is_featured', false);

    // Update blog
    $blog->update($validated);

    // Handle tags
    if ($tagsInput !== null) {
        if (!empty($tagsInput)) {
            $tagNames = array_map('trim', explode(',', $tagsInput));
            $tagIds = [];

            foreach ($tagNames as $tagName) {
                if (!empty($tagName)) {
                    $tag = Tag::firstOrCreate(
                        ['slug' => Str::slug($tagName)],
                        [
                            'name' => $tagName,
                            'slug' => Str::slug($tagName),
                            'meta_title' => $tagName . ' - ' . config('app.name'),
                            'meta_description' => 'Learn about ' . $tagName . ' with our comprehensive guides.'
                        ]
                    );
                    $tagIds[] = $tag->id;
                }
            }

            $blog->tags()->sync($tagIds);
        } else {
            // If tags input is empty, detach all tags
            $blog->tags()->detach();
        }
    }
    // If tagsInput is null (not provided in the request), don't change the tags

    // Perform SEO analysis if service exists
    $successMessage = 'Blog updated successfully!';
    if ($this->seoAnalyzer) {
        try {
            $seoData = $this->seoAnalyzer->analyzeBlog($blog);
            $blog->update([
                'seo_score' => $seoData['score'] ?? 0,
                'seo_analysis' => isset($seoData['analysis']) ? json_encode($seoData['analysis']) : null
            ]);
            $successMessage = 'Blog updated successfully with SEO score: ' . ($seoData['score'] ?? 0) . '%';
        } catch (\Exception $e) {
            Log::warning('SEO analysis failed during update: ' . $e->getMessage());
        }
    }

    return redirect()->route('seo.blogs.index')
        ->with('success', $successMessage);
}

    /**
     * Display the specified blog
     */
    public function show($id)
    {
        $blog = SeoBlog::with(['category', 'tags', 'creator'])->findOrFail($id);
        
        // Perform fresh SEO analysis if service exists
        $seoData = ['score' => $blog->seo_score ?? 0, 'analysis' => []];
        if ($this->seoAnalyzer) {
            try {
                $seoData = $this->seoAnalyzer->analyzeBlog($blog);
            } catch (\Exception $e) {
                $seoData = ['score' => 0, 'analysis' => ['error' => 'SEO analysis unavailable']];
            }
        }

        return view('seo.blogs.show', compact('blog', 'seoData'));
    }

    /**
     * Show the form for editing the specified blog
     */
    public function edit($id)
    {
        $blog = SeoBlog::with(['category', 'tags'])->findOrFail($id);
        
        $categories = Category::select('id', 'name')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
            
        $tags = Tag::select('id', 'name')->orderBy('name')->get();

        // Get current SEO analysis if service exists
        $seoData = ['score' => $blog->seo_score ?? 0, 'analysis' => []];
        if ($this->seoAnalyzer) {
            try {
                $seoData = $this->seoAnalyzer->analyzeBlog($blog);
            } catch (\Exception $e) {
                $seoData = ['score' => 0, 'analysis' => ['error' => 'SEO analysis unavailable']];
            }
        }

        return view('seo.blogs.edit', compact('blog', 'categories', 'tags', 'seoData'));
    }

    /**
     * Update the specified blog
     */
    

    /**
     * Remove the specified blog
     */
    public function destroy($id)
    {
          $blog = SeoBlog::findOrFail($id);
        
        // Delete associated images
        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }
        if ($blog->og_image) {
            Storage::disk('public')->delete($blog->og_image);
        }

        $blog->delete();

        return redirect()->route('seo.blogs.index')
            ->with('success', 'Blog deleted successfully.');
    }

    /**
     * Update blog status (AJAX)
     */
    public function updateStatus(Request $request, $id)
    {
        $blog = SeoBlog::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:draft,published,scheduled'
        ]);

        $blog->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully'
            ]);
        }

        return redirect()->back()->with('success', 'Status updated successfully');
    }

    /**
     * Duplicate a blog
     */
    public function duplicate($id)
    {
        $blog = SeoBlog::findOrFail($id);
        
        $newBlog = $blog->replicate();
        $newBlog->title = $blog->title . ' (Copy)';
        $newBlog->slug = Str::slug($newBlog->title);

        // Ensure slug is unique
        $originalSlug = $newBlog->slug;
        $counter = 1;
        while (SeoBlog::where('slug', $newBlog->slug)->exists()) {
            $newBlog->slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $newBlog->status = 'draft';
        $newBlog->publish_date = null;
        $newBlog->seo_score = 0;
        $newBlog->seo_analysis = null;
        $newBlog->save();

        // Copy tags
        $newBlog->tags()->sync($blog->tags->pluck('id'));

        return redirect()->route('seo.blogs.edit', $newBlog->id)
            ->with('success', 'Blog duplicated successfully.');
    }

    /**
     * Analyze SEO for a specific blog (AJAX)
     */
    public function analyzeSeo(Request $request, $id)
    {
        $blog = SeoBlog::findOrFail($id);
        
        if (!$this->seoAnalyzer) {
            return response()->json([
                'score' => 0,
                'analysis' => ['error' => 'SEO analyzer service not available']
            ], 500);
        }

        try {
            $seoData = $this->seoAnalyzer->analyzeBlog($blog);

            $blog->update([
                'seo_score' => $seoData['score'] ?? 0,
                'seo_analysis' => isset($seoData['analysis']) ? json_encode($seoData['analysis']) : null
            ]);

            return response()->json($seoData);
        } catch (\Exception $e) {
            return response()->json([
                'score' => 0,
                'analysis' => ['error' => 'SEO analysis failed: ' . $e->getMessage()]
            ], 500);
        }
    }

    /**
     * Get blog preview for SEO analysis (AJAX)
     */
    public function previewSeo(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'meta_description' => 'nullable|string',
            'focus_keyword' => 'nullable|string'
        ]);

        if (!$this->seoAnalyzer) {
            return response()->json([
                'score' => 0,
                'analysis' => ['error' => 'SEO analyzer service not available']
            ], 500);
        }

        try {
            $tempBlog = new SeoBlog($data);
            $seoData = $this->seoAnalyzer->analyzeBlog($tempBlog);

            return response()->json($seoData);
        } catch (\Exception $e) {
            return response()->json([
                'score' => 0,
                'analysis' => ['error' => 'SEO analysis failed: ' . $e->getMessage()]
            ], 500);
        }
    }
}