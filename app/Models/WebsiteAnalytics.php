<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class WebsiteAnalytics extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'ip_address',
        'user_agent',
        'device_type',
        'browser',
        'operating_system',
        'country',
        'city',
        'referrer',
        'landing_page',
        'current_page',
        'page_views',
        'session_duration',
        'is_bot',
        'utm_parameters'
    ];

    protected $casts = [
        'utm_parameters' => 'array',
        'is_bot' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get daily visitors for the last 30 days
     */
    public static function getDailyVisitors($days = 30)
    {
        return static::selectRaw('DATE(created_at) as date, COUNT(DISTINCT session_id) as visitors')
            ->where('created_at', '>=', Carbon::now()->subDays($days))
            ->where('is_bot', false)
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    /**
     * Get unique visitors today
     */
    public static function getTodayVisitors()
    {
        return static::where('created_at', '>=', Carbon::today())
            ->where('is_bot', false)
            ->distinct('session_id')
            ->count();
    }

    /**
     * Get total page views today
     */
    public static function getTodayPageViews()
    {
        return static::where('created_at', '>=', Carbon::today())
            ->where('is_bot', false)
            ->sum('page_views');
    }

    /**
     * Get device statistics
     */
    public static function getDeviceStats($days = 7)
    {
        return static::selectRaw('device_type, COUNT(DISTINCT session_id) as count')
            ->where('created_at', '>=', Carbon::now()->subDays($days))
            ->where('is_bot', false)
            ->whereNotNull('device_type')
            ->groupBy('device_type')
            ->orderByDesc('count')
            ->get();
    }

    /**
     * Get country statistics
     */
    public static function getCountryStats($days = 7)
    {
        return static::selectRaw('country, COUNT(DISTINCT session_id) as count')
            ->where('created_at', '>=', Carbon::now()->subDays($days))
            ->where('is_bot', false)
            ->whereNotNull('country')
            ->groupBy('country')
            ->orderByDesc('count')
            ->limit(10)
            ->get();
    }

    /**
     * Get referrer statistics
     */
    public static function getReferrerStats($days = 7)
    {
        $results = collect();
        
        // Direct traffic
        $direct = static::where('created_at', '>=', Carbon::now()->subDays($days))
            ->where('is_bot', false)
            ->where(function($query) {
                $query->whereNull('referrer')->orWhere('referrer', '');
            })
            ->distinct('session_id')
            ->count();
            
        if ($direct > 0) {
            $results->push((object)['source' => 'Direct', 'count' => $direct]);
        }
        
        // Google traffic
        $google = static::where('created_at', '>=', Carbon::now()->subDays($days))
            ->where('is_bot', false)
            ->where('referrer', 'LIKE', '%google%')
            ->distinct('session_id')
            ->count();
            
        if ($google > 0) {
            $results->push((object)['source' => 'Google', 'count' => $google]);
        }
        
        // Facebook traffic
        $facebook = static::where('created_at', '>=', Carbon::now()->subDays($days))
            ->where('is_bot', false)
            ->where('referrer', 'LIKE', '%facebook%')
            ->distinct('session_id')
            ->count();
            
        if ($facebook > 0) {
            $results->push((object)['source' => 'Facebook', 'count' => $facebook]);
        }
        
        // Twitter traffic
        $twitter = static::where('created_at', '>=', Carbon::now()->subDays($days))
            ->where('is_bot', false)
            ->where('referrer', 'LIKE', '%twitter%')
            ->distinct('session_id')
            ->count();
            
        if ($twitter > 0) {
            $results->push((object)['source' => 'Twitter', 'count' => $twitter]);
        }
        
        // LinkedIn traffic
        $linkedin = static::where('created_at', '>=', Carbon::now()->subDays($days))
            ->where('is_bot', false)
            ->where('referrer', 'LIKE', '%linkedin%')
            ->distinct('session_id')
            ->count();
            
        if ($linkedin > 0) {
            $results->push((object)['source' => 'LinkedIn', 'count' => $linkedin]);
        }
        
        // YouTube traffic
        $youtube = static::where('created_at', '>=', Carbon::now()->subDays($days))
            ->where('is_bot', false)
            ->where('referrer', 'LIKE', '%youtube%')
            ->distinct('session_id')
            ->count();
            
        if ($youtube > 0) {
            $results->push((object)['source' => 'YouTube', 'count' => $youtube]);
        }
        
        // Other traffic (excluding the above sources)
        $other = static::where('created_at', '>=', Carbon::now()->subDays($days))
            ->where('is_bot', false)
            ->whereNotNull('referrer')
            ->where('referrer', '!=', '')
            ->where('referrer', 'NOT LIKE', '%google%')
            ->where('referrer', 'NOT LIKE', '%facebook%')
            ->where('referrer', 'NOT LIKE', '%twitter%')
            ->where('referrer', 'NOT LIKE', '%linkedin%')
            ->where('referrer', 'NOT LIKE', '%youtube%')
            ->distinct('session_id')
            ->count();
            
        if ($other > 0) {
            $results->push((object)['source' => 'Other', 'count' => $other]);
        }
        
        return $results->sortByDesc('count')->values();
    }

    /**
     * Get average session duration
     */
    public static function getAverageSessionDuration($days = 7)
    {
        return static::where('created_at', '>=', Carbon::now()->subDays($days))
            ->where('is_bot', false)
            ->where('session_duration', '>', 0)
            ->avg('session_duration');
    }
}