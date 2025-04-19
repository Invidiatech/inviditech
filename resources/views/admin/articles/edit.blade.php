@extends('layouts.admin.master')

@section('title', 'Edit Article')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Custom Styles */
    .blogThumbnail {
        width: 100%;
        aspect-ratio: 1.2;
        display: block;
        border-radius: 8px;
        overflow: hidden;
        cursor: pointer;
        position: relative;
        border: 2px dashed #dee2e6;
        transition: all 0.3s;
    }
    
    .blogThumbnail:hover {
        border-color: #0d6efd;
    }
    
    .blogThumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .ql-editor {
        min-height: 200px;
        max-height: 500px;
        overflow-y: auto;
    }
    
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        margin-bottom: 1.5rem;
    }
    
    .select2-container--default .select2-selection--multiple {
        border-color: #dee2e6;
    }
    
    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    
    /* Form Section Title */
    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #dee2e6;
    }
    
    /* Audio player */
    .audio-player {
        width: 100%;
        margin-top: 10px;
    }
    
    /* Stats display */
    .stat-card {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
    }
    
    .stat-value {
        font-size: 22px;
        font-weight: 600;
    }
    
    .stat-label {
        color: #6c757d;
        font-size: 14px;
    }
</style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.articles.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h4 class="mb-0">{{ __('Edit Article') }}</h4>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="card mt-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <!-- Basic Information -->
                            <div class="section-title">Basic Information</div>
                            
                            <div class="mb-3">
                                <label for="title" class="form-label">
                                    {{ __('Title') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                    id="title" name="title" value="{{ old('title', $article->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="slug" class="form-label d-flex justify-content-between">
                                    <span>{{ __('Slug') }}</span>
                                    <small class="text-muted">Auto-generated from title if left empty</small>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">/article/</span>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                        id="slug" name="slug" value="{{ old('slug', $article->slug) }}">
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="category_id" class="form-label">
                                    {{ __('Category') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                    <option value="" disabled>{{ __('Select Category') }}</option>
                                    @foreach ($categories as $category)
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
                                <label for="tags" class="form-label">{{ __('Tags') }}</label>
                                <select id="tags" name="tags[]" class="form-control select2-tags @error('tags') is-invalid @enderror" multiple>
                                    @foreach ($tags as $tag)
                                        <option value="{{ $tag->name }}" 
                                            {{ (is_array(old('tags')) && in_array($tag->name, old('tags'))) || 
                                               (old('tags') === null && in_array($tag->name, $articleTags)) ? 'selected' : '' }}>
                                            {{ $tag->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">{{ __('Write tag and press Enter to add new tags') }}</small>
                                @error('tags')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="excerpt" class="form-label">{{ __('Excerpt') }}</label>
                                <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                    id="excerpt" name="excerpt" rows="3">{{ old('excerpt', $article->excerpt) }}</textarea>
                                <small class="text-muted">{{ __('A short summary of the article (optional)') }}</small>
                                @error('excerpt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- SEO Settings -->
                            <div class="section-title mt-4">SEO Settings</div>
                            
                            <div class="mb-3">
                                <label for="meta_title" class="form-label">{{ __('Meta Title') }}</label>
                                <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                                    id="meta_title" name="meta_title" value="{{ old('meta_title', $article->meta_title) }}">
                                <small class="text-muted">{{ __('Leave empty to use the article title') }}</small>
                                @error('meta_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="meta_description" class="form-label">{{ __('Meta Description') }}</label>
                                <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                    id="meta_description" name="meta_description" rows="2">{{ old('meta_description', $article->meta_description) }}</textarea>
                                <small class="text-muted">{{ __('Leave empty to use the excerpt') }}</small>
                                @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="canonical_url" class="form-label">{{ __('Canonical URL') }}</label>
                                <input type="url" class="form-control @error('canonical_url') is-invalid @enderror" 
                                    id="canonical_url" name="canonical_url" value="{{ old('canonical_url', $article->canonical_url) }}">
                                <small class="text-muted">{{ __('Use this if content is duplicated from another source') }}</small>
                                @error('canonical_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <!-- Article Stats -->
                            <div class="section-title">Article Stats</div>
                            
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="stat-card">
                                        <div class="stat-value">{{ number_format($article->views_count) }}</div>
                                        <div class="stat-label">{{ __('Views') }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-card">
                                        <div class="stat-value">{{ $article->comments_count }}</div>
                                        <div class="stat-label">{{ __('Comments') }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-card">
                                        <div class="stat-value">{{ $article->reading_time ?? 0 }}</div>
                                        <div class="stat-label">{{ __('Reading Time (mins)') }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-card">
                                        <div class="stat-value">{{ $article->created_at->format('M d, Y') }}</div>
                                        <div class="stat-label">{{ __('Created Date') }}</div>
                                    </div>
                                </div>
                            </div>
                        
                            <!-- Featured Image -->
                            <div class="section-title mt-4">Featured Image</div>
                            
                            <div class="mb-3">
                                <label for="featured_image" class="blogThumbnail">
                                    @if($article->featured_image)
                                        <img src="{{ Storage::url($article->featured_image) }}" id="preview" alt="{{ $article->title }}">
                                    @else
                                        <img src="https://placehold.co/880x440/f1f5f9/png" id="preview" alt="preview">
                                    @endif
                                </label>
                                <input id="featured_image" type="file" name="featured_image" accept="image/*"
                                    class="d-none @error('featured_image') is-invalid @enderror"
                                    onchange="previewImage(event)"/>
                                <div class="mt-2">
                                    <small class="text-muted">{{ __('Recommended size: 880x440px') }}</small>
                                </div>
                                @error('featured_image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="featured_image_alt" class="form-label">{{ __('Image Alt Text') }}</label>
                                <input type="text" class="form-control @error('featured_image_alt') is-invalid @enderror"
                                    id="featured_image_alt" name="featured_image_alt" value="{{ old('featured_image_alt', $article->featured_image_alt) }}">
                                <small class="text-muted">{{ __('Describe the image for accessibility') }}</small>
                                @error('featured_image_alt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Publishing Options -->
                            <div class="section-title mt-4">Publishing Options</div>
                            
                            <div class="mb-3">
                                <label for="status" class="form-label">{{ __('Status') }}</label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="draft" {{ old('status', $article->status) == 'draft' ? 'selected' : '' }}>{{ __('Draft') }}</option>
                                    <option value="published" {{ old('status', $article->status) == 'published' ? 'selected' : '' }}>{{ __('Published') }}</option>
                                    <option value="private" {{ old('status', $article->status) == 'private' ? 'selected' : '' }}>{{ __('Private') }}</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" 
                                    {{ old('is_featured', $article->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    {{ __('Featured Article') }}
                                </label>
                                <div><small class="text-muted">{{ __('Display this article in featured sections') }}</small></div>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="is_premium" name="is_premium" value="1"
                                    {{ old('is_premium', $article->is_premium) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_premium">
                                    {{ __('Premium Content') }}
                                </label>
                                <div><small class="text-muted">{{ __('Restrict to premium members only') }}</small></div>
                            </div>
                            
                            <!-- Audio Section -->
                            <div class="section-title mt-4">Audio Version</div>
                            
                            @if($article->audio_path)
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Current Audio') }}</label>
                                    <audio controls class="audio-player">
                                        <source src="{{ Storage::url($article->audio_path) }}" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                    
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="remove_audio" name="remove_audio" value="1">
                                        <label class="form-check-label" for="remove_audio">
                                            {{ __('Remove current audio') }}
                                        </label>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="mb-3">
                                <label for="audio_file" class="form-label">
                                    {{ $article->audio_path ? __('Replace Audio File') : __('Upload Audio File') }}
                                </label>
                                <input type="file" class="form-control @error('audio_file') is-invalid @enderror"
                                    id="audio_file" name="audio_file" accept="audio/*">
                                <small class="text-muted">{{ __('MP3, WAV or OGG files (max: 20MB)') }}</small>
                                @error('audio_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Article Content -->
                    <div class="section-title mt-4">Article Content</div>
                    
                    <div class="mb-3">
                        <div id="editor" style="min-height: 300px;"></div>
                        <input type="hidden" name="content" id="content" value="{{ old('content', $article->content) }}">
                        @error('content')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="card-footer d-flex justify-content-between">
                    <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this article? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="bi bi-trash me-1"></i> {{ __('Delete Article') }}
                        </button>
                    </form>
                    
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            {{ __('Update Article') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<script>
    // Image preview function
    function previewImage(event) {
        const preview = document.getElementById('preview');
        const file = event.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function() {
                preview.src = reader.result;
            }
            reader.readAsDataURL(file);
        }
    }
    
    $(document).ready(function() {
        // Initialize Select2 for tags
        $(".select2-tags").select2({
            tags: true,
            placeholder: "Enter tags...",
            tokenSeparators: [',']
        });
        
        // Initialize Quill editor
        const quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    [{ 'font': [] }],
                    ['bold', 'italic', 'underline', 'strike', 'blockquote'],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    [{ 'align': [] }],
                    [{ 'color': [] }, { 'background': [] }],
                    ['link', 'image'],
                    ['clean']
                ]
            }
        });
        
        // Set initial content
        const contentInput = document.getElementById('content');
        if (contentInput.value) {
            quill.root.innerHTML = contentInput.value;
        }
        
        // Update hidden input when editor content changes
        quill.on('text-change', function() {
            document.getElementById('content').value = quill.root.innerHTML;
        });
        
        // Handle audio removal checkbox
        $('#remove_audio').on('change', function() {
            if ($(this).is(':checked')) {
                $('#audio_file').prop('disabled', true);
            } else {
                $('#audio_file').prop('disabled', false);
            }
        });
    });
</script>
@endsection