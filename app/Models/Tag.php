<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Seo\SeoBlog;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'meta_title',
        'meta_description'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tag) {
            if (empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
            }
            if (empty($tag->meta_title)) {
                $tag->meta_title = $tag->name;
            }
        });
    }

    /**
     * Get the articles that belong to the tag.
     */
    public function articles()
    {
        return $this->belongsToMany(\App\Models\Seo\SeoBlog::class, 'seo_blog_tag', 'tag_id', 'seo_blog_id');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get articles count for this tag
     */
    public function getArticlesCountAttribute()
    {
        return $this->articles()->where('status', 'published')->count();
    }
}