@extends('layouts.seo')
@section('seo-content')
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">SEO</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('seo.dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('seo.pages.index') }}">Pages</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit {{ $page->title }}</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a href="{{ route('seo.pages.show', $page) }}" class="btn btn-outline-info me-2">
                <i class="bx bx-show"></i> Preview
            </a>
            <a href="{{ route('seo.pages.index') }}" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back"></i> Back to List
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('seo.pages.update', $page) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8">
                <!-- Main Content -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Page Content</h5>
                        <div class="d-flex gap-2 ms-auto">
                            <span class="badge bg-{{ $page->status == 'published' ? 'success' : ($page->status == 'draft' ? 'warning' : 'info') }}">
                                {{ ucfirst($page->status) }}
                            </span>
                            <span class="badge bg-light text-dark">
                                Last updated: {{ $page->updated_at->format('M d, Y H:i') }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Page Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ old('title', $page->title) }}" required>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">URL Slug</label>
                            <div class="input-group">
                                <span class="input-group-text">{{ url('/pages/') }}/</span>
                                <input type="text" class="form-control" id="slug" name="slug"
                                       value="{{ old('slug', $page->slug) }}" readonly>
                                <button class="btn btn-outline-secondary" type="button" onclick="editSlug()">
                                    <i class="bx bx-edit"></i>
                                </button>
                            </div>
                            <small class="text-muted">Changing the slug may affect SEO and existing links</small>
                        </div>

                        <div class="mb-3">
                            <label for="excerpt" class="form-label">Excerpt</label>
                            <textarea class="form-control" id="excerpt" name="excerpt" rows="3">{{ old('excerpt', $page->excerpt) }}</textarea>
                            <small class="text-muted">Brief description of the page content</small>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Content *</label>
                            <textarea class="form-control @error('content') is-invalid @enderror"
                                      id="content" name="content" rows="15" required>{{ old('content', $page->content) }}</textarea>
                            @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="featured_image" class="form-label">Featured Image</label>
                                <input type="file" class="form-control @error('featured_image') is-invalid @enderror"
                                       id="featured_image" name="featured_image" accept="image/*">
                                @error('featured_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($page->featured_image)
                                <div class="mt-2">
                                    <img src="{{ Storage::url($page->featured_image) }}" alt="Current featured image"
                                         class="img-thumbnail" style="max-width: 200px;">
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" name="remove_featured_image" id="remove_featured_image">
                                        <label class="form-check-label" for="remove_featured_image">
                                            Remove current image
                                        </label>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Content Statistics</label>
                                <div class="border rounded p-3 bg-light">
                                    <div class="row text-center">
                                        <div class="col-4">
                                            <div class="text-primary h5 mb-0" id="word-count">{{ str_word_count(strip_tags($page->content)) }}</div>
                                            <small class="text-muted">Words</small>
                                        </div>
                                        <div class="col-4">
                                            <div class="text-success h5 mb-0" id="char-count">{{ strlen(strip_tags($page->content)) }}</div>
                                            <small class="text-muted">Characters</small>
                                        </div>
                                        <div class="col-4">
                                            <div class="text-info h5 mb-0" id="reading-time">{{ ceil(str_word_count(strip_tags($page->content)) / 200) }}</div>
                                            <small class="text-muted">Min read</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEO Settings -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">SEO Settings</h5>
                        <div class="ms-auto">
                            <span class="badge bg-{{ $page->seo_score >= 80 ? 'success' : ($page->seo_score >= 60 ? 'warning' : 'danger') }}">
                                SEO Score: {{ $page->seo_score }}%
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="focus_keyword" class="form-label">Focus Keyword</label>
                            <input type="text" class="form-control" id="focus_keyword" name="focus_keyword"
                                   value="{{ old('focus_keyword', $page->focus_keyword) }}"
                                   placeholder="Enter your target keyword">
                            <small class="text-muted">The main keyword you want this page to rank for</small>
                        </div>

                        <div class="mb-3">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                                   id="meta_title" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}" maxlength="60">
                            <div class="form-text">
                                <span id="meta-title-length">{{ strlen($page->meta_title ?? '') }}</span>/60 characters
                                <span id="title-status" class="ms-2"></span>
                            </div>
                            @error('meta_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                      id="meta_description" name="meta_description" rows="3" maxlength="160">{{ old('meta_description', $page->meta_description) }}</textarea>
                            <div class="form-text">
                                <span id="meta-desc-length">{{ strlen($page->meta_description ?? '') }}</span>/160 characters
                                <span id="desc-status" class="ms-2"></span>
                            </div>
                            @error('meta_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                                   value="{{ old('meta_keywords', $page->meta_keywords) }}"
                                   placeholder="keyword1, keyword2, keyword3">
                            <small class="text-muted">Separate keywords with commas</small>
                        </div>

                        <div class="mb-3">
                            <label for="canonical_url" class="form-label">Canonical URL</label>
                            <input type="url" class="form-control" id="canonical_url" name="canonical_url"
                                   value="{{ old('canonical_url', $page->canonical_url) }}"
                                   placeholder="https://example.com/page-url">
                        </div>
                    </div>
                </div>

                <!-- Social Media Settings -->
                <div class="card d-none">
                    <div class="card-header">
                        <h5 class="card-title">Social Media</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Open Graph (Facebook)</h6>
                                <div class="mb-3">
                                    <label for="og_title" class="form-label">OG Title</label>
                                    <input type="text" class="form-control" id="og_title" name="og_title"
                                           value="{{ old('og_title', $page->og_title) }}">
                                </div>
                                <div class="mb-3">
                                    <label for="og_description" class="form-label">OG Description</label>
                                    <textarea class="form-control" id="og_description" name="og_description"
                                              rows="2">{{ old('og_description', $page->og_description) }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="og_image" class="form-label">OG Image URL</label>
                                    <input type="url" class="form-control" id="og_image" name="og_image"
                                           value="{{ old('og_image', $page->og_image) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6>Twitter Cards</h6>
                                <div class="mb-3">
                                    <label for="twitter_title" class="form-label">Twitter Title</label>
                                    <input type="text" class="form-control" id="twitter_title" name="twitter_title"
                                           value="{{ old('twitter_title', $page->twitter_title) }}">
                                </div>
                                <div class="mb-3">
                                    <label for="twitter_description" class="form-label">Twitter Description</label>
                                    <textarea class="form-control" id="twitter_description" name="twitter_description"
                                              rows="2">{{ old('twitter_description', $page->twitter_description) }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="twitter_image" class="form-label">Twitter Image URL</label>
                                    <input type="url" class="form-control" id="twitter_image" name="twitter_image"
                                           value="{{ old('twitter_image', $page->twitter_image) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Schema Markup -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Schema Markup</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="schema_markup" class="form-label">JSON-LD Schema</label>
                            <textarea class="form-control" id="schema_markup" name="schema_markup"
                                      rows="8" placeholder='{"@context": "https://schema.org", "@type": "WebPage"}'>{{ old('schema_markup', json_encode($page->schema_markup, JSON_PRETTY_PRINT)) }}</textarea>
                            <div class="d-flex justify-content-between mt-2">
                                <small class="text-muted">Add structured data to help search engines understand your content</small>
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="validateSchema()">
                                    <i class="bx bx-check"></i> Validate Schema
                                </button>
                            </div>
                            <div id="schema-validation-result" class="mt-2"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Publishing Options -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Publish</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="draft" {{ old('status', $page->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status', $page->status) == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="scheduled" {{ old('status', $page->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            </select>
                        </div>

                        <div class="mb-3" id="publish-date-field" style="{{ old('status', $page->status) == 'scheduled' ? '' : 'display: none;' }}">
                            <label for="publish_date" class="form-label">Publish Date</label>
                            <input type="datetime-local" class="form-control" id="publish_date" name="publish_date"
                                   value="{{ old('publish_date', $page->publish_date ? $page->publish_date->format('Y-m-d\TH:i') : '') }}">
                        </div>

                        <div class="mb-3">
                            <small class="text-muted">
                                <strong>Created:</strong> {{ $page->created_at->format('M d, Y H:i') }}<br>
                                <strong>Last Modified:</strong> {{ $page->updated_at->format('M d, Y H:i') }}<br>
                                <strong>Author:</strong> {{ $page->creator->name }}
                            </small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save"></i> Update Page
                            </button>
                            <a href="{{ route('seo.pages.show', $page) }}" class="btn btn-outline-info">
                                <i class="bx bx-show"></i> Preview Changes
                            </a>
                            <a href="{{ route('seo.pages.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>

                <!-- SEO Preview -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Search Preview</h5>
                    </div>
                    <div class="card-body">
                        <div id="seo-preview" class="border rounded p-3 bg-light">
                            <div class="text-primary text-decoration-none" id="preview-title">{{ $page->meta_title ?: $page->title }}</div>
                            <div class="text-success small" id="preview-url">{{ url('/pages/' . $page->slug) }}</div>
                            <div class="text-muted small mt-1" id="preview-description">{{ $page->meta_description ?: Str::limit(strip_tags($page->content), 155) }}</div>
                        </div>
                    </div>
                </div>

                <!-- SEO Analysis -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">SEO Analysis</h5>
                    </div>
                    <div class="card-body">
                        <div id="seo-analysis">
                            <div class="mb-3">
                                <small class="text-muted">Overall SEO Score:</small>
                                <div class="progress">
                                    <div class="progress-bar bg-{{ $page->seo_score >= 80 ? 'success' : ($page->seo_score >= 60 ? 'warning' : 'danger') }}"
                                         style="width: {{ $page->seo_score }}%">{{ $page->seo_score }}%</div>
                                </div>
                            </div>

                            <div class="mb-2">
                                <small class="text-muted">Title Length:</small>
                                <div class="progress progress-sm">
                                    <div class="progress-bar" id="title-progress"></div>
                                </div>
                                <small id="title-analysis" class="text-muted"></small>
                            </div>

                            <div class="mb-2">
                                <small class="text-muted">Description Length:</small>
                                <div class="progress progress-sm">
                                    <div class="progress-bar" id="desc-progress"></div>
                                </div>
                                <small id="desc-analysis" class="text-muted"></small>
                            </div>

                            <div class="mb-2">
                                <small class="text-muted">Focus Keyword:</small>
                                <span id="keyword-status" class="badge bg-{{ $page->focus_keyword ? 'primary' : 'secondary' }}">
                                    {{ $page->focus_keyword ?: 'Not set' }}
                                </span>
                            </div>

                            <div class="mb-2">
                                <small class="text-muted">Readability Score:</small>
                                <span class="badge bg-{{ $page->readability_score >= 60 ? 'success' : ($page->readability_score >= 30 ? 'warning' : 'danger') }}">
                                    {{ $page->readability_score ?: 0 }}/100
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <form method="POST" action="{{ route('seo.pages.duplicate', $page) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary w-100">
                                    <i class="bx bx-copy"></i> Duplicate Page
                                </button>
                            </form>

                            @if($page->status == 'published')
                            <a href="{{ url('/' . $page->slug) }}" target="_blank" class="btn btn-outline-success d-none">
                                <i class="bx bx-link-external"></i> View Live Page
                            </a>
                            @endif

                            <button type="button" class="btn btn-outline-info d-none" onclick="generateSeoReport()">
                                <i class="bx bx-line-chart"></i> SEO Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Character counters and analysis
    const metaTitle = document.getElementById('meta_title');
    const metaDesc = document.getElementById('meta_description');
    const content = document.getElementById('content');

    // Initialize analysis
    updateSeoAnalysis();
    updateContentStats();

    metaTitle.addEventListener('input', function() {
        document.getElementById('meta-title-length').textContent = this.value.length;
        updateSeoPreview();
        updateSeoAnalysis();
    });

    metaDesc.addEventListener('input', function() {
        document.getElementById('meta-desc-length').textContent = this.value.length;
        updateSeoPreview();
        updateSeoAnalysis();
    });

    content.addEventListener('input', function() {
        updateContentStats();
    });

    function updateSeoPreview() {
        const title = metaTitle.value || document.getElementById('title').value;
        const description = metaDesc.value || 'Your meta description will appear here.';

        document.getElementById('preview-title').textContent = title;
        document.getElementById('preview-description').textContent = description;
    }

    function updateSeoAnalysis() {
        const titleLen = metaTitle.value.length;
        const descLen = metaDesc.value.length;

        // Title analysis
        const titleProgress = document.getElementById('title-progress');
        const titleAnalysis = document.getElementById('title-analysis');

        if (titleLen === 0) {
            titleProgress.style.width = '0%';
            titleProgress.className = 'progress-bar bg-secondary';
            titleAnalysis.textContent = 'Add a title';
            titleAnalysis.className = 'text-secondary';
        } else if (titleLen < 30) {
            titleProgress.style.width = '50%';
            titleProgress.className = 'progress-bar bg-warning';
            titleAnalysis.textContent = 'Too short';
            titleAnalysis.className = 'text-warning';
        } else if (titleLen <= 60) {
            titleProgress.style.width = '100%';
            titleProgress.className = 'progress-bar bg-success';
            titleAnalysis.textContent = 'Good length';
            titleAnalysis.className = 'text-success';
        } else {
            titleProgress.style.width = '100%';
            titleProgress.className = 'progress-bar bg-danger';
            titleAnalysis.textContent = 'Too long';
            titleAnalysis.className = 'text-danger';
        }

        // Description analysis
        const descProgress = document.getElementById('desc-progress');
        const descAnalysis = document.getElementById('desc-analysis');

        if (descLen === 0) {
            descProgress.style.width = '0%';
            descProgress.className = 'progress-bar bg-secondary';
            descAnalysis.textContent = 'Add a description';
            descAnalysis.className = 'text-secondary';
        } else if (descLen < 120) {
            descProgress.style.width = '60%';
            descProgress.className = 'progress-bar bg-warning';
            descAnalysis.textContent = 'Too short';
            descAnalysis.className = 'text-warning';
        } else if (descLen <= 160) {
            descProgress.style.width = '100%';
            descProgress.className = 'progress-bar bg-success';
            descAnalysis.textContent = 'Good length';
            descAnalysis.className = 'text-success';
        } else {
            descProgress.style.width = '100%';
            descProgress.className = 'progress-bar bg-danger';
            descAnalysis.textContent = 'Too long';
            descAnalysis.className = 'text-danger';
        }
    }

    function updateContentStats() {
        const text = content.value.replace(/<[^>]*>/g, ''); // Strip HTML
        const wordCount = text.trim() ? text.trim().split(/\s+/).length : 0;
        const charCount = text.length;
        const readingTime = Math.ceil(wordCount / 200);

        document.getElementById('word-count').textContent = wordCount;
        document.getElementById('char-count').textContent = charCount;
        document.getElementById('reading-time').textContent = readingTime;
    }

    // Status change handler
    document.getElementById('status').addEventListener('change', function() {
        const publishDateField = document.getElementById('publish-date-field');
        if (this.value === 'scheduled') {
            publishDateField.style.display = 'block';
        } else {
            publishDateField.style.display = 'none';
        }
    });

    // Focus keyword tracking
    document.getElementById('focus_keyword').addEventListener('input', function() {
        const keywordStatus = document.getElementById('keyword-status');
        if (this.value) {
            keywordStatus.textContent = this.value;
            keywordStatus.className = 'badge bg-primary';
        } else {
            keywordStatus.textContent = 'Not set';
            keywordStatus.className = 'badge bg-secondary';
        }
    });
});

function editSlug() {
    const slugInput = document.getElementById('slug');
    if (slugInput.readOnly) {
        slugInput.readOnly = false;
        slugInput.focus();
        slugInput.select();
    } else {
        slugInput.readOnly = true;
    }
}

function validateSchema() {
    const schemaInput = document.getElementById('schema_markup');
    const resultDiv = document.getElementById('schema-validation-result');

    try {
        if (schemaInput.value.trim()) {
            JSON.parse(schemaInput.value);
            resultDiv.innerHTML = '<div class="alert alert-success alert-sm mb-0"><i class="bx bx-check"></i> Valid JSON Schema</div>';
        } else {
            resultDiv.innerHTML = '';
        }
    } catch (e) {
        resultDiv.innerHTML = '<div class="alert alert-danger alert-sm mb-0"><i class="bx bx-x"></i> Invalid JSON: ' + e.message + '</div>';
    }
}

function generateSeoReport() {
    // This would typically make an AJAX call to generate a detailed SEO report
    alert('SEO Report generation would be implemented here');
}
</script>
@endsection
