<?php

namespace App\Models\Seo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;

class SeoBlog extends Model
{
    use SoftDeletes;

    protected $table = 'seo_blogs';

    protected $fillable = [
        'title',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'content',
        'excerpt',
        'is_indexed',
        'is_featured',
        'featured_image',
        'featured_image_alt',
        'status',
        'publish_date',
        'canonical_url',
        'devto_id',
        'devto_url',
        'devto_published_at',
        'linkedin_id',
        'linkedin_published_at',
        'og_title',
        'og_description',
        'og_image',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'schema_markup',
        'created_by',
        'category',
        'seo_score',
        'seo_analysis',
        'focus_keyword',
        'readability_score',
        'reading_time',
        'views_count',
    ];

    protected $casts = [
        'is_indexed' => 'boolean',
        'is_featured' => 'boolean',
        'publish_date' => 'datetime',
        'devto_published_at' => 'datetime',
        'linkedin_published_at' => 'datetime',
        'seo_analysis' => 'array',
        'schema_markup' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the category that owns the blog.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category', 'id');
    }

    /**
     * The tags that belong to the blog.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'seo_blog_tag', 'seo_blog_id', 'tag_id')
                    ->withTimestamps();
    }

    /**
     * Get the user that created the blog.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the creator (alias for user).
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all comments for the blog.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'seo_blog_id');
    }

    /**
     * Get all likes for the blog.
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class, 'seo_blog_id');
    }

    /**
     * Get all bookmarks for the blog.
     */
    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class, 'seo_blog_id');
    }

    /**
     * Scope for published blogs
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope for featured blogs
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for indexed blogs
     */
    public function scopeIndexed($query)
    {
        return $query->where('is_indexed', true);
    }

    /**
     * Check if blog is published to Dev.to
     */
    public function isPublishedToDevTo(): bool
    {
        return !is_null($this->devto_id);
    }

    /**
     * Check if blog is published to LinkedIn
     */
    public function isPublishedToLinkedIn(): bool
    {
        return !is_null($this->linkedin_id);
    }

    /**
     * Get the full URL for the blog
     */
    public function getUrlAttribute(): string
    {
        return url('/blog/' . $this->slug);
    }

    /**
     * Get the featured image URL
     */
    public function getFeaturedImageUrlAttribute(): ?string
    {
        return $this->featured_image ? asset('storage/' . $this->featured_image) : null;
    }

    /**
     * Get the OG image URL
     */
    public function getOgImageUrlAttribute(): ?string
    {
        return $this->og_image ? asset('storage/' . $this->og_image) : null;
    }

    /**
     * Get the Twitter image URL
     */
    public function getTwitterImageUrlAttribute(): ?string
    {
        return $this->twitter_image ? asset('storage/' . $this->twitter_image) : null;
    }

    /**
     * Increment views count
     */
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    /**
     * Get reading time in human readable format
     */
    public function getReadingTimeFormattedAttribute(): string
    {
        $minutes = $this->reading_time;
        if ($minutes < 1) {
            return 'Less than 1 min read';
        } elseif ($minutes == 1) {
            return '1 min read';
        } else {
            return $minutes . ' min read';
        }
    }

    /**
     * Get SEO score color class for display
     */
    public function getSeoScoreColorAttribute(): string
    {
        $score = $this->seo_score;
        if ($score >= 80) {
            return 'success';
        } elseif ($score >= 60) {
            return 'warning';
        } else {
            return 'danger';
        }
    }

    /**
     * Get published date in human readable format
     */
    public function getPublishedDateFormattedAttribute(): ?string
    {
        return $this->publish_date ? $this->publish_date->format('M d, Y') : null;
    }
}