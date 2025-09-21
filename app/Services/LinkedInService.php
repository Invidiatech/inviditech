<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Seo\SeoBlog;

class LinkedInService
{
    private $clientId;
    private $clientSecret;
    private $accessToken;
    private $baseUrl;

    public function __construct()
    {
        $this->clientId = config('services.linkedin.client_id');
        $this->clientSecret = config('services.linkedin.client_secret');
        $this->accessToken = config('services.linkedin.access_token');
        $this->baseUrl = 'https://api.linkedin.com/v2';
    }

    /**
     * Publish blog to LinkedIn using the UGC API with actual member ID
     */
    public function publishBlog(SeoBlog $blog)
    {
        try {
            if (!$this->accessToken) {
                return [
                    'success' => false,
                    'message' => 'LinkedIn access token not configured'
                ];
            }

            // Use the actual member ID from userinfo endpoint
            $authorUrn = "urn:li:person:XDR8N06WVQ";
            
            // Use the exact format from LinkedIn documentation
            $postData = [
                "author" => $authorUrn,
                "lifecycleState" => "PUBLISHED",
                "specificContent" => [
                    "com.linkedin.ugc.ShareContent" => [
                        "shareCommentary" => [
                            "text" => $this->prepareCommentary($blog)
                        ],
                        "shareMediaCategory" => "ARTICLE",
                        "media" => [
                            [
                                "status" => "READY",
                                "description" => [
                                    "text" => $blog->excerpt ?: $blog->meta_description ?: 'Read this blog post'
                                ],
                                "originalUrl" => url('/blog/' . $blog->slug),
                                "title" => [
                                    "text" => $blog->title
                                ]
                            ]
                        ]
                    ]
                ],
                "visibility" => [
                    "com.linkedin.ugc.MemberNetworkVisibility" => "PUBLIC"
                ]
            ];

            // Use the exact endpoint and headers from documentation
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Content-Type' => 'application/json',
                'X-Restli-Protocol-Version' => '2.0.0'
            ])->post('https://api.linkedin.com/v2/ugcPosts', $postData);

