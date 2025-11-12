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
     * Serve the React application for frontend pages.
     */
    public function reactApp(Request $request, $slug = null): View
    {
        // Get blog data for React components
        $blogData = $this->getBlogData($request);
        
        // If it's a blog detail page, get the specific blog
        $currentBlog = null;
        if ($slug) {
            $currentBlog = SeoBlog::with(['category', 'tags', 'creator', 'comments', 'likes'])
                ->where('slug', $slug)
                ->where('status', 'published')
                ->where(function ($query) {
                    $query->whereNull('publish_date')
                          ->orWhere('publish_date', '<=', now());
                })
                ->first();
                
            if ($currentBlog) {
                // Increment view count
                $currentBlog->increment('views_count');
                
                // Format the blog data
                $currentBlog = [
                    'id' => $currentBlog->id,
                    'title' => $currentBlog->title,
                    'slug' => $currentBlog->slug,
                    'excerpt' => $currentBlog->excerpt,
                    'content' => $currentBlog->content,
                    'featured_image' => $currentBlog->featured_image_url,
                    'featured_image_alt' => $currentBlog->featured_image_alt,
                    'category' => $currentBlog->category && is_object($currentBlog->category) ? $currentBlog->category->name : null,
                    'category_slug' => $currentBlog->category && is_object($currentBlog->category) ? $currentBlog->category->slug : null,
                    'tags' => $currentBlog->tags->map(function ($tag) {
                        return [
                            'id' => $tag->id,
                            'name' => $tag->name,
                            'slug' => $tag->slug,
                        ];
                    }),
                    'author' => $currentBlog->creator ? $currentBlog->creator->name : 'Muhammad Nawaz',
                    'publish_date' => $currentBlog->publish_date ? $currentBlog->publish_date->format('M d, Y') : $currentBlog->created_at->format('M d, Y'),
                    'reading_time' => $currentBlog->reading_time_formatted,
                    'views_count' => $currentBlog->views_count,
                    'likes_count' => $currentBlog->likes()->count(),
                    'comments_count' => $currentBlog->comments()->count(),
                    'url' => $currentBlog->url,
                    'meta_title' => $currentBlog->meta_title,
                    'meta_description' => $currentBlog->meta_description,
                    'meta_keywords' => $currentBlog->meta_keywords,
                ];
            }
        }
        
        return view('layouts.react', compact('blogData', 'currentBlog'));
    }

    /**
     * Get blog data for React components
     */
    private function getBlogData(Request $request = null)
    {
        // Get featured blogs
        $featuredBlogs = SeoBlog::with(['category', 'tags', 'creator'])
            ->where('status', 'published')
            ->where('is_featured', true)
            ->where(function ($query) {
                $query->whereNull('publish_date')
                      ->orWhere('publish_date', '<=', now());
            })
            ->latest('publish_date')
            ->limit(4)
            ->get()
            ->map(function ($blog) {
                return [
                    'id' => $blog->id,
                    'title' => $blog->title,
                    'slug' => $blog->slug,
                    'excerpt' => $blog->excerpt,
                    'featured_image' => $blog->featured_image_url,
                    'featured_image_alt' => $blog->featured_image_alt,
                    'category' => $blog->category && is_object($blog->category) ? $blog->category->name : null,
                    'category_slug' => $blog->category && is_object($blog->category) ? $blog->category->slug : null,
                    'tags' => $blog->tags->map(function ($tag) {
                        return [
                            'id' => $tag->id,
                            'name' => $tag->name,
                            'slug' => $tag->slug,
                        ];
                    }),
                    'author' => $blog->creator ? $blog->creator->name : 'Muhammad Nawaz',
                    'publish_date' => $blog->publish_date ? $blog->publish_date->format('M d, Y') : $blog->created_at->format('M d, Y'),
                    'reading_time' => $blog->reading_time_formatted,
                    'views_count' => $blog->views_count,
                    'likes_count' => $blog->likes()->count(),
                    'comments_count' => $blog->comments()->count(),
                    'url' => $blog->url,
                ];
            });

        // Get latest blogs
        $latestBlogs = SeoBlog::with(['category', 'tags', 'creator'])
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('publish_date')
                      ->orWhere('publish_date', '<=', now());
            })
            ->latest('publish_date')
            ->limit(6)
            ->get()
            ->map(function ($blog) {
                return [
                    'id' => $blog->id,
                    'title' => $blog->title,
                    'slug' => $blog->slug,
                    'excerpt' => $blog->excerpt,
                    'featured_image' => $blog->featured_image_url,
                    'featured_image_alt' => $blog->featured_image_alt,
                    'category' => $blog->category && is_object($blog->category) ? $blog->category->name : null,
                    'category_slug' => $blog->category && is_object($blog->category) ? $blog->category->slug : null,
                    'tags' => $blog->tags->map(function ($tag) {
                        return [
                            'id' => $tag->id,
                            'name' => $tag->name,
                            'slug' => $tag->slug,
                        ];
                    }),
                    'author' => $blog->creator ? $blog->creator->name : 'Muhammad Nawaz',
                    'publish_date' => $blog->publish_date ? $blog->publish_date->format('M d, Y') : $blog->created_at->format('M d, Y'),
                    'reading_time' => $blog->reading_time_formatted,
                    'views_count' => $blog->views_count,
                    'likes_count' => $blog->likes()->count(),
                    'comments_count' => $blog->comments()->count(),
                    'url' => $blog->url,
                ];
            });

        // Get all blogs for blog page
        $allBlogs = SeoBlog::with(['category', 'tags', 'creator'])
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('publish_date')
                      ->orWhere('publish_date', '<=', now());
            })
            ->latest('publish_date')
            ->limit(12)
            ->get()
            ->map(function ($blog) {
                return [
                    'id' => $blog->id,
                    'title' => $blog->title,
                    'slug' => $blog->slug,
                    'excerpt' => $blog->excerpt,
                    'featured_image' => $blog->featured_image_url,
                    'featured_image_alt' => $blog->featured_image_alt,
                    'category' => $blog->category && is_object($blog->category) ? $blog->category->name : null,
                    'category_slug' => $blog->category && is_object($blog->category) ? $blog->category->slug : null,
                    'tags' => $blog->tags->map(function ($tag) {
                        return [
                            'id' => $tag->id,
                            'name' => $tag->name,
                            'slug' => $tag->slug,
                        ];
                    }),
                    'author' => $blog->creator ? $blog->creator->name : 'Muhammad Nawaz',
                    'publish_date' => $blog->publish_date ? $blog->publish_date->format('M d, Y') : $blog->created_at->format('M d, Y'),
                    'reading_time' => $blog->reading_time_formatted,
                    'views_count' => $blog->views_count,
                    'likes_count' => $blog->likes()->count(),
                    'comments_count' => $blog->comments()->count(),
                    'url' => $blog->url,
                ];
            });

        // Get categories
        $categories = Category::whereHas('seoBlogs', function ($query) {
            $query->where('status', 'published')
                  ->where(function ($q) {
                      $q->whereNull('publish_date')
                        ->orWhere('publish_date', '<=', now());
                  });
        })
        ->withCount(['seoBlogs' => function ($query) {
            $query->where('status', 'published')
                  ->where(function ($q) {
                      $q->whereNull('publish_date')
                        ->orWhere('publish_date', '<=', now());
                  });
        }])
        ->orderBy('name')
        ->get()
        ->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'description' => $category->description,
                'blogs_count' => $category->seo_blogs_count,
            ];
        });

        return [
            'featured' => $featuredBlogs,
            'latest' => $latestBlogs,
            'all' => $allBlogs,
            'categories' => $categories,
        ];
    }

    /**
     * Display the home page.
     */
    public function home(): View
    {
        // Get published blogs with their relationships
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
        
        // Base query - using SeoBlog instead of Article
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
        
        // Get featured articles - using SeoBlog
        $featuredArticle = SeoBlog::where('is_featured', true)
            ->where('status', 'published')
            ->with(['category', 'tags'])
            ->latest()
            ->first();
            
        // Get paginated articles
        $articles = $articlesQuery->paginate(6);
        
        // Get trending articles (most viewed) - using SeoBlog
        $trendingArticles = SeoBlog::where('status', 'published')
            ->orderBy('views_count', 'desc')
            ->limit(4)
            ->get();
            
        // Get all categories with count - updated to use seo_blogs relationship
        $categories = Category::withCount(['articles' => function($query) {
                $query->where('status', 'published');
            }])
            ->orderBy('articles_count', 'desc')
            ->get();
            
        // Get popular tags - updated to use seo_blogs relationship
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
        // Using SeoBlog instead of Article
        $article = SeoBlog::where('slug', $slug)
            ->where('status', 'published')
           ->with(['category', 'tags', 'comments' => function($query) {
                $query->where('is_approved', true)
                    ->whereNull('parent_id')
                    ->with(['user', 'replies.user']);
            }])
            ->firstOrFail();
            
         // Increment view count
        $article->increment('views_count');
 
        // Get related articles - using SeoBlog
        $relatedArticles = SeoBlog::where('id', '!=', $article->id)
            ->where('status', 'published')
            ->where(function($query) use ($article) {
                $query->where('category', $article->category) // Updated field name
                    ->orWhereHas('tags', function($query) use ($article) {
                        $query->whereIn('tags.id', $article->tags->pluck('id'));
                    });
            })
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
                ->where('following_id', $article->created_by) // Updated field
                ->exists();
        }
        
        // Pass the article to the view for SEO meta tags
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
        
        // Get featured/popular tutorials - using SeoBlog
        $popularTutorials = SeoBlog::with('category')
            ->where('status', 'published')
            ->latest('publish_date') // Updated field name
            ->take(2)
            ->get();

        $latestTutorials = SeoBlog::with('category')
            ->where('status', 'published')
            ->latest('publish_date') // Updated field name
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
                $popularTutorials = SeoBlog::with('category')
                    ->where('status', 'published')
                    ->where('category', $activeCategory->id) // Updated field name
                    ->latest('publish_date')
                    ->take(2)
                    ->get();
                    
                $latestTutorials = SeoBlog::with('category')
                    ->where('status', 'published')
                    ->where('category', $activeCategory->id) // Updated field name
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
        // Using SeoBlog instead of Article
        $article = SeoBlog::with(['category', 'tags'])
                    ->where('slug', $slug)
                    ->where('status', 'published')
                    ->firstOrFail();
        
        // Increment the view count
        $article->increment('views_count'); // Updated method
        
        // Get related articles - using SeoBlog
        $relatedArticles = SeoBlog::with('category')
                    ->where('id', '!=', $article->id)
                    ->where('category', $article->category) // Updated field name
                    ->where('status', 'published')
                    ->latest('publish_date')
                    ->take(3)
                    ->get();
        
        // Pass the article to the view for SEO meta tags
        return view('website.pages.article-detail', [
            'article' => $article,
            'relatedArticles' => $relatedArticles,
        ]);
    }
}