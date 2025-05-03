@extends('layouts.admin.master')

@section('title', 'Create Article')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<!-- Tagify CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.17.7/tagify.min.css" rel="stylesheet">

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
    
    /* Editor styling */
    .tox-tinymce {
        border-radius: 0.375rem !important;
        border-color: #dee2e6 !important;
    }
    
    .editor-toolbar {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-bottom: none;
        border-top-left-radius: 0.375rem;
        border-top-right-radius: 0.375rem;
        padding: 0.5rem;
        display: flex;
        flex-wrap: wrap;
        gap: 0.25rem;
    }
    
    .editor-toolbar button {
        width: 2rem;
        height: 2rem;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .editor-content {
        border: 1px solid #dee2e6;
        border-bottom-left-radius: 0.375rem;
        border-bottom-right-radius: 0.375rem;
        min-height: 400px;
        padding: 1rem;
        outline: none;
    }
    
    .editor-content:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
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
    
    /* Recording */
    .record-button {
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }
    
    .record-button.recording {
        background-color: #dc3545;
        animation: pulse 1.5s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .recording-timer {
        font-family: monospace;
        font-size: 1.5rem;
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
    
    /* Tags */
    .tagify {
        --tag-bg: #e9ecef;
        --tag-hover: #dee2e6;
        --tag-text-color: #495057;
        --tags-border-color: #ced4da;
        --tags-focus-border-color: #86b7fe;
        --tag-border-radius: 0.375rem;
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
    
    .form-control:focus, .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    
    .required-indicator {
        color: #dc3545;
    }
    
    /* Card styling */
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        overflow: hidden;
    }
    
    .card-header {
        background-color: #f5f5f7;
        font-weight: 500;
        padding: 0.75rem 1rem;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4 animate-fade-in">
    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" id="articleForm">
        @csrf
        
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('admin.articles.index') }}" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center">
                    <i class="bi bi-arrow-left me-1"></i>
                    <span>Back</span>
                </a>
                <h1 class="h3 mb-0">Create New Article</h1>
            </div>
            
            <div>
                <button type="submit" class="btn bg-apple-blue text-white d-inline-flex align-items-center">
                    <i class="bi bi-save me-2"></i>
                    Create Article
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
                                id="title" name="title" value="{{ old('title') }}" required>
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
                                    id="slug" name="slug" value="{{ old('slug') }}" placeholder="article-url-slug">
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="excerpt" class="form-label">Excerpt</label>
                            <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                id="excerpt" name="excerpt" rows="3" 
                                placeholder="Brief summary of the article (SEO-friendly)">{{ old('excerpt') }}</textarea>
                            @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Leave empty to generate from content</small>
                        </div>
                        <div class="mt-3">
                    <label for="" class="form-label">
                        {{ __('Content') }}
                        <span class="text-danger">*</span>
                    </label>
                    <div id="editor" style="max-height: 750px; overflow-y: auto; min-height: 200px">
                        {!! old('content') !!}
                    </div>
                    <input type="hidden" id="content" name="content" value="{{ old('content') }}">
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
                                        {{ old('meta_title') ?: 'Your article title will appear here' }}
                                    </div>
                                    <div class="seo-preview-url">
                                        {{ config('app.url', 'https://yourdomain.com') }}/article/<span id="seoPreviewSlug">{{ old('slug') ?: 'article-slug' }}</span>
                                    </div>
                                    <div class="seo-preview-description" id="seoPreviewDescription">
                                        {{ old('meta_description') ?: 'Your meta description will appear here. It should be between 120-160 characters for optimal SEO performance.' }}
                                    </div>
                                </div>
                                
                                <div class="mb-3 position-relative">
                                    <label for="meta_title" class="form-label">Meta Title</label>
                                    <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                                        id="meta_title" name="meta_title" value="{{ old('meta_title') }}" 
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
                                        placeholder="SEO-optimized description (120-160 characters)">{{ old('meta_description') }}</textarea>
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
                                        id="og_title" name="og_title" value="{{ old('og_title') }}" 
                                        placeholder="Title for social sharing">
                                    @error('og_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="og_description" class="form-label">Description</label>
                                    <textarea class="form-control @error('og_description') is-invalid @enderror" 
                                        id="og_description" name="og_description" rows="3" 
                                        placeholder="Description for social sharing">{{ old('og_description') }}</textarea>
                                    @error('og_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <hr class="my-4">
                                
                                <h6 class="mb-3">Twitter Preview</h6>
                                <div class="mb-3">
                                    <label for="twitter_title" class="form-label">Title</label>
                                    <input type="text" class="form-control @error('twitter_title') is-invalid @enderror" 
                                        id="twitter_title" name="twitter_title" value="{{ old('twitter_title') }}" 
                                        placeholder="Title for Twitter sharing">
                                    @error('twitter_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="twitter_description" class="form-label">Description</label>
                                    <textarea class="form-control @error('twitter_description') is-invalid @enderror" 
                                        id="twitter_description" name="twitter_description" rows="3" 
                                        placeholder="Description for Twitter sharing">{{ old('twitter_description') }}</textarea>
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
                                        id="canonical_url" name="canonical_url" value="{{ old('canonical_url') }}" 
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
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending Review</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category <span class="required-indicator">*</span></label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="tags_input" class="form-label">Tags</label>
                            <input type="text" class="form-control @error('tags_input') is-invalid @enderror" 
                                id="tags_input" name="tags_input" value="{{ old('tags_input') }}" 
                                placeholder="Enter tag and press Enter">
                            @error('tags_input')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" 
                                    id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">Featured Article</label>
                            </div>
                            <small class="form-text text-muted">Featured articles appear in prominent positions</small>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" 
                                    id="is_premium" name="is_premium" value="1" {{ old('is_premium') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_premium">Premium Content</label>
                            </div>
                            <small class="form-text text-muted">Premium content is only accessible to subscribed users</small>
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn bg-apple-blue text-white d-flex align-items-center justify-content-center">
                                <i class="bi bi-save me-2"></i>
                                Save Article
                            </button>
                            
                            <button type="button" id="previewBtn" class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                                <i class="bi bi-eye me-2"></i>
                                Preview
                            </button>
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
                            <img id="imagePreview" src="#" alt="Preview" class="d-none">
                            <div id="imagePlaceholder" class="text-center py-4">
                                <i class="bi bi-image text-muted fs-1 mb-2"></i>
                                <p class="mb-0">Image preview will appear here</p>
                            </div>
                        </div>
                        
                        <div class="mb-0">
                            <label for="featured_image_alt" class="form-label">Alt Text</label>
                            <input type="text" class="form-control @error('featured_image_alt') is-invalid @enderror" 
                                id="featured_image_alt" name="featured_image_alt" value="{{ old('featured_image_alt') }}" 
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
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Select2 for category
            $(".select2").select2({
                placeholder: "Select Category"
            });
            
            // Initialize Select2 for tags
            $(".selectTags").select2({
                tags: true,
                placeholder: "Write tag and Press enter to add tags"
            });
        });
        
        // Image preview function
        function previewFile(event, previewId) {
            const preview = document.getElementById(previewId);
            const file = event.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function() {
                    preview.src = reader.result;
                }
                reader.readAsDataURL(file);
            }
        }

        const quill = new Quill('#editor', {
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
                    ['link', 'image', 'video', 'formula']
                ]
            }
        });

        quill.on('text-change', function(delta, oldDelta, source) {
            document.getElementById('content').value = quill.root.innerHTML;
        });
        
        // Generate slug from title
        $('#title').on('blur', function() {
            if ($('#slug').val() === '') {
                const title = $(this).val();
                const slug = title.toLowerCase()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
                $('#slug').val(slug);
            }
        });
    </script>
@endpush
