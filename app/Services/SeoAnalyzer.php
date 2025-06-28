<?php

// Services/SeoAnalyzer.php
namespace App\Services;

use App\Models\SeoPage;
use App\Models\Blog; // Change this to your actual Blog model
use App\Models\SeoCollection;

class SeoAnalyzer
{
    public function analyzePage($page)
    {
        $score = 0;
        $maxScore = 100;

        // Title optimization (20 points)
        if (!empty($page->meta_title)) {
            $titleLength = strlen($page->meta_title);
            if ($titleLength >= 30 && $titleLength <= 60) {
                $score += 20;
            } elseif ($titleLength > 0) {
                $score += 10;
            }
        }

        // Meta description (15 points)
        if (!empty($page->meta_description)) {
            $descLength = strlen($page->meta_description);
            if ($descLength >= 120 && $descLength <= 160) {
                $score += 15;
            } elseif ($descLength > 0) {
                $score += 8;
            }
        }

        // Focus keyword optimization (25 points)
        if (!empty($page->focus_keyword)) {
            $keyword = strtolower($page->focus_keyword);
            $title = strtolower($page->title);
            $content = strtolower(strip_tags($page->content));
            $metaDesc = strtolower($page->meta_description ?? '');

            $keywordScore = 0;

            // Keyword in title
            if (strpos($title, $keyword) !== false) {
                $keywordScore += 8;
            }

            // Keyword in meta description
            if (strpos($metaDesc, $keyword) !== false) {
                $keywordScore += 5;
            }

            // Keyword density in content (1-3%)
            $wordCount = str_word_count($content);
            $keywordCount = substr_count($content, $keyword);
            $density = $wordCount > 0 ? ($keywordCount / $wordCount) * 100 : 0;

            if ($density >= 1 && $density <= 3) {
                $keywordScore += 12;
            } elseif ($density > 0) {
                $keywordScore += 6;
            }

            $score += $keywordScore;
        }

        // Content length (15 points)
        $wordCount = str_word_count(strip_tags($page->content));
        if ($wordCount >= 300) {
            if ($wordCount >= 1000) {
                $score += 15;
            } else {
                $score += 10;
            }
        }

        // Image optimization (10 points)
        if (!empty($page->featured_image)) {
            $score += 5;
        }

        // Check for alt tags in content images
        if (preg_match_all('/<img[^>]+alt=["\']([^"\']*)["\'][^>]*>/i', $page->content, $matches)) {
            $score += 5;
        }

        // Internal/External links (10 points)
        $linkCount = preg_match_all('/<a[^>]+href=["\']([^"\']*)["\'][^>]*>/i', $page->content, $matches);
        if ($linkCount > 0) {
            $score += 5;
            if ($linkCount >= 3) {
                $score += 5;
            }
        }

        // Schema markup (5 points)
        if (!empty($page->schema_markup)) {
            $score += 5;
        }

        return min($score, $maxScore);
    }

    // FIXED: Update the analyzeBlog method to return the expected array structure
    public function analyzeBlog($blog)
    {
        $analysis = [];
        $score = 0;
        $maxScore = 100;

        // Title Analysis (20 points)
        $titleAnalysis = $this->analyzeBlogTitle($blog);
        $analysis['title_check'] = $titleAnalysis;
        $score += $titleAnalysis['points'];

        // Meta Description Analysis (20 points)
        $metaAnalysis = $this->analyzeBlogMetaDescription($blog);
        $analysis['meta_description_check'] = $metaAnalysis;
        $score += $metaAnalysis['points'];

        // Content Length Analysis (20 points)
        $contentAnalysis = $this->analyzeBlogContent($blog);
        $analysis['content_length_check'] = $contentAnalysis;
        $score += $contentAnalysis['points'];

        // Focus Keyword Analysis (25 points)
        $keywordAnalysis = $this->analyzeBlogKeyword($blog);
        $analysis['keyword_check'] = $keywordAnalysis;
        $score += $keywordAnalysis['points'];

        // Image Analysis (10 points)
        $imageAnalysis = $this->analyzeBlogImages($blog);
        $analysis['image_check'] = $imageAnalysis;
        $score += $imageAnalysis['points'];

        // Technical SEO (5 points)
        $technicalAnalysis = $this->analyzeBlogTechnical($blog);
        $analysis['technical_check'] = $technicalAnalysis;
        $score += $technicalAnalysis['points'];

        $finalScore = min($score, $maxScore);

        return [
            'score' => $finalScore,
            'analysis' => $analysis
        ];
    }

