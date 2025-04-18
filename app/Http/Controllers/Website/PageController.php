<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
class PageController extends Controller
{
    /**
     * Display the home page.
     */
    public function home(): View
    {
        return view('website.pages.home');
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
        // Get category filter if provided
        $categorySlug = $request->query('category');
        $tagSlug = $request->query('tag');
        $search = $request->query('search');
        
        // Base query
        $articlesQuery = Article::with(['category', 'tags', 'user'])
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
        $featuredArticle = Article::where('is_featured', true)
            ->where('status', 'published')
            ->with(['category', 'tags'])
            ->latest()
            ->first();
            
        // Get paginated articles
        $articles = $articlesQuery->paginate(6);
        
        // Get trending articles (most viewed)
        $trendingArticles = Article::where('status', 'published')
            ->orderBy('views_count', 'desc')
            ->limit(4)
            ->get();
            
        // Get all categories with count
        $categories = Category::withCount(['articles' => function($query) {
                $query->where('status', 'published');
            }])
            ->orderBy('articles_count', 'desc')
            ->get();
            
        // Get popular tags
        $popularTags = Tag::withCount(['articles' => function($query) {
                $query->where('status', 'published');
            }])
            ->orderBy('articles_count', 'desc')
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
        $article = Article::where('slug', $slug)
            ->where('status', 'published')
            ->with(['category', 'tags', 'user'])
            ->firstOrFail();
        $article->increment('views_count');
        
        // Get related articles from same category
        $relatedArticles = Article::where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->where('status', 'published')
            ->limit(3)
            ->get();
            
        return view('website.pages.article-detail', compact('article', 'relatedArticles'));
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
        $popularTutorials = Article::with('category')
            ->where('status', 'published')
             ->latest('published_at')
            ->take(2)
            ->get();
            // dd($popularTutorials);
        $latestTutorials = Article::with('category')
            ->where('status', 'published')
            ->latest('published_at')
            ->take(5)
            ->get();
        
        // If a specific topic is selected, filter the tutorials accordingly
        $activeTopic = null;
        $activeCategory = null;
        if ($topic) {
            $activeCategory = Category::where('slug', $topic)->first();
             if ($activeCategory) {
                $activeTopic = $topic;
                 // Update queries to filter by the selected category
                $popularTutorials = Article::with('category')
                    ->where('status', 'published')
                    ->where('category_id', $activeCategory->id)
                    ->where('is_featured', false)
                    ->latest('published_at')
                    ->take(2)
                    ->get();
                    
                $latestTutorials = Article::with('category')
                    ->where('status', 'published')
                    ->where('category_id', $activeCategory->id)
                    ->latest('published_at')
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
        // When you have a database, load Laravel-focused blog posts here
        /* 
        $articles = Article::where('category_id', 1) // Assuming 1 is Laravel category
            ->orderBy('published_at', 'desc')
            ->paginate(10);
        
        return view('pages.blog', [
            'articles' => $articles
        ]);
        */
        
        return view('website.pages.blog');
    }

    /**
     * Display a specific blog post or article.
     */
    public function blogPost(string $slug): View
    {
        $article = Article::with(['category', 'tags', 'user'])
                    ->where('slug', $slug)
                    ->where('status', 'published')
                    ->firstOrFail();
         // Increment the view count
        $article->incrementViews();        
        // Get related articles
        $relatedArticles = Article::with('category')
                    ->where('id', '!=', $article->id)
                    ->where('category_id', $article->category_id)
                    ->where('status', 'published')
                    ->latest('published_at')
                    ->take(3)
                    ->get();
        
        return view('website.pages.article', [
            'article' => $article,
            'relatedArticles' => $relatedArticles,
        ]);
    }
}