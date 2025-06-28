<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Seo\SeoBlog;
use App\Models\User;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'seo_blog_id', // Changed from article_id
        'user_id',
        'parent_id',
        'content',
        'is_approved'
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    /**
     * Get the blog that owns the comment.
     */
    public function seoBlog()
    {
        return $this->belongsTo(SeoBlog::class, 'seo_blog_id');
    }

    /**
     * Get the user that owns the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent comment.
     */
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Get the replies for the comment.
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')
                    ->where('is_approved', true)
                    ->with('user');
    }
}