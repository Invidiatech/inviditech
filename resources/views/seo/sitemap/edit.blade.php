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
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a href="{{ route('seo.sitemap.show', $sitemap) }}" class="btn btn-outline-info me-2">
                <i class="bx bx-show"></i> View
            </a>
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
                    <h5 class="card-title">Edit Sitemap: {{ $sitemap->name }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('seo.sitemap.update', $sitemap) }}" method="POST" id="sitemapForm">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Sitemap Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $sitemap->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Sitemap Type -->
                        <div class="mb-3">
                            <label for="type" class="form-label">Sitemap Type <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror"
                                    id="type" name="type" required onchange="toggleCustomUrls()">
                                @foreach($sitemapTypes as $key => $label)
                                    <option value="{{ $key }}" {{ old('type', $sitemap->type) == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Current Statistics -->
                        <div class="mb-3">
                            <div class="alert alert-info">
                                <div class="row text-center">
                                    <div class="col-md-3">
                                        <strong>{{ $sitemap->total_urls }}</strong>
                                        <br><small>Total URLs</small>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>{{ $sitemap->last_generated ? $sitemap->last_generated->format('M d, Y') : 'Never' }}</strong>
                                        <br><small>Last Generated</small>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>{{ $sitemap->file_size ?? 'N/A' }}</strong>
                                        <br><small>File Size</small>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>{{ $sitemap->submitted_to_google ? 'Yes' : 'No' }}</strong>
                                        <br><small>Google Submitted</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Custom URLs (only for custom type) -->
                        <div class="mb-3" id="customUrlsSection" style="{{ old('type', $sitemap->type) == 'custom' ? 'display: block;' : 'display: none;' }}">
                            <label for="custom_urls" class="form-label">Custom URLs <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('custom_urls') is-invalid @enderror"
                                      id="custom_urls" name="custom_urls" rows="15"
                                      placeholder="Enter URLs (one per line)">{{ old('custom_urls', $sitemap->type == 'custom' ? implode("\n", array_column($sitemap->urls, 'loc')) : '') }}</textarea>
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
                                            <option value="{{ $key }}" {{ old('change_frequency', $sitemap->settings['change_frequency'] ?? 'weekly') == $key ? 'selected' : '' }}>
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
                                        <option value="0.1" {{ old('priority', $sitemap->settings['priority'] ?? '0.5') == '0.1' ? 'selected' : '' }}>0.1 - Lowest</option>
                                        <option value="0.3" {{ old('priority', $sitemap->settings['priority'] ?? '0.5') == '0.3' ? 'selected' : '' }}>0.3 - Low</option>
                                        <option value="0.5" {{ old('priority', $sitemap->settings['priority'] ?? '0.5') == '0.5' ? 'selected' : '' }}>0.5 - Medium</option>
                                        <option value="0.8" {{ old('priority', $sitemap->settings['priority'] ?? '0.5') == '0.8' ? 'selected' : '' }}>0.8 - High</option>
                                        <option value="1.0" {{ old('priority', $sitemap->settings['priority'] ?? '0.5') == '1.0' ? 'selected' : '' }}>1.0 - Highest</option>
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
                                <option value="active" {{ old('status', $sitemap->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $sitemap->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save me-1"></i> Update Sitemap
                            </button>
                            <a href="{{ route('seo.sitemap.show', $sitemap) }}" class="btn btn-outline-info">
                                <i class="bx bx-show me-1"></i> View
                            </a>
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
                    <h5 class="card-title">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary" onclick="generateSitemap()">
                            <i class="bx bx-refresh me-1"></i> Regenerate Now
                        </button>
                        @if($sitemap->file_path)
                        <a href="{{ route('seo.sitemap.download') }}?sitemap_id={{ $sitemap->id }}" class="btn btn-outline-success">
                            <i class="bx bx-download me-1"></i> Download XML
                        </a>
                        <a href="{{ $sitemap->sitemap_url }}" target="_blank" class="btn btn-outline-info">
                            <i class="bx bx-link-external me-1"></i> View XML
                        </a>
                        @endif
                        @if($sitemap->file_path && !$sitemap->submitted_to_google)
                        <button class="btn btn-outline-warning" onclick="submitToGoogle()">
                            <i class="bx bx-cloud-upload me-1"></i> Submit to Google
                        </button>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Sitemap Information</h5>
                </div>
                <div class="card-body">
                    <div class="info-item mb-3">
                        <strong>Created:</strong>
                        <br><small class="text-muted">{{ $sitemap->created_at->format('M d, Y H:i') }}</small>
                    </div>
                    <div class="info-item mb-3">
                        <strong>Last Updated:</strong>
                        <br><small class="text-muted">{{ $sitemap->updated_at->format('M d, Y H:i') }}</small>
                    </div>
                    <div class="info-item mb-3">
                        <strong>Created By:</strong>
                        <br><small class="text-muted">{{ $sitemap->creator->name ?? 'N/A' }}</small>
                    </div>
                    @if($sitemap->google_submission_date)
                    <div class="info-item mb-3">
                        <strong>Google Submission:</strong>
                        <br><small class="text-muted">{{ $sitemap->google_submission_date->format('M d, Y H:i') }}</small>
                    </div>
                    @endif
                </div>
            </div>

            @if($sitemap->needsRegeneration())
            <div class="card border-warning">
                <div class="card-header bg-warning text-dark">
                    <h5 class="card-title mb-0">
                        <i class="bx bx-time me-1"></i> Needs Update
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-2">This sitemap was last generated over 24 hours ago.</p>
                    <button class="btn btn-warning btn-sm" onclick="generateSitemap()">
                        <i class="bx bx-refresh me-1"></i> Update Now
                    </button>
                </div>
            </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Danger Zone</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Permanently delete this sitemap. This action cannot be undone.</p>
                    <form action="{{ route('seo.sitemap.destroy', $sitemap) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this sitemap? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="bx bx-trash me-1"></i> Delete Sitemap
                        </button>
                    </form>
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
            showToast('Sitemap generated successfully!', 'success');
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

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleCustomUrls();
});
</script>

<style>
.info-item {
    border-bottom: 1px solid #eee;
    padding-bottom: 10px;
}

.info-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}
</style>
@endsection
