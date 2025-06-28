@extends('layouts.seo')
@section('seo-content')
<link rel="stylesheet" href="{{ asset('assets/css/backend/category.css') }}" />
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">SEO</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('seo.dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Sitemaps</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <!-- Fixed: Changed from POST form to GET link -->
            <a href="{{ route('seo.sitemap.create') }}" class="btn btn-primary">
                <i class="bx bx-plus"></i> Create Sitemap
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
        <i class="bx bx-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bx bx-error-circle me-1"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4 d-none">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-1">{{ $stats['total'] }}</h4>
                            <p class="mb-0">Total Sitemaps</p>
                        </div>
                        <i class="bx bx-sitemap fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-1">{{ $stats['active'] }}</h4>
                            <p class="mb-0">Active</p>
                        </div>
                        <i class="bx bx-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-1">{{ $stats['submitted'] }}</h4>
                            <p class="mb-0">Submitted to Google</p>
                        </div>
                        <i class="bx bx-cloud-upload fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-1">{{ number_format($stats['total_urls']) }}</h4>
                            <p class="mb-0">Total URLs</p>
                        </div>
                        <i class="bx bx-link fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card radius-10">
        <div class="card-body">
            <h5 class="card-title">Sitemaps</h5>
            <hr>
            <div>
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>URLs</th>
                            <th>Status</th>
                            <th>Last Generated</th>
                             <th>File Size</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sitemaps as $sitemap)
                        <tr>
                            <td>#{{ $sitemap->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $sitemap->name }}</h6>
                                        <p class="mb-0 text-muted small">{{ \App\Models\Seo\SeoSitemap::SITEMAP_TYPES[$sitemap->type] ?? $sitemap->type }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ \App\Models\Seo\SeoSitemap::SITEMAP_TYPES[$sitemap->type] ?? $sitemap->type }}</span>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ number_format($sitemap->total_urls) }} URLs</span>
                            </td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" class="status-switch" {{ $sitemap->status == 'active' ? 'checked' : '' }}
                                           onchange="updateStatus({{ $sitemap->id }}, this.checked)">
                                    <span class="slider"></span>
                                </label>
                            </td>
                            <td>
                                @if($sitemap->last_generated)
                                    <span class="text-success">{{ $sitemap->last_generated->format('M d, Y H:i') }}</span>
                                    @if(method_exists($sitemap, 'needsRegeneration') && $sitemap->needsRegeneration())
                                        <br><small class="text-warning">Needs update</small>
                                    @endif
                                @else
                                    <span class="text-muted">Not generated</span>
                                @endif
                            </td>
                            <td>
                                @if($sitemap->file_path && file_exists(public_path($sitemap->file_path)))
                                    <span class="text-success">{{ $sitemap->file_size ?? 'N/A' }}</span>
                                @else
                                    <span class="text-muted">No file</span>
                                @endif
                            </td>
                            <td>
                                <div >
                                    <button class="btn dropdown-toggle custom-dropdown-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-custom">
                                        <li><a class="dropdown-item" href="{{ route('seo.sitemap.show', $sitemap) }}"><i class="bx bx-show me-1"></i> View</a></li>
                                        <li><a class="dropdown-item" href="{{ route('seo.sitemap.edit', $sitemap) }}"><i class="bx bx-edit me-1"></i> Edit</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <button class="dropdown-item generate-sitemap" data-sitemap-id="{{ $sitemap->id }}">
                                                <i class="bx bx-refresh me-1"></i> Generate
                                            </button>
                                        </li>
                                        @if($sitemap->file_path)
                                        <li>
                                            <a class="dropdown-item" href="{{ route('seo.sitemap.download') }}?sitemap_id={{ $sitemap->id }}">
                                                <i class="bx bx-download me-1"></i> Download
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ url($sitemap->file_path) }}" target="_blank">
                                                <i class="bx bx-link-external me-1"></i> View XML
                                            </a>
                                        </li>
                                        @endif
                                        <li><hr class="dropdown-divider"></li>
                                        @if($sitemap->file_path)
                                        <li class="d-none">
                                            <button class="dropdown-item submit-google" data-sitemap-id="{{ $sitemap->id }}">
                                                <i class="bx bx-cloud-upload me-1"></i> Submit to Google
                                            </button>
                                        </li>
                                        @endif
                                        <li>
                                            <form method="POST" action="{{ route('seo.sitemap.destroy', $sitemap) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this sitemap?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="bx bx-trash me-1"></i> Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                        @if(count($sitemaps) == 0)
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="bx bx-sitemap display-4"></i>
                                    <p class="mt-2">No sitemaps found.</p>
                                    <!-- Fixed: Changed from POST form to GET link -->
                                    <a href="{{ route('seo.sitemap.create') }}" class="btn btn-primary">
                                        <i class="bx bx-plus"></i> Create Your First Sitemap
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $sitemaps->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    // Function to update status via AJAX
    function updateStatus(id, status) {
        fetch(`{{ url('/seo/sitemap') }}/${id}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                status: status ? 'active' : 'inactive'
            })
        })
        .then(response => {
            if (response.ok) {
                showToast('Status updated successfully!', 'success');
            } else {
                showToast('Error updating status', 'error');
                // Revert checkbox state
                const checkbox = document.querySelector(`input[onchange*="${id}"]`);
                if (checkbox) checkbox.checked = !status;
            }
        })
        .catch(error => {
            showToast('Error updating status', 'error');
            console.error('Error:', error);
            // Revert checkbox state
            const checkbox = document.querySelector(`input[onchange*="${id}"]`);
            if (checkbox) checkbox.checked = !status;
        });
    }

    // Generate sitemap functionality
    document.querySelectorAll('.generate-sitemap').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const sitemapId = this.dataset.sitemapId;
            const btn = this;
            const originalHtml = btn.innerHTML;

            btn.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i> Generating...';
            btn.disabled = true;

            fetch('{{ route("seo.sitemap.generate") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ sitemap_id: sitemapId })
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
        });
    });

    // Submit to Google functionality
    document.querySelectorAll('.submit-google').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const sitemapId = this.dataset.sitemapId;
            const btn = this;
            const originalHtml = btn.innerHTML;

            btn.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i> Submitting...';
            btn.disabled = true;

            fetch('{{ route("seo.sitemap.submit-google") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ sitemap_id: sitemapId })
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
        });
    });

    // Toast notification function
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

    // Auto-dismiss success alerts
    setTimeout(() => {
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            successAlert.remove();
        }
    }, 5000);
</script>
@endsection
