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
            ['url' => route('tutorials'), 'lastmod' => now(), 'changefreq' => 'weekly', 'priority' => '0.7'],
            ['url' => route('articles'), 'lastmod' => now(), 'changefreq' => 'daily', 'priority' => '0.9'],
            ['url' => route('contact'), 'lastmod' => now(), 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['url' => route('hire-us'), 'lastmod' => now(), 'changefreq' => 'monthly', 'priority' => '0.7'],
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
        $robotsTxt .= "Disallow: /seo/\n";
        $robotsTxt .= "Disallow: /admin/\n";
        $robotsTxt .= "Disallow: /storage/\n";
        $robotsTxt .= "Disallow: /*.json$\n";
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