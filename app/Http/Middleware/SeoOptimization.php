<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Helpers\SeoHelper;

class SeoOptimization
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Add X-Robots-Tag header for better SEO control
        if ($request->is('seo/*') || $request->is('admin/*')) {
            $response->headers->set('X-Robots-Tag', 'noindex, nofollow');
        }

        // Add security headers that also help with SEO
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        return $response;
    }
}