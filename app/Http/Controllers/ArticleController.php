<?php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Series;
use App\Models\Like;
use App\Models\Clap;
use App\Models\Bookmark;
use App\Services\SeoService;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    protected $seoService;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
        $this->middleware('auth')->except(['index', 'show', 'category', 'tag', 'search']);
    }

    public function index(Request $request)
    {
        $articles = Article::with(['user', 'category', 'tags'])
            ->published()
            ->when($request->filled('sort'), function ($query) use ($request) {
                if ($request->sort === 'popular') {
                    return $query->orderBy('views_count', 'desc');
                } elseif ($request->sort === 'trending') {
                    return $query->whereRaw('DATE(published_at) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)')
                                 ->orderBy('views_count', 'desc');
                } elseif ($request->sort === 'claps') {
                    return $query->orderBy('likes_count', 'desc');
                }
                return $query->orderBy('published_at', 'desc');
            }, function ($query) {
                return $query->orderBy('published_at', 'desc');
            })
            ->when($request->filled('category'), function ($query) use ($request) {
                return $query->whereHas('category', function ($q) use ($request) {
                    $q->where('slug', $request->category);
                });
            })
            ->when($request->filled('tag'), function ($query) use ($request) {
                return $query->whereHas('tags', function ($q) use ($request) {
                    $q->where('slug', $request->tag);
                });
            })
            ->when($request->filled('author'), function ($query) use ($request) {
                return $query->whereHas('user', function ($q) use ($request) {
                    $q->where('username', $request->author);
                });
            })
            ->paginate(10);

        // Add structured data for SEO
        $this->seoService->generateArticleListSchema($articles);

        return view('articles.index', compact('articles'));
    }

    public function show($slug)
    {
        $article = Article::with(['user', 'category', 'tags', 'comments' => function ($query) {
                $query->approved()->rootComments()->with(['user', 'replies.user']);
            }])
            ->where('slug', $slug)
            ->where(function ($query) {
                if (!Auth::check()) {
                    $query->where('status', 'published')
                          ->where('published_at', '<=', now());
                } elseif (!Auth::user()->is_admin) {
                    $query->where(function ($q) {
                        $q->where('status', 'published')
                          ->where('published_at', '<=', now())
                          ->orWhere('user_id', Auth::id());
                    });
                }
            })
            ->firstOrFail();

        // Check if premium content is accessible
        if ($article->is_premium && (!Auth::check() || !Auth::user()->subscription)) {
            return view('articles.premium', compact('article'));
        }

        // Increment view count
        $article->incrementViews();

        // Get related articles
        $relatedArticles = Article::with(['user'])
            ->published()
            ->where('id', '!=', $article->id)
            ->where(function ($query) use ($article) {
                $query->where('category_id', $article->category_id)
                    ->orWhereHas('tags', function ($q) use ($article) {
                        $q->whereIn('tags.id', $article->tags->pluck('id'));
                    });
            })
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        // Add structured data for SEO
        $this->seoService->generateArticleSchema($article);

        return view('articles.show', compact('article', 'relatedArticles'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        $series = Series::where('user_id', Auth::id())->orderBy('title')->get();
        return view('articles.create', compact('categories', 'tags', 'series'));
    }

    public function store(ArticleRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        
        // Handle slug
        $data['slug'] = Str::slug($data['title']);
        $slugExists = Article::where('slug', $data['slug'])->exists();
        if ($slugExists) {
            $data['slug'] = $data['slug'] . '-' . Str::random(5);
        }
        
        // Handle featured image
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')
                ->store('articles/featured', 'public');
        }
        
        // Set publication date if published
        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }
        
        // Create article
        $article = Article::create($data);
        
        // Sync tags
        if ($request->has('tags')) {
            $article->tags()->sync($request->tags);
        }
        // Generate auto SEO meta tags if not provided
        $this->seoService->generateMetaTags($article);
        
        return redirect()->route('articles.show', $article->slug)
            ->with('success', 'Article created successfully!');
    }

    public function edit(Article $article)
    {
        // Authorization check
        $this->authorize('update', $article);
        
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        $series = Series::where('user_id', Auth::id())->orderBy('title')->get();
        
        return view('articles.edit', compact('article', 'categories', 'tags', 'series'));
    }

    public function update(ArticleRequest $request, Article $article)
    {
        // Authorization check
        $this->authorize('update', $article);
        
        $data = $request->validated();
        
        // Handle slug if title changed
        if ($article->title !== $data['title']) {
            $data['slug'] = Str::slug($data['title']);
            $slugExists = Article::where('slug', $data['slug'])
                ->where('id', '!=', $article->id)
                ->exists();
            if ($slugExists) {
                $data['slug'] = $data['slug'] . '-' . Str::random(5);
            }
        }
        
        // Handle featured image
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            
            $data['featured_image'] = $request->file('featured_image')
                ->store('articles/featured', 'public');
        }
        
        // Set publication date if status changed to published
        if ($data['status'] === 'published' && 
            ($article->status !== 'published' || $article->published_at === null)) {
            $data['published_at'] = now();
        }
        
        // Update article
        $article->update($data);
        
        // Sync tags
        if ($request->has('tags')) {
            $article->tags()->sync($request->tags);
        }
        
        // Sync series if selected
        if ($request->has('series_id')) {
            if ($request->series_id) {
                $article->series()->sync([
                    $request->series_id => ['sort_order' => $request->sort_order ?? 0]
                ]);
            } else {
                $article->series()->detach();
            }
        }
        
        // Update SEO meta tags
        $this->seoService->generateMetaTags($article);
        
        return redirect()->route('articles.show', $article->slug)
            ->with('success', 'Article updated successfully!');
    }

    public function destroy(Article $article)
    {
        // Authorization check
        $this->authorize('delete', $article);
        
        // Delete article (soft delete)
        $article->delete();
        
        return redirect()->route('dashboard')
            ->with('success', 'Article deleted successfully!');
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        
        $articles = Article::with(['user', 'category'])
            ->published()
            ->search($query)
            ->orderBy('published_at', 'desc')
            ->paginate(10);
        
        return view('articles.search', compact('articles', 'query'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        $articles = Article::with(['user', 'category', 'tags'])
            ->published()
            ->where('category_id', $category->id)
            ->orderBy('published_at', 'desc')
            ->paginate(10);
        
        return view('articles.category', compact('category', 'articles'));
    }

    public function tag($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        
        $articles = Article::with(['user', 'category', 'tags'])
            ->published()
            ->whereHas('tags', function ($query) use ($slug) {
                $query->where('tags.slug', $slug);
            })
            ->orderBy('published_at', 'desc')
            ->paginate(10);
        
        return view('articles.tag', compact('tag', 'articles'));
    }

    public function like(Article $article)
    {
        $user = Auth::user();
        
        $exist = Like::where('user_id', $user->id)
            ->where('article_id', $article->id)
            ->first();
            
        if ($exist) {
            $exist->delete();
            $article->decrement('likes_count');
            $liked = false;
        } else {
            Like::create([
                'user_id' => $user->id,
                'article_id' => $article->id
            ]);
            $article->increment('likes_count');
            $liked = true;
        }
        
        return response()->json([
            'liked' => $liked,
            'count' => $article->likes_count
        ]);
    }

    public function clap(Article $article, Request $request)
    {
        $user = Auth::user();
        $count = $request->input('count', 1);
        
        // Limit to 50 claps per article
        $count = min($count, 50);
        
        $clap = Clap::where('user_id', $user->id)
            ->where('article_id', $article->id)
            ->first();
            
        if ($clap) {
            // Update existing clap count, but don't exceed 50
            $newCount = min(50, $clap->count + $count);
            $countDiff = $newCount - $clap->count;
            
            $clap->update(['count' => $newCount]);
        } else {
            Clap::create([
                'user_id' => $user->id,
                'article_id' => $article->id,
                'count' => $count
            ]);
            $countDiff = $count;
        }
        
        return response()->json([
            'success' => true,
            'claps' => $article->getClapCountAttribute()
        ]);
    }

    public function bookmark(Article $article)
    {
        $user = Auth::user();
        
        $exist = Bookmark::where('user_id', $user->id)
            ->where('article_id', $article->id)
            ->first();
            
        if ($exist) {
            $exist->delete();
            $bookmarked = false;
        } else {
            Bookmark::create([
                'user_id' => $user->id,
                'article_id' => $article->id
            ]);
            $bookmarked = true;
        }
        
        return response()->json([
            'bookmarked' => $bookmarked
        ]);
    }
}
