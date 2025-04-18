<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'meta_title',
        'meta_description',
        'image',
        'is_featured',
        'parent_id',
        'sort_order'
    ];
    protected $casts = [
        'is_featured' => 'boolean',
    ];
    // This function is part of an Eloquent model in Laravel, and it automatically sets the slug and meta_title fields when a new category is created
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
            if (empty($category->meta_title)) {
                $category->meta_title = $category->name;
            }
        });
    }
    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
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
}