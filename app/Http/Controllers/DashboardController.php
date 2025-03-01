<?php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $user = Auth::user();
        
        // Get user's articles
        $articles = Article::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        // Get stats for published articles
        $publishedCount = Article::where('user_id', $user->id)
            ->where('status', 'published')
            ->count();
            
        $totalViews = Article::where('user_id', $user->id)
            ->sum('views_count');
            
        $totalLikes = Article::where('user_id', $user->id)
            ->sum('likes_count');
            
        $totalComments = Article::where('user_id', $user->id)
            ->sum('comments_count');
            
        // Get most popular articles
        $popularArticles = Article::where('user_id', $user->id)
            ->orderBy('views_count', 'desc')
            ->take(5)
            ->get();
            
        // Get monthly stats
        $monthlyStats = Article::where('user_id', $user->id)
            ->where('status', 'published')
            ->where('published_at', '>=', now()->subMonths(6))
            ->select(
                DB::raw('DATE_FORMAT(published_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as articles_count'),
                DB::raw('SUM(views_count) as views_count'),
                DB::raw('SUM(likes_count) as likes_count'),
                DB::raw('SUM(comments_count) as comments_count')
            )
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
            
        return view('dashboard.index', compact(
            'articles',
            'publishedCount',
            'totalViews',
            'totalLikes',
            'totalComments',
            'popularArticles',
            'monthlyStats'
        ));
    }
    
    public function analytics($slug)
    {
        $article = Article::where('slug', $slug)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        // Here you would integrate with a more sophisticated analytics system
        // For now we'll just return basic stats from the database
        
        $engagement = [
            'views' => $article->views_count,
            'likes' => $article->likes_count,
            'claps' => $article->getClapCountAttribute(),
            'comments' => $article->comments_count,
            'bookmarks' => $article->bookmarks()->count()
        ];
        
        $commenters = Comment::with('user:id,name,username,profile_image')
            ->where('article_id', $article->id)
            ->select('user_id', DB::raw('COUNT(*) as comment_count'))
            ->groupBy('user_id')
            ->orderBy('comment_count', 'desc')
            ->take(5)
            ->get();
            
        return view('dashboard.analytics', compact('article', 'engagement', 'commenters'));
    }
}