    private function analyzeBlogTitle($blog)
    {
        $title = $blog->meta_title ?? $blog->title;
        $length = strlen($title);
        $points = 0;
        $passed = false;
        $message = '';

        if ($length >= 30 && $length <= 60) {
            $points = 20;
            $passed = true;
            $message = "Title length is optimal ({$length} characters)";
        } elseif ($length > 0 && $length < 30) {
            $points = 10;
            $message = "Title is too short ({$length} characters) - aim for 30-60";
        } elseif ($length > 60) {
            $points = 10;
            $message = "Title is too long ({$length} characters) - aim for 30-60";
        } else {
            $message = "Title is missing";
        }

        return [
            'passed' => $passed,
            'points' => $points,
            'message' => $message,
            'title' => 'Title Optimization'
        ];
    }

    private function analyzeBlogMetaDescription($blog)
    {
        $description = $blog->meta_description ?? '';
        $length = strlen($description);
        $points = 0;
        $passed = false;
        $message = '';

        if ($length >= 120 && $length <= 160) {
            $points = 20;
            $passed = true;
            $message = "Meta description length is optimal ({$length} characters)";
        } elseif ($length > 0 && $length < 120) {
            $points = 10;
            $message = "Meta description is too short ({$length} characters) - aim for 120-160";
        } elseif ($length > 160) {
            $points = 10;
            $message = "Meta description is too long ({$length} characters) - aim for 120-160";
        } else {
            $message = "Meta description is missing";
        }

        return [
            'passed' => $passed,
            'points' => $points,
            'message' => $message,
            'title' => 'Meta Description'
        ];
    }

    private function analyzeBlogContent($blog)
    {
        $content = strip_tags($blog->content ?? '');
        $wordCount = str_word_count($content);
        $points = 0;
        $passed = false;
        $message = '';

        if ($wordCount >= 300) {
            if ($wordCount >= 1000) {
                $points = 20;
                $passed = true;
                $message = "Excellent content length ({$wordCount} words)";
            } else {
                $points = 15;
                $passed = true;
                $message = "Good content length ({$wordCount} words)";
            }
        } elseif ($wordCount > 0) {
            $points = 5;
            $message = "Content is too short ({$wordCount} words) - aim for at least 300";
        } else {
            $message = "No content found";
        }

        return [
            'passed' => $passed,
            'points' => $points,
            'message' => $message,
            'title' => 'Content Length'
        ];
    }

    private function analyzeBlogKeyword($blog)
    {
        $keyword = $blog->focus_keyword ?? '';
        $points = 0;
        $passed = false;
        $message = '';

        if (empty($keyword)) {
            $message = "No focus keyword set";
        } else {
            $keyword = strtolower($keyword);
            $title = strtolower($blog->title ?? '');
            $content = strtolower(strip_tags($blog->content ?? ''));
            $metaDesc = strtolower($blog->meta_description ?? '');

            $keywordScore = 0;
            $checks = [];

            // Keyword in title (8 points)
            if (strpos($title, $keyword) !== false) {
                $keywordScore += 8;
                $checks[] = "✓ Keyword found in title";
            } else {
                $checks[] = "✗ Keyword not found in title";
            }

            // Keyword in meta description (5 points)
            if (strpos($metaDesc, $keyword) !== false) {
                $keywordScore += 5;
                $checks[] = "✓ Keyword found in meta description";
            } else {
                $checks[] = "✗ Keyword not found in meta description";
            }

            // Keyword density in content (12 points)
            $wordCount = str_word_count($content);
            if ($wordCount > 0) {
                $keywordCount = substr_count($content, $keyword);
                $density = ($keywordCount / $wordCount) * 100;

                if ($density >= 1 && $density <= 3) {
                    $keywordScore += 12;
                    $checks[] = "✓ Good keyword density (" . round($density, 2) . "%)";
                } elseif ($density > 0) {
                    $keywordScore += 6;
                    if ($density < 1) {
                        $checks[] = "⚠ Keyword density too low (" . round($density, 2) . "%)";
                    } else {
                        $checks[] = "⚠ Keyword density too high (" . round($density, 2) . "%)";
                    }
                } else {
                    $checks[] = "✗ Keyword not found in content";
                }
            }

            $points = $keywordScore;
            $passed = $keywordScore >= 20;
            $message = implode(' | ', $checks);
        }

        return [
            'passed' => $passed,
            'points' => $points,
            'message' => $message,
            'title' => 'Focus Keyword Usage'
        ];
    }

