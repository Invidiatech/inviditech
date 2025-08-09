<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use App\Models\Seo\SeoBlog;

class SeoHelper
{
    /**
     * Generate optimized meta title
     */
    public static function generateMetaTitle($title, $siteTitle = 'InvidiaTech')
    {
        $cleanTitle = strip_tags($title);
        $maxLength = 60;
        
        if (strlen($cleanTitle . ' - ' . $siteTitle) <= $maxLength) {
            return $cleanTitle . ' - ' . $siteTitle;
        }
        
        return Str::limit($cleanTitle, $maxLength - strlen(' - ' . $siteTitle) - 3) . ' - ' . $siteTitle;
    }

    /**
     * Generate optimized meta description
     */
    public static function generateMetaDescription($content, $excerpt = null, $maxLength = 160)
    {
        if ($excerpt && !empty(trim($excerpt))) {
            $description = strip_tags($excerpt);
        } else {
            $description = strip_tags($content);
        }
        
        // Clean up the description
        $description = preg_replace('/\s+/', ' ', $description);
        $description = trim($description);
        
        return Str::limit($description, $maxLength);
    }

    /**
     * Generate canonical URL
     */
    public static function generateCanonicalUrl($url = null)
    {
        if ($url) {
            return $url;
        }
        
        return url()->current();
    }

    /**
     * Calculate reading time
     */
    public static function calculateReadingTime($content, $wordsPerMinute = 200)
    {
        $wordCount = str_word_count(strip_tags($content));
        $readingTime = ceil($wordCount / $wordsPerMinute);
        
        return max(1, $readingTime); // Minimum 1 minute
    }

    /**
     * Generate Open Graph image URL
     */
    public static function generateOgImage($featuredImage = null, $ogImage = null)
    {
        if ($featuredImage) {
            return asset('storage/' . $featuredImage);
        }
        
        if ($ogImage) {
            return asset('storage/' . $ogImage);
        }
        
        return asset('assets/website/images/og-default.jpg');
    }

    /**
     * Generate comprehensive article schema
     */
    public static function generateArticleSchema($article)
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $article->title,
            'description' => self::generateMetaDescription($article->content, $article->excerpt),
            'image' => [
                '@type' => 'ImageObject',
                'url' => self::generateOgImage($article->featured_image, $article->og_image),
                'width' => 1200,
                'height' => 630
            ],
            'author' => [
                '@type' => 'Person',
                'name' => 'InvidiaTech Team',
                'url' => url('/')
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'InvidiaTech',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('assets/website/images/logo.png')
                ],
                'url' => url('/')
            ],
            'datePublished' => $article->publish_date ? $article->publish_date->toISOString() : $article->created_at->toISOString(),
            'dateModified' => $article->updated_at->toISOString(),
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => url()->current()
            ],
            'wordCount' => str_word_count(strip_tags($article->content)),
            'timeRequired' => 'PT' . self::calculateReadingTime($article->content) . 'M',
            'inLanguage' => 'en-US',
            'isAccessibleForFree' => true
        ];

        // Add article section if category exists
        if ($article->category) {
            // Handle both cases: loaded relationship or just ID
            if (is_object($article->category) && isset($article->category->name)) {
                $schema['articleSection'] = $article->category->name;
            } elseif (is_numeric($article->category)) {
                // If category is just an ID, try to load it
                $category = \App\Models\Category::find($article->category);
                if ($category) {
                    $schema['articleSection'] = $category->name;
                }
            }
        }

        // Add keywords
        $keywords = [];
        if ($article->focus_keyword) {
            $keywords[] = $article->focus_keyword;
        }
        if ($article->tags && $article->tags->count()) {
            foreach ($article->tags as $tag) {
                $keywords[] = $tag->name;
            }
        }
        if (!empty($keywords)) {
            $schema['keywords'] = $keywords;
        }

        return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * Generate website schema for non-article pages
     */
    public static function generateWebsiteSchema()
    {
        return json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => 'InvidiaTech',
            'url' => url('/'),
            'description' => 'Professional technical solutions and development services',
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'InvidiaTech',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('assets/website/images/logo.png')
                ]
            ],
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => route('articles') . '?search={search_term_string}',
                'query-input' => 'required name=search_term_string'
            ]
        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * Validate SEO content
     */
    public static function validateSeoContent($article)
    {
        $issues = [];
        $recommendations = [];

        // Title checks
        if (!$article->title || strlen($article->title) < 10) {
            $issues[] = 'Title is too short (minimum 10 characters)';
        }
        if (strlen($article->title) > 60) {
            $recommendations[] = 'Title should be under 60 characters for better SEO';
        }

        // Meta description checks
        if (!$article->meta_description) {
            $issues[] = 'Meta description is missing';
        } elseif (strlen($article->meta_description) < 120) {
            $recommendations[] = 'Meta description should be at least 120 characters';
        } elseif (strlen($article->meta_description) > 160) {
            $issues[] = 'Meta description is too long (maximum 160 characters)';
        }

        // Focus keyword checks
        if (!$article->focus_keyword) {
            $recommendations[] = 'Consider adding a focus keyword';
        } elseif ($article->focus_keyword && $article->title) {
            if (stripos($article->title, $article->focus_keyword) === false) {
                $recommendations[] = 'Include focus keyword in title';
            }
        }

        // Content checks
        $wordCount = str_word_count(strip_tags($article->content));
        if ($wordCount < 300) {
            $recommendations[] = 'Content should be at least 300 words for better SEO';
        }

        // Image checks
        if (!$article->featured_image) {
            $recommendations[] = 'Add a featured image for better social sharing';
        }

        return [
            'issues' => $issues,
            'recommendations' => $recommendations,
            'score' => self::calculateSeoScore($article)
        ];
    }

    /**
     * Calculate SEO score
     */
    public static function calculateSeoScore($article)
    {
        $score = 0;
        $maxScore = 100;

        // Title (20 points)
        if ($article->title && strlen($article->title) >= 10 && strlen($article->title) <= 60) {
            $score += 20;
        } elseif ($article->title) {
            $score += 10;
        }

        // Meta description (20 points)
        if ($article->meta_description && strlen($article->meta_description) >= 120 && strlen($article->meta_description) <= 160) {
            $score += 20;
        } elseif ($article->meta_description) {
            $score += 10;
        }

        // Focus keyword (15 points)
        if ($article->focus_keyword) {
            $score += 10;
            if ($article->title && stripos($article->title, $article->focus_keyword) !== false) {
                $score += 5;
            }
        }

        // Content length (15 points)
        $wordCount = str_word_count(strip_tags($article->content));
        if ($wordCount >= 300) {
            $score += 15;
        } elseif ($wordCount >= 150) {
            $score += 10;
        } elseif ($wordCount >= 100) {
            $score += 5;
        }

        // Featured image (10 points)
        if ($article->featured_image) {
            $score += 10;
        }

        // Tags (10 points)
        if ($article->tags && $article->tags->count() >= 2) {
            $score += 10;
        } elseif ($article->tags && $article->tags->count() >= 1) {
            $score += 5;
        }

        // Category (5 points)
        if ($article->category) {
            $score += 5;
        }

        // Reading time (5 points)
        if ($article->reading_time) {
            $score += 5;
        }

        return min($score, $maxScore);
    }
}