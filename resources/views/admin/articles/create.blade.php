 @extends('layouts.admin.master')

@section('title', 'Create Article')

@section('styles')
<style>
    /* Audio recording styles */
.record-button {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.record-button.recording {
    background-color: #dc3545;
    color: white;
    border-color: #dc3545;
    animation: pulse 1.5s infinite;
}

.recording-timer {
    font-size: 1.5rem;
    font-weight: 500;
    font-family: monospace;
}

/* Pulsing animation for recording button */
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

/* Tab styling */
.nav-tabs .nav-link {
    color: #6c757d;
}

.nav-tabs .nav-link.active {
    color: #212529;
    font-weight: 500;
}

/* Audio player styling */
audio {
    border-radius: 8px;
}

/* Form validation feedback */
.is-invalid {
    border-color: #dc3545;
}

.invalid-feedback {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}
    /* Animation */
    .animate-fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    /* Apple-inspired style - Fixed save button color */
    .bg-apple-blue {
        background-color: #0071e3 !important;
        border-color: #0071e3 !important;
    }
    
    .bg-apple-blue:hover {
        background-color: #0077ed !important;
        border-color: #0077ed !important;
    }
    
    .bg-apple-blue:focus {
        background-color: #0077ed !important;
        border-color: #0077ed !important;
        box-shadow: 0 0 0 0.2rem rgba(0, 113, 227, 0.25) !important;
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
                <button type="submit" class="btn btn-primary bg-apple-blue text-white d-inline-flex align-items-center">
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
                            <label for="editor" class="form-label">
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
                            <select class="form-select select2 @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
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
                            <label for="tags" class="form-label">Tags</label>
                            <select id="tags" name="tags[]" class="form-control select2" multiple="multiple">
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->name }}" {{ (is_array(old('tags')) && in_array($tag->name, old('tags'))) ? 'selected' : '' }}>
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
                            <button type="submit" class="btn btn-primary bg-apple-blue text-white d-flex align-items-center justify-content-center">
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
               <!-- Audio Content Card -->
