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
    
    public function __construct(Article $article)
    {
        $this->article = $article;
    }
    
    /**
     * Get all articles with pagination
     *
     * @param int $perPage
     * @param string $search
     * @param string $status
     * @param int $categoryId
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllArticles($perPage = 10, $search = null, $status = null, $categoryId = null)
    {
        $query = $this->article->with(['user', 'category', 'tags'])
                            ->withCount(['comments', 'likes', 'claps', 'bookmarks']);
        
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
        return $this->article->findOrFail($id);
    }
    
    /**
     * Get article by slug
     *
     * @param string $slug
     * @return Article
     */
    public function getArticleBySlug($slug)
    {
        return $this->article->where('slug', $slug)->firstOrFail();
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
        $data['user_id'] = Auth::id();
        $data['published_at'] = $data['status'] === 'published' ? Carbon::now() : null;
        
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
        if (isset($data['tags']) && is_array($data['tags'])) {
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
        if ($article->status !== 'published' && $data['status'] === 'published' && !$article->published_at) {
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
            $tag = Tag::firstOrCreate(['name' => $tagName], [
                'slug' => Str::slug($tagName)
            ]);
            
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
        return Category::orderBy('name')->get();
    }
    
    /**
     * Get tags for article
     *
     * @param int $articleId
     * @return array
     */
    public function getArticleTags($articleId)
    {
        $article = $this->getArticleById($articleId);
        return $article->tags->pluck('name')->toArray();
    }
}