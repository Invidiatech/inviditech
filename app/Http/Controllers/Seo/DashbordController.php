<?php

namespace App\Http\Controllers\Seo;

use App\Http\Controllers\Controller;
use App\Models\WebsiteAnalytics;
use App\Models\PageView;
use App\Models\SearchConsoleData;
use App\Models\Seo\SeoBlog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashbordController extends Controller
{
    public function index(Request $request)
    {
        // Get date range from request or default to last 30 days
        $days = $request->get('days', 30);
        $startDate = Carbon::now()->subDays($days);

        // Analytics Overview
        $analytics = [
            'today_visitors' => WebsiteAnalytics::getTodayVisitors() ?? 0,
            'today_pageviews' => WebsiteAnalytics::getTodayPageViews() ?? 0,
            'total_visitors' => WebsiteAnalytics::where('created_at', '>=', $startDate)
                ->where('is_bot', false)
                ->distinct('session_id')
                ->count() ?? 0,
            'total_pageviews' => PageView::where('created_at', '>=', $startDate)->count() ?? 0,
            'bounce_rate' => PageView::getBounceRate($days) ?? 0,
            'avg_session_duration' => WebsiteAnalytics::getAverageSessionDuration($days) ?? 0,
            'avg_time_on_page' => PageView::getAverageTimeOnPage($days) ?? 0
        ];

        // Traffic Sources
        $trafficSources = WebsiteAnalytics::getReferrerStats($days) ?? collect();

        // Device Statistics
        $deviceStats = WebsiteAnalytics::getDeviceStats($days) ?? collect();

        // Country Statistics
        $countryStats = WebsiteAnalytics::getCountryStats($days) ?? collect();

        // Most Viewed Pages
        $topPages = PageView::getMostViewedPages($days, 10) ?? collect();

        // Trending Articles
        $trendingArticles = PageView::getTrendingArticles($days, 10) ?? collect();

        // Daily Visitors Chart Data
        $dailyVisitors = WebsiteAnalytics::getDailyVisitors($days) ?? collect();

        // Page Views Chart Data
        $dailyPageViews = PageView::getPageViewsForPeriod($days) ?? collect();

        // SEO Blog Statistics
        $blogStats = [
            'total_articles' => SeoBlog::count(),
            'published_articles' => SeoBlog::where('status', 'published')->count(),
            'draft_articles' => SeoBlog::where('status', 'draft')->count(),
            'featured_articles' => SeoBlog::where('is_featured', true)->count(),
            'avg_seo_score' => SeoBlog::avg('seo_score'),
        ];

        // Search Console Data (if available)
        $searchConsole = [
            'total_clicks' => SearchConsoleData::getTotalClicks($days),
            'total_impressions' => SearchConsoleData::getTotalImpressions($days),
            'average_ctr' => SearchConsoleData::getAverageCTR($days),
            'average_position' => SearchConsoleData::getAveragePosition($days),
            'top_queries' => SearchConsoleData::getTopQueries($days, 5),
            'top_pages' => SearchConsoleData::getTopPages($days, 5),
            'daily_performance' => SearchConsoleData::getDailyPerformance($days),
            'device_performance' => SearchConsoleData::getDevicePerformance($days)
        ];

        // Recent Activity
        $recentActivity = $this->getRecentActivity();

        return view('seo.dashboard', compact(
            'analytics',
            'trafficSources',
            'deviceStats',
            'countryStats',
            'topPages',
            'trendingArticles',
            'dailyVisitors',
            'dailyPageViews',
            'blogStats',
            'searchConsole',
            'recentActivity',
            'days'
        ));
    }

    /**
     * Get recent activity for the dashboard
     */
    private function getRecentActivity()
    {
        $recentViews = PageView::with('article')
            ->where('page_type', 'article')
            ->whereNotNull('article_id')
            ->latest()
            ->limit(10)
            ->get()
            ->map(function ($view) {
                return [
                    'type' => 'page_view',
                    'description' => 'Article viewed: ' . ($view->page_title ?? 'Unknown'),
                    'url' => $view->url,
                    'time' => $view->created_at,
                ];
            });

        $recentArticles = SeoBlog::latest()
            ->limit(5)
            ->get()
            ->map(function ($article) {
                return [
                    'type' => 'article_published',
                    'description' => 'Article published: ' . $article->title,
                    'url' => route('article.show', $article->slug),
                    'time' => $article->created_at,
                ];
            });

        return $recentViews->concat($recentArticles)
            ->sortByDesc('time')
            ->take(10)
            ->values();
    }

    /**
     * API endpoint for real-time analytics
     */
    public function analytics(Request $request)
    {
        $days = $request->get('days', 7);

        return response()->json([
            'visitors_today' => WebsiteAnalytics::getTodayVisitors(),
            'pageviews_today' => WebsiteAnalytics::getTodayPageViews(),
            'daily_visitors' => WebsiteAnalytics::getDailyVisitors($days),
            'device_stats' => WebsiteAnalytics::getDeviceStats($days),
            'country_stats' => WebsiteAnalytics::getCountryStats($days),
            'traffic_sources' => WebsiteAnalytics::getReferrerStats($days),
            'trending_articles' => PageView::getTrendingArticles($days, 5),
        ]);
    }
}
