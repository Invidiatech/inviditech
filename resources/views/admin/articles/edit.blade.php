@extends('layouts.admin.master')

@section('title', 'Edit Article')

@section('styles')
<style>
    /* Animation */
    .animate-fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    /* Apple-inspired style */
    .bg-apple-blue {
        background-color: #0071e3;
    }
    
    .bg-apple-blue:hover {
        background-color: #0077ed;
    }
    
    .bg-apple-lightgray {
        background-color: #f5f5f7;
    }
    
    /* Image preview */
    .image-preview-container {
        aspect-ratio: 16/9;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
        border: 1px dashed #dee2e6;
        border-radius: 0.375rem;
        overflow: hidden;
        transition: all 0.3s;
    }
    
    .image-preview-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    /* SEO Preview */
    .seo-preview {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        padding: 1rem;
        background-color: #fff;
    }
    
    .seo-preview-title {
        color: #1a0dab;
        font-size: 1.1rem;
        margin-bottom: 0.25rem;
        font-weight: medium;
    }
    
    .seo-preview-url {
        color: #006621;
        font-size: 0.8rem;
        margin-bottom: 0.25rem;
    }
    
    .seo-preview-description {
        color: #545454;
        font-size: 0.9rem;
        line-height: 1.5;
    }
    
    /* Character counter */
    .char-counter {
        position: absolute;
        right: 10px;
        top: 0;
        font-size: 0.8rem;
        color: #6c757d;
    }
    
    .char-counter.warning {
        color: #fd7e14;
    }
    
    .char-counter.danger {
        color: #dc3545;
    }
    
    /* Form adjustments */
    .form-label {
        font-weight: 500;
    }
    
    .form-text {
        margin-top: 0.25rem;
    }
    
    .required-indicator {
        color: #dc3545;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4 animate-fade-in">
    <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data" id="articleForm">
        @csrf
        @method('PUT')
        
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('admin.articles.index') }}" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center">
                    <i class="bi bi-arrow-left me-1"></i>
                    <span>Back</span>
                </a>
                <h1 class="h3 mb-0">Edit Article</h1>
            </div>
            
            <div>
                <button type="submit" class="btn bg-apple-blue text-white d-inline-flex align-items-center">
                    <i class="bi bi-save me-2"></i>
                    Update Article
                </button>
            </div>
        </div>

        <hr class="mb-4">

        <div class="row">
            <!-- Main Column -->
            <div class="col-lg-8">
                <!-- Article Content Card -->
                <div class="card mb-4">
                    <div class="card-header bg-apple-lightgray">
                        <h5 class="card-title mb-0">Article Content</h5>
                    </div>
                    
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="required-indicator">*</span></label>
                            <input type="text" class="form-control form-control-lg @error('title') is-invalid @enderror" 
                                id="title" name="title" value="{{ old('title', $article->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="slug" class="form-label d-flex justify-content-between">
                                <span>Slug</span>
                                <small class="text-muted">Auto-generated from title if left empty</small>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">/article/</span>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                    id="slug" name="slug" value="{{ old('slug', $article->slug) }}" placeholder="article-url-slug">
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="excerpt" class="form-label">Excerpt</label>
                            <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                id="excerpt" name="excerpt" rows="3" 
                                placeholder="Brief summary of the article (SEO-friendly)">{{ old('excerpt', $article->excerpt) }}</textarea>
                            @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Leave empty to generate from content</small>
                        </div>
                        
                        <div class="mt-3">
                            <label for="editor" class="form-label">
                                {{ __('Content') }}
                                <span class="text-danger">*</span>
                            </label>
                            <div id="editor" style="max-height: 750px; overflow-y: auto; min-height: 200px">
                                {!! old('content', $article->content) !!}
                            </div>
                            <input type="hidden" id="content" name="content" value="{{ old('content', $article->content) }}">
                            @error('content')
                                <p class="text text-danger m-0">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- SEO & Social Media Card -->
                <div class="card mb-4">
                    <div class="card-header bg-apple-lightgray">
                        <h5 class="card-title mb-0">SEO & Social Media</h5>
                    </div>
                    
                    <div class="card-body p-4">
                        <ul class="nav nav-tabs" id="seoTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo-tab-pane" type="button" role="tab">
                                    <i class="bi bi-globe me-2"></i>SEO
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social-tab-pane" type="button" role="tab">
                                    <i class="bi bi-facebook me-2"></i>Social Media
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="advanced-tab" data-bs-toggle="tab" data-bs-target="#advanced-tab-pane" type="button" role="tab">
                                    <i class="bi bi-code-slash me-2"></i>Advanced
                                </button>
                            </li>
                        </ul>
                        
                        <div class="tab-content p-3" id="seoTabsContent">
                            <!-- SEO Tab -->
                            <div class="tab-pane fade show active" id="seo-tab-pane" role="tabpanel" tabindex="0">
                                <!-- SEO Preview -->
                                <div class="seo-preview mb-4">
                                    <small class="text-muted mb-2 d-block">Search Engine Preview</small>
                                    <div class="seo-preview-title" id="seoPreviewTitle">
                                        {{ old('meta_title', $article->meta_title) ?: $article->title }}
                                    </div>
                                    <div class="seo-preview-url">
                                        {{ config('app.url', 'https://yourdomain.com') }}/article/<span id="seoPreviewSlug">{{ old('slug', $article->slug) }}</span>
                                    </div>
                                    <div class="seo-preview-description" id="seoPreviewDescription">
                                        {{ old('meta_description', $article->meta_description) ?: 'Your meta description will appear here. It should be between 120-160 characters for optimal SEO performance.' }}
                                    </div>
                                </div>
                                
                                <div class="mb-3 position-relative">
                                    <label for="meta_title" class="form-label">Meta Title</label>
                                    <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                                        id="meta_title" name="meta_title" value="{{ old('meta_title', $article->meta_title) }}" 
                                        placeholder="SEO-optimized title (50-60 characters)">
                                    <span class="char-counter" id="metaTitleCounter">0/60</span>
                                    @error('meta_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Recommended length: 50-60 characters</small>
                                </div>
                                
                                <div class="mb-3 position-relative">
                                    <label for="meta_description" class="form-label">Meta Description</label>
                                    <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                        id="meta_description" name="meta_description" rows="3" 
                                        placeholder="SEO-optimized description (120-160 characters)">{{ old('meta_description', $article->meta_description) }}</textarea>
                                    <span class="char-counter" id="metaDescCounter">0/160</span>
                                    @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Recommended length: 120-160 characters</small>
                                </div>
                            </div>
                            
                            <!-- Social Media Tab -->
                            <div class="tab-pane fade" id="social-tab-pane" role="tabpanel" tabindex="0">
                                <h6 class="mb-3">Facebook/LinkedIn Preview</h6>
                                <div class="mb-3">
                                    <label for="og_title" class="form-label">Title</label>
                                    <input type="text" class="form-control @error('og_title') is-invalid @enderror" 
                                        id="og_title" name="og_title" value="{{ old('og_title', $article->og_title) }}" 
                                        placeholder="Title for social sharing">
                                    @error('og_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="og_description" class="form-label">Description</label>
                                    <textarea class="form-control @error('og_description') is-invalid @enderror" 
                                        id="og_description" name="og_description" rows="3" 
                                        placeholder="Description for social sharing">{{ old('og_description', $article->og_description) }}</textarea>
                                    @error('og_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <hr class="my-4">
                                
                                <h6 class="mb-3">Twitter Preview</h6>
                                <div class="mb-3">
                                    <label for="twitter_title" class="form-label">Title</label>
                                    <input type="text" class="form-control @error('twitter_title') is-invalid @enderror" 
                                        id="twitter_title" name="twitter_title" value="{{ old('twitter_title', $article->twitter_title) }}" 
                                        placeholder="Title for Twitter sharing">
                                    @error('twitter_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="twitter_description" class="form-label">Description</label>
                                    <textarea class="form-control @error('twitter_description') is-invalid @enderror" 
                                        id="twitter_description" name="twitter_description" rows="3" 
                                        placeholder="Description for Twitter sharing">{{ old('twitter_description', $article->twitter_description) }}</textarea>
                                    @error('twitter_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Advanced Tab -->
                            <div class="tab-pane fade" id="advanced-tab-pane" role="tabpanel" tabindex="0">
                                <div class="mb-3">
                                    <label for="canonical_url" class="form-label">Canonical URL</label>
                                    <input type="url" class="form-control @error('canonical_url') is-invalid @enderror" 
                                        id="canonical_url" name="canonical_url" value="{{ old('canonical_url', $article->canonical_url) }}" 
                                        placeholder="https://yourdomain.com/original-content">
                                    @error('canonical_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Use this if the content appears on multiple URLs to avoid duplicate content issues
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar Column -->
            <div class="col-lg-4">
                <!-- Publish Settings Card -->
                <div class="card mb-4">
                    <div class="card-header bg-apple-lightgray">
                        <h5 class="card-title mb-0">Publish Settings</h5>
                    </div>
                    
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="draft" {{ old('status', $article->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="pending" {{ old('status', $article->status) == 'pending' ? 'selected' : '' }}>Pending Review</option>
                                <option value="published" {{ old('status', $article->status) == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category <span class="required-indicator">*</span></label>
                            <select class="form-select select2 @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="tags" class="form-label">Tags</label>
                            <select id="tags" name="tags[]" class="form-control select2" multiple="multiple">
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->name }}" 
                                        {{ (is_array(old('tags')) && in_array($tag->name, old('tags'))) || 
                                           (old('tags') === null && in_array($tag->name, $articleTags)) ? 'selected' : '' }}>
                                        {{ $tag->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Type to add new tags or select existing ones</small>
                            @error('tags')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" 
                                    id="is_featured" name="is_featured" value="1" {{ old('is_featured', $article->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">Featured Article</label>
                            </div>
                            <small class="form-text text-muted">Featured articles appear in prominent positions</small>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" 
                                    id="is_premium" name="is_premium" value="1" {{ old('is_premium', $article->is_premium) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_premium">Premium Content</label>
                            </div>
                            <small class="form-text text-muted">Premium content is only accessible to subscribed users</small>
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn bg-apple-blue text-white d-flex align-items-center justify-content-center">
                                <i class="bi bi-save me-2"></i>
                                Update Article
                            </button>
                            
                            <a href="{{ route('admin.articles.show', $article->id) }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                                <i class="bi bi-eye me-2"></i>
                                Preview
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Featured Image Card -->
                <div class="card mb-4">
                    <div class="card-header bg-apple-lightgray">
                        <h5 class="card-title mb-0">Featured Image</h5>
                    </div>
                    
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label for="featured_image" class="form-label">Upload Image</label>
                            <input type="file" class="form-control @error('featured_image') is-invalid @enderror" 
                                id="featured_image" name="featured_image" accept="image/*">
                            @error('featured_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Recommended size: 1200x630px. Max size: 5MB.</small>
                        </div>
                        
                        <div class="image-preview-container mb-3">
                            @if($article->featured_image)
                                <img id="imagePreview" src="{{ Storage::url($article->featured_image) }}" alt="Preview" class="d-block">
                                <div id="imagePlaceholder" class="text-center py-4 d-none">
                                    <i class="bi bi-image text-muted fs-1 mb-2"></i>
                                    <p class="mb-0">Image preview will appear here</p>
                                </div>
                            @else
                                <img id="imagePreview" src="#" alt="Preview" class="d-none">
                                <div id="imagePlaceholder" class="text-center py-4">
                                    <i class="bi bi-image text-muted fs-1 mb-2"></i>
                                    <p class="mb-0">Image preview will appear here</p>
                                </div>
                            @endif
                        </div>
                        
                        <div class="mb-0">
                            <label for="featured_image_alt" class="form-label">Alt Text</label>
                            <input type="text" class="form-control @error('featured_image_alt') is-invalid @enderror" 
                                id="featured_image_alt" name="featured_image_alt" value="{{ old('featured_image_alt', $article->featured_image_alt) }}" 
                                placeholder="Describe the image for accessibility">
                            @error('featured_image_alt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Describe the image for screen readers and SEO</small>
                        </div>
                    </div>
                </div>
                
                <!-- Audio Content Card -->
                <div class="card mb-4">
                    <div class="card-header bg-apple-lightgray">
                        <h5 class="card-title mb-0">Audio Content</h5>
                    </div>
                    
                    <div class="card-body p-4">
                        <ul class="nav nav-tabs" id="audioTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload-tab-pane" type="button" role="tab">
                                    <i class="bi bi-upload me-2"></i>Upload
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="record-tab" data-bs-toggle="tab" data-bs-target="#record-tab-pane" type="button" role="tab">
                                    <i class="bi bi-mic me-2"></i>Record
                                </button>
                            </li>
                        </ul>
                        
                        <div class="tab-content p-3" id="audioTabsContent">
                            <!-- Upload Tab -->
                            <div class="tab-pane fade show active" id="upload-tab-pane" role="tabpanel" tabindex="0">
                                @if($article->audio_file)
                                    <div class="mb-3">
                                        <label class="form-label">Current Audio</label>
                                        <audio controls class="w-100 mb-3">
                                            <source src="{{ Storage::url($article->audio_file) }}" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                        </audio>
                                        
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="remove_audio" name="remove_audio" value="1">
                                            <label class="form-check-label" for="remove_audio">
                                                Remove current audio
                                            </label>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="mb-3">
                                    <input type="file" class="form-control @error('audio_file') is-invalid @enderror" 
                                        id="audio_file" name="audio_file" accept="audio/*">
                                    @error('audio_file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Supported formats: MP3, WAV, OGG. Max size: 20MB.</small>
                                </div>
                                
                                <div id="uploadedAudioPreview" class="d-none mt-3">
                                    <audio id="audioPreview" controls class="w-100"></audio>
                                </div>
                            </div>
                            
                            <!-- Record Tab -->
                            <div class="tab-pane fade" id="record-tab-pane" role="tabpanel" tabindex="0">
                                <div class="text-center py-3">
                                    <div class="mb-3">
                                        <span class="recording-timer" id="recordingTimer">00:00</span>
                                    </div>
                                    
                                    <button type="button" id="recordButton" class="btn btn-outline-secondary record-button mb-2">
                                        <i class="bi bi-mic fs-4"></i>
                                    </button>
                                    
                                    <p id="recordingStatus" class="mb-0 text-muted">
                                        Click to start recording
                                    </p>
                                </div>
                                
                                <div id="recordedAudioContainer" class="d-none mt-3">
                                    <audio id="recordedAudio" controls class="w-100 mb-3"></audio>
                                    
                                    <div class="d-flex justify-content-between">
                                        <button type="button" id="discardRecording" class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-x me-1"></i> Discard
                                        </button>
                                        
                                        <button type="button" id="saveRecording" class="btn btn-primary btn-sm">
                                            <i class="bi bi-check me-1"></i> Use Recording
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" id="recorded_audio_data" name="recorded_audio_data">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Stats Card (Edit-specific) -->
                <div class="card mb-4">
                    <div class="card-header bg-apple-lightgray">
                        <h5 class="card-title mb-0">Article Stats</h5>
                    </div>
                    
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <div class="stat-card p-3 text-center bg-light rounded">
                                    <div class="stat-value">{{ number_format($article->views_count ?? 0) }}</div>
                                    <div class="stat-label">Views</div>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="stat-card p-3 text-center bg-light rounded">
                                    <div class="stat-value">{{ $article->comments_count ?? 0 }}</div>
                                    <div class="stat-label">Comments</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-6">
                                <div class="stat-card p-3 text-center bg-light rounded">
                                    <div class="stat-value">{{ $article->created_at->format('M d') }}</div>
                                    <div class="stat-label">Created</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-card p-3 text-center bg-light rounded">
                                    <div class="stat-value">{{ $article->updated_at->format('M d') }}</div>
                                    <div class="stat-label">Updated</div>
                                </div>
                            </div>
                        </div>
                        
                        @if($article->published_at)
                        <div class="mt-3">
                            <small class="d-block text-muted">Published on:</small>
                            <div class="fw-medium">{{ $article->published_at->format('M d, Y g:i A') }}</div>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Danger Zone Card (Edit-specific) -->
                <div class="card mb-4">
                    <div class="card-header bg-danger text-white">
                        <h5 class="card-title mb-0">Danger Zone</h5>
                    </div>
                    
                    <div class="card-body p-4">
                        <p class="text-muted mb-3">Be careful with these actions, they cannot be undone.</p>
                        
                        <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteArticleModal">
                            <i class="bi bi-trash me-2"></i> Delete Article
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    
    <!-- Delete Article Modal -->
    <div class="modal fade" id="deleteArticleModal" tabindex="-1" aria-labelledby="deleteArticleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                    <h5 class="modal-title" id="deleteArticleModalLabel">Delete Article</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        This action cannot be undone. This will permanently delete the article "{{ $article->title }}".
                    </div>
                    <p>Please type <strong>{{ $article->slug }}</strong> to confirm.</p>
                    <input type="text" class="form-control" id="deleteConfirmation" placeholder="Enter article slug to confirm">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="confirmDeleteBtn" class="btn btn-danger" disabled>Delete Permanently</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Initialize Quill editor
var quill = new Quill('#editor', {
    theme: 'snow',
    modules: {
        toolbar: [
            [{
                'header': [1, 2, 3, 4, 5, 6, false]
            }],
            [{
                'font': []
            }],
            ['bold', 'italic', 'underline', 'strike', 'blockquote'],
            [{
                'list': 'ordered'
            }, {
                'list': 'bullet'
            }],
            [{
                'align': []
            }],
            [{
                'script': 'sub'
            }, {
                'script': 'super'
            }],
            [{
                'indent': '-1'
            }, {
                'indent': '+1'
            }],
            [{
                'direction': 'rtl'
            }],
            [{
                'color': []
            }, {
                'background': []
            }],
            ['link', 'image', 'video', 'formula', 'code-block']
        ]
    }
});

// Update hidden input when editor content changes
quill.on('text-change', function() {
    document.getElementById('content').value = quill.root.innerHTML;
});

// Initial counter values
$(document).ready(function() {
    // Image Preview functionality
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result);
                $('#imagePreview').removeClass('d-none');
                $('#imagePlaceholder').addClass('d-none');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#featured_image").change(function() {
        readURL(this);
    });
    
    // Audio preview functionality
    $("#audio_file").change(function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                $('#audioPreview').attr('src', e.target.result);
                $('#uploadedAudioPreview').removeClass('d-none');
            }
            
            reader.readAsDataURL(this.files[0]);
        }
    });
    
    // Handle audio removal checkbox
    $('#remove_audio').change(function() {
        if ($(this).is(':checked')) {
            $('#audio_file').prop('disabled', true);
        } else {
            $('#audio_file').prop('disabled', false);
        }
    });
    
    // Character counters
    function updateCounter(inputElem, counterElem, maxLength) {
        let currentLength = $(inputElem).val().length;
        $(counterElem).text(currentLength + '/' + maxLength);
        
        if (currentLength > maxLength) {
            $(counterElem).addClass('danger');
        } else if (currentLength > (maxLength * 0.8)) {
            $(counterElem).addClass('warning').removeClass('danger');
        } else {
            $(counterElem).removeClass('warning danger');
        }
    }
    
    // Initialize counters
    updateCounter('#meta_title', '#metaTitleCounter', 60);
    updateCounter('#meta_description', '#metaDescCounter', 160);
    
    // Update counters on input
    $('#meta_title').on('input', function() {
        updateCounter(this, '#metaTitleCounter', 60);
        $('#seoPreviewTitle').text($(this).val() || $('#title').val());
    });
    
    $('#meta_description').on('input', function() {
        updateCounter(this, '#metaDescCounter', 160);
        $('#seoPreviewDescription').text($(this).val() || 'Your meta description will appear here. It should be between 120-160 characters for optimal SEO performance.');
    });
    
    // Update slug preview
    $('#slug').on('input', function() {
        $('#seoPreviewSlug').text($(this).val());
    });
    
    // Auto-generate slug from title
    $('#title').on('input', function() {
        if (!$('#meta_title').val()) {
            $('#seoPreviewTitle').text($(this).val());
        }
        
        if ($('#slug').val() === '') {
            const title = $(this).val();
            const slug = title.toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            
            $('#slug').val(slug);
            $('#seoPreviewSlug').text(slug);
        }
    });
    
    // Initialize Select2 for tags
    $('.select2').select2({
        tags: true,
        placeholder: "Select or add tags",
        tokenSeparators: [',', ' ']
    });
    
    // Delete confirmation
    $('#deleteConfirmation').on('input', function() {
        const enteredSlug = $(this).val();
        const actualSlug = '{{ $article->slug }}';
        
        if (enteredSlug === actualSlug) {
            $('#confirmDeleteBtn').prop('disabled', false);
        } else {
            $('#confirmDeleteBtn').prop('disabled', true);
        }
    });
    
    // Recording functionality
    let mediaRecorder;
    let audioChunks = [];
    let isRecording = false;
    let recordingTimer;
    let recordingSeconds = 0;
    
    $('#recordButton').on('click', function() {
        if (!isRecording) {
            startRecording();
        } else {
            stopRecording();
        }
    });
    
    $('#discardRecording').on('click', function() {
        $('#recordedAudioContainer').addClass('d-none');
        $('#recordButton').removeClass('btn-danger').addClass('btn-outline-secondary');
        $('#recordingStatus').text('Click to start recording');
        $('#recordingTimer').text('00:00');
        recordingSeconds = 0;
        audioChunks = [];
    });
    
    $('#saveRecording').on('click', function() {
        const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
        const reader = new FileReader();
        reader.readAsDataURL(audioBlob);
        reader.onloadend = function() {
            const base64data = reader.result;
            $('#recorded_audio_data').val(base64data);
            $('#recordingStatus').text('Recording saved');
        };
    });
    
    function startRecording() {
        navigator.mediaDevices.getUserMedia({ audio: true })
            .then(stream => {
                mediaRecorder = new MediaRecorder(stream);
                audioChunks = [];
                
                mediaRecorder.addEventListener('dataavailable', event => {
                    audioChunks.push(event.data);
                });
                
                mediaRecorder.addEventListener('stop', () => {
                    const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                    const audioUrl = URL.createObjectURL(audioBlob);
                    $('#recordedAudio').attr('src', audioUrl);
                    $('#recordedAudioContainer').removeClass('d-none');
                });
                
                mediaRecorder.start();
                isRecording = true;
                
                $('#recordButton').removeClass('btn-outline-secondary').addClass('btn-danger');
                $('#recordingStatus').text('Recording... Click to stop');
                
                // Start timer
                recordingTimer = setInterval(updateRecordingTime, 1000);
            })
            .catch(error => {
                console.error('Error accessing microphone:', error);
                alert('Unable to access microphone. Please ensure you have granted permission.');
            });
    }
    
    function stopRecording() {
        mediaRecorder.stop();
        isRecording = false;
        
        $('#recordButton').removeClass('btn-danger').addClass('btn-outline-secondary');
        $('#recordingStatus').text('Recording stopped');
        
        // Stop timer
        clearInterval(recordingTimer);
    }
    
    function updateRecordingTime() {
        recordingSeconds++;
        const minutes = Math.floor(recordingSeconds / 60).toString().padStart(2, '0');
        const seconds = (recordingSeconds % 60).toString().padStart(2, '0');
        $('#recordingTimer').text(`${minutes}:${seconds}`);
    }
});
</script>
@endpush