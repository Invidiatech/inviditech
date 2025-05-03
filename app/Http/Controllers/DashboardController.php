<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use App\Models\Bookmark;
use App\Models\Comment;
use App\Models\Like;

class DashboardController extends Controller
{
    /**
     * Show the user dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get user stats
        $bookmarkCount = Bookmark::where('user_id', $user->id)->count();
        $commentCount = Comment::where('user_id', $user->id)->count();
        $likeCount = Like::where('user_id', $user->id)->count();
        
        // Get recent activity
        $recentBookmarks = Bookmark::with('article')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();
            
        $recentComments = Comment::with('article')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();
        
        return view('user.dashboard.index', compact(
            'user', 
            'bookmarkCount', 
            'commentCount', 
            'likeCount', 
            'recentBookmarks', 
            'recentComments'
        ));
    }
    
    /**
     * Show the user profile page.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('user.dashboard.profile', compact('user'));
    }
    
    /**
     * Show the user bookmarks.
     */
    public function bookmarks()
    {
        $user = Auth::user();
        $bookmarks = Bookmark::with('article.user', 'article.category')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);
            
        return view('user.dashboard.bookmarks', compact('bookmarks'));
    }
    
    /**
     * Show the user comments.
     */
    public function comments()
    {
        $user = Auth::user();
        $comments = Comment::with('article')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);
            
        return view('user.dashboard.comments', compact('comments'));
    }
    
    /**
     * Show the user settings.
     */
    public function settings()
    {
        $user = Auth::user();
        return view('user.dashboard.settings', compact('user'));
    }
}