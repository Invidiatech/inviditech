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
                    <li class="breadcrumb-item active" aria-current="page">Create Page</li>
                </ol>
            </nav>
        </div>
    </div>

    <form method="POST" action="{{ route('seo.pages.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <!-- Main Content -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Page Content</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Page Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="excerpt" class="form-label">Excerpt</label>
                            <textarea class="form-control" id="excerpt" name="excerpt" rows="3">{{ old('excerpt') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Content *</label>
                            <textarea class="form-control @error('content') is-invalid @enderror"
                                      id="content" name="content" rows="15" required>{{ old('content') }}</textarea>
                            @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="featured_image" class="form-label">Featured Image</label>
                            <input type="file" class="form-control @error('featured_image') is-invalid @enderror"
                                   id="featured_image" name="featured_image" accept="image/*">
                            @error('featured_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- SEO Settings -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">SEO Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="focus_keyword" class="form-label">Focus Keyword</label>
                            <input type="text" class="form-control" id="focus_keyword" name="focus_keyword"
                                   value="{{ old('focus_keyword') }}" placeholder="Enter your target keyword">
                            <small class="text-muted">The main keyword you want this page to rank for</small>
                        </div>

                        <div class="mb-3">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                                   id="meta_title" name="meta_title" value="{{ old('meta_title') }}" maxlength="60">
                            <div class="form-text">
                                <span id="meta-title-length">0</span>/60 characters
                            </div>
                            @error('meta_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                      id="meta_description" name="meta_description" rows="3" maxlength="160">{{ old('meta_description') }}</textarea>
                            <div class="form-text">
                                <span id="meta-desc-length">0</span>/160 characters
                            </div>
                            @error('meta_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                                   value="{{ old('meta_keywords') }}" placeholder="keyword1, keyword2, keyword3">
                            <small class="text-muted">Separate keywords with commas</small>
                        </div>

                        <div class="mb-3">
                            <label for="canonical_url" class="form-label">Canonical URL</label>
                            <input type="url" class="form-control" id="canonical_url" name="canonical_url"
                                   value="{{ old('canonical_url') }}" placeholder="https://example.com/page-url">
                        </div>
                    </div>
                </div>

                <!-- Social Media Preview -->
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
                                    <input type="text" class="form-control" id="og_title" name="og_title" value="{{ old('og_title') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="og_description" class="form-label">OG Description</label>
                                    <textarea class="form-control" id="og_description" name="og_description" rows="2">{{ old('og_description') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6>Twitter Cards</h6>
                                <div class="mb-3">
                                    <label for="twitter_title" class="form-label">Twitter Title</label>
                                    <input type="text" class="form-control" id="twitter_title" name="twitter_title" value="{{ old('twitter_title') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="twitter_description" class="form-label">Twitter Description</label>
                                    <textarea class="form-control" id="twitter_description" name="twitter_description" rows="2">{{ old('twitter_description') }}</textarea>
                                </div>
                            </div>
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
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            </select>
                        </div>

                        <div class="mb-3" id="publish-date-field" style="display: none;">
                            <label for="publish_date" class="form-label">Publish Date</label>
                            <input type="datetime-local" class="form-control" id="publish_date" name="publish_date" value="{{ old('publish_date') }}">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Create Page</button>
                            <a href="{{ route('seo.pages.index') }}" class="btn btn-outline-secondary">Cancel</a>
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
                            <div class="text-primary text-decoration-none" id="preview-title">Your page title will appear here</div>
                            <div class="text-success small" id="preview-url">{{ url('/pages/your-page-slug') }}</div>
                            <div class="text-muted small mt-1" id="preview-description">Your meta description will appear here. Make it compelling to encourage clicks from search results.</div>
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
                            <div class="mb-2">
                                <small class="text-muted">Title Length:</small>
                                <div class="progress progress-sm">
                                    <div class="progress-bar" id="title-progress" style="width: 0%"></div>
                                </div>
                                <small id="title-status" class="text-muted">Add a title</small>
                            </div>

                            <div class="mb-2">
                                <small class="text-muted">Description Length:</small>
                                <div class="progress progress-sm">
                                    <div class="progress-bar" id="desc-progress" style="width: 0%"></div>
                                </div>
                                <small id="desc-status" class="text-muted">Add a description</small>
                            </div>

                            <div class="mb-2">
                                <small class="text-muted">Focus Keyword:</small>
                                <span id="keyword-status" class="badge bg-secondary">Not set</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Character counters
    const metaTitle = document.getElementById('meta_title');
    const metaDesc = document.getElementById('meta_description');
    const titleLength = document.getElementById('meta-title-length');
    const descLength = document.getElementById('meta-desc-length');

    metaTitle.addEventListener('input', function() {
        titleLength.textContent = this.value.length;
        updateSeoPreview();
    });

    metaDesc.addEventListener('input', function() {
        descLength.textContent = this.value.length;
        updateSeoPreview();
    });

    // Update SEO preview
    function updateSeoPreview() {
        const title = metaTitle.value || document.getElementById('title').value || 'Your page title will appear here';
        const description = metaDesc.value || 'Your meta description will appear here.';

        document.getElementById('preview-title').textContent = title;
        document.getElementById('preview-description').textContent = description;

        // Update analysis
        updateSeoAnalysis();
    }

    function updateSeoAnalysis() {
        const titleLen = metaTitle.value.length;
        const descLen = metaDesc.value.length;

        // Title analysis
        const titleProgress = document.getElementById('title-progress');
        const titleStatus = document.getElementById('title-status');

        if (titleLen === 0) {
            titleProgress.style.width = '0%';
            titleProgress.className = 'progress-bar bg-secondary';
            titleStatus.textContent = 'Add a title';
        } else if (titleLen < 30) {
            titleProgress.style.width = '50%';
            titleProgress.className = 'progress-bar bg-warning';
            titleStatus.textContent = 'Too short';
        } else if (titleLen <= 60) {
            titleProgress.style.width = '100%';
            titleProgress.className = 'progress-bar bg-success';
            titleStatus.textContent = 'Good length';
        } else {
            titleProgress.style.width = '100%';
            titleProgress.className = 'progress-bar bg-danger';
            titleStatus.textContent = 'Too long';
        }

        // Description analysis
        const descProgress = document.getElementById('desc-progress');
        const descStatus = document.getElementById('desc-status');

        if (descLen === 0) {
            descProgress.style.width = '0%';
            descProgress.className = 'progress-bar bg-secondary';
            descStatus.textContent = 'Add a description';
        } else if (descLen < 120) {
            descProgress.style.width = '60%';
            descProgress.className = 'progress-bar bg-warning';
            descStatus.textContent = 'Too short';
        } else if (descLen <= 160) {
            descProgress.style.width = '100%';
            descProgress.className = 'progress-bar bg-success';
            descStatus.textContent = 'Good length';
        } else {
            descProgress.style.width = '100%';
            descProgress.className = 'progress-bar bg-danger';
            descStatus.textContent = 'Too long';
        }
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

    // Auto-generate meta title from page title
    document.getElementById('title').addEventListener('input', function() {
        if (!metaTitle.value) {
            metaTitle.value = this.value;
            titleLength.textContent = this.value.length;
        }
        updateSeoPreview();
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
</script>
@endsection
