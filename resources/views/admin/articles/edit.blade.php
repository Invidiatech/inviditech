@extends('layouts.admin.master')

@section('title', 'Edit Article')

@section('styles')
    <!-- Include TinyMCE CSS -->
     <style>
        
        .character-count {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            background-color: #f8f9fa;
            border-radius: 0.25rem;
        }
        .character-count.warning {
            color: #fd7e14;
        }
        .character-count.danger {
            color: #dc3545;
        }
        .seo-preview {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 1rem;
            background-color: #fff;
            margin-bottom: 1rem;
        }
        .seo-preview-title {
            color: #1a0dab;
            font-size: 1.125rem;
            margin-bottom: 0.25rem;
            font-weight: 500;
        }
        .seo-preview-url {
            color: #006621;
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
        }
        .seo-preview-description {
            color: #545454;
            font-size: 0.875rem;
        }
        .image-preview-container {
            border: 1px dashed #dee2e6;
            border-radius: 0.375rem;
            overflow: hidden;
        }
        .image-preview {
            width: 100%;
            height: auto;
            max-height: 200px;
            object-fit: contain;
        }
        .record-button {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }
        .record-button.recording {
            background-color: #dc3545;
            color: white;
            animation: pulse 1.5s infinite;
        }
        .recording-timer {
            font-family: monospace;
            font-size: 1.25rem;
            font-weight: 500;
        }
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(220, 53, 69, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
            }
        }
    </style>
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.articles.index') }}">Articles</a></li>
    <li class="breadcrumb-item active">Edit Article</li>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Edit Article: {{ $article->title }}</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.articles.show', $article->id) }}" class="btn btn-outline-info">
                <i class="bi bi-eye me-1"></i> Preview
            </a>
            <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Articles
            </a>
        </div>
    </div>
    
    <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data" id="articleForm">
        @csrf
        @method('PUT')
        
        <div class="row">
            <!-- Main Content Column -->
            <div class="col-lg-8 mb-4">
                <div class="admin-card mb-4">
                    <div class="admin-card-header">
                        <h5 class="admin-card-title">Article Content</h5>
                    </div>
                    <div class="admin-card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $article->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <div class="input-group">
                                <span class="input-group-text">/article/</span>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $article->slug) }}">
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">URL-friendly name (automatically generated from title if empty).</small>
                        </div>

                        <div class="mb-3">
                            <label for="excerpt" class="form-label">Excerpt</label>
                            <textarea class="form-control @error('excerpt') is-invalid @enderror" id="excerpt" name="excerpt" rows="3">{{ old('excerpt', $article->excerpt) }}</textarea>
                            @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Brief summary of the article (SEO-friendly).</small>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="20">{{ old('content', $article->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- SEO & Social Media Settings -->
                <div class="admin-card">
                    <div class="admin-card-header">
                        <h5 class="admin-card-title">SEO & Social Media</h5>
                    </div>
                    <div class="admin-card-body">
                        <ul class="nav nav-tabs" id="seoTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button" role="tab" aria-controls="seo" aria-selected="true">
                                    <i class="bi bi-search me-1"></i> SEO
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button" role="tab" aria-controls="social" aria-selected="false">
                                    <i class="bi bi-share me-1"></i> Social Media
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="advanced-tab" data-bs-toggle="tab" data-bs-target="#advanced" type="button" role="tab" aria-controls="advanced" aria-selected="false">
                                    <i class="bi bi-gear me-1"></i> Advanced
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content mt-4" id="seoTabsContent">
                            <!-- SEO Tab -->
                            <div class="tab-pane fade show active" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                                <div class="seo-preview">
                                    <div class="seo-preview-title" id="seoPreviewTitle">
                                        {{ old('meta_title', $article->meta_title ?? $article->title) }}
                                    </div>
                                    <div class="seo-preview-url">
                                        {{ config('app.url') }}/article/<span id="seoPreviewSlug">{{ old('slug', $article->slug) }}</span>
                                    </div>
                                    <div class="seo-preview-description" id="seoPreviewDescription">
                                        {{ old('meta_description', $article->meta_description ?? Str::limit(strip_tags($article->content), 160)) }}
                                    </div>
                                </div>

                                <div class="mb-3 mt-3">
                                    <label for="meta_title" class="form-label">Meta Title</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('meta_title') is-invalid @enderror" id="meta_title" name="meta_title" value="{{ old('meta_title', $article->meta_title) }}">
                                        <span class="character-count" id="metaTitleCount">{{ strlen(old('meta_title', $article->meta_title ?? '')) }}/60</span>
                                    </div>
                                    @error('meta_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Recommended length: 50-60 characters</small>
                                </div>

                                <div class="mb-3">
                                    <label for="meta_description" class="form-label">Meta Description</label>
                                    <div class="input-group">
                                        <textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description" name="meta_description" rows="3">{{ old('meta_description', $article->meta_description) }}</textarea>
                                        <span class="character-count" id="metaDescriptionCount">{{ strlen(old('meta_description', $article->meta_description ?? '')) }}/160</span>
                                    </div>
                                    @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Recommended length: 120-160 characters</small>
                                </div>
                            </div>

                            <!-- Social Media Tab -->
                            <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
                                <h6 class="mb-3">Facebook/LinkedIn Preview</h6>
                                <div class="mb-3">
                                    <label for="og_title" class="form-label">Title</label>
                                    <input type="text" class="form-control @error('og_title') is-invalid @enderror" id="og_title" name="og_title" value="{{ old('og_title', $article->og_title) }}">
                                    @error('og_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="og_description" class="form-label">Description</label>
                                    <textarea class="form-control @error('og_description') is-invalid @enderror" id="og_description" name="og_description" rows="3">{{ old('og_description', $article->og_description) }}</textarea>
                                    @error('og_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <h6 class="mb-3 mt-4">Twitter Preview</h6>
                                <div class="mb-3">
                                    <label for="twitter_title" class="form-label">Title</label>
                                    <input type="text" class="form-control @error('twitter_title') is-invalid @enderror" id="twitter_title" name="twitter_title" value="{{ old('twitter_title', $article->twitter_title) }}">
                                    @error('twitter_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="twitter_description" class="form-label">Description</label>
                                    <textarea class="form-control @error('twitter_description') is-invalid @enderror" id="twitter_description" name="twitter_description" rows="3">{{ old('twitter_description', $article->twitter_description) }}</textarea>
                                    @error('twitter_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Advanced Tab -->
                            <div class="tab-pane fade" id="advanced" role="tabpanel" aria-labelledby="advanced-tab">
                                <div class="mb-3">
                                    <label for="canonical_url" class="form-label">Canonical URL</label>
                                    <input type="url" class="form-control @error('canonical_url') is-invalid @enderror" id="canonical_url" name="canonical_url" value="{{ old('canonical_url', $article->canonical_url) }}">
                                    @error('canonical_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Use this if the content appears on multiple URLs to avoid duplicate content issues.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Column -->
            <div class="col-lg-4">
                <!-- Publish Settings -->
                <div class="admin-card mb-4">
                    <div class="admin-card-header">
                        <h5 class="admin-card-title">Publish Settings</h5>
                    </div>
                    <div class="admin-card-body">
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
                            <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
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
                            <label for="tags_input" class="form-label">Tags</label>
                            <input type="text" class="form-control @error('tags_input') is-invalid @enderror" id="tags_input" name="tags_input" value="{{ old('tags_input', implode(',', $tags)) }}">
                            @error('tags_input')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Enter tags separated by commas</small>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $article->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">Featured Article</label>
                            <small class="form-text d-block text-muted">Featured articles appear in prominent positions.</small>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="is_premium" name="is_premium" value="1" {{ old('is_premium', $article->is_premium) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_premium">Premium Content</label>
                            <small class="form-text d-block text-muted">Premium content is only accessible to subscribed users.</small>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Update Article
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Article Info Card -->
                <div class="admin-card mb-4">
                    <div class="admin-card-header">
                        <h5 class="admin-card-title">Article Information</h5>
                    </div>
                    <div class="admin-card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>Created By</span>
                                <span class="badge bg-secondary">{{ $article->user->name ?? 'Unknown' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>Created At</span>
                                <span class="badge bg-secondary">{{ $article->created_at->format('M d, Y \a\t H:i') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>Last Updated</span>
                                <span class="badge bg-secondary">{{ $article->updated_at->format('M d, Y \a\t H:i') }}</span>
                            </li>
                            @if($article->published_at)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>Published</span>
                                <span class="badge bg-success">{{ $article->published_at->format('M d, Y \a\t H:i') }}</span>
                            </li>
                            @endif
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>Views</span>
                                <span class="badge bg-primary">{{ $article->views_count ?? 0 }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="admin-card mb-4">
                    <div class="admin-card-header">
                        <h5 class="admin-card-title">Featured Image</h5>
                    </div>
                    <div class="admin-card-body">
                        <div class="mb-3">
                            <input type="file" class="form-control @error('featured_image') is-invalid @enderror" id="featured_image" name="featured_image" accept="image/*">
                            @error('featured_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Leave empty to keep current image. Recommended size: 1200x630px.</small>
                        </div>
                        <div class="image-preview-container">
                            @if($article->featured_image)
                                <img id="imagePreview" src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->featured_image_alt }}" class="image-preview">
                                <div id="imagePlaceholder" class="text-center py-4 d-none">
                                    <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                    <p class="mb-0">Image preview will appear here</p>
                                </div>
                            @else
                                <img id="imagePreview" src="{{ asset('img/placeholder-image.png') }}" alt="Preview" class="image-preview d-none">
                                <div id="imagePlaceholder" class="text-center py-4">
                                    <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                    <p class="mb-0">No featured image</p>
                                </div>
                            @endif
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="featured_image_alt" class="form-label">Alt Text</label>
                            <input type="text" class="form-control @error('featured_image_alt') is-invalid @enderror" id="featured_image_alt" name="featured_image_alt" value="{{ old('featured_image_alt', $article->featured_image_alt) }}">
                            @error('featured_image_alt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Describe the image for screen readers and SEO.</small>
                        </div>
                        
                        @if($article->featured_image)
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="remove_featured_image" name="remove_featured_image" value="1">
                            <label class="form-check-label" for="remove_featured_image">Remove current image</label>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Audio Content -->
                <div class="admin-card">
                    <div class="admin-card-header">
                        <h5 class="admin-card-title">Audio Content</h5>
                    </div>
                    <div class="admin-card-body">
                        <ul class="nav nav-tabs" id="audioTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload" type="button" role="tab" aria-controls="upload" aria-selected="true">
                                    <i class="bi bi-upload me-1"></i> Upload
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="record-tab" data-bs-toggle="tab" data-bs-target="#record" type="button" role="tab" aria-controls="record" aria-selected="false">
                                    <i class="bi bi-mic me-1"></i> Record
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content mt-3" id="audioTabsContent">
                            <!-- Upload Tab -->
                            <div class="tab-pane fade show active" id="upload" role="tabpanel" aria-labelledby="upload-tab">
                                <div class="mb-3">
                                    <input type="file" class="form-control @error('audio_file') is-invalid @enderror" id="audio_file" name="audio_file" accept="audio/*">
                                    @error('audio_file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Leave empty to keep current audio. Supported formats: MP3, WAV, OGG.</small>
                                </div>
                                
                                @if($article->audio_file)
                                <div id="currentAudio" class="mb-3">
                                    <label class="form-label">Current Audio</label>
                                    <audio src="{{ asset('storage/' . $article->audio_file) }}" controls class="w-100"></audio>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="remove_audio" name="remove_audio" value="1">
                                        <label class="form-check-label" for="remove_audio">Remove current audio</label>
                                    </div>
                                </div>
                                @endif
                                
                                <div id="uploadedAudioPreview" class="d-none mt-3">
                                    <label class="form-label">New Audio Preview</label>
                                    <audio id="audioPreview" controls class="w-100"></audio>
                                </div>
                            </div>
                            
                            <!-- Record Tab -->
                            <div class="tab-pane fade" id="record" role="tabpanel" aria-labelledby="record-tab">
                                <div class="text-center mb-3">
                                    <div class="mb-2">
                                        <span class="recording-timer" id="recordingTimer">00:00</span>
                                    </div>
                                    <button type="button" id="recordButton" class="btn record-button">
                                        <i class="bi bi-mic fs-4"></i>
                                    </button>
                                    <p class="mt-2 mb-0" id="recordingStatus">Click to start recording</p>
                                </div>
                                <div id="recordedAudioContainer" class="d-none mt-3">
                                    <audio id="recordedAudio" controls class="w-100"></audio>
                                    <div class="d-flex justify-content-between mt-2">
                                        <button type="button" id="discardRecording" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash me-1"></i> Discard
                                        </button>
                                        <button type="button" id="saveRecording" class="btn btn-sm btn-primary">
                                            <i class="bi bi-check-circle me-1"></i> Use Recording
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
@endsection

@section('scripts')
    <!-- Include TinyMCE and other scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.6.0/tinymce.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.17.7/tagify.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            

          

            // Title to slug conversion
            const titleInput = document.getElementById('title');
            const slugInput = document.getElementById('slug');
            
            titleInput.addEventListener('keyup', function() {
                if (!slugInput.value) {
                    slugInput.value = titleInput.value
                        .toLowerCase()
                        .replace(/\s+/g, '-')
                        .replace(/[^\w\-]+/g, '')
                        .replace(/\-\-+/g, '-')
                        .replace(/^-+/, '')
                        .replace(/-+$/, '');

                    // Update SEO preview
                    document.getElementById('seoPreviewSlug').textContent = slugInput.value;
                }
            });

            // Featured image preview
            const imageInput = document.getElementById('featured_image');
            const imagePreview = document.getElementById('imagePreview');
            const imagePlaceholder = document.getElementById('imagePlaceholder');
            const removeImageCheckbox = document.getElementById('remove_featured_image');
            
            imageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.classList.remove('d-none');
                        imagePlaceholder.classList.add('d-none');
                        
                        // Uncheck remove checkbox if user uploads a new image
                        if (removeImageCheckbox) {
                            removeImageCheckbox.checked = false;
                        }
                    }
                    
                    reader.readAsDataURL(this.files[0]);
                }
            });
            
            // Handle remove image checkbox
            if (removeImageCheckbox) {
                removeImageCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        imagePreview.classList.add('d-none');
                        imagePlaceholder.classList.remove('d-none');
                    } else {
                        imagePreview.classList.remove('d-none');
                        imagePlaceholder.classList.add('d-none');
                    }
                });
            }

            // Audio upload preview
            const audioInput = document.getElementById('audio_file');
            const audioPreview = document.getElementById('audioPreview');
            const uploadedAudioPreview = document.getElementById('uploadedAudioPreview');
            const removeAudioCheckbox = document.getElementById('remove_audio');
            
            audioInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        audioPreview.src = e.target.result;
                        uploadedAudioPreview.classList.remove('d-none');
                        
                        // Uncheck remove checkbox if user uploads a new audio
                        if (removeAudioCheckbox) {
                            removeAudioCheckbox.checked = false;
                        }
                    }
                    
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // SEO Preview updates
            const metaTitleInput = document.getElementById('meta_title');
            const metaDescriptionInput = document.getElementById('meta_description');
            const seoPreviewTitle = document.getElementById('seoPreviewTitle');
            const seoPreviewDescription = document.getElementById('seoPreviewDescription');
            const metaTitleCount = document.getElementById('metaTitleCount');
            const metaDescriptionCount = document.getElementById('metaDescriptionCount');
            
            // Update meta title
            metaTitleInput.addEventListener('input', function() {
                const length = this.value.length;
                seoPreviewTitle.textContent = this.value || titleInput.value || 'Your article title will appear here';
                metaTitleCount.textContent = `${length}/60`;
                
                if (length > 60) {
                    metaTitleCount.classList.add('danger');
                } else if (length > 50) {
                    metaTitleCount.classList.add('warning');
                    metaTitleCount.classList.remove('danger');
                } else {
                    metaTitleCount.classList.remove('warning', 'danger');
                }
            });
            
            // Update meta description
            metaDescriptionInput.addEventListener('input', function() {
                const length = this.value.length;
                seoPreviewDescription.textContent = this.value || 'Your meta description will appear here. It should be between 120-160 characters for optimal SEO performance.';
                metaDescriptionCount.textContent = `${length}/160`;
                
                if (length > 160) {
                    metaDescriptionCount.classList.add('danger');
                } else if (length > 150 || length < 120) {
                    metaDescriptionCount.classList.add('warning');
                    metaDescriptionCount.classList.remove('danger');
                } else {
                    metaDescriptionCount.classList.remove('warning', 'danger');
                }
            });
            
            // Copy title to meta title if empty when title loses focus
            titleInput.addEventListener('blur', function() {
                if (!metaTitleInput.value) {
                    metaTitleInput.value = titleInput.value;
                    seoPreviewTitle.textContent = titleInput.value;
                    metaTitleCount.textContent = `${titleInput.value.length}/60`;
                }
            });
            
            // Audio Recording Functionality
            let mediaRecorder;
            let audioChunks = [];
            let recordingTimer;
            let recordingSeconds = 0;
            
            const recordButton = document.getElementById('recordButton');
            const recordingStatus = document.getElementById('recordingStatus');
            const recordingTimerDisplay = document.getElementById('recordingTimer');
            const recordedAudio = document.getElementById('recordedAudio');
            const recordedAudioContainer = document.getElementById('recordedAudioContainer');
            const discardRecording = document.getElementById('discardRecording');
            const saveRecording = document.getElementById('saveRecording');
            const recordedAudioData = document.getElementById('recorded_audio_data');
            
            // Format time for display
            function formatTime(seconds) {
                const minutes = Math.floor(seconds / 60);
                seconds = seconds % 60;
                return `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }
            
            // Start/stop recording when record button is clicked
            recordButton.addEventListener('click', function() {
                if (mediaRecorder && mediaRecorder.state === 'recording') {
                    // Stop recording
                    mediaRecorder.stop();
                    recordButton.classList.remove('recording');
                    recordingStatus.textContent = 'Processing recording...';
                    clearInterval(recordingTimer);
                } else {
                    // Start recording
                    navigator.mediaDevices.getUserMedia({ audio: true })
                        .then(stream => {
                            recordButton.classList.add('recording');
                            recordingStatus.textContent = 'Recording... Click to stop';
                            
                            // Reset timer
                            recordingSeconds = 0;
                            recordingTimerDisplay.textContent = formatTime(recordingSeconds);
                            
                            // Start timer
                            recordingTimer = setInterval(() => {
                                recordingSeconds++;
                                recordingTimerDisplay.textContent = formatTime(recordingSeconds);
                            }, 1000);
                            
                            // Create media recorder and start recording
                            mediaRecorder = new MediaRecorder(stream);
                            audioChunks = [];
                            
                            mediaRecorder.addEventListener('dataavailable', event => {
                                audioChunks.push(event.data);
                            });
                            
                            mediaRecorder.addEventListener('stop', () => {
                                // Create audio blob
                                const audioBlob = new Blob(audioChunks, { type: 'audio/mp3' });
                                const audioUrl = URL.createObjectURL(audioBlob);
                                
                                // Show recorded audio
                                recordedAudio.src = audioUrl;
                                recordedAudioContainer.classList.remove('d-none');
                                recordingStatus.textContent = 'Recording complete';
                                
                                // Stop all tracks to release microphone
                                stream.getTracks().forEach(track => track.stop());
                            });
                            
                            mediaRecorder.start();
                        })
                        .catch(error => {
                            console.error('Error accessing microphone:', error);
                            recordingStatus.textContent = 'Error accessing microphone. Please check permissions.';
                        });
                }
            });
            
            // Discard recording
            discardRecording.addEventListener('click', function() {
                recordedAudioContainer.classList.add('d-none');
                recordedAudio.src = '';
                recordedAudioData.value = '';
                recordingStatus.textContent = 'Click to start recording';
            });
            
            // Save recording
            saveRecording.addEventListener('click', function() {
                // Convert blob to base64 data
                const reader = new FileReader();
                const audioBlob = new Blob(audioChunks, { type: 'audio/mp3' });
                
                reader.readAsDataURL(audioBlob);
                reader.onloadend = function() {
                    const base64data = reader.result;
                    recordedAudioData.value = base64data;
                    recordingStatus.textContent = 'Recording saved';
                    
                    // Uncheck remove audio checkbox if a new recording is saved
                    if (removeAudioCheckbox) {
                        removeAudioCheckbox.checked = false;
                    }
                };
            });
            
            // Handle form submission with improved validation
            document.getElementById('articleForm').addEventListener('submit', function(e) {
                // Make sure TinyMCE content is updated
                tinymce.triggerSave();
                
                // Basic validation
                const title = document.getElementById('title').value.trim();
                const content = tinymce.get('content').getContent().trim();
                const category = document.getElementById('category_id').value;
                
                let hasError = false;
                
                if (!title) {
                    e.preventDefault();
                    document.getElementById('title').classList.add('is-invalid');
                    hasError = true;
                }
                
                if (!content) {
                    e.preventDefault();
                    tinymce.get('content').getContainer().style.border = '1px solid #dc3545';
                    hasError = true;
                }
                
                if (!category) {
                    e.preventDefault();
                    document.getElementById('category_id').classList.add('is-invalid');
                    hasError = true;
                }
                
                if (hasError) {
                    window.scrollTo(0, 0);
                }
            });
        });
    </script>
@endsection