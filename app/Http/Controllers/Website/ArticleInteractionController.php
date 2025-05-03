<?php
namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Bookmark;
use App\Models\Clap;
use App\Models\Comment;
use App\Models\Follow;
use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class ArticleInteractionController extends Controller
{
    /**
     * Toggle like for an article
     */
    public function toggleLike(Request $request)
    {
        try {
            Log::info('toggleLike called with data: ', $request->all());
            
            $request->validate([
                'article_id' => 'required|exists:articles,id',
            ]);
            
            // Check if user is authenticated
            if (!Auth::check()) {
                Log::warning('User not authenticated in toggleLike');
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }
            
            $article = Article::findOrFail($request->article_id);
            $user = Auth::user();
            
            Log::info('Processing like for article: ' . $article->id . ' by user: ' . $user->id);
            
            $like = Like::where('user_id', $user->id)
                ->where('article_id', $article->id)
                ->first();
                
            if ($like) {
                Log::info('Deleting existing like');
                $like->delete();
                $isLiked = false;
            } else {
                Log::info('Creating new like');
                Like::create([
                    'user_id' => $user->id,
                    'article_id' => $article->id
                ]);
                $isLiked = true;
            }
            
            $likeCount = Like::where('article_id', $article->id)->count();
            Log::info('Like count for article ' . $article->id . ': ' . $likeCount);
            
            return response()->json([
                'success' => true,
                'liked' => $isLiked,
                'count' => $likeCount
            ]);
        } catch (\Exception $e) {
            Log::error('Error in toggleLike: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Toggle bookmark for an article
     */
    public function toggleBookmark(Request $request)
    {
        try {
            Log::info('toggleBookmark called with data: ', $request->all());
            
            $request->validate([
                'article_id' => 'required|exists:articles,id',
            ]);
            
            // Check if user is authenticated
            if (!Auth::check()) {
                Log::warning('User not authenticated in toggleBookmark');
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }
            
            $article = Article::findOrFail($request->article_id);
            $user = Auth::user();
            
            Log::info('Processing bookmark for article: ' . $article->id . ' by user: ' . $user->id);
            
            $bookmark = Bookmark::where('user_id', $user->id)
                ->where('article_id', $article->id)
                ->first();
                
            if ($bookmark) {
                Log::info('Deleting existing bookmark');
                $bookmark->delete();
                $isBookmarked = false;
            } else {
                Log::info('Creating new bookmark');
                Bookmark::create([
                    'user_id' => $user->id,
                    'article_id' => $article->id
                ]);
                $isBookmarked = true;
            }
            
            return response()->json([
                'success' => true,
                'bookmarked' => $isBookmarked
            ]);
        } catch (\Exception $e) {
            Log::error('Error in toggleBookmark: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Toggle follow for an author
     */
    public function toggleFollow(Request $request)
    {
        try {
            Log::info('toggleFollow called with data: ', $request->all());
            
            $request->validate([
                'user_id' => 'required|exists:users,id',
            ]);
            
            // Check if user is authenticated
            if (!Auth::check()) {
                Log::warning('User not authenticated in toggleFollow');
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }
            
            $authorId = $request->user_id;
            $user = Auth::user();
            
            Log::info('Processing follow for author: ' . $authorId . ' by user: ' . $user->id);
            
            // Can't follow yourself
            if ($user->id == $authorId) {
                Log::info('User attempted to follow themselves');
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot follow yourself'
                ], 400);
            }
            
            $follow = Follow::where('follower_id', $user->id)
                ->where('following_id', $authorId)
                ->first();
                
            if ($follow) {
                Log::info('Deleting existing follow');
                $follow->delete();
                $isFollowing = false;
            } else {
                Log::info('Creating new follow');
                Follow::create([
                    'follower_id' => $user->id,
                    'following_id' => $authorId
                ]);
                $isFollowing = true;
            }
            
            return response()->json([
                'success' => true,
                'following' => $isFollowing
            ]);
        } catch (\Exception $e) {
            Log::error('Error in toggleFollow: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Add a comment to an article
     */
    public function addComment(Request $request)
    {
        try {
            Log::info('addComment called with data: ', $request->all());
            
            $request->validate([
                'article_id' => 'required|exists:articles,id',
                'content' => 'required|string|max:1000',
                'parent_id' => 'nullable|exists:comments,id'
            ]);
            
            // Check if user is authenticated
            if (!Auth::check()) {
                Log::warning('User not authenticated in addComment');
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }
            
            $user = Auth::user();
            
            Log::info('Creating comment for article: ' . $request->article_id . ' by user: ' . $user->id);
            
            $comment = Comment::create([
                'user_id' => $user->id,
                'article_id' => $request->article_id,
                'parent_id' => $request->parent_id,
                'content' => $request->content,
                'is_approved' => true, // Auto-approve for now, could be changed based on site policy
            ]);
            
            // Get the created comment with user relationship
            $comment->load('user');
            
            $article = Article::find($request->article_id);
            
            // Check if the view exists
            $view = 'website.components.comment';
            if (!view()->exists($view)) {
                Log::warning('View not found: ' . $view);
                $view = 'website.pages.components.comment'; // Try alternative path
                
                if (!view()->exists($view)) {
                    Log::error('Alternative view not found either: ' . $view);
                    return response()->json([
                        'success' => true,
                        'comment' => $comment,
                        'html' => '<div class="comment">View template not found. Comment was saved but cannot be displayed.</div>'
                    ]);
                }
            }
            
            Log::info('Rendering comment view: ' . $view);
            
            return response()->json([
                'success' => true,
                'comment' => $comment,
                'html' => view($view, ['comment' => $comment, 'article' => $article])->render()
            ]);
        } catch (\Exception $e) {
            Log::error('Error in addComment: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Generate and download a PDF version of the article
     */
    public function downloadPdf($slug)
    {
        try {
            Log::info('downloadPdf called for article slug: ' . $slug);
            
            $article = Article::where('slug', $slug)->firstOrFail();
            $article->load(['user', 'category', 'tags']);
            
            // Increment download count
            $article->increment('downloads');
            
            // Check if the view exists
            $view = 'website.pdf.article';
            if (!view()->exists($view)) {
                Log::error('PDF view not found: ' . $view);
                return response()->json([
                    'success' => false,
                    'message' => 'PDF view template not found.'
                ], 404);
            }
            
            Log::info('Generating PDF for article: ' . $article->id);
            
            $pdf = PDF::loadView($view, [
                'article' => $article
            ]);
            
            return $pdf->download($article->slug . '.pdf');
        } catch (\Exception $e) {
            Log::error('Error in downloadPdf: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Add/update claps for an article
     */
    public function clap(Request $request)
    {
        try {
            Log::info('clap called with data: ', $request->all());
            
            $request->validate([
                'article_id' => 'required|exists:articles,id',
                'count' => 'required|integer|min:1|max:50',
            ]);
            
            // Check if user is authenticated
            if (!Auth::check()) {
                Log::warning('User not authenticated in clap');
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }
            
            $article = Article::findOrFail($request->article_id);
            $user = Auth::user();
            
            Log::info('Processing claps for article: ' . $article->id . ' by user: ' . $user->id);
            
            $clap = Clap::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'article_id' => $article->id
                ],
                [
                    'count' => $request->count
                ]
            );
            
            $totalClaps = Clap::where('article_id', $article->id)->sum('count');
            Log::info('Total claps for article ' . $article->id . ': ' . $totalClaps);
            
            return response()->json([
                'success' => true,
                'claps' => $clap->count,
                'totalClaps' => $totalClaps
            ]);
        } catch (\Exception $e) {
            Log::error('Error in clap: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
}