<div class="card mb-4">
    <div class="card-header bg-apple-lightgray">
        <h5 class="card-title mb-0">Audio Summary</h5>
    </div>
    
    <div class="card-body p-4">
        <p class="text-muted mb-3">Add an audio summary related to your article. You can either upload an existing audio file or record a new one.</p>
        
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
        
        <!-- Audio Summary Title and Description -->
        <div class="mt-4 pt-3 border-top">
            <div class="mb-3">
                <label for="audio_title" class="form-label">Audio Summary Title</label>
                <input type="text" class="form-control @error('audio_title') is-invalid @enderror" 
                    id="audio_title" name="audio_title" placeholder="Brief title for your audio summary">
                @error('audio_title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="audio_description" class="form-label">Description (Optional)</label>
                <textarea class="form-control @error('audio_description') is-invalid @enderror" 
                    id="audio_description" name="audio_description" rows="2" 
                    placeholder="Short description of what your audio summary covers"></textarea>
                @error('audio_description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <!-- Audio Submission Status -->
        <div id="audioSubmissionStatus" class="mt-3 d-none">
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i> 
                <span id="audioStatusMessage">Your audio summary is ready to be submitted with the article.</span>
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

//article voice recording js
// Audio Recording Implementation
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const recordButton = document.getElementById('recordButton');
    const recordingStatus = document.getElementById('recordingStatus');
    const recordingTimer = document.getElementById('recordingTimer');
    const recordedAudioContainer = document.getElementById('recordedAudioContainer');
    const recordedAudio = document.getElementById('recordedAudio');
    const discardRecording = document.getElementById('discardRecording');
    const saveRecording = document.getElementById('saveRecording');
    const recordedAudioDataInput = document.getElementById('recorded_audio_data');
    const audioFileInput = document.getElementById('audio_file');
    const uploadedAudioPreview = document.getElementById('uploadedAudioPreview');
    const audioPreview = document.getElementById('audioPreview');
    
    // Recording variables
    let mediaRecorder;
    let audioChunks = [];
    let startTime;
    let timerInterval;
    let audioBlob;
    let audioUrl;
    
    // Function to format timer
    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return `${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
    }
    
    // Function to update timer
    function updateTimer() {
        const currentTime = Math.floor((Date.now() - startTime) / 1000);
        recordingTimer.textContent = formatTime(currentTime);
    }
    
    // Start recording
    recordButton.addEventListener('click', function() {
        if (!mediaRecorder || mediaRecorder.state === 'inactive') {
            // Request microphone access
            navigator.mediaDevices.getUserMedia({ audio: true })
                .then(stream => {
                    audioChunks = [];
                    mediaRecorder = new MediaRecorder(stream);
                    
                    mediaRecorder.addEventListener('dataavailable', event => {
                        audioChunks.push(event.data);
                    });
                    
                    mediaRecorder.addEventListener('stop', () => {
                        // Clear timer
                        clearInterval(timerInterval);
                        
                        // Create audio blob
                        audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
                        audioUrl = URL.createObjectURL(audioBlob);
                        
                        // Display the recorded audio
                        recordedAudio.src = audioUrl;
                        recordedAudioContainer.classList.remove('d-none');
                        
                        // Convert to base64 for form submission
                        const reader = new FileReader();
                        reader.readAsDataURL(audioBlob);
                        reader.onloadend = function() {
                            const base64data = reader.result;
                            recordedAudioDataInput.value = base64data;
                        };
                    });
                    
                    // Start recording
                    mediaRecorder.start();
                    startTime = Date.now();
                    timerInterval = setInterval(updateTimer, 1000);
                    
                    // Update UI
                    recordButton.innerHTML = '<i class="bi bi-stop-fill fs-4"></i>';
                    recordButton.classList.add('recording');
                    recordingStatus.textContent = 'Recording in progress...';
                })
                .catch(error => {
                    console.error('Error accessing microphone:', error);
                    recordingStatus.textContent = 'Error: Could not access microphone';
                });
        } else {
            // Stop recording
            mediaRecorder.stop();
            mediaRecorder.stream.getTracks().forEach(track => track.stop());
            
            // Update UI
            recordButton.innerHTML = '<i class="bi bi-mic fs-4"></i>';
            recordButton.classList.remove('recording');
            recordingStatus.textContent = 'Recording completed';
        }
    });
    
    // Discard recording
    discardRecording.addEventListener('click', function() {
        // Reset recording
        if (audioUrl) {
            URL.revokeObjectURL(audioUrl);
        }
        
        recordedAudioContainer.classList.add('d-none');
        recordedAudio.src = '';
        recordedAudioDataInput.value = '';
        recordingStatus.textContent = 'Click to start recording';
        recordingTimer.textContent = '00:00';
    });
    
    // Save recording (just keeps it visible for submission)
    saveRecording.addEventListener('click', function() {
        // This will keep the current recording and make sure the data is in the hidden input
        // We'll add a confirmation message
        recordingStatus.textContent = 'Recording ready for submission';
    });
    
    // Handle file upload preview
    audioFileInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            
            // Clear any recorded audio if we're uploading instead
            recordedAudioDataInput.value = '';
            
            // Show preview
            audioPreview.src = URL.createObjectURL(file);
            uploadedAudioPreview.classList.remove('d-none');
        }
    });
    
    // Form submission validation
    document.querySelector('form').addEventListener('submit', function(event) {
        // Check if we have either an uploaded file or a recorded audio
        const hasUploadedFile = audioFileInput.files && audioFileInput.files.length > 0;
        const hasRecordedAudio = recordedAudioDataInput.value !== '';
        
        // If we're on the audio tab and have neither, prevent submission
        const audioTabActive = document.querySelector('.card-title').textContent.includes('Audio');
        
        if (audioTabActive && !hasUploadedFile && !hasRecordedAudio) {
            event.preventDefault();
            alert('Please upload an audio file or record audio before submitting.');
        }
    });
});
</script>
@endpush