<?php

namespace App\Models\Seo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Bookmark;

class SeoBlog extends Model
{
    use SoftDeletes;

    protected $table = 'seo_blogs';
    
    protected $fillable = [
        'title', 'slug', 'content', 'excerpt', 'meta_title', 'meta_description',
        'meta_keywords', 'focus_keyword', 'canonical_url', 'og_title', 'og_description',
        'og_image', 'twitter_title', 'twitter_description', 'twitter_image', 'schema_markup',
        'featured_image', 'featured_image_alt', 'status', 'publish_date',
        'category', 'created_by', 'is_indexed', 'is_featured', 'seo_score',
        'seo_analysis', 'reading_time', 'readability_score', 'views_count', 'devto_id','devto_url','devto_published_at'
    ];

    protected $casts = [
        'is_indexed' => 'boolean',
        'is_featured' => 'boolean',
        'publish_date' => 'datetime',
        'seo_analysis' => 'array',
        'schema_markup' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the category that owns the blog.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category', 'id');
    }

    /**
     * The tags that belong to the blog.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'seo_blog_tag', 'seo_blog_id', 'tag_id')
                    ->withTimestamps();
    }

    /**
     * Get the user that created the blog.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the creator (alias for user).
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all comments for the blog.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'seo_blog_id');
    }

    /**
     * Get all likes for the blog.
     */
    public function likes()
    {
        return $this->hasMany(Like::class, 'seo_blog_id');
    }

    /**
     * Get all bookmarks for the blog.
     */
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class, 'seo_blog_id');
    }
}