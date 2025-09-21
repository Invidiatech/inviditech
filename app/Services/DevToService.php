<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Seo\SeoBlog;

class DevToService
{
    private $apiKey;
    private $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.devto.api_key', 'nXGt5tCM4mf6rjyDdwDVQWLz');
        $this->baseUrl = 'https://dev.to/api';
    }

    /**
     * Publish blog to Dev.to
     */
    public function publishBlog(SeoBlog $blog)
    {
        try {
            // Prepare the article data for Dev.to
            $articleData = $this->prepareBlogData($blog);

            // Make API request to Dev.to
            $response = Http::withHeaders([
                'api-key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/articles', [
                'article' => $articleData
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                
                // Update the blog with Dev.to information
                $blog->update([
                    'devto_id' => $responseData['id'] ?? null,
                    'devto_url' => $responseData['url'] ?? null,
                    'devto_published_at' => now(),
                ]);

                Log::info("Successfully published blog '{$blog->title}' to Dev.to", [
                    'blog_id' => $blog->id,
                    'devto_id' => $responseData['id'] ?? null,
                    'devto_url' => $responseData['url'] ?? null,
                ]);

                return [
                    'success' => true,
                    'message' => 'Blog successfully published to Dev.to',
                    'devto_url' => $responseData['url'] ?? null,
                    'devto_id' => $responseData['id'] ?? null,
                ];
            } else {
                Log::error("Failed to publish blog '{$blog->title}' to Dev.to", [
                    'blog_id' => $blog->id,
                    'status_code' => $response->status(),
                    'response' => $response->body(),
                ]);

                return [
                    'success' => false,
                    'message' => 'Failed to publish to Dev.to: ' . $response->body(),
                ];
            }
        } catch (\Exception $e) {
            Log::error("Exception publishing blog '{$blog->title}' to Dev.to", [
                'blog_id' => $blog->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Error publishing to Dev.to: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Update an existing Dev.to article
     */
    public function updateBlog(SeoBlog $blog)
    {
        if (!$blog->devto_id) {
            return $this->publishBlog($blog);
        }

        try {
            $articleData = $this->prepareBlogData($blog);

            $response = Http::withHeaders([
                'api-key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->put($this->baseUrl . '/articles/' . $blog->devto_id, [
                'article' => $articleData
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                
                Log::info("Successfully updated blog '{$blog->title}' on Dev.to", [
                    'blog_id' => $blog->id,
                    'devto_id' => $blog->devto_id,
                ]);

                return [
                    'success' => true,
                    'message' => 'Blog successfully updated on Dev.to',
                    'devto_url' => $responseData['url'] ?? $blog->devto_url,
                ];
            } else {
                Log::error("Failed to update blog '{$blog->title}' on Dev.to", [
                    'blog_id' => $blog->id,
                    'devto_id' => $blog->devto_id,
                    'status_code' => $response->status(),
                    'response' => $response->body(),
                ]);

                return [
                    'success' => false,
                    'message' => 'Failed to update on Dev.to: ' . $response->body(),
                ];
            }
        } catch (\Exception $e) {
            Log::error("Exception updating blog '{$blog->title}' on Dev.to", [
                'blog_id' => $blog->id,
                'devto_id' => $blog->devto_id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Error updating on Dev.to: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Delete a Dev.to article
     */
    public function deleteBlog(SeoBlog $blog)
    {
        if (!$blog->devto_id) {
            return ['success' => true, 'message' => 'No Dev.to article to delete'];
        }

        try {
            // Note: Dev.to API doesn't support deleting articles
            // You can only unpublish them by setting published to false
            $response = Http::withHeaders([
                'api-key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->put($this->baseUrl . '/articles/' . $blog->devto_id, [
                'article' => [
                    'published' => false
                ]
            ]);

            if ($response->successful()) {
                Log::info("Successfully unpublished blog '{$blog->title}' on Dev.to", [
                    'blog_id' => $blog->id,
                    'devto_id' => $blog->devto_id,
                ]);

                return [
                    'success' => true,
                    'message' => 'Blog unpublished on Dev.to',
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Failed to unpublish on Dev.to',
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error unpublishing on Dev.to: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Prepare blog data for Dev.to API format
     */
    private function prepareBlogData(SeoBlog $blog)
    {
        // Convert HTML content to Markdown with better formatting
        $bodyMarkdown = $this->convertHtmlToMarkdown($blog->content);

        // Prepare tags array
        $tags = [];
        if ($blog->tags) {
            $tags = $blog->tags->pluck('name')->map(function($tag) {
                // Dev.to tags should be lowercase and without spaces
                return strtolower(str_replace(' ', '', $tag));
            })->take(4)->toArray(); // Dev.to allows max 4 tags
        }

        // Add default tags if none exist
        if (empty($tags)) {
            $tags = ['webdev', 'programming', 'tutorial'];
        }

        $articleData = [
            'title' => $blog->title,
            'body_markdown' => $bodyMarkdown,
            'published' => $blog->status === 'published',
            'description' => $blog->excerpt ?: $blog->meta_description,
            'tags' => $tags,
            'canonical_url' => $blog->canonical_url ?: url('/blog/' . $blog->slug),
        ];

        // Add main image if available
        if ($blog->featured_image) {
            $articleData['main_image'] = asset('storage/' . $blog->featured_image);
        }

        // Add organization name
        $articleData['organization_id'] = null; // Set your Dev.to organization ID if you have one

        return $articleData;
    }

    /**
     * Improved HTML to Markdown conversion with better formatting
     */
    private function convertHtmlToMarkdown($html)
    {
        // Clean up the HTML first
        $html = trim($html);
        
        // Preserve line breaks temporarily
        $html = str_replace(["\r\n", "\r"], "\n", $html);
        
        // Convert headers with proper spacing
        $html = preg_replace('/<h1[^>]*>(.*?)<\/h1>/is', "\n# $1\n\n", $html);
        $html = preg_replace('/<h2[^>]*>(.*?)<\/h2>/is', "\n## $1\n\n", $html);
        $html = preg_replace('/<h3[^>]*>(.*?)<\/h3>/is', "\n### $1\n\n", $html);
        $html = preg_replace('/<h4[^>]*>(.*?)<\/h4>/is', "\n#### $1\n\n", $html);
        $html = preg_replace('/<h5[^>]*>(.*?)<\/h5>/is', "\n##### $1\n\n", $html);
        $html = preg_replace('/<h6[^>]*>(.*?)<\/h6>/is', "\n###### $1\n\n", $html);
        
        // Convert bold and italic
        $html = preg_replace('/<(strong|b)[^>]*>(.*?)<\/(strong|b)>/is', '**$2**', $html);
        $html = preg_replace('/<(em|i)[^>]*>(.*?)<\/(em|i)>/is', '*$2*', $html);
        
        // Convert links
        $html = preg_replace('/<a[^>]*href=["\']([^"\']*)["\'][^>]*>(.*?)<\/a>/is', '[$2]($1)', $html);
        
        // Convert images with better formatting
        $html = preg_replace('/<img[^>]*src=["\']([^"\']*)["\'][^>]*alt=["\']([^"\']*)["\'][^>]*\/?>/is', "\n![$2]($1)\n", $html);
        $html = preg_replace('/<img[^>]*alt=["\']([^"\']*)["\'][^>]*src=["\']([^"\']*)["\'][^>]*\/?>/is', "\n![$1]($2)\n", $html);
        $html = preg_replace('/<img[^>]*src=["\']([^"\']*)["\'][^>]*\/?>/is', "\n![]($1)\n", $html);
        
        // Convert code blocks (preserve formatting)
        $html = preg_replace_callback('/<pre[^>]*><code[^>]*class=["\']language-([^"\']*)["\'][^>]*>(.*?)<\/code><\/pre>/is', function($matches) {
            return "\n```" . $matches[1] . "\n" . html_entity_decode($matches[2]) . "\n```\n\n";
        }, $html);
        $html = preg_replace('/<pre[^>]*><code[^>]*>(.*?)<\/code><\/pre>/is', "\n```\n$1\n```\n\n", $html);
        $html = preg_replace('/<code[^>]*>(.*?)<\/code>/is', '`$1`', $html);
        
        // Convert blockquotes
        $html = preg_replace('/<blockquote[^>]*>(.*?)<\/blockquote>/is', "\n> $1\n\n", $html);
        
        // Convert lists with proper formatting
        $html = preg_replace('/<ul[^>]*>/i', "\n", $html);
        $html = preg_replace('/<\/ul>/i', "\n", $html);
        $html = preg_replace('/<ol[^>]*>/i', "\n", $html);
        $html = preg_replace('/<\/ol>/i', "\n", $html);
        
        // Convert list items
        $html = preg_replace('/<li[^>]*>(.*?)<\/li>/is', "- $1\n", $html);
        
        // Convert paragraphs with proper spacing
        $html = preg_replace('/<p[^>]*>(.*?)<\/p>/is', "$1\n\n", $html);
        
        // Convert line breaks
        $html = preg_replace('/<br[^>]*\/?>/i', "\n", $html);
        
        // Convert horizontal rules
        $html = preg_replace('/<hr[^>]*\/?>/i', "\n---\n\n", $html);
        
        // Handle divs (convert to paragraphs)
        $html = preg_replace('/<div[^>]*>(.*?)<\/div>/is', "$1\n\n", $html);
        
        // Remove remaining HTML tags
        $html = strip_tags($html);
        
        // Decode HTML entities
        $html = html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        
        // Clean up whitespace and formatting
        $html = preg_replace('/\n{3,}/', "\n\n", $html); // Remove excessive line breaks
        $html = preg_replace('/[ \t]+/', ' ', $html); // Remove excessive spaces
        $html = preg_replace('/\n /', "\n", $html); // Remove leading spaces after line breaks
        
        // Trim and ensure proper ending
        $html = trim($html);
        
        return $html;
    }

    /**
     * Get user's published articles from Dev.to
     */
    public function getUserArticles()
    {
        try {
            $response = Http::withHeaders([
                'api-key' => $this->apiKey,
            ])->get($this->baseUrl . '/articles/me/published');

            if ($response->successful()) {
                return $response->json();
            }

            return [];
        } catch (\Exception $e) {
            Log::error('Error fetching Dev.to articles: ' . $e->getMessage());
            return [];
        }
    }
}