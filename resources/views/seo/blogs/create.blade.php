@extends('layouts.seo')

@section('seo-content')
<link rel="stylesheet" href="https://cdn.quilljs.com/1.3.6/quill.snow.css">

<div class="page-content">
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">SEO</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('seo.dashboard') }}">
                            <i class="bx bx-home-alt"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('seo.blogs.index') }}">Blogs</a>
                    </li>
                    <li class="breadcrumb-item active">Create New Blog</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bx bx-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Error Message -->
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bx bx-error-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Validation Errors -->
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h6 class="mb-2"><i class="bx bx-error-circle me-2"></i>Validation Errors:</h6>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Main Form -->
    <form action="{{ route('seo.blogs.store') }}" method="POST" enctype="multipart/form-data" id="blog-form">
        @csrf

        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8">

                <!-- Blog Content Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-edit me-2"></i>Blog Content
                        </h5>
                    </div>
                    <div class="card-body">
                        
                        <!-- Title Field -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ old('title') }}"
                                   placeholder="Enter blog title" maxlength="255">
                            <small class="form-text text-muted">
                                <span id="title-char">0</span>/60 characters
                            </small>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Slug Field -->
                        <div class="mb-3">
                            <label for="slug" class="form-label">URL Slug</label>
                            <div class="input-group">
                                <span class="input-group-text">{{ url('/blog') }}/</span>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                       id="slug" name="slug" value="{{ old('slug') }}"
                                       placeholder="auto-generated">
                            </div>
                            <small class="form-text text-muted">Leave blank to auto-generate</small>
                            @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Content Editor -->
                        <div class="mb-3">
                            <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                            <div id="editor" style="height: 400px; background: white;"></div>
                            <input type="hidden" id="content" name="content" value="{{ old('content') }}">
                            <small class="form-text text-muted d-block mt-2">
                                Words: <strong id="word-count">0</strong> | 
                                Reading Time: <strong id="read-time">0</strong> min
                            </small>
                            @error('content')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Excerpt Field -->
                        <div class="mb-3">
                            <label for="excerpt" class="form-label">Excerpt</label>
                            <textarea class="form-control @error('excerpt') is-invalid @enderror"
                                      id="excerpt" name="excerpt" rows="3" maxlength="500"
                                      placeholder="Brief summary of your post">{{ old('excerpt') }}</textarea>
                            <small class="form-text text-muted">
                                <span id="excerpt-char">0</span>/500 characters
                            </small>
                            @error('excerpt')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                <!-- SEO Optimization Card -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-search-alt me-2"></i>SEO Optimization
                        </h5>
                        <span class="badge bg-secondary" id="seo-score">Score: 0%</span>
                    </div>
                    <div class="card-body">

                        <!-- Focus Keyword -->
                        <div class="mb-3">
                            <label for="focus_keyword" class="form-label">Focus Keyword</label>
                            <input type="text" class="form-control @error('focus_keyword') is-invalid @enderror"
                                   id="focus_keyword" name="focus_keyword" value="{{ old('focus_keyword') }}"
                                   placeholder="Main keyword for SEO">
                            @error('focus_keyword')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Meta Title -->
                        <div class="mb-3">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                                   id="meta_title" name="meta_title" value="{{ old('meta_title') }}"
                                   maxlength="60" placeholder="SEO title for search engines">
                            <small class="form-text text-muted">
                                <span id="meta-char">0</span>/60 characters
                            </small>
                            @error('meta_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Meta Description -->
                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                      id="meta_description" name="meta_description" rows="3" 
                                      maxlength="160" placeholder="Description for search results">{{ old('meta_description') }}</textarea>
                            <small class="form-text text-muted">
                                <span id="desc-char">0</span>/160 characters
                            </small>
                            @error('meta_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Indexing -->
                        <div class="mb-3">
                            <label for="is_indexed" class="form-label">Search Engine Indexing</label>
                            <select class="form-select @error('is_indexed') is-invalid @enderror" 
                                    id="is_indexed" name="is_indexed">
                                <option value="1" {{ old('is_indexed', 1) == 1 ? 'selected' : '' }}>Index</option>
                                <option value="0" {{ old('is_indexed') == '0' ? 'selected' : '' }}>Noindex</option>
                            </select>
                            @error('is_indexed')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Canonical URL -->
                        <div class="mb-3">
                            <label for="canonical_url" class="form-label">Canonical URL</label>
                            <input type="url" class="form-control @error('canonical_url') is-invalid @enderror"
                                   id="canonical_url" name="canonical_url" value="{{ old('canonical_url') }}"
                                   placeholder="https://example.com/blog/post">
                            <small class="form-text text-muted">Leave blank to use default</small>
                            @error('canonical_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                <!-- Schema Markup Card -->
                <div class="card mb-4">
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
                                      placeholder="Auto-generated schema will appear here">{{ old('schema_markup') }}</textarea>
                            @error('schema_markup')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="generate-schema">
                            <i class="bx bx-magic-wand me-1"></i>Auto Generate Schema
                        </button>
                    </div>
                </div>

            </div>

            <!-- Right Sidebar -->
            <div class="col-lg-4">

                <!-- Publish Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="card-title mb-0">
                            <i class="bx bx-send me-2"></i>Publish Settings
                        </h6>
                    </div>
                    <div class="card-body">

                        <!-- Status -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status">
                                <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publish Now</option>
                                <option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : '' }}>Schedule</option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Publish Date (hidden by default) -->
                        <div class="mb-3 d-none" id="publish-date-group">
                            <label for="published_at" class="form-label">Publish Date</label>
                            <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror"
                                   id="published_at" name="published_at" value="{{ old('published_at') }}">
                            @error('published_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Featured Post -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" 
                                       id="is_featured" name="is_featured" value="1" 
                                       {{ old('is_featured') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">Featured Post</label>
                            </div>
                            <small class="form-text text-muted">Display on homepage</small>
                        </div>

                        <!-- LinkedIn Publishing -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="hidden" name="publish_to_linkedin" value="0">
                                <input type="checkbox" class="form-check-input" 
                                       id="publish_to_linkedin" name="publish_to_linkedin" value="1"
                                       {{ old('publish_to_linkedin') ? 'checked' : '' }}>
                                <label class="form-check-label" for="publish_to_linkedin">
                                    <i class="fab fa-linkedin me-1"></i>Publish to LinkedIn
                                </label>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bx bx-save me-1"></i>Create Blog
                            </button>
                            <a href="{{ route('seo.blogs.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-x me-1"></i>Cancel
                            </a>
                        </div>

                    </div>
                </div>

                <!-- Featured Image Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="card-title mb-0">
                            <i class="bx bx-image me-2"></i>Featured Image
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <input type="file" class="form-control @error('featured_image') is-invalid @enderror"
                                   id="featured_image" name="featured_image" accept="image/*">
                            <small class="form-text text-muted">1200x800px recommended, Max 2MB</small>
                            @error('featured_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Image Preview -->
                        <div id="preview-container" class="text-center d-none mb-3">
                            <img id="preview-image" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                        </div>

                        <!-- Alt Text -->
                        <div class="mb-3">
                            <label for="featured_image_alt" class="form-label">Image Alt Text</label>
                            <input type="text" class="form-control @error('featured_image_alt') is-invalid @enderror"
                                   id="featured_image_alt" name="featured_image_alt" 
                                   value="{{ old('featured_image_alt') }}"
                                   placeholder="Description for accessibility">
                            @error('featured_image_alt')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Category & Tags Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="card-title mb-0">
                            <i class="bx bx-category me-2"></i>Organization
                        </h6>
                    </div>
                    <div class="card-body">

                        <!-- Category -->
                        <div class="mb-3">
                            <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select @error('category') is-invalid @enderror" 
                                    id="category" name="category" required>
                                <option value="">Select a Category</option>
                                @if(isset($categories))
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tags -->
                        <div class="mb-3">
                            <label for="tags" class="form-label">Tags</label>
                            <input type="text" class="form-control @error('tags') is-invalid @enderror"
                                   id="tags" name="tags" value="{{ old('tags') }}"
                                   placeholder="Separate tags with commas">
                            <small class="form-text text-muted">E.g. Laravel, PHP, Web Development</small>
                            @error('tags')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                <!-- SEO Preview Card -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">
                            <i class="bx bx-search me-2"></i>Search Preview
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="border rounded p-3" style="background: #f8f9fa;">
                            <div class="text-success small mb-1" id="preview-url">
                                example.com/blog/your-slug
                            </div>
                            <h6 class="text-primary mb-1" id="preview-title" style="font-size: 16px;">
                                Your Blog Title
                            </h6>
                            <p class="text-muted small mb-0" id="preview-desc">
                                Your meta description will appear here...
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </form>

</div>

<!-- Quill Editor Library -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<!-- External JS File -->
<script src="{{ asset('assets/js/blog-create.js') }}"></script>

@endsection