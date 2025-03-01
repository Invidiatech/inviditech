<?php
 namespace App\Http\Controllers;

 use App\Models\Article;
 use App\Models\Comment;
 use App\Http\Requests\CommentRequest;
 use Illuminate\Http\Request;
 use Illuminate\Support\Facades\Auth;
 
 class CommentController extends Controller
 {
     public function __construct()
     {
         $this->middleware('auth');
     }
     
     public function store(CommentRequest $request, Article $article)
     {
         $comment = new Comment([
             'user_id' => Auth::id(),
             'content' => $request->content,
             'parent_id' => $request->parent_id
         ]);
         
         $article->comments()->save($comment);
         $article->increment('comments_count');
         
         // Send notification to article author
         if (Auth::id() !== $article->user_id) {
             $article->user->notify(new \App\Notifications\NewComment($comment));
         }
         
         // Send notification to parent comment author if this is a reply
         if ($request->parent_id) {
             $parentComment = Comment::find($request->parent_id);
             if (Auth::id() !== $parentComment->user_id) {
                 $parentComment->user->notify(new \App\Notifications\CommentReply($comment));
             }
         }
         
         return redirect()->back()->with('success', 'Comment added successfully!');
     }
     
     public function update(CommentRequest $request, Comment $comment)
     {
         $this->authorize('update', $comment);
         
         $comment->update([
             'content' => $request->content
         ]);
         
         return redirect()->back()->with('success', 'Comment updated successfully!');
     }
     
     public function destroy(Comment $comment)
     {
         $this->authorize('delete', $comment);
         
         $article = $comment->article;
         
         // Update comment count
         $countToDecrement = 1; // The comment itself
         $countToDecrement += $comment->replies()->count(); // Plus all replies
         
         $comment->delete();
         $article->decrement('comments_count', $countToDecrement);
         
         return redirect()->back()->with('success', 'Comment deleted successfully!');
     }
 }
