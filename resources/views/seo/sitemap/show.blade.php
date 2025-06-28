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
                    <li class="breadcrumb-item active" aria-current="page">{{ $sitemap->name }}</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a href="{{ route('seo.sitemap.edit', $sitemap) }}" class="btn btn-primary me-2">
                <i class="bx bx-edit"></i> Edit
            </a>
            <a href="{{ route('seo.sitemap.index') }}" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back"></i> Back to Sitemaps
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Sitemap Overview -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ $sitemap->name }}</h5>
                    <span class="badge bg-{{ $sitemap->status == 'active' ? 'success' : 'secondary' }}">
                        {{ ucfirst($sitemap->status) }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3 text-center">
                            <div class="p-3 bg-primary text-white rounded">
                                <i class="bx bx-link display-6"></i>
                                <h4 class="mt-2">{{ number_format($sitemap->total_urls) }}</h4>
                                <p class="mb-0">Total URLs</p>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="p-3 bg-info text-white rounded">
                                <i class="bx bx-category display-6"></i>
                                <h4 class="mt-2">{{ \App\Models\Seo\SeoSitemap::SITEMAP_TYPES[$sitemap->type] ?? $sitemap->type }}</h4>
                                <p class="mb-0">Type</p>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="p-3 bg-success text-white rounded">
                                <i class="bx bx-time display-6"></i>
                                <h4 class="mt-2">{{ $sitemap->settings['change_frequency'] ?? 'N/A' }}</h4>
                                <p class="mb-0">Frequency</p>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="p-3 bg-warning text-white rounded">
                                <i class="bx bx-star display-6"></i>
                                <h4 class="mt-2">{{ $sitemap->settings['priority'] ?? 'N/A' }}</h4>
                                <p class="mb-0">Priority</p>
                            </div>
                        </div>
                    </div>

                    <!-- Generation Status -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-calendar me-2 text-primary"></i>
                                <div>
                                    <strong>Last Generated:</strong>
                                    <br>
                                    @if($sitemap->last_generated)
                                        <span class="text-success">{{ $sitemap->last_generated->format('M d, Y H:i') }}</span>
                                        <small class="text-muted">({{ $sitemap->last_generated->diffForHumans() }})</small>
                                    @else
                                        <span class="text-muted">Never generated</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 d-none">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-cloud-upload me-2 text-info"></i>
                                <div>
                                    <strong>Google Status:</strong>
                                    <br>
                                    @if($sitemap->submitted_to_google)
                                        <span class="text-success">Submitted</span>
                                        @if($sitemap->google_submission_date)
                                            <small class="text-muted">({{ $sitemap->google_submission_date->format('M d, Y') }})</small>
                                        @endif
                                    @else
                                        <span class="text-muted">Not submitted</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- File Information -->
                    @if($sitemap->file_path)
                    <div class="alert alert-info">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <i class="bx bx-file me-2"></i>
                                <strong>XML File:</strong> {{ basename($sitemap->file_path) }}
                                <br>
                                <small class="text-muted">
                                    Size: {{ $sitemap->file_size }} |
                                    URL: <a href="{{ $sitemap->sitemap_url }}" target="_blank">{{ $sitemap->sitemap_url }}</a>
                                </small>
                            </div>
                            <div class="col-md-4 text-end">
                                <a href="{{ route('seo.sitemap.download') }}?sitemap_id={{ $sitemap->id }}" class="btn btn-sm btn-primary">
                                    <i class="bx bx-download me-1"></i> Download
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- URLs List -->
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">URLs in Sitemap</h5>
                    <span class="badge bg-primary">{{ count($sitemap->urls) }} URLs</span>
                </div>
                <div class="card-body">
                    @if(count($sitemap->urls) > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>URL</th>
                                        <th>Last Modified</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sitemap->urls as $index => $url)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <a href="{{ $url['loc'] }}" target="_blank" class="text-decoration-none">
                                                {{ Str::limit($url['loc'], 80) }}
                                                <i class="bx bx-link-external ms-1 small"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $url['lastmod'] ?? 'N/A' }}</small>
                                        </td>
                                        <td>
                                            <a href="{{ $url['loc'] }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="bx bx-link-external"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if(count($sitemap->urls) > 20)
                        <div class="text-center mt-3">
                            <button class="btn btn-outline-secondary btn-sm" onclick="toggleAllUrls()">
                                <i class="bx bx-show me-1"></i> <span id="toggleText">Show All URLs</span>
                            </button>
                        </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <i class="bx bx-link display-4 text-muted"></i>
                            <p class="text-muted mt-2">No URLs found. Generate the sitemap to populate URLs.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">


            <!-- Sitemap Details -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title">Details</h5>
                </div>
                <div class="card-body">
                    <div class="detail-item mb-3">
                        <strong>Created:</strong>
                        <br><small class="text-muted">{{ $sitemap->created_at->format('M d, Y H:i') }}</small>
                    </div>
                    <div class="detail-item mb-3">
                        <strong>Last Updated:</strong>
                        <br><small class="text-muted">{{ $sitemap->updated_at->format('M d, Y H:i') }}</small>
                    </div>
                    <div class="detail-item mb-3">
                        <strong>Created By:</strong>
                        <br><small class="text-muted">{{ $sitemap->creator->name ?? 'N/A' }}</small>
                    </div>
                    <div class="detail-item mb-3">
                        <strong>Type:</strong>
                        <br><span class="badge bg-info">{{ \App\Models\Seo\SeoSitemap::SITEMAP_TYPES[$sitemap->type] ?? $sitemap->type }}</span>
                    </div>
                    <div class="detail-item">
                        <strong>Status:</strong>
                        <br><span class="badge bg-{{ $sitemap->status == 'active' ? 'success' : 'secondary' }}">{{ ucfirst($sitemap->status) }}</span>
                    </div>
                </div>
            </div>

            <!-- SEO Tips -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title">SEO Tips</h5>
                </div>
                <div class="card-body">
                    <div class="tip-item mb-3">
                        <i class="bx bx-check-circle text-success me-2"></i>
                        <small>Submit your sitemap to Google Search Console for better indexing.</small>
                    </div>
                    <div class="tip-item mb-3">
                        <i class="bx bx-time text-warning me-2"></i>
                        <small>Update your sitemap when you add new content or change URLs.</small>
                    </div>
                    <div class="tip-item mb-3">
                        <i class="bx bx-link text-info me-2"></i>
                        <small>Keep your sitemap under 50,000 URLs and 50MB for optimal performance.</small>
                    </div>
                </div>
            </div>

            @if($sitemap->needsRegeneration())
            <!-- Update Warning -->
            <div class="card mt-4 border-warning">
                <div class="card-header bg-warning text-dark">
                    <h5 class="card-title mb-0">
                        <i class="bx bx-time me-1"></i> Update Recommended
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-2">This sitemap was last generated over 24 hours ago. Consider updating it to include recent changes.</p>
                    <button class="btn btn-warning btn-sm" onclick="generateSitemap()">
                        <i class="bx bx-refresh me-1"></i> Update Now
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
function generateSitemap() {
    const btn = event.target;
    const originalHtml = btn.innerHTML;

    btn.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i> Generating...';
    btn.disabled = true;

    fetch('/seo/sitemap/generate', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ sitemap_id: {{ $sitemap->id }} })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Sitemap generated successfully with ' + data.url_count + ' URLs!', 'success');
            setTimeout(() => location.reload(), 2000);
        } else {
            showToast('Error: ' + data.message, 'error');
        }
    })
    .catch(error => {
        showToast('Error generating sitemap', 'error');
        console.error('Error:', error);
    })
    .finally(() => {
        btn.innerHTML = originalHtml;
        btn.disabled = false;
    });
}

function submitToGoogle() {
    const btn = event.target;
    const originalHtml = btn.innerHTML;

    btn.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i> Submitting...';
    btn.disabled = true;

    fetch('/seo/sitemap/submit-google', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ sitemap_id: {{ $sitemap->id }} })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Sitemap submitted to Google successfully!', 'success');
            setTimeout(() => location.reload(), 2000);
        } else {
            showToast('Error: ' + data.message, 'error');
        }
    })
    .catch(error => {
        showToast('Error submitting to Google', 'error');
        console.error('Error:', error);
    })
    .finally(() => {
        btn.innerHTML = originalHtml;
        btn.disabled = false;
    });
}

function showToast(message, type) {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    toast.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(toast);

    setTimeout(() => {
        if (toast.parentNode) {
            toast.remove();
        }
    }, 5000);
}

function toggleAllUrls() {
    // This function can be implemented to show/hide URLs if there are many
    const toggleText = document.getElementById('toggleText');
    // Implementation depends on your specific needs
}
</script>

@endsection