            if ($response->successful()) {
                $responseData = $response->json();
                
                $blog->update([
                    'linkedin_id' => $responseData['id'] ?? null,
                    'linkedin_published_at' => now(),
                ]);

                Log::info("Successfully published blog '{$blog->title}' to LinkedIn", [
                    'blog_id' => $blog->id,
                    'linkedin_id' => $responseData['id'] ?? null,
                ]);

                return [
                    'success' => true,
                    'message' => 'Blog successfully published to LinkedIn',
                    'linkedin_id' => $responseData['id'] ?? null,
                ];
            } else {
                Log::error("Failed to publish blog '{$blog->title}' to LinkedIn", [
                    'blog_id' => $blog->id,
                    'status_code' => $response->status(),
                    'response' => $response->body(),
                ]);

                return [
                    'success' => false,
                    'message' => 'Failed to publish to LinkedIn: ' . $response->body(),
                ];
            }
        } catch (\Exception $e) {
            Log::error("Exception publishing blog '{$blog->title}' to LinkedIn", [
                'blog_id' => $blog->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Error publishing to LinkedIn: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Prepare commentary text for LinkedIn post
     */
    private function prepareCommentary(SeoBlog $blog)
    {
        $text = $blog->title . "\n\n";
        
        if ($blog->excerpt) {
            $text .= $blog->excerpt . "\n\n";
        } else {
            // Create excerpt from content
            $cleanContent = $this->convertHtmlToText($blog->content);
            $excerpt = substr($cleanContent, 0, 200);
            if (strlen($cleanContent) > 200) {
                $excerpt .= '...';
            }
            $text .= $excerpt . "\n\n";
        }
        
        $text .= "Read more: " . url('/blog/' . $blog->slug);

        // Add hashtags
        if ($blog->tags && $blog->tags->count() > 0) {
            $hashtags = [];
            foreach ($blog->tags->take(5) as $tag) {
                $hashtags[] = '#' . str_replace(' ', '', ucwords($tag->name));
            }
            $text .= "\n\n" . implode(' ', $hashtags);
        }

        return $text;
    }

    /**
     * Update an existing LinkedIn post
     */
    public function updateBlog(SeoBlog $blog)
    {
        // LinkedIn doesn't support updating posts via API
        // We'll delete and republish
        if ($blog->linkedin_id) {
            $this->deleteBlog($blog);
        }
        
        return $this->publishBlog($blog);
    }

    /**
     * Delete a LinkedIn post
     */
    public function deleteBlog(SeoBlog $blog)
    {
        if (!$blog->linkedin_id) {
            return ['success' => true, 'message' => 'No LinkedIn post to delete'];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->accessToken,
                'X-Restli-Protocol-Version' => '2.0.0'
            ])->delete($this->baseUrl . '/ugcPosts/' . $blog->linkedin_id);

            if ($response->successful()) {
                $blog->update([
                    'linkedin_id' => null,
                    'linkedin_published_at' => null,
                ]);

                Log::info("Successfully deleted blog '{$blog->title}' from LinkedIn", [
                    'blog_id' => $blog->id,
                    'linkedin_id' => $blog->linkedin_id,
                ]);

                return [
                    'success' => true,
                    'message' => 'Blog deleted from LinkedIn',
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Failed to delete from LinkedIn',
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error deleting from LinkedIn: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Prepare blog data with correct URN format
     */
    private function prepareBlogData(SeoBlog $blog, $authorUrn)
    {
        // Convert HTML to text for LinkedIn
        $text = $this->convertHtmlToText($blog->content);
        
        // Prepare the text post
        $postText = $blog->title . "\n\n";
        
        if ($blog->excerpt) {
            $postText .= $blog->excerpt . "\n\n";
        }
        
        // Add content snippet
        $contentSnippet = substr($text, 0, 1000);
        if (strlen($text) > 1000) {
            $contentSnippet .= '...';
        }
        
        $postText .= $contentSnippet . "\n\n";
        $postText .= "Read more: " . url('/blog/' . $blog->slug);

        // Add hashtags
        $hashtags = [];
        if ($blog->tags && $blog->tags->count() > 0) {
            foreach ($blog->tags->take(5) as $tag) {
                $hashtags[] = '#' . str_replace(' ', '', ucwords($tag->name));
            }
            $postText .= "\n\n" . implode(' ', $hashtags);
        }

        return [
            'author' => $authorUrn,
            'lifecycleState' => 'PUBLISHED',
            'specificContent' => [
                'com.linkedin.ugc.ShareContent' => [
                    'shareCommentary' => [
                        'text' => $postText
                    ],
                    'shareMediaCategory' => 'ARTICLE',
                    'media' => [
                        [
                            'status' => 'READY',
                            'description' => [
                                'text' => $blog->excerpt ?: $blog->meta_description ?: 'Read this blog post'
                            ],
                            'originalUrl' => url('/blog/' . $blog->slug),
                            'title' => [
                                'text' => $blog->title
                            ]
                        ]
                    ]
                ]
            ],
            'visibility' => [
                'com.linkedin.ugc.MemberNetworkVisibility' => 'PUBLIC'
            ]
        ];
    }

    /**
     * Convert HTML to plain text for LinkedIn - Fixed regex issues
     */
    private function convertHtmlToText($html)
    {
        // Remove script and style elements
        $text = preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/i', '', $html);
        $text = preg_replace('/<style\b[^<]*(?:(?!<\/style>)<[^<]*)*<\/style>/i', '', $text);
        
        // Convert headers to text with line breaks
        $text = preg_replace('/<h[1-6][^>]*>(.*?)<\/h[1-6]>/i', "\n\n$1\n\n", $text);
        
        // Convert paragraphs
        $text = preg_replace('/<p[^>]*>(.*?)<\/p>/i', "$1\n\n", $text);
        
        // Convert line breaks
        $text = preg_replace('/<br[^>]*\/?>/i', "\n", $text);
        
        // Convert lists
        $text = preg_replace('/<li[^>]*>(.*?)<\/li>/i', "• $1\n", $text);
        $text = preg_replace('/<\/?(ul|ol)[^>]*>/i', "\n", $text);
        
        // Remove all remaining HTML tags
        $text = strip_tags($text);
        
        // Decode HTML entities
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        
        // Clean up whitespace - Fixed regex patterns
        $text = preg_replace('/\n{3,}/', "\n\n", $text);
        $text = preg_replace('/[ \t]+/', ' ', $text);
        $text = trim($text);
        
        return $text;
    }

    /**
     * Generate LinkedIn OAuth URL for authorization
     */
    public function getAuthUrl($redirectUri)
    {
        $params = [
            'response_type' => 'code',
            'client_id' => $this->clientId,
            'redirect_uri' => $redirectUri,
            'scope' => 'w_member_social',
        ];

        return 'https://www.linkedin.com/oauth/v2/authorization?' . http_build_query($params);
    }

    /**
     * Exchange authorization code for access token
     */
    public function getAccessToken($code, $redirectUri)
    {
        try {
            $response = Http::asForm()->post('https://www.linkedin.com/oauth/v2/accessToken', [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => $redirectUri,
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Error getting LinkedIn access token: ' . $e->getMessage());
            return null;
        }
    }
}