    private function analyzeBlogImages($blog)
    {
        $points = 0;
        $passed = false;
        $checks = [];

        // Featured image (5 points)
        if (!empty($blog->featured_image)) {
            $points += 5;
            $checks[] = "✓ Featured image present";
        } else {
            $checks[] = "✗ No featured image";
        }

        // Alt tags in content images (5 points)
        $content = $blog->content ?? '';
        preg_match_all('/<img[^>]*>/i', $content, $allImages);
        preg_match_all('/<img[^>]+alt=["\']([^"\']*)["\'][^>]*>/i', $content, $imagesWithAlt);

        $totalImages = count($allImages[0]);
        $imagesWithAltCount = count($imagesWithAlt[0]);

        if ($totalImages > 0) {
            if ($imagesWithAltCount === $totalImages) {
                $points += 5;
                $checks[] = "✓ All images have alt text ({$totalImages}/{$totalImages})";
            } else {
                $points += 2;
                $checks[] = "⚠ Some images missing alt text ({$imagesWithAltCount}/{$totalImages})";
            }
        } else {
            $checks[] = "ℹ No images in content";
        }

        $passed = $points >= 8;
        $message = implode(' | ', $checks);

        return [
            'passed' => $passed,
            'points' => $points,
            'message' => $message,
            'title' => 'Image Optimization'
        ];
    }

    private function analyzeBlogTechnical($blog)
    {
        $points = 0;
        $passed = false;
        $checks = [];

        // Schema markup (3 points)
        if (!empty($blog->schema_markup)) {
            $points += 3;
            $checks[] = "✓ Schema markup present";
        } else {
            $checks[] = "✗ No schema markup";
        }

        // Canonical URL (2 points)
        if (!empty($blog->canonical_url)) {
            $points += 2;
            $checks[] = "✓ Canonical URL set";
        } else {
            $checks[] = "✗ No canonical URL";
        }

        $passed = $points >= 3;
        $message = implode(' | ', $checks);

        return [
            'passed' => $passed,
            'points' => $points,
            'message' => $message,
            'title' => 'Technical SEO'
        ];
    }

    public function analyzeReadability($content)
    {
        $text = strip_tags($content);
        $sentences = preg_split('/[.!?]+/', $text, -1, PREG_SPLIT_NO_EMPTY);
        $words = str_word_count($text);
        $syllables = $this->countSyllables($text);

        if (count($sentences) == 0 || $words == 0) {
            return 0;
        }

        // Flesch Reading Ease Score
        $avgSentenceLength = $words / count($sentences);
        $avgSyllablesPerWord = $syllables / $words;

        $score = 206.835 - (1.015 * $avgSentenceLength) - (84.6 * $avgSyllablesPerWord);

        return max(0, min(100, round($score)));
    }

    private function countSyllables($text)
    {
        $text = strtolower($text);
        $vowels = 'aeiouy';
        $syllableCount = 0;
        $previousChar = '';

        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            if (strpos($vowels, $char) !== false && strpos($vowels, $previousChar) === false) {
                $syllableCount++;
            }
            $previousChar = $char;
        }

