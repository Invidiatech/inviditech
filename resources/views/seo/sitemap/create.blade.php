@extends('layouts.seo')
@section('seo-content')
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">SEO</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('seo.dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('seo.sitemap.index') }}">Sitemaps</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a href="{{ route('seo.sitemap.index') }}" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back"></i> Back to Sitemaps
            </a>
        </div>
    </div>

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bx bx-error-circle me-1"></i>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Create New Sitemap</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('seo.sitemap.store') }}" method="POST" id="sitemapForm">
                        @csrf

                        <!-- Basic Information -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Sitemap Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name') }}" required
                                   placeholder="e.g., Main Pages Sitemap">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Sitemap Type -->
                        <div class="mb-3">
                            <label for="type" class="form-label">Sitemap Type <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror"
                                    id="type" name="type" required onchange="toggleCustomUrls()">
                                <option value="">Select Type</option>
                                @foreach($sitemapTypes as $key => $label)
                                    <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Type Information -->
                        <div class="mb-3" id="typeInfo">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="text-center p-3 bg-light rounded" id="pagesInfo">
                                        <i class="bx bx-file display-6 text-primary"></i>
                                        <h6 class="mt-2">Static Pages</h6>
                                        <span class="badge bg-primary">{{ $counts['pages'] }} pages</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center p-3 bg-light rounded" id="blogsInfo">
                                        <i class="bx bx-news display-6 text-success"></i>
                                        <h6 class="mt-2">Blog Posts</h6>
                                        <span class="badge bg-success">{{ $counts['blogs'] }} posts</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center p-3 bg-light rounded" id="productsInfo">
                                        <i class="bx bx-package display-6 text-info"></i>
                                        <h6 class="mt-2">Products</h6>
                                        <span class="badge bg-info">{{ $counts['products'] }} products</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center p-3 bg-light rounded" id="categoriesInfo">
                                        <i class="bx bx-category display-6 text-warning"></i>
                                        <h6 class="mt-2">Categories</h6>
                                        <span class="badge bg-warning">{{ $counts['categories'] }} categories</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Custom URLs (only for custom type) -->
                        <div class="mb-3" id="customUrlsSection" style="display: none;">
                            <label for="custom_urls" class="form-label">Custom URLs <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('custom_urls') is-invalid @enderror"
                                      id="custom_urls" name="custom_urls" rows="10"
                                      placeholder="Enter URLs (one per line)&#10;https://example.com/page1&#10;https://example.com/page2">{{ old('custom_urls') }}</textarea>
                            @error('custom_urls')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Enter one URL per line. Include the full URL with https://</div>
                        </div>

                        <!-- SEO Settings -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="change_frequency" class="form-label">Change Frequency</label>
                                    <select class="form-select @error('change_frequency') is-invalid @enderror"
                                            id="change_frequency" name="change_frequency" required>
                                        @foreach($changeFrequencies as $key => $label)
                                            <option value="{{ $key }}" {{ old('change_frequency', 'weekly') == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('change_frequency')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="priority" class="form-label">Priority</label>
                                    <select class="form-select @error('priority') is-invalid @enderror"
                                            id="priority" name="priority" required>
                                        <option value="0.1" {{ old('priority') == '0.1' ? 'selected' : '' }}>0.1 - Lowest</option>
                                        <option value="0.3" {{ old('priority') == '0.3' ? 'selected' : '' }}>0.3 - Low</option>
                                        <option value="0.5" {{ old('priority', '0.5') == '0.5' ? 'selected' : '' }}>0.5 - Medium</option>
                                        <option value="0.8" {{ old('priority') == '0.8' ? 'selected' : '' }}>0.8 - High</option>
                                        <option value="1.0" {{ old('priority') == '1.0' ? 'selected' : '' }}>1.0 - Highest</option>
                                    </select>
                                    @error('priority')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror"
                                    id="status" name="status" required>
                                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save me-1"></i> Create Sitemap
                            </button>
                            <a href="{{ route('seo.sitemap.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-x me-1"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Sitemap Guide</h5>
                </div>
                <div class="card-body">
                    <div id="sitemapGuide">
                        <div class="guide-item mb-3">
                            <h6><i class="bx bx-file text-primary me-2"></i>Static Pages</h6>
                            <p class="small text-muted">Includes homepage, about, contact, and other static pages.</p>
                        </div>
                        <div class="guide-item mb-3">
                            <h6><i class="bx bx-news text-success me-2"></i>Blog Posts</h6>
                            <p class="small text-muted">All published blog articles and posts.</p>
                        </div>
                        <div class="guide-item mb-3">
                            <h6><i class="bx bx-package text-info me-2"></i>Products</h6>
                            <p class="small text-muted">All product pages from your catalog.</p>
                        </div>
                        <div class="guide-item mb-3">
                            <h6><i class="bx bx-category text-warning me-2"></i>Categories</h6>
                            <p class="small text-muted">Product category and collection pages.</p>
                        </div>
                        <div class="guide-item mb-3">
                            <h6><i class="bx bx-link text-secondary me-2"></i>Custom URLs</h6>
                            <p class="small text-muted">Manually specify URLs to include.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">SEO Tips</h5>
                </div>
                <div class="card-body">
                    <div class="tip-item mb-3">
                        <i class="bx bx-info-circle text-primary me-2"></i>
                        <small>Higher priority (0.8-1.0) for important pages like homepage and key products.</small>
                    </div>
                    <div class="tip-item mb-3">
                        <i class="bx bx-time text-warning me-2"></i>
                        <small>Set change frequency based on how often content updates.</small>
                    </div>
                    <div class="tip-item mb-3">
                        <i class="bx bx-check-circle text-success me-2"></i>
                        <small>Submit generated sitemaps to Google Search Console for better indexing.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleCustomUrls() {
    const typeSelect = document.getElementById('type');
    const customUrlsSection = document.getElementById('customUrlsSection');
    const customUrlsField = document.getElementById('custom_urls');

    if (typeSelect.value === 'custom') {
        customUrlsSection.style.display = 'block';
        customUrlsField.required = true;
    } else {
        customUrlsSection.style.display = 'none';
        customUrlsField.required = false;
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleCustomUrls();
});
</script>

<style>
.guide-item, .tip-item {
    border-left: 3px solid transparent;
    padding-left: 10px;
}

.guide-item {
    border-left-color: #e9ecef;
}

.tip-item {
    border-left-color: #dee2e6;
}

.bg-light.rounded:hover {
    background-color: #f1f3f4 !important;
    cursor: pointer;
}

#typeInfo .col-md-3 {
    transition: all 0.3s ease;
}

#typeInfo .col-md-3:hover {
    transform: translateY(-2px);
}
</style>
@endsection
