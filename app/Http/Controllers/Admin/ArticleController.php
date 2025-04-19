<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    protected $articleRepository;
    
    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }
    
    /**
     * Display a listing of the articles.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $categoryId = $request->input('category_id');
        $perPage = $request->input('per_page', 10);
        
        $articles = $this->articleRepository->getAllArticles($perPage, $search, $status, $categoryId);
        $categories = $this->articleRepository->getCategoriesForDropdown();
        
        return view('admin.articles.index', compact('articles', 'categories', 'search', 'status', 'categoryId'));
    }
    
    /**
     * Show the form for creating a new article.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->articleRepository->getCategoriesForDropdown();
        $tags = $this->articleRepository->getAllTags();
        return view('admin.articles.create', compact('categories', 'tags'));
    }
    
    /**
     * Store a newly created article in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            'tags' => 'nullable|array',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'featured_image_alt' => 'nullable|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'status' => 'required|in:draft,published,private',
            'is_premium' => 'boolean',
            'is_featured' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:255',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string|max:255',
            'canonical_url' => 'nullable|url',
            'audio_file' => 'nullable|file|mimes:mp3,wav,ogg|max:20480',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Prepare data
        $data = $request->all();
        
        // Add user ID
        $data['user_id'] = Auth::id();
        
        // Handle slug
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }
        
        // Handle boolean fields
        $data['is_premium'] = $request->has('is_premium');
        $data['is_featured'] = $request->has('is_featured');
        
        // Set published_at for published articles
        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }
        
        try {
            $article = $this->articleRepository->createArticle($data);
            
            return redirect()->route('admin.articles.index')
                ->with('success', 'Article created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating article: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    /**
     * Display the specified article.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = $this->articleRepository->getArticleById($id);
        
        return view('admin.articles.show', compact('article'));
    }
    
    /**
     * Show the form for editing the specified article.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = $this->articleRepository->getArticleById($id);
        $categories = $this->articleRepository->getCategoriesForDropdown();
        $tags = $this->articleRepository->getAllTags();
        $articleTags = $this->articleRepository->getArticleTags($id);
        
        return view('admin.articles.edit', compact('article', 'categories', 'tags', 'articleTags'));
    }
    
    /**
     * Update the specified article in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            'tags' => 'nullable|array',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'featured_image_alt' => 'nullable|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'status' => 'required|in:draft,published,private',
            'is_premium' => 'boolean',
            'is_featured' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:255',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string|max:255',
            'canonical_url' => 'nullable|url',
            'audio_file' => 'nullable|file|mimes:mp3,wav,ogg|max:20480',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Prepare data
        $data = $request->all();
        
        // Handle boolean fields
        $data['is_premium'] = $request->has('is_premium');
        $data['is_featured'] = $request->has('is_featured');
        
        // Set published_at for newly published articles
        $article = $this->articleRepository->getArticleById($id);
        if ($data['status'] === 'published' && $article->status !== 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }
        
        try {
            $this->articleRepository->updateArticle($id, $data);
            
            return redirect()->route('admin.articles.edit', $id)
                ->with('success', 'Article updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating article: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    /**
     * Remove the specified article from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->articleRepository->deleteArticle($id);
            
            return redirect()->route('admin.articles.index')
                ->with('success', 'Article deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting article: ' . $e->getMessage());
        }
    }
    
    /**
     * Toggle the featured status of an article
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggleFeatured($id)
    {
        try {
            $article = $this->articleRepository->getArticleById($id);
            $data = ['is_featured' => !$article->is_featured];
            
            $this->articleRepository->updateArticle($id, $data);
            
            return redirect()->back()
                ->with('success', 'Article featured status updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating article featured status: ' . $e->getMessage());
        }
    }
    
    /**
     * Toggle the premium status of an article
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function togglePremium($id)
    {
        try {
            $article = $this->articleRepository->getArticleById($id);
            $data = ['is_premium' => !$article->is_premium];
            
            $this->articleRepository->updateArticle($id, $data);
            
            return redirect()->back()
                ->with('success', 'Article premium status updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating article premium status: ' . $e->getMessage());
        }
    }
    
    /**
     * Toggle the status of an article between draft and published
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggleStatus($id)
    {
        try {
            $article = $this->articleRepository->getArticleById($id);
            
            // Toggle between published and draft
            $newStatus = $article->status === 'published' ? 'draft' : 'published';
            $data = ['status' => $newStatus];
            
            // Set published_at if publishing
            if ($newStatus === 'published' && empty($article->published_at)) {
                $data['published_at'] = now();
            }
            
            $this->articleRepository->updateArticle($id, $data);
            
            return redirect()->back()
                ->with('success', 'Article status updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating article status: ' . $e->getMessage());
        }
    }
}