        return max(1, $syllableCount);
    }

    public function getDetailedAnalysis($page)
    {
        return [
            'title_analysis' => $this->analyzeTitleTag($page),
            'meta_analysis' => $this->analyzeMetaDescription($page),
            'keyword_analysis' => $this->analyzeKeywordUsage($page),
            'content_analysis' => $this->analyzeContent($page),
            'technical_analysis' => $this->analyzeTechnicalSEO($page),
            'suggestions' => $this->generateSuggestions($page)
        ];
    }

    private function analyzeTitleTag($page)
    {
        $title = $page->meta_title ?? $page->title;
        $length = strlen($title);

        return [
            'length' => $length,
            'status' => $length >= 30 && $length <= 60 ? 'good' : ($length > 0 ? 'warning' : 'error'),
            'message' => $this->getTitleMessage($length)
        ];
    }

    private function analyzeMetaDescription($page)
    {
        $description = $page->meta_description ?? '';
        $length = strlen($description);

        return [
            'length' => $length,
            'status' => $length >= 120 && $length <= 160 ? 'good' : ($length > 0 ? 'warning' : 'error'),
            'message' => $this->getDescriptionMessage($length),
            'description' => $description
        ];
    }

    private function analyzeKeywordUsage($page)
    {
        $keyword = $page->focus_keyword ?? '';

        if (empty($keyword)) {
            return [
                'status' => 'error',
                'message' => 'No focus keyword set',
                'density' => 0,
                'count' => 0,
                'positions' => []
            ];
        }

        $keyword = strtolower($keyword);
        $title = strtolower($page->title);
        $content = strtolower(strip_tags($page->content));
        $metaDesc = strtolower($page->meta_description ?? '');

        $titleMatch = strpos($title, $keyword) !== false;
        $metaMatch = strpos($metaDesc, $keyword) !== false;

        $wordCount = str_word_count($content);
        $keywordCount = substr_count($content, $keyword);
        $density = $wordCount > 0 ? ($keywordCount / $wordCount) * 100 : 0;

        $status = 'good';
        $message = 'Keyword usage is optimal';

        if ($density < 0.5) {
            $status = 'warning';
            $message = 'Keyword density is too low';
        } elseif ($density > 3) {
            $status = 'error';
            $message = 'Keyword density is too high (keyword stuffing)';
        }

        return [
            'status' => $status,
            'message' => $message,
            'density' => round($density, 2),
            'count' => $keywordCount,
            'in_title' => $titleMatch,
            'in_meta_description' => $metaMatch,
            'total_words' => $wordCount
        ];
    }

    private function analyzeContent($page)
    {
        $content = strip_tags($page->content);
        $wordCount = str_word_count($content);
        $charCount = strlen($content);
        $readingTime = ceil($wordCount / 200); // Average reading speed

        // Analyze heading structure
        $headings = $this->analyzeHeadings($page->content);

        // Analyze paragraph structure
        $paragraphs = explode("\n", $content);
        $paragraphs = array_filter($paragraphs, function($p) {
            return trim($p) !== '';
        });

        $avgParagraphLength = count($paragraphs) > 0 ? $wordCount / count($paragraphs) : 0;

        $status = 'good';
        $message = 'Content length and structure is good';

        if ($wordCount < 300) {
            $status = 'error';
            $message = 'Content is too short (less than 300 words)';
        } elseif ($wordCount < 600) {
            $status = 'warning';
            $message = 'Content could be longer for better SEO';
        }

        return [
            'word_count' => $wordCount,
            'character_count' => $charCount,
            'reading_time' => $readingTime,
            'paragraph_count' => count($paragraphs),
            'avg_paragraph_length' => round($avgParagraphLength),
            'headings' => $headings,
            'status' => $status,
            'message' => $message
        ];
    }

    private function analyzeTechnicalSEO($page)
    {
        $issues = [];
        $warnings = [];
        $passed = [];

        // Check meta title
        if (empty($page->meta_title)) {
            $issues[] = 'Missing meta title';
        } else {
            $passed[] = 'Meta title is present';
        }

        // Check meta description
        if (empty($page->meta_description)) {
            $issues[] = 'Missing meta description';
        } else {
            $passed[] = 'Meta description is present';
        }

        // Check canonical URL
        if (empty($page->canonical_url)) {
            $warnings[] = 'No canonical URL set';
        } else {
            $passed[] = 'Canonical URL is set';
        }

        // Check Open Graph tags
        if (empty($page->og_title) && empty($page->og_description)) {
            $warnings[] = 'Missing Open Graph tags for social media';
        } else {
            $passed[] = 'Open Graph tags are present';
        }

        // Check schema markup
        if (empty($page->schema_markup)) {
            $warnings[] = 'No schema markup found';
        } else {
            $passed[] = 'Schema markup is present';
        }

        // Check images
        $imageAnalysis = $this->analyzeImages($page->content);
        if ($imageAnalysis['missing_alt'] > 0) {
            $issues[] = "{$imageAnalysis['missing_alt']} images missing alt text";
        }

        // Check internal links
        $linkCount = preg_match_all('/<a[^>]+href=["\']([^"\']*)["\'][^>]*>/i', $page->content, $matches);
        if ($linkCount === 0) {
            $warnings[] = 'No internal links found';
        } else {
            $passed[] = "Found {$linkCount} links in content";
        }

        return [
            'issues' => $issues,
            'warnings' => $warnings,
            'passed' => $passed,
            'score' => $this->calculateTechnicalScore($issues, $warnings, $passed)
        ];
    }

    private function analyzeHeadings($content)
    {
        $headings = [];

        for ($i = 1; $i <= 6; $i++) {
            preg_match_all("/<h{$i}[^>]*>(.*?)<\/h{$i}>/i", $content, $matches);
            $headings["h{$i}"] = count($matches[0]);
        }

        return $headings;
    }

    private function analyzeImages($content)
    {
        preg_match_all('/<img[^>]*>/i', $content, $allImages);
        preg_match_all('/<img[^>]+alt=["\']([^"\']*)["\'][^>]*>/i', $content, $imagesWithAlt);

        return [
            'total' => count($allImages[0]),
            'with_alt' => count($imagesWithAlt[0]),
            'missing_alt' => count($allImages[0]) - count($imagesWithAlt[0])
        ];
    }

    private function calculateTechnicalScore($issues, $warnings, $passed)
    {
        $totalChecks = count($issues) + count($warnings) + count($passed);

        if ($totalChecks === 0) {
            return 0;
        }

        $score = (count($passed) * 100 + count($warnings) * 50) / ($totalChecks * 100) * 100;

        return round($score);
    }

    private function getTitleMessage($length)
    {
        if ($length == 0) return 'No title tag found';
        if ($length < 30) return 'Title is too short';
        if ($length > 60) return 'Title is too long';
        return 'Title length is optimal';
    }

    private function getDescriptionMessage($length)
    {
        if ($length == 0) return 'No meta description found';
        if ($length < 120) return 'Meta description is too short';
        if ($length > 160) return 'Meta description is too long';
        return 'Meta description length is optimal';
    }

    private function generateSuggestions($page)
    {
        $suggestions = [];

        if (empty($page->meta_title)) {
            $suggestions[] = 'Add a meta title tag for better search engine visibility';
        }

        if (empty($page->meta_description)) {
            $suggestions[] = 'Add a meta description to improve click-through rates';
        }

        if (empty($page->focus_keyword)) {
            $suggestions[] = 'Set a focus keyword to optimize content around';
        }

        $wordCount = str_word_count(strip_tags($page->content));
        if ($wordCount < 300) {
            $suggestions[] = 'Consider adding more content - aim for at least 300 words';
        }

        // Check for heading structure
        $headings = $this->analyzeHeadings($page->content);
        if ($headings['h1'] === 0) {
            $suggestions[] = 'Add an H1 heading to your content';
        }

        if ($headings['h2'] === 0 && $wordCount > 300) {
            $suggestions[] = 'Add H2 headings to break up your content';
        }

        // Check for images
        $imageAnalysis = $this->analyzeImages($page->content);
        if ($imageAnalysis['total'] === 0 && $wordCount > 500) {
            $suggestions[] = 'Consider adding images to make your content more engaging';
        }

        if ($imageAnalysis['missing_alt'] > 0) {
            $suggestions[] = 'Add alt text to all images for better accessibility and SEO';
        }

        // Check for internal links
        $linkCount = preg_match_all('/<a[^>]+href=["\']([^"\']*)["\'][^>]*>/i', $page->content, $matches);
        if ($linkCount === 0 && $wordCount > 500) {
            $suggestions[] = 'Add internal links to other relevant pages on your site';
        }

        // Check for schema markup
        if (empty($page->schema_markup)) {
            $suggestions[] = 'Add schema markup to help search engines understand your content';
        }

        // Check keyword density
        if (!empty($page->focus_keyword)) {
            $keywordAnalysis = $this->analyzeKeywordUsage($page);
            if ($keywordAnalysis['density'] < 0.5) {
                $suggestions[] = 'Use your focus keyword more frequently in the content';
            } elseif ($keywordAnalysis['density'] > 3) {
                $suggestions[] = 'Reduce keyword usage to avoid keyword stuffing';
            }

            if (!$keywordAnalysis['in_title']) {
                $suggestions[] = 'Include your focus keyword in the page title';
            }

            if (!$keywordAnalysis['in_meta_description']) {
                $suggestions[] = 'Include your focus keyword in the meta description';
            }
        }

        return $suggestions;
    }

    public function analyzeCollection($collection)
    {
        // Product/collection specific SEO analysis
        $score = 0;
        $maxScore = 100;

        // Product title optimization
        if (!empty($collection->meta_title)) {
            $titleLength = strlen($collection->meta_title);
            if ($titleLength >= 30 && $titleLength <= 60) {
                $score += 15;
            } elseif ($titleLength > 0) {
                $score += 8;
            }
        }

        // Product description
        if (!empty($collection->meta_description)) {
            $descLength = strlen($collection->meta_description);
            if ($descLength >= 120 && $descLength <= 160) {
                $score += 15;
            } elseif ($descLength > 0) {
                $score += 8;
            }
        }

        // Product images
        if (!empty($collection->featured_image)) {
            $score += 10;
        }

        if (!empty($collection->gallery) && count($collection->gallery) > 1) {
            $score += 10;
        }

        // Product data
        if (!empty($collection->price)) {
            $score += 10;
        }

        if (!empty($collection->sku)) {
            $score += 5;
        }

        // Category and tags
        if (!empty($collection->category)) {
            $score += 10;
        }

        if (!empty($collection->tags) && count($collection->tags) > 0) {
            $score += 10;
        }

        // Product schema markup
        if (!empty($collection->schema_markup)) {
            $score += 15;
        }

        return min($score, $maxScore);
    }

    // Bulk analysis methods
    public function bulkAnalyzePages($pageIds = null)
    {
        $query = SeoPage::query();

        if ($pageIds) {
            $query->whereIn('id', $pageIds);
        }

        $pages = $query->get();
        $results = [];

        foreach ($pages as $page) {
            $results[] = [
                'id' => $page->id,
                'title' => $page->title,
                'seo_score' => $this->analyzePage($page),
                'readability_score' => $this->analyzeReadability($page->content),
                'issues' => $this->getQuickIssues($page)
            ];
        }

        return $results;
    }

    private function getQuickIssues($page)
    {
        $issues = [];

        if (empty($page->meta_title)) {
            $issues[] = 'Missing meta title';
        }

        if (empty($page->meta_description)) {
            $issues[] = 'Missing meta description';
        }

        if (empty($page->focus_keyword)) {
            $issues[] = 'No focus keyword set';
        }

        $wordCount = str_word_count(strip_tags($page->content));
        if ($wordCount < 300) {
            $issues[] = 'Content too short';
        }

        return $issues;
    }
}
