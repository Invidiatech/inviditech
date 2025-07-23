<?php
namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Seo\SeoBlog;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Like;
use App\Models\BookMark;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;
 
class PageController extends Controller
{
    /**
     * Display the home page.
     */
    public function home(): View
    {
        // Get published blogs with their relationships - proper eager loading
        $blogs = SeoBlog::with(['category', 'tags'])
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('publish_date')
                      ->orWhere('publish_date', '<=', now());
            })
            ->latest('publish_date')
            ->paginate(15);
        
        // Get categories that have published articles
        $categories = Category::whereHas('seoBlogs', function ($query) {
            $query->where('status', 'published')
                  ->where(function ($q) {
                      $q->whereNull('publish_date')
                        ->orWhere('publish_date', '<=', now());
                  });
        })->get();
        
        return view('website.pages.home', compact('blogs', 'categories'));
    }

    public function about()
    {
        return view('website.pages.about');
    }

    public function contact()
    {
        return view('website.pages.contact');
    }

    public function hireUs()
    {
        return view('website.pages.hire-us');
    }

    public function articles(Request $request)
    {
        $categorySlug = $request->query('category');
        $tagSlug = $request->query('tag');
        $search = $request->query('search');
        
        // Base query with proper eager loading
        $articlesQuery = SeoBlog::with(['category', 'tags'])
            ->where('status', 'published')
            ->orderBy('created_at', 'desc');
        
        // Apply search filter if provided
        if ($search) {
            $articlesQuery->where(function($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }
        
        // Apply category filter if provided
        if ($categorySlug) {
            $articlesQuery->whereHas('category', function($query) use ($categorySlug) {
                $query->where('slug', $categorySlug);
            });
        }
        
        // Apply tag filter if provided
        if ($tagSlug) {
            $articlesQuery->whereHas('tags', function($query) use ($tagSlug) {
                $query->where('slug', $tagSlug);
            });
        }
        
        // Get featured articles
        $featuredArticle = SeoBlog::where('is_featured', true)
            ->where('status', 'published')
            ->with(['category', 'tags'])
            ->latest()
            ->first();
            
        // Get paginated articles
        $articles = $articlesQuery->paginate(6);
        
        // Get trending articles (most viewed)
        $trendingArticles = SeoBlog::where('status', 'published')
            ->with(['category', 'tags'])
            ->orderBy('views_count', 'desc')
            ->limit(4)
            ->get();
            
        // Get all categories with count - fixed the relationship name
        $categories = Category::withCount(['seoBlogs' => function($query) {
                $query->where('status', 'published');
            }])
            ->orderBy('seo_blogs_count', 'desc')
            ->get();
            
        // Get popular tags - fixed the relationship name
        $popularTags = Tag::withCount(['seoBlogs' => function($query) {
                $query->where('status', 'published');
            }])
            ->orderBy('seo_blogs_count', 'desc')
            ->limit(12)
            ->get();
        
        return view('website.pages.article', compact(
            'articles', 
            'featuredArticle', 
            'trendingArticles', 
            'categories', 
            'popularTags',
            'categorySlug',
            'tagSlug',
            'search'
        ));
    }

    public function show($slug)
    {
        // Get the article with proper eager loading
        $article = SeoBlog::where('slug', $slug)
            ->where('status', 'published')
            ->with(['category', 'tags'])
            ->firstOrFail();
            
        // Increment view count
        $article->increment('views_count');
 
        // Get related articles - using proper relationship
        $relatedArticles = SeoBlog::where('id', '!=', $article->id)
            ->where('status', 'published')
            ->where(function($query) use ($article) {
                // Use the foreign key 'category' instead of accessing relationship
                $query->where('category', $article->category)
                    ->orWhereHas('tags', function($query) use ($article) {
                        $query->whereIn('tags.id', $article->tags->pluck('id'));
                    });
            })
            ->with(['category', 'tags'])
            ->take(3)
            ->get();
        
        // Get interaction data if user is logged in
        $userLiked = false;
        $userBookmarked = false;
        $userFollowing = false;
        $likesCount = Like::where('seo_blog_id', $article->id)->count();
        
        if (Auth::check()) {
            $user = Auth::user();
            
            $userLiked = Like::where('user_id', $user->id)
                ->where('seo_blog_id', $article->id)
                ->exists();
                
            $userBookmarked = Bookmark::where('user_id', $user->id)
                ->where('seo_blog_id', $article->id)
                ->exists();
                
            $userFollowing = Follow::where('follower_id', $user->id)
                ->where('following_id', $article->created_by)
                ->exists();
        }
        
        return view('website.pages.article-detail', compact(
            'article', 
            'relatedArticles',
            'userLiked',
            'userBookmarked',
            'userFollowing',
            'likesCount'
        ));
    }

    /**
     * Display the tutorials page with Laravel focus.
     */
    public function tutorials(?string $topic = null): View
    {
        // Get all the Laravel categories
        $categories = Category::whereIn('slug', [
            'laravel-basics',
            'eloquent-orm',
            'laravel-apis',
            'authentication',
            'middleware',
            'blade-templates',
            'laravel-packages',
            'deployment'
        ])->orderBy('name')->get();
        
        // Get featured/popular tutorials
        $popularTutorials = SeoBlog::with('category')
            ->where('status', 'published')
            ->latest('publish_date')
            ->take(2)
            ->get();

        $latestTutorials = SeoBlog::with('category')
            ->where('status', 'published')
            ->latest('publish_date')
            ->take(5)
            ->get();
        
        // If a specific topic is selected, filter the tutorials accordingly
        $activeTopic = null;
        $activeCategory = null;
        if ($topic) {
            $activeCategory = Category::where('slug', $topic)->first();
            if ($activeCategory) {
                $activeTopic = $topic;
                // Update queries to filter by the selected category - using foreign key
                $popularTutorials = SeoBlog::with('category')
                    ->where('status', 'published')
                    ->where('category', $activeCategory->id)
                    ->latest('publish_date')
                    ->take(2)
                    ->get();
                    
                $latestTutorials = SeoBlog::with('category')
                    ->where('status', 'published')
                    ->where('category', $activeCategory->id)
                    ->latest('publish_date')
                    ->take(5)
                    ->get();
            }
        }
        
        return view('website.pages.tutorials', [
            'categories' => $categories,
            'popularTutorials' => $popularTutorials,
            'latestTutorials' => $latestTutorials,
            'activeTopic' => $activeTopic,
            'activeCategory' => $activeCategory
        ]);
    }

    /**
     * Display the Laravel references page.
     */
    public function references(): View
    {
        return view('website.pages.references');
    }

    /**
     * Display the services page.
     */
    public function services(): View
    {
        return view('website.pages.services');
    }

    /**
     * Display the enterprise page.
     */
    public function enterprise(): View
    {
        return view('website.pages.enterprise');
    }

    /**
     * Display the blog page with Laravel focus.
     */
    public function blog(): View
    {
        // Get published blogs for the blog page
        $blogs = SeoBlog::with(['category', 'tags'])
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('publish_date')
                      ->orWhere('publish_date', '<=', now());
            })
            ->latest('publish_date')
            ->paginate(12);
            
        return view('website.pages.blog', compact('blogs'));
    }

    /**
     * Display a specific blog post or article.
     */
    public function blogPost(string $slug): View
    {
        // Get the article with proper eager loading
        $article = SeoBlog::with(['category', 'tags'])
                    ->where('slug', $slug)
                    ->where('status', 'published')
                    ->firstOrFail();
        
        // Increment the view count
        $article->increment('views_count');
        
        // Get related articles - using foreign key instead of relationship
        $relatedArticles = SeoBlog::with(['category', 'tags'])
                    ->where('id', '!=', $article->id)
                    ->where('category', $article->category) // Using foreign key
                    ->where('status', 'published')
                    ->latest('publish_date')
                    ->take(3)
                    ->get();
        
        return view('website.pages.article-detail', [
            'article' => $article,
            'relatedArticles' => $relatedArticles,
        ]);
    }
}