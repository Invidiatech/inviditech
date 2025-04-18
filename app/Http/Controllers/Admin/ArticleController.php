<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class ArticleController extends Controller
{
    protected $articleRepository;
    
    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }
    
    /**
     * Display a listing of articles.
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
        
        $blogs = $this->articleRepository->getAllArticles($perPage, $search, $status, $categoryId);
        $categories = $this->articleRepository->getCategoriesForDropdown();
        
        return view('admin.articles.index', compact('blogs', 'categories', 'search', 'status', 'categoryId'));
    }
    
    /**
     * Show the form for creating a new article.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->articleRepository->getCategoriesForDropdown();
        
        return view('admin.articles.create', compact('categories'));
    }
    
    /**
     * Store a newly created article in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:articles,slug',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'featured_image_alt' => 'nullable|string|max:255',
            'audio_file' => 'nullable|file|mimes:mp3,wav,ogg|max:20480',
            'status' => 'required|in:draft,pending,published',
            'is_premium' => 'boolean',
            'is_featured' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'canonical_url' => 'nullable|url',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:255',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string|max:255',
            'no_index' => 'nullable|boolean',
            'no_follow' => 'nullable|boolean',
        ]);
        
        if ($validator->fails()) {
            \Log::error('Article validation failed:', ['errors' => $validator->errors()->toArray()]);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Prepare data for repository
        $data = $request->all();
        
        // Handle boolean fields properly
        $data['is_premium'] = $request->has('is_premium');
        $data['is_featured'] = $request->has('is_featured');
        $data['no_index'] = $request->has('no_index');
        $data['no_follow'] = $request->has('no_follow');
        
        // Generate slug if not provided
        if (empty($data['slug']) && !empty($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }
        
        // Process tags (convert comma-separated string to array)
        if ($request->has('tags_input') && !empty($request->tags_input)) {
            $tags = explode(',', $request->tags_input);
            $data['tags'] = array_map('trim', $tags);
        }
        
        // Handle recorded audio (convert base64 to file)
        if ($request->has('recorded_audio_data') && !empty($request->recorded_audio_data)) {
            try {
                $data['audio_file'] = $this->base64ToFile($request->recorded_audio_data);
                \Log::info('Successfully converted recorded audio to file');
            } catch (\Exception $e) {
                \Log::error('Error converting recorded audio', ['error' => $e->getMessage()]);
                return redirect()->back()
                    ->with('error', 'Error processing audio recording: ' . $e->getMessage())
                    ->withInput();
            }
        }
        
        try {
            $article = $this->articleRepository->createArticle($data);
            \Log::info('Article created successfully', ['article_id' => $article->id]);
            
            return redirect()->route('admin.articles.index')
                ->with('success', 'Article created successfully.');
        } catch (\Exception $e) {
            \Log::error('Error creating article', ['error' => $e->getMessage()]);
            return redirect()->back()
                ->with('error', 'Error creating article: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    /**
     * Convert base64 audio data to file
     *
     * @param string $base64Data
     * @return \Illuminate\Http\UploadedFile
     */
    protected function base64ToFile($base64Data)
    {
        // Extract the MIME type and base64 content
        list($type, $data) = explode(';', $base64Data);
        list(, $data) = explode(',', $data);
        $data = base64_decode($data);
        
        // Check decoded data size (max 5MB)
        if (strlen($data) > 5 * 1024 * 1024) {
            throw new \Exception('Recorded audio is too large (max 5MB).');
        }
        
        // Create temporary file
        $tempFile = tempnam(sys_get_temp_dir(), 'audio_');
        file_put_contents($tempFile, $data);
        
        // Get the MIME type
        $mimeType = substr($type, 5); // Remove "data:" prefix
        
        // Get file extension based on MIME type
        $extension = 'mp3'; // Default
        if ($mimeType === 'audio/wav') {
            $extension = 'wav';
        } elseif ($mimeType === 'audio/ogg') {
            $extension = 'ogg';
        }
        
        // Create uploaded file from temporary file
        $file = new \Illuminate\Http\UploadedFile(
            $tempFile,
            'recorded_audio.' . $extension,
            $mimeType,
            null,
            true
        );
        
        return $file;
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
        $tags = $this->articleRepository->getArticleTags($id);
        
        return view('admin.articles.edit', compact('article', 'categories', 'tags'));
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
        $article = $this->articleRepository->getArticleById($id);
        
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:articles,slug,' . $id,
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'featured_image_alt' => 'nullable|string|max:255',
            'audio_file' => 'nullable|file|mimes:mp3,wav,ogg|max:20480',
            'status' => 'required|in:draft,pending,published',
            'is_premium' => 'boolean',
            'is_featured' => 'boolean',
            'tags' => 'nullable|array',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'canonical_url' => 'nullable|url',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:255',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string|max:255',
            'twitter_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $data = $request->all();
        
        // Handle is_premium and is_featured checkboxes
        $data['is_premium'] = $request->has('is_premium');
        $data['is_featured'] = $request->has('is_featured');
        
        // Process tags (convert comma-separated string to array if needed)
        if ($request->has('tags_input') && !empty($request->tags_input)) {
            $tags = explode(',', $request->tags_input);
            $data['tags'] = array_map('trim', $tags);
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
}