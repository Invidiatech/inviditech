<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Seo\SeoBlog;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'parent_id',
        'is_active',
        'is_featured',
        'sort_order',
        'meta_data'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'meta_data' => 'array',
        'sort_order' => 'integer'
    ];

    // Auto-generate slug when creating/updating
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // Relationships
    public function articles()
    {
        return $this->hasMany(SeoBlog::class, 'category');
    }

    // Alias for consistency
    public function seoBlogs()
    {
        return $this->hasMany(SeoBlog::class, 'category');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeParentOnly($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeWithActiveArticles($query)
    {
        return $query->whereHas('articles', function($q) {
            $q->where('status', 'published');
        });
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return null;
    }

    public function getFullPathAttribute()
    {
        $path = $this->name;
        $parent = $this->parent;

        while ($parent) {
            $path = $parent->name . ' > ' . $path;
            $parent = $parent->parent;
        }

        return $path;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Helper Methods
    public function hasChildren()
    {
        return $this->children()->count() > 0;
    }

    public function hasArticles()
    {
        return $this->articles()->count() > 0;
    }

    public function hasPublishedArticles()
    {
        return $this->articles()->where('status', 'published')->count() > 0;
    }

    public function getArticlesCountAttribute()
    {
        return $this->articles()->where('status', 'published')->count();
    }

    public function getPublishedArticlesCountAttribute()
    {
        return $this->articles()->where('status', 'published')->count();
    }

    public function getTotalArticlesCountAttribute()
    {
        return $this->articles()->count();
    }

    /**
     * Get featured articles for this category
     */
    public function getFeaturedArticles($limit = 3)
    {
        return $this->articles()
            ->where('status', 'published')
            ->where('is_featured', true)
            ->latest('publish_date')
            ->limit($limit)
            ->get();
    }

    /**
     * Get latest articles for this category
     */
    public function getLatestArticles($limit = 5)
    {
        return $this->articles()
            ->where('status', 'published')
            ->latest('publish_date')
            ->limit($limit)
            ->get();
    }

    /**
     * Check if category is empty (no published articles)
     */
    public function isEmpty()
    {
        return !$this->hasPublishedArticles();
    }

    /**
     * Get breadcrumb trail for nested categories
     */
    public function getBreadcrumbTrail()
    {
        $trail = collect([$this]);
        $parent = $this->parent;

        while ($parent) {
            $trail->prepend($parent);
            $parent = $parent->parent;
        }

        return $trail;
    }
}