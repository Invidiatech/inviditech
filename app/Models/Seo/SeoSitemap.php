<?php

namespace App\Models\Seo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoSitemap extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'urls',
        'settings',
        'last_generated',
        'status',
        'file_path',
        'total_urls',
        'submitted_to_google',
        'google_submission_date',
        'google_submission_status',
        'created_by'
    ];

    protected $casts = [
        'urls' => 'array',
        'settings' => 'array',
        'last_generated' => 'datetime',
        'google_submission_date' => 'datetime',
        'submitted_to_google' => 'boolean',
    ];

    /**
     * Sitemap types
     */
    const SITEMAP_TYPES = [
        'pages' => 'Static Pages',
        'blogs' => 'Blog Posts',
        'products' => 'Products',
        'categories' => 'Categories',
        'custom' => 'Custom URLs'
    ];

    /**
     * Change frequencies
     */
    const CHANGE_FREQUENCIES = [
        'always' => 'Always',
        'hourly' => 'Hourly',
        'daily' => 'Daily',
        'weekly' => 'Weekly',
        'monthly' => 'Monthly',
        'yearly' => 'Yearly',
        'never' => 'Never'
    ];

    /**
     * Get the creator of the sitemap
     */
    public function creator()
    {
        return $this->belongsTo(\App\Models\Seo\Seo::class, 'created_by');
    }

    /**
     * Scope for active sitemaps
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Get formatted file size
     */
    public function getFileSizeAttribute()
    {
        if (!$this->file_path || !file_exists(public_path($this->file_path))) {
            return 'N/A';
        }

        $bytes = filesize(public_path($this->file_path));
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Get sitemap URL
     */
    public function getSitemapUrlAttribute()
    {
        return $this->file_path ? url($this->file_path) : null;
    }

    /**
     * Check if sitemap needs regeneration
     */
    public function needsRegeneration()
    {
        if (!$this->last_generated) {
            return true;
        }

        // Check if it's older than 24 hours
        return $this->last_generated->diffInHours(now()) > 24;
    }
}
