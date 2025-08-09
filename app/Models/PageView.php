<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PageView extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'url',
        'page_title',
        'page_type',
        'article_id',
        'ip_address',
        'referrer',
        'time_on_page',
        'scroll_depth',
        'utm_parameters'
    ];

    protected $casts = [
        'utm_parameters' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get most viewed pages
     */
    public static function getMostViewedPages($days = 7, $limit = 10)
    {
        return static::selectRaw('url, page_title, page_type, COUNT(*) as views')
            ->where('created_at', '>=', Carbon::now()->subDays($days))
            ->groupBy('url', 'page_title', 'page_type')
            ->orderByDesc('views')
            ->limit($limit)
            ->get();
    }

    /**
     * Get trending articles
     */
    public static function getTrendingArticles($days = 7, $limit = 10)
    {
        return static::selectRaw('article_id, url, page_title, COUNT(*) as views')
            ->where('created_at', '>=', Carbon::now()->subDays($days))
            ->where('page_type', 'article')
            ->whereNotNull('article_id')
            ->groupBy('article_id', 'url', 'page_title')
            ->orderByDesc('views')
            ->limit($limit)
            ->get();
    }

    /**
     * Get page views for specific period
     */
    public static function getPageViewsForPeriod($days = 30)
    {
        return static::selectRaw('DATE(created_at) as date, COUNT(*) as views')
            ->where('created_at', '>=', Carbon::now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    /**
     * Get bounce rate (single page sessions)
     */
    public static function getBounceRate($days = 7)
    {
        $totalSessions = static::selectRaw('COUNT(DISTINCT session_id) as count')
            ->where('created_at', '>=', Carbon::now()->subDays($days))
            ->first()->count;

        $bounceSessions = static::selectRaw('session_id')
            ->where('created_at', '>=', Carbon::now()->subDays($days))
            ->groupBy('session_id')
            ->havingRaw('COUNT(*) = 1')
            ->get()
            ->count();

        return $totalSessions > 0 ? ($bounceSessions / $totalSessions) * 100 : 0;
    }

    /**
     * Get average time on page
     */
    public static function getAverageTimeOnPage($days = 7)
    {
        return static::where('created_at', '>=', Carbon::now()->subDays($days))
            ->where('time_on_page', '>', 0)
            ->avg('time_on_page');
    }

    /**
     * Relationship with SEO Blog
     */
    public function article()
    {
        return $this->belongsTo(\App\Models\Seo\SeoBlog::class, 'article_id');
    }
}