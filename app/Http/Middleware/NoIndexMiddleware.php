<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoIndexMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Add noindex, nofollow meta tags to prevent search engine indexing
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only add meta tags to HTML responses
        if ($response instanceof Response && 
            str_contains($response->headers->get('Content-Type', ''), 'text/html')) {
            
            // Add X-Robots-Tag header as primary method
            $response->headers->set('X-Robots-Tag', 'noindex, nofollow, noarchive, nosnippet');
            
            $content = $response->getContent();
            
            // Add meta robots tag if <head> exists and doesn't already have robots meta
            if (str_contains($content, '<head>') && !str_contains($content, 'name="robots"')) {
                $metaTag = '<meta name="robots" content="noindex, nofollow, noarchive, nosnippet">';
                $content = str_replace('<head>', '<head>' . $metaTag, $content);
                $response->setContent($content);
            }
        }

        return $response;
    }
}
