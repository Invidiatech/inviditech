<?php

namespace App\Http\Middleware;

use App\Services\AnalyticsService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackAnalytics
{
    protected $analyticsService;

    public function __construct(AnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track GET requests to avoid tracking form submissions, API calls, etc.
        if ($request->isMethod('GET') && !$request->ajax()) {
            $this->trackPageView($request);
        }

        return $response;
    }

    /**
     * Track page view with context
     */
    protected function trackPageView(Request $request)
    {
        $route = $request->route();
        $pageType = null;
        $articleId = null;

        if ($route) {
            $routeName = $route->getName();
            
            // Determine page type and extract article ID if applicable
            switch ($routeName) {
                case 'home':
                    $pageType = 'home';
                    break;
                case 'services':
                    $pageType = 'services';
                    break;
                case 'articles':
                    $pageType = 'articles_list';
                    break;
                case 'article.show':
                    $pageType = 'article';
                    $articleId = $this->extractArticleId($request);
                    break;
                case 'about':
                    $pageType = 'about';
                    break;
                case 'contact':
                    $pageType = 'contact';
                    break;
                case 'tutorials':
                    $pageType = 'tutorials';
                    break;
                default:
                    $pageType = 'other';
            }
        }

        $this->analyticsService->trackPageView($request, $pageType, $articleId);
    }

    /**
     * Extract article ID from route parameters
     */
    protected function extractArticleId(Request $request)
    {
        $route = $request->route();
        
        if ($route && $route->hasParameter('slug')) {
            $slug = $route->parameter('slug');
            
            // Try to find the article by slug
            $article = \App\Models\Seo\SeoBlog::where('slug', $slug)->first();
            return $article ? $article->id : null;
        }
        
        return null;
    }
}