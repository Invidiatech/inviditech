<?php

namespace App\Services;

use App\Models\WebsiteAnalytics;
use App\Models\PageView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Agent;

class AnalyticsService
{
    protected $agent;

    public function __construct()
    {
        $this->agent = new Agent();
    }

    /**
     * Track page view
     */
    public function trackPageView(Request $request, $pageType = null, $articleId = null)
    {
        if ($this->isBot($request)) {
            return;
        }

        $sessionId = Session::getId();
        $ipAddress = $this->getClientIp($request);
        $userAgent = $request->userAgent();

        // Track or update session analytics
        $this->trackSession($sessionId, $request, $ipAddress, $userAgent);

        // Track individual page view
        $this->trackIndividualPageView($request, $sessionId, $pageType, $articleId);
    }

    /**
     * Track session analytics
     */
    protected function trackSession($sessionId, Request $request, $ipAddress, $userAgent)
    {
        $analytics = WebsiteAnalytics::where('session_id', $sessionId)->first();

        if (!$analytics) {
            // New session
            $analytics = WebsiteAnalytics::create([
                'session_id' => $sessionId,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'device_type' => $this->getDeviceType(),
                'browser' => $this->agent->browser(),
                'operating_system' => $this->agent->platform(),
                'country' => $this->getCountryFromIp($ipAddress),
                'city' => $this->getCityFromIp($ipAddress),
                'referrer' => $request->header('referer'),
                'landing_page' => $request->fullUrl(),
                'current_page' => $request->fullUrl(),
                'utm_parameters' => $this->getUtmParameters($request),
                'is_bot' => $this->isBot($request)
            ]);
        } else {
            // Update existing session
            $analytics->update([
                'current_page' => $request->fullUrl(),
                'page_views' => $analytics->page_views + 1,
                'session_duration' => now()->diffInSeconds($analytics->created_at)
            ]);
        }

        return $analytics;
    }

    /**
     * Track individual page view
     */
    protected function trackIndividualPageView(Request $request, $sessionId, $pageType, $articleId)
    {
        PageView::create([
            'session_id' => $sessionId,
            'url' => $request->fullUrl(),
            'page_title' => $this->getPageTitle($request),
            'page_type' => $pageType,
            'article_id' => $articleId,
            'ip_address' => $this->getClientIp($request),
            'referrer' => $request->header('referer'),
            'utm_parameters' => $this->getUtmParameters($request)
        ]);
    }

    /**
     * Get device type
     */
    protected function getDeviceType()
    {
        if ($this->agent->isMobile()) {
            return 'mobile';
        } elseif ($this->agent->isTablet()) {
            return 'tablet';
        } elseif ($this->agent->isDesktop()) {
            return 'desktop';
        }
        
        return 'unknown';
    }

    /**
     * Get client IP address
     */
    protected function getClientIp(Request $request)
    {
        $ipKeys = ['HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP', 'HTTP_CLIENT_IP', 'REMOTE_ADDR'];
        
        foreach ($ipKeys as $key) {
            if (!empty($request->server($key))) {
                $ips = explode(',', $request->server($key));
                $ip = trim($ips[0]);
                
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }
        
        return $request->ip();
    }

    /**
     * Get country from IP (basic implementation)
     */
    protected function getCountryFromIp($ip)
    {
        // For development, return a default value
        // In production, integrate with a GeoIP service like MaxMind or ip-api.com
        if ($ip === '127.0.0.1' || $ip === '::1') {
            return 'Local';
        }

        try {
            // Using a free API service (replace with your preferred service)
            $response = @file_get_contents("http://ip-api.com/json/{$ip}?fields=country");
            if ($response) {
                $data = json_decode($response, true);
                return $data['country'] ?? 'Unknown';
            }
        } catch (\Exception $e) {
            // Fallback
        }

        return 'Unknown';
    }

    /**
     * Get city from IP (basic implementation)
     */
    protected function getCityFromIp($ip)
    {
        if ($ip === '127.0.0.1' || $ip === '::1') {
            return 'Local';
        }

        try {
            $response = @file_get_contents("http://ip-api.com/json/{$ip}?fields=city");
            if ($response) {
                $data = json_decode($response, true);
                return $data['city'] ?? 'Unknown';
            }
        } catch (\Exception $e) {
            // Fallback
        }

        return 'Unknown';
    }

    /**
     * Check if request is from a bot
     */
    protected function isBot(Request $request)
    {
        $userAgent = strtolower($request->userAgent() ?? '');
        
        $bots = [
            'googlebot', 'bingbot', 'slurp', 'duckduckbot', 'baiduspider',
            'yandexbot', 'facebookexternalhit', 'twitterbot', 'rogerbot',
            'linkedinbot', 'embedly', 'quora link preview', 'showyoubot',
            'outbrain', 'pinterest', 'developers.google.com/+/web/snippet',
            'slackbot', 'vkshare', 'w3c_validator', 'redditbot', 'applebot',
            'whatsapp', 'flipboard', 'tumblr', 'bitlybot', 'skypeuripreview',
            'nuzzel', 'discordbot', 'google page speed', 'qwantbot'
        ];

        foreach ($bots as $bot) {
            if (strpos($userAgent, $bot) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get UTM parameters
     */
    protected function getUtmParameters(Request $request)
    {
        $utmParams = [];
        $utmKeys = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content'];

        foreach ($utmKeys as $key) {
            if ($request->has($key)) {
                $utmParams[$key] = $request->get($key);
            }
        }

        return !empty($utmParams) ? $utmParams : null;
    }

    /**
     * Get page title
     */
    protected function getPageTitle(Request $request)
    {
        // Extract page title from route or URL
        $route = $request->route();
        
        if ($route) {
            $routeName = $route->getName();
            
            $titles = [
                'home' => 'Home - InvidiaTech',
                'services' => 'Services - InvidiaTech',
                'articles' => 'Articles - InvidiaTech',
                'article.show' => 'Article - InvidiaTech',
                'about' => 'About - InvidiaTech',
                'contact' => 'Contact - InvidiaTech',
            ];

            return $titles[$routeName] ?? 'InvidiaTech';
        }

        return 'InvidiaTech';
    }

    /**
     * Update time on page
     */
    public function updateTimeOnPage($sessionId, $url, $timeSpent)
    {
        PageView::where('session_id', $sessionId)
            ->where('url', $url)
            ->latest()
            ->first()
            ?->update(['time_on_page' => $timeSpent]);
    }

    /**
     * Update scroll depth
     */
    public function updateScrollDepth($sessionId, $url, $scrollDepth)
    {
        PageView::where('session_id', $sessionId)
            ->where('url', $url)
            ->latest()
            ->first()
            ?->update(['scroll_depth' => $scrollDepth]);
    }
}