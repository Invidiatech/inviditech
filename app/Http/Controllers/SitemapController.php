<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Seo\SeoBlog;
use App\Models\Category;
use Carbon\Carbon;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemaps = [
            ['url' => route('sitemap.pages'), 'lastmod' => now()],
            ['url' => route('sitemap.articles'), 'lastmod' => now()],
            ['url' => route('sitemap.categories'), 'lastmod' => now()],
        ];

        return response()->view('sitemap.index', compact('sitemaps'))
            ->header('Content-Type', 'application/xml');
    }

    public function pages()
    {
        $pages = [
            ['url' => route('home'), 'lastmod' => now(), 'changefreq' => 'weekly', 'priority' => '1.0'],
            ['url' => route('about'), 'lastmod' => now(), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['url' => route('services'), 'lastmod' => now(), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['url' => route('services.laravel'), 'lastmod' => now(), 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['url' => route('services.api'), 'lastmod' => now(), 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['url' => route('services.performance'), 'lastmod' => now(), 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['url' => route('tutorials'), 'lastmod' => now(), 'changefreq' => 'weekly', 'priority' => '0.7'],
            ['url' => route('articles'), 'lastmod' => now(), 'changefreq' => 'daily', 'priority' => '0.9'],
            ['url' => route('contact'), 'lastmod' => now(), 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['url' => route('hire-us'), 'lastmod' => now(), 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['url' => route('software-engineer'), 'lastmod' => now(), 'changefreq' => 'monthly', 'priority' => '0.9'],
            ['url' => route('case-studies'), 'lastmod' => now(), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['url' => route('projects'), 'lastmod' => now(), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['url' => route('resume'), 'lastmod' => now(), 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['url' => route('faq'), 'lastmod' => now(), 'changefreq' => 'monthly', 'priority' => '0.6'],
            // Developer Tools (High Priority for SEO)
            ['url' => route('tools.json-formatter'), 'lastmod' => now(), 'changefreq' => 'monthly', 'priority' => '0.9'],
            ['url' => route('tools.base64-tool'), 'lastmod' => now(), 'changefreq' => 'monthly', 'priority' => '0.9'],
            ['url' => route('tools.hash-generator'), 'lastmod' => now(), 'changefreq' => 'monthly', 'priority' => '0.9'],
            ['url' => route('tools.url-encoder-decoder'), 'lastmod' => now(), 'changefreq' => 'monthly', 'priority' => '0.9'],
            ['url' => route('tools.timestamp-converter'), 'lastmod' => now(), 'changefreq' => 'monthly', 'priority' => '0.9'],
        ];

        return response()->view('sitemap.pages', compact('pages'))
            ->header('Content-Type', 'application/xml');
    }

    public function articles()
    {
        $articles = SeoBlog::where('status', 'published')
            ->where('is_indexed', true)
            ->select(['slug', 'updated_at', 'created_at'])
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function ($article) {
                return [
                    'url' => route('article.show', $article->slug),
                    'lastmod' => $article->updated_at,
                    'changefreq' => 'weekly',
                    'priority' => '0.8'
                ];
            });

        return response()->view('sitemap.articles', compact('articles'))
            ->header('Content-Type', 'application/xml');
    }

    public function categories()
    {
        $categories = Category::has('articles')
            ->select(['slug', 'updated_at'])
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function ($category) {
                return [
                    'url' => route('articles', ['category' => $category->slug]),
                    'lastmod' => $category->updated_at,
                    'changefreq' => 'weekly',
                    'priority' => '0.7'
                ];
            });

        return response()->view('sitemap.categories', compact('categories'))
            ->header('Content-Type', 'application/xml');
    }

    public function robots()
    {
        $robotsTxt = "User-agent: *\n";
        $robotsTxt .= "Allow: /\n";
        $robotsTxt .= "\n";
        $robotsTxt .= "# Block admin and backend areas\n";
        $robotsTxt .= "Disallow: /seo/\n";
        $robotsTxt .= "Disallow: /admin/\n";
        $robotsTxt .= "Disallow: /storage/\n";
        $robotsTxt .= "\n";
        $robotsTxt .= "# Block authentication pages\n";
        $robotsTxt .= "Disallow: /login\n";
        $robotsTxt .= "Disallow: /register\n";
        $robotsTxt .= "Disallow: /forgot-password\n";
        $robotsTxt .= "Disallow: /reset-password\n";
        $robotsTxt .= "Disallow: /verify-email\n";
        $robotsTxt .= "Disallow: /confirm-password\n";
        $robotsTxt .= "Disallow: /logout\n";
        $robotsTxt .= "Disallow: /password\n";
        $robotsTxt .= "\n";
        $robotsTxt .= "# Block system and utility pages\n";
        $robotsTxt .= "Disallow: /optimize-clear\n";
        $robotsTxt .= "Disallow: /storage-link\n";
        $robotsTxt .= "Disallow: /run-migrate\n";
        $robotsTxt .= "Disallow: /coalationtech-task\n";
        $robotsTxt .= "Disallow: /fetch\n";
        $robotsTxt .= "Disallow: /store\n";
        $robotsTxt .= "Disallow: /update\n";
        $robotsTxt .= "Disallow: /blog-post-image-generator\n";
        $robotsTxt .= "\n";
        $robotsTxt .= "# Block API endpoints and JSON files\n";
        $robotsTxt .= "Disallow: /*.json$\n";
        $robotsTxt .= "Disallow: /api/\n";
        $robotsTxt .= "\n";
        $robotsTxt .= "# Block URL parameters (avoid duplicate content)\n";
        $robotsTxt .= "Disallow: /*?*\n";
        $robotsTxt .= "\n";
        $robotsTxt .= "Sitemap: " . route('sitemap.index') . "\n";
        $robotsTxt .= "\n";
        $robotsTxt .= "# Crawl-delay for bots\n";
        $robotsTxt .= "User-agent: Googlebot\n";
        $robotsTxt .= "Crawl-delay: 1\n";
        $robotsTxt .= "\n";
        $robotsTxt .= "User-agent: Bingbot\n";
        $robotsTxt .= "Crawl-delay: 1\n";

        return response($robotsTxt)
            ->header('Content-Type', 'text/plain');
    }

    public function cv()
    {
        $cvPath = public_path('cv/Muhammad Nawaz(Full-Stack Developer).pdf');

        if (!file_exists($cvPath)) {
            abort(404, 'CV file not found');
        }

        return response()->file($cvPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="Muhammad Nawaz CV.pdf"'
        ]);
    }
}