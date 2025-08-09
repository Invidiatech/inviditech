<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SearchConsoleData extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'page_url',
        'query',
        'clicks',
        'impressions',
        'ctr',
        'position',
        'country',
        'device'
    ];

    protected $casts = [
        'date' => 'date',
        'ctr' => 'decimal:4',
        'position' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get total clicks for period
     */
    public static function getTotalClicks($days = 30)
    {
        return static::where('date', '>=', Carbon::now()->subDays($days))
            ->sum('clicks');
    }

    /**
     * Get total impressions for period
     */
    public static function getTotalImpressions($days = 30)
    {
        return static::where('date', '>=', Carbon::now()->subDays($days))
            ->sum('impressions');
    }

    /**
     * Get average CTR for period
     */
    public static function getAverageCTR($days = 30)
    {
        return static::where('date', '>=', Carbon::now()->subDays($days))
            ->where('impressions', '>', 0)
            ->avg('ctr');
    }

    /**
     * Get average position for period
     */
    public static function getAveragePosition($days = 30)
    {
        return static::where('date', '>=', Carbon::now()->subDays($days))
            ->avg('position');
    }

    /**
     * Get top performing queries
     */
    public static function getTopQueries($days = 30, $limit = 10)
    {
        return static::selectRaw('query, SUM(clicks) as total_clicks, SUM(impressions) as total_impressions, AVG(position) as avg_position')
            ->where('date', '>=', Carbon::now()->subDays($days))
            ->whereNotNull('query')
            ->groupBy('query')
            ->orderByDesc('total_clicks')
            ->limit($limit)
            ->get();
    }

    /**
     * Get top performing pages
     */
    public static function getTopPages($days = 30, $limit = 10)
    {
        return static::selectRaw('page_url, SUM(clicks) as total_clicks, SUM(impressions) as total_impressions, AVG(position) as avg_position')
            ->where('date', '>=', Carbon::now()->subDays($days))
            ->groupBy('page_url')
            ->orderByDesc('total_clicks')
            ->limit($limit)
            ->get();
    }

    /**
     * Get daily performance data
     */
    public static function getDailyPerformance($days = 30)
    {
        return static::selectRaw('date, SUM(clicks) as clicks, SUM(impressions) as impressions, AVG(ctr) as ctr, AVG(position) as position')
            ->where('date', '>=', Carbon::now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    /**
     * Get device performance
     */
    public static function getDevicePerformance($days = 30)
    {
        return static::selectRaw('device, SUM(clicks) as clicks, SUM(impressions) as impressions, AVG(ctr) as ctr')
            ->where('date', '>=', Carbon::now()->subDays($days))
            ->whereNotNull('device')
            ->groupBy('device')
            ->orderByDesc('clicks')
            ->get();
    }
}