@extends('layouts.seo')
@section('seo-content')
     <div class="page-content">
        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">SEO</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('seo.dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('seo.blogs.index') }}">Blogs</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit: {{ Str::limit($blog->title, 30) }}</li>
                    </ol>
                </nav>
            </div>
        </div>
         <!-- Display Session Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bx bx-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bx bx-error-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Display All Validation Errors -->
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h6 class="mb-2"><i class="bx bx-error-circle me-2"></i>Please fix the following errors:</h6>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('seo.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data" id="blog-form">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <!-- Basic Information -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="bx bx-edit me-2"></i>Blog Content
                            </h5>
                            <div class="d-flex gap-2">
                                <span class="badge bg-{{ $blog->status == 'published' ? 'success' : ($blog->status == 'draft' ? 'secondary' : 'warning') }}">
                                    {{ ucfirst($blog->status) }}
                                </span>
                                @if($blog->seo_score > 0)
                                <span class="badge bg-{{ $blog->seo_score >= 80 ? 'success' : ($blog->seo_score >= 60 ? 'warning' : 'danger') }}">
                                    SEO: {{ $blog->seo_score }}%
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Title -->
                            <div class="mb-3">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                       id="title" name="title" value="{{ old('title', $blog->title) }}"
                                       placeholder="Enter blog title..." maxlength="255">
                                <div class="form-text">
                                    <span id="title-count">{{ strlen($blog->title) }}</span>/60 characters (recommended for SEO)
                                </div>
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Slug -->
                            <div class="mb-3">
                                <label for="slug" class="form-label">URL Slug</label>
                                <div class="input-group">
                                    <span class="input-group-text">{{ url('/') }}/</span>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                           id="slug" name="slug" value="{{ old('slug', $blog->slug) }}">
                                </div>
                                @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Content Editor -->
                            <div class="mb-3">
                                <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('content') is-invalid @enderror"
                                          id="content" name="content" rows="15">{{ old('content', $blog->content) }}</textarea>
                                <div class="form-text">
                                    Word count: <span id="word-count">0</span> |
                                    Reading time: <span id="reading-time">{{ $blog->reading_time ?? 0 }}</span> minutes
                                </div>
                                @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Excerpt -->
                            <div class="mb-3">
                                <label for="excerpt" class="form-label">Excerpt</label>
                                <textarea class="form-control @error('excerpt') is-invalid @enderror"
                                          id="excerpt" name="excerpt" rows="3" maxlength="500"
                                          placeholder="Brief description of the blog post...">{{ old('excerpt', $blog->excerpt) }}</textarea>
                                <div class="form-text">
                                    <span id="excerpt-count">{{ strlen($blog->excerpt ?? '') }}</span>/500 characters
                                </div>
                                @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- SEO Optimization -->
                    <div class="card mt-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="bx bx-search-alt me-2"></i>SEO Optimization
                            </h5>
                            <div class="d-flex gap-2">
                                <div class="seo-score-badge">
                                    <span class="badge bg-{{ isset($seoData['score']) && $seoData['score'] >= 80 ? 'success' : (isset($seoData['score']) && $seoData['score'] >= 60 ? 'warning' : 'danger') }}" id="seo-score">
                                        Score: {{ $seoData['score'] ?? $blog->seo_score ?? 0 }}%
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Focus Keyword -->
                            <div class="mb-3">
                                <label for="focus_keyword" class="form-label">Focus Keyword</label>
                                <input type="text" class="form-control @error('focus_keyword') is-invalid @enderror"
                                       id="focus_keyword" name="focus_keyword" value="{{ old('focus_keyword', $blog->focus_keyword) }}"
                                       placeholder="Primary keyword for this blog post">
                                <div class="form-text">Main keyword you want to rank for</div>
                                @error('focus_keyword')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Meta Title -->
                            <div class="mb-3">
                                <label for="meta_title" class="form-label">Meta Title</label>
                                <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                                       id="meta_title" name="meta_title" value="{{ old('meta_title', $blog->meta_title) }}"
                                       maxlength="60" placeholder="SEO optimized title for search engines">
                                <div class="form-text">
                                    <span id="meta-title-count">{{ strlen($blog->meta_title ?? '') }}</span>/60 characters
                                </div>
                                @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Meta Description -->
                            <div class="mb-3">
                                <label for="meta_description" class="form-label">Meta Description</label>
                                <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                          id="meta_description" name="meta_description" rows="3" maxlength="160"
                                          placeholder="Compelling description for search engine results">{{ old('meta_description', $blog->meta_description) }}</textarea>
                                <div class="form-text">
                                    <span id="meta-desc-count">{{ strlen($blog->meta_description ?? '') }}</span>/160 characters
                                </div>
                                @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Indexing Option -->
                            <div class="mb-3">
                                <label for="is_indexed" class="form-label">Search Engine Indexing</label>
                                <select class="form-select @error('is_indexed') is-invalid @enderror" id="is_indexed" name="is_indexed">
                                    <option value="1" {{ old('is_indexed', $blog->is_indexed) == 1 ? 'selected' : '' }}>Index</option>
                                    <option value="0" {{ old('is_indexed', $blog->is_indexed) == 0 ? 'selected' : '' }}>Noindex</option>
                                </select>
                                <div class="form-text">Choose whether search engines should index this page.</div>
                                @error('is_indexed')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Featured Post -->
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $blog->is_featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">
                                        Featured Post
                                    </label>
                                </div>
                                <div class="form-text">Mark as featured post for homepage</div>
                            </div>

                            <!-- Canonical URL -->
                            <div class="mb-3">
                                <label for="canonical_url" class="form-label">Canonical URL</label>
                                <input type="url" class="form-control @error('canonical_url') is-invalid @enderror"
                                       id="canonical_url" name="canonical_url" value="{{ old('canonical_url', $blog->canonical_url) }}"
                                       placeholder="https://example.com/blog/post-url">
                                <div class="form-text">Leave blank to use default URL</div>
                                @error('canonical_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Real-time SEO Analysis -->
                            <div id="seo-analysis" class="mt-4">
                                <h6>Real-time SEO Analysis</h6>
                                <div id="seo-recommendations"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Schema Markup -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="bx bx-code-alt me-2"></i>Schema Markup
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="schema_markup" class="form-label">JSON-LD Schema</label>
                                <textarea class="form-control @error('schema_markup') is-invalid @enderror"
                                          id="schema_markup" name="schema_markup" rows="8"
                                          placeholder='{"@context": "https://schema.org", "@type": "BlogPosting", ...}'>{{ old('schema_markup', is_array($blog->schema_markup) ? json_encode($blog->schema_markup, JSON_PRETTY_PRINT) : $blog->schema_markup) }}</textarea>
                                <div class="form-text">Add structured data markup for rich snippets</div>
                                @error('schema_markup')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="generate-schema">
                                    <i class="bx bx-magic-wand me-1"></i>Auto Generate Schema
                                </button>
                                <button type="button" class="btn btn-outline-info btn-sm" id="validate-schema">
                                    <i class="bx bx-check-circle me-1"></i>Validate Schema
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Publish -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="bx bx-send me-2"></i>Update & Publish
                            </h6>
                        </div>
                        <div class="card-body">
                            <!-- Status -->
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                    <option value="draft" {{ old('status', $blog->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('status', $blog->status) == 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="scheduled" {{ old('status', $blog->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Publish Date -->
                            <div class="mb-3" id="publish-date-group" style="{{ old('status', $blog->status) == 'scheduled' ? '' : 'display: none;' }}">
                                <label for="published_at" class="form-label">Publish Date</label>
                                <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror"
                                       id="published_at" name="published_at"
                                       value="{{ old('published_at', $blog->publish_date ? $blog->publish_date->format('Y-m-d\TH:i') : '') }}">
                                @error('published_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Last Updated Info -->
                            <div class="mb-3">
                                <small class="text-muted">
                                    <strong>Created:</strong> {{ $blog->created_at->format('M d, Y \a\t h:i A') }}<br>
                                    <strong>Last Updated:</strong> {{ $blog->updated_at->format('M d, Y \a\t h:i A') }}
                                    @if($blog->publish_date)
                                    <br><strong>Published:</strong> {{ $blog->publish_date->format('M d, Y \a\t h:i A') }}
                                    @endif
                                </small>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-save me-1"></i>Update Blog
                                </button>
                                <a href="{{ route('seo.blogs.show', $blog->id) }}" class="btn btn-outline-info">
                                    <i class="bx bx-show me-1"></i>Preview
                                </a>
                                <a href="{{ route('seo.blogs.index') }}" class="btn btn-outline-secondary">
                                    <i class="bx bx-arrow-back me-1"></i>Back to List
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="bx bx-image me-2"></i>Featured Image
                            </h6>
                        </div>
                        <div class="card-body">
                            @if($blog->featured_image)
                            <div class="current-image mb-3">
                                <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="Current Featured Image"
                                     class="img-fluid rounded" style="max-height: 200px; width: 100%; object-fit: cover;">
                                <div class="form-text mt-2">Current featured image</div>
                            </div>
                            @endif
                            
                            <div class="mb-3">
                                <input type="file" class="form-control @error('featured_image') is-invalid @enderror"
                                       id="featured_image" name="featured_image" accept="image/*">
                                <div class="form-text">Recommended: 1200x800px, Max: 2MB {{ $blog->featured_image ? '(Upload new to replace)' : '' }}</div>
                                @error('featured_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Alt Text -->
                            <div class="mb-3">
                                <label for="featured_image_alt" class="form-label">Alt Text</label>
                                <input type="text" class="form-control @error('featured_image_alt') is-invalid @enderror"
                                       id="featured_image_alt" name="featured_image_alt" value="{{ old('featured_image_alt', $blog->featured_image_alt) }}"
                                       placeholder="Describe the image for accessibility">
                                @error('featured_image_alt')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div id="featured-preview" class="text-center" style="display: none;">
                                <img id="featured-img" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                                <div class="form-text mt-2">New image preview</div>
                            </div>
                        </div>
                    </div>

                    <!-- Categories & Tags -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="bx bx-category me-2"></i>Organization
                            </h6>
                        </div>
                        <div class="card-body">
                            <!-- Category -->
                            <div class="mb-3">
                                <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                        <option value="">Select Category</option>
                                        @if(isset($categories) && $categories->count() > 0)
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ old('category', $blog->category) == $cat->id ? 'selected' : '' }}>
                                                    {{ $cat->name }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option value="" disabled>No categories available</option>
                                        @endif
                                    </select>
                                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#newCategoryModal">
                                        <i class="bx bx-plus"></i>
                                    </button>
                                </div>
                                @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                
                                <!-- Current Category Display -->
                                @if($blog->category && $blog->category instanceof \App\Models\Category)
                                <div class="form-text">
                                    <strong>Current:</strong> {{ $blog->category->name }}
                                </div>
                                @endif
                            </div>

                            <!-- Tags -->
                            <div class="mb-3">
                                <label for="tags-input" class="form-label">Tags</label>
                                
                                <!-- Manual Tag Input -->
                                <div class="mb-2">
                                    <input type="text" class="form-control" id="tags-manual" 
                                           placeholder="Laravel, PHP, Tutorial..." 
                                           data-bs-toggle="tooltip" 
                                           title="Type tags separated by commas and press Enter">
                                    <div class="form-text">Type tags separated by commas and press Enter</div>
                                </div>

                                <!-- Hidden input for form submission -->
                                <input type="hidden" name="tags" id="tags-input" value="{{ old('tags', $blog->tags->pluck('name')->join(',')) }}">
                                
                                @error('tags')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                <!-- Selected Tags Display -->
                                <div class="mb-3">
                                    <label class="form-label">Selected Tags:</label>
                                    <div id="selected-tags" class="d-flex flex-wrap gap-2">
                                        <!-- Current tags will be loaded here -->
                                    </div>
                                </div>

                                <!-- Current Tags Display -->
                                @if($blog->tags && $blog->tags->count() > 0)
                                <div class="mb-3">
                                    <label class="form-label">Current Tags:</label>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($blog->tags as $tag)
                                            <span class="badge bg-primary">{{ $tag->name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                <!-- Suggested Tags -->
                                @if(isset($tags) && $tags->count() > 0)
                                <div class="mb-3">
                                    <label class="form-label">Suggested Tags:</label>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($tags->take(10) as $tag)
                                            <span class="badge bg-light text-dark tag-suggestion border" style="cursor: pointer;" data-tag="{{ $tag->name }}">
                                                {{ $tag->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- SEO Preview -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="bx bx-search me-2"></i>Search Preview
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="google-preview border rounded p-3">
                                <div class="google-url text-success small mb-1" id="preview-url">
                                    {{ url('/' . $blog->slug) }}
                                </div>
                                <h6 class="google-title text-primary mb-1" id="preview-title" style="cursor: pointer;">
                                    {{ $blog->meta_title ?: $blog->title }}
                                </h6>
                                <p class="google-description text-muted small mb-0" id="preview-description">
                                    {{ $blog->meta_description ?: Str::limit(strip_tags($blog->content), 160) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Blog Statistics -->
                    @if($blog->created_at)
                    <div class="card mt-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="bx bx-bar-chart me-2"></i>Blog Statistics
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="border-end">
                                        <h5 class="text-primary mb-1">{{ str_word_count(strip_tags($blog->content)) }}</h5>
                                        <p class="text-muted small mb-0">Words</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="border-end">
                                        <h5 class="text-info mb-1">{{ $blog->reading_time ?? 0 }}</h5>
                                        <p class="text-muted small mb-0">Min Read</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <h5 class="text-success mb-1">{{ $blog->views_count ?? 0 }}</h5>
                                    <p class="text-muted small mb-0">Views</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </form>
    </div>

<!-- New Category Modal -->
<div class="modal fade" id="newCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="new-category-name" class="form-label">Category Name</label>
                    <input type="text" class="form-control" id="new-category-name" placeholder="Enter category name">
                </div>
                <div class="mb-3">
                    <label for="new-category-description" class="form-label">Description (Optional)</label>
                    <textarea class="form-control" id="new-category-description" rows="3" placeholder="Category description"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="add-category">Add Category</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize CKEditor
    ClassicEditor
        .create(document.querySelector('#content'), {
            toolbar: [
                'heading', '|', 'bold', 'italic', 'underline', '|',
                'bulletedList', 'numberedList', '|',
                'link', 'blockQuote', '|',
                'undo', 'redo'
            ],
            removePlugins: ['CKFinderUploadAdapter', 'CKFinder']
        })
        .then(editor => {
            const wordCountElement = document.getElementById('word-count');
            const readingTimeElement = document.getElementById('reading-time');

            const updateStats = () => {
                const html = editor.getData();
                const text = html.replace(/<[^>]*>/g, ' ').replace(/\s+/g, ' ').trim();
                const wordCount = text.length > 0 ? text.split(' ').length : 0;
                const readingTime = Math.ceil(wordCount / 200);

                wordCountElement.textContent = wordCount;
                readingTimeElement.textContent = readingTime;
            };

            editor.model.document.on('change:data', updateStats);
            updateStats();
        })
        .catch(error => {
            console.error('Error initializing CKEditor:', error);
        });

    // Tags Management
    let selectedTags = [];

    // Load existing tags
    const existingTags = '{{ old("tags", $blog->tags->pluck("name")->join(",")) }}';
    if (existingTags) {
        selectedTags = existingTags.split(',').map(tag => tag.trim()).filter(tag => tag.length > 0);
    }

    function updateTagsDisplay() {
        const container = document.getElementById('selected-tags');
        const input = document.getElementById('tags-input');
        
        container.innerHTML = '';
        selectedTags.forEach((tag, index) => {
            const tagElement = document.createElement('span');
            tagElement.className = 'badge bg-primary d-flex align-items-center gap-1';
            tagElement.innerHTML = `
                ${tag}
                <button type="button" class="btn-close btn-close-white" style="font-size: 0.7em;" onclick="removeTag(${index})"></button>
            `;
            container.appendChild(tagElement);
        });
        
        input.value = selectedTags.join(',');
    }

    function addTag(tagName) {
        const trimmedTag = tagName.trim();
        if (trimmedTag && !selectedTags.includes(trimmedTag)) {
            selectedTags.push(trimmedTag);
            updateTagsDisplay();
        }
    }

    window.removeTag = function(index) {
        selectedTags.splice(index, 1);
        updateTagsDisplay();
    };

    // Manual tag input
    const tagsManualInput = document.getElementById('tags-manual');
    tagsManualInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const tags = this.value.split(',');
            tags.forEach(tag => addTag(tag));
            this.value = '';
        }
    });

    // Suggested tags click
    document.querySelectorAll('.tag-suggestion').forEach(badge => {
        badge.addEventListener('click', function() {
            addTag(this.dataset.tag);
            this.style.opacity = '0.5';
            this.style.pointerEvents = 'none';
        });
    });

    // Character counters
    function setupCharCounter(input, counter, max) {
        const inputElement = document.querySelector(input);
        const counterElement = document.querySelector(counter);
        
        if (inputElement && counterElement) {
            inputElement.addEventListener('input', function() {
                const length = this.value.length;
                counterElement.textContent = length;

                counterElement.className = '';
                if (length > max) {
                    counterElement.classList.add('text-danger');
                } else if (length > max * 0.8) {
                    counterElement.classList.add('text-warning');
                } else {
                    counterElement.classList.add('text-success');
                }
            });
        }
    }

    setupCharCounter('#title', '#title-count', 60);
    setupCharCounter('#meta_title', '#meta-title-count', 60);
    setupCharCounter('#meta_description', '#meta-desc-count', 160);
    setupCharCounter('#excerpt', '#excerpt-count', 500);

    // Auto-update SEO preview
    ['#title', '#meta_title', '#meta_description', '#slug', '#focus_keyword'].forEach(selector => {
        const element = document.querySelector(selector);
        if (element) {
            element.addEventListener('input', updateSeoPreview);
        }
    });

    function updateSeoPreview() {
        const title = document.getElementById('meta_title')?.value || document.getElementById('title')?.value || 'Your Blog Title';
        const description = document.getElementById('meta_description')?.value || document.getElementById('excerpt')?.value || 'Your meta description will appear here...';
        const slug = document.getElementById('slug')?.value || 'your-blog-title';

        const previewTitle = document.getElementById('preview-title');
        const previewDescription = document.getElementById('preview-description');
        const previewUrl = document.getElementById('preview-url');

        if (previewTitle) previewTitle.textContent = title;
        if (previewDescription) previewDescription.textContent = description;
        if (previewUrl) previewUrl.textContent = `{{ url('/') }}/${slug}`;

        // Trigger SEO analysis
        performSeoAnalysis();
    }

    // Featured image preview
    document.getElementById('featured_image').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('featured-preview');
                const img = document.getElementById('featured-img');
                img.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    // Status change handler
    document.getElementById('status').addEventListener('change', function() {
        const publishDateGroup = document.getElementById('publish-date-group');
        const publishedAtInput = document.getElementById('published_at');
        
        if (this.value === 'scheduled') {
            publishDateGroup.style.display = 'block';
            publishedAtInput.required = true;
        } else {
            publishDateGroup.style.display = 'none';
            publishedAtInput.required = false;
        }
    });

    // Add new category
    document.getElementById('add-category').addEventListener('click', function() {
        const categoryName = document.getElementById('new-category-name').value.trim();
        const categorySelect = document.getElementById('category');
        
        if (categoryName && categorySelect) {
            // In a real implementation, you'd want to send an AJAX request to create the category
            const option = document.createElement('option');
            option.value = categoryName;
            option.textContent = categoryName;
            option.selected = true;
            categorySelect.appendChild(option);
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('newCategoryModal'));
            modal.hide();
            
            // Clear form
            document.getElementById('new-category-name').value = '';
            document.getElementById('new-category-description').value = '';
        }
    });

    // Auto-generate schema markup
    document.getElementById('generate-schema').addEventListener('click', function() {
        const title = document.getElementById('title').value;
        const description = document.getElementById('meta_description').value || document.getElementById('excerpt').value;
        const publishDate = '{{ $blog->publish_date ? $blog->publish_date->toISOString() : $blog->created_at->toISOString() }}';
        const modifiedDate = new Date().toISOString();

        const schema = {
            "@context": "https://schema.org",
            "@type": "BlogPosting",
            "headline": title,
            "description": description,
            "author": {
                "@type": "Person",
                "name": "{{ auth('seo')->user()->name ?? 'Admin' }}"
            },
            "publisher": {
                "@type": "Organization",
                "name": "{{ config('app.name') }}",
                "logo": {
                    "@type": "ImageObject",
                    "url": "{{ asset('logo.png') }}"
                }
            },
            "datePublished": publishDate,
            "dateModified": modifiedDate,
            "mainEntityOfPage": {
                "@type": "WebPage",
                "@id": "{{ url('/' . $blog->slug) }}"
            }
        };

        @if($blog->featured_image)
        schema.image = "{{ asset('storage/' . $blog->featured_image) }}";
        @endif

        document.getElementById('schema_markup').value = JSON.stringify(schema, null, 2);
    });

    // Validate schema markup
    document.getElementById('validate-schema').addEventListener('click', function() {
        const schema = document.getElementById('schema_markup').value;
        if (!schema.trim()) {
            alert('Please enter schema markup to validate');
            return;
        }

        try {
            JSON.parse(schema);
            alert('Schema markup is valid JSON');
        } catch (e) {
            alert('Invalid JSON in schema markup: ' + e.message);
        }
    });

    // SEO Analysis
    function performSeoAnalysis() {
        const title = document.getElementById('title')?.value || '';
        const content = document.querySelector('#content')?.value || '';
        const metaDesc = document.getElementById('meta_description')?.value || '';
        const focusKeyword = document.getElementById('focus_keyword')?.value || '';

        let score = 0;
        let recommendations = [];

        // Title check (20 points)
        if (title.length >= 30 && title.length <= 60) {
            score += 20;
        } else if (title.length > 0) {
            score += 10;
            recommendations.push(`Title should be 30-60 characters (currently ${title.length})`);
        } else {
            recommendations.push('Add a title for your blog post');
        }

        // Meta description check (20 points)
        if (metaDesc.length >= 120 && metaDesc.length <= 160) {
            score += 20;
        } else if (metaDesc.length > 0) {
            score += 10;
            recommendations.push(`Meta description should be 120-160 characters (currently ${metaDesc.length})`);
        } else {
            recommendations.push('Add a meta description');
        }

        // Content length check (20 points)
        const text = content.replace(/<[^>]*>/g, '').trim();
        const wordCount = text.split(/\s+/).filter(word => word.length > 0).length;
        if (wordCount >= 300) {
            score += 20;
        } else if (wordCount > 0) {
            score += Math.round((wordCount / 300) * 20);
            recommendations.push(`Content should be at least 300 words (currently ${wordCount})`);
        } else {
            recommendations.push('Add content to your blog post');
        }

        // Focus keyword checks (40 points total)
        if (focusKeyword) {
            score += 10; // 10 points for having a focus keyword

            // Keyword in title (10 points)
            if (title.toLowerCase().includes(focusKeyword.toLowerCase())) {
                score += 10;
            } else {
                recommendations.push('Include focus keyword in title');
            }

            // Keyword in meta description (10 points)
            if (metaDesc.toLowerCase().includes(focusKeyword.toLowerCase())) {
                score += 10;
            } else {
                recommendations.push('Include focus keyword in meta description');
            }

            // Keyword in content (10 points)
            if (text.toLowerCase().includes(focusKeyword.toLowerCase())) {
                score += 10;
            } else {
                recommendations.push('Include focus keyword in content');
            }
        } else {
            recommendations.push('Add a focus keyword');
        }

        // Update score badge
        let badgeClass = 'bg-danger';
        if (score >= 80) badgeClass = 'bg-success';
        else if (score >= 60) badgeClass = 'bg-warning';

        const scoreElement = document.getElementById('seo-score');
        if (scoreElement) {
            scoreElement.className = scoreElement.className.replace(/bg-\w+/g, '') + ' ' + badgeClass;
            scoreElement.textContent = `Score: ${score}%`;
        }

        // Show recommendations
        const recommendationsContainer = document.getElementById('seo-recommendations');
        if (recommendationsContainer) {
            if (recommendations.length > 0) {
                let html = '<div class="alert alert-info"><strong>SEO Recommendations:</strong><ul class="mb-0 mt-2">';
                recommendations.forEach(rec => {
                    html += `<li>${rec}</li>`;
                });
                html += '</ul></div>';
                recommendationsContainer.innerHTML = html;
            } else {
                recommendationsContainer.innerHTML = '<div class="alert alert-success">Great! Your blog post follows SEO best practices.</div>';
            }
        }
    }

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Form submission with loading state
    document.getElementById('blog-form').addEventListener('submit', function() {
        const submitBtn = document.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i>Updating...';
        submitBtn.disabled = true;
    });

    // Initial setup
    updateTagsDisplay();
    updateSeoPreview();
    performSeoAnalysis();
});
</script>

@endsection