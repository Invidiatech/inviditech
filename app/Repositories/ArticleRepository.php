<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ArticleRepository implements ArticleRepositoryInterface
{
    protected $article;
    protected $category;
    protected $tag;
    
    public function __construct(Article $article, Category $category, Tag $tag)
    {
        $this->article = $article;
        $this->category = $category;
        $this->tag = $tag;
    }
    
    /**
     * Get all articles with pagination and filters
     *
     * @param int $perPage
     * @param string|null $search
     * @param string|null $status
     * @param int|null $categoryId
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllArticles($perPage = 10, $search = null, $status = null, $categoryId = null)
    {
        $query = $this->article->with(['user', 'category', 'tags'])
                            ->withCount(['comments']);
        
        // Apply search filter
        if ($search) {
            $query->search($search);
        }
        
        // Apply status filter
        if ($status) {
            $query->where('status', $status);
        }
        
        // Apply category filter
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        
        return $query->latest('published_at')
                    ->latest('created_at')
                    ->paginate($perPage);
    }
    
    /**
     * Get article by ID
     *
     * @param int $id
     * @return Article
     */
    public function getArticleById($id)
    {
        return $this->article->with(['category', 'tags'])->findOrFail($id);
    }
    
    /**
     * Get article by slug
     *
     * @param string $slug
     * @return Article
     */
    public function getArticleBySlug($slug)
    {
        return $this->article->with(['category', 'tags', 'user'])->where('slug', $slug)->firstOrFail();
    }
    
    /**
     * Create new article
     *
     * @param array $data
     * @return Article
     */
    public function createArticle(array $data)
    {
        // Handle featured image upload
        if (isset($data['featured_image']) && $data['featured_image']) {
            $data['featured_image'] = $this->uploadImage($data['featured_image']);
        }
        
        // Handle audio upload
        if (isset($data['audio_file']) && $data['audio_file']) {
            $data['audio_path'] = $this->uploadAudio($data['audio_file']);
        }
        
        // Set additional defaults
        if (!isset($data['user_id'])) {
            $data['user_id'] = Auth::id();
        }
        
        if ($data['status'] === 'published' && !isset($data['published_at'])) {
            $data['published_at'] = Carbon::now();
        }
        
        // Set social media metadata defaults if not provided
        if (!isset($data['og_title']) || empty($data['og_title'])) {
            $data['og_title'] = $data['title'];
        }
        
        if (!isset($data['og_description']) || empty($data['og_description'])) {
            $data['og_description'] = $data['excerpt'] ?? Str::limit(strip_tags($data['content']), 160);
        }
        
        if (!isset($data['og_image']) && isset($data['featured_image'])) {
            $data['og_image'] = $data['featured_image'];
        }
        
        if (!isset($data['twitter_title']) || empty($data['twitter_title'])) {
            $data['twitter_title'] = $data['og_title'];
        }
        
        if (!isset($data['twitter_description']) || empty($data['twitter_description'])) {
            $data['twitter_description'] = $data['og_description'];
        }
        
        if (!isset($data['twitter_image']) && isset($data['og_image'])) {
            $data['twitter_image'] = $data['og_image'];
        }
        
        // Create article
        $article = $this->article->create($data);
        
        // Sync tags if provided
        if (isset($data['tags']) && !empty($data['tags'])) {
            $this->syncTags($article, $data['tags']);
        }
        
        return $article;
    }
    
    /**
     * Update existing article
     *
     * @param int $id
     * @param array $data
     * @return Article
     */
    public function updateArticle($id, array $data)
    {
        $article = $this->getArticleById($id);
        
        // Handle status change to published
        if ($article->status !== 'published' && isset($data['status']) && $data['status'] === 'published' && !$article->published_at) {
            $data['published_at'] = Carbon::now();
        }
        
        // Handle featured image upload
        if (isset($data['featured_image']) && $data['featured_image']) {
            // Delete old image if exists
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            
            $data['featured_image'] = $this->uploadImage($data['featured_image']);
        }
        
        // Handle audio upload
        if (isset($data['audio_file']) && $data['audio_file']) {
            // Delete old audio if exists
            if ($article->audio_path) {
                Storage::disk('public')->delete($article->audio_path);
            }
            
            $data['audio_path'] = $this->uploadAudio($data['audio_file']);
        }
        
        // Update article
        $article->update($data);
        
        // Sync tags if provided
        if (isset($data['tags']) && is_array($data['tags'])) {
            $this->syncTags($article, $data['tags']);
        }
        
        return $article;
    }
    
    /**
     * Delete article
     *
     * @param int $id
     * @return bool
     */
    public function deleteArticle($id)
    {
        $article = $this->getArticleById($id);
        
        // Delete featured image if exists
        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }
        
        // Delete audio if exists
        if ($article->audio_path) {
            Storage::disk('public')->delete($article->audio_path);
        }
        
        return $article->delete();
    }
    
    /**
     * Upload and store image
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @return string
     */
    protected function uploadImage($image)
    {
        return $image->store('articles/images', 'public');
    }
    
    /**
     * Upload and store audio
     *
     * @param \Illuminate\Http\UploadedFile $audio
     * @return string
     */
    protected function uploadAudio($audio)
    {
        return $audio->store('articles/audio', 'public');
    }
    
    /**
     * Sync tags with article
     *
     * @param Article $article
     * @param array $tags
     * @return void
     */
    protected function syncTags(Article $article, array $tags)
    {
        $tagIds = [];
        
        foreach ($tags as $tagName) {
            // Skip empty tags
            if (empty($tagName)) continue;
            
            // Find or create tag
            $tag = $this->tag->firstOrCreate(
                ['name' => $tagName],
                ['slug' => Str::slug($tagName)]
            );
            
            $tagIds[] = $tag->id;
        }
        
        $article->tags()->sync($tagIds);
    }
    
    /**
     * Get categories for dropdown
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCategoriesForDropdown()
    {
        return $this->category->orderBy('name')->get();
    }
    
    /**
     * Get all tags
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllTags()
    {
        return $this->tag->orderBy('name')->get();
    }
    
    /**
     * Get article tags
     * 
     * @param int $articleId
     * @return array
     */
    public function getArticleTags($articleId)
    {
        $article = $this->getArticleById($articleId);
        return $article->tags->pluck('name')->toArray();
    }
    
    /**
     * Get featured articles
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFeaturedArticles($limit = 5)
    {
        return $this->article->with(['category', 'user'])
                    ->where('is_featured', true)
                    ->where('status', 'published')
                    ->where('published_at', '<=', now())
                    ->latest('published_at')
                    ->limit($limit)
                    ->get();
    }
    
    /**
     * Get popular articles based on views
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPopularArticles($limit = 5)
    {
        return $this->article->with(['category', 'user'])
                    ->where('status', 'published')
                    ->where('published_at', '<=', now())
                    ->orderBy('views_count', 'desc')
                    ->limit($limit)
                    ->get();
    }
    
    /**
     * Get recent articles
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecentArticles($limit = 5)
    {
        return $this->article->with(['category', 'user'])
                    ->where('status', 'published')
                    ->where('published_at', '<=', now())
                    ->latest('published_at')
                    ->limit($limit)
                    ->get();
    }
    
    /**
     * Get related articles
     *
     * @param int $articleId
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRelatedArticles($articleId, $limit = 4)
    {
        $article = $this->getArticleById($articleId);
        
        // Get articles in the same category
        return $this->article->with(['category', 'user'])
                    ->where('id', '!=', $article->id)
                    ->where('category_id', $article->category_id)
                    ->where('status', 'published')
                    ->where('published_at', '<=', now())
                    ->latest('published_at')
                    ->limit($limit)
                    ->get();
    }
    
    /**
     * Increment article views
     *
     * @param int $articleId
     * @return bool
     */
    public function incrementViews($articleId)
    {
        $article = $this->getArticleById($articleId);
        $article->increment('views_count');
        
        return true;
    }
    
    /**
     * Get articles by tag
     *
     * @param string $tagSlug
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getArticlesByTag($tagSlug, $perPage = 10)
    {
        $tag = $this->tag->where('slug', $tagSlug)->firstOrFail();
        
        return $tag->articles()
                ->with(['category', 'user', 'tags'])
                ->where('status', 'published')
                ->where('published_at', '<=', now())
                ->latest('published_at')
                ->paginate($perPage);
    }
    
    /**
     * Get articles by category
     *
     * @param string $categorySlug
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getArticlesByCategory($categorySlug, $perPage = 10)
    {
        $category = $this->category->where('slug', $categorySlug)->firstOrFail();
        
        return $this->article->with(['category', 'user', 'tags'])
                    ->where('category_id', $category->id)
                    ->where('status', 'published')
                    ->where('published_at', '<=', now())
                    ->latest('published_at')
                    ->paginate($perPage);
    }
}