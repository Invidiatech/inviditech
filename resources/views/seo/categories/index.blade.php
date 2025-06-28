@extends('layouts.seo')
@section('seo-content')
<link rel="stylesheet" href="{{ asset('assets/css/backend/category.css') }}" />
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Categories</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('seo.dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Categories</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            @can('Create Categories', auth('seo')->user())
            <a href="{{ route('seo.categories.create') }}" class="btn btn-primary">
                <i class="bx bx-plus"></i> Add Category
            </a>
            @endcan
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

    <div class="card radius-10">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="card-title mb-0">Blog Categories</h5>
                <div class="badge bg-primary">{{ count($categories) }} Total</div>
            </div>
            <hr>
            <div class="table-responsive">
                <table class="table align-middle mb-0" id="dataTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Parent</th>
                            <th>Articles</th>
                            <th>Status</th>
                            <th>Featured</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                        <tr>
                            <td>#{{ $category->id }}</td>
                            <td>
                                @if($category->image)
                                    <img src="{{ $category->image_url }}"
                                        alt="{{ $category->name }}" class="rounded" width="50" height="50"
                                        style="object-fit: cover;">
                                @else
                                    <div class="rounded bg-light d-flex align-items-center justify-content-center"
                                        style="width: 50px; height: 50px;">
                                        <i class="bx bx-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $category->name }}</h6>
                                        <p class="mb-0 text-muted small">{{ $category->slug }}</p>
                                        @if($category->description)
                                        <p class="mb-0 text-muted small">{{ Str::limit($category->description, 50) }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($category->parent)
                                    <span class="badge bg-info">{{ $category->parent->name }}</span>
                                @else
                                    <span class="text-muted">Parent Category</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $category->articles_count }}</span>
                            </td>
                            <td>
                                @can('Edit Categories', auth('seo')->user())
                                <label class="switch">
                                    <input type="checkbox" class="status-switch" {{ $category->is_active ? 'checked' : '' }}
                                           onchange="updateStatus({{ $category->id }}, this.checked)">
                                    <span class="slider"></span>
                                </label>
                                @else
                                <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                @endcan
                            </td>
                            <td>
                                @can('Edit Categories', auth('seo')->user())
                                <label class="switch">
                                    <input type="checkbox" class="featured-switch" {{ $category->is_featured ? 'checked' : '' }}
                                           onchange="updateFeatured({{ $category->id }}, this.checked)">
                                    <span class="slider"></span>
                                </label>
                                @else
                                <span class="badge {{ $category->is_featured ? 'bg-warning' : 'bg-secondary' }}">
                                    {{ $category->is_featured ? 'Featured' : 'Regular' }}
                                </span>
                                @endcan
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle custom-dropdown-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-custom">
                                        @can('View Categories', auth('seo')->user())
                                        <li><a class="dropdown-item" href="{{ route('seo.categories.show', $category) }}"><i class="bx bx-show me-1"></i> View</a></li>
                                        @endcan
                                        @can('Edit Categories', auth('seo')->user())
                                        <li><a class="dropdown-item" href="{{ route('seo.categories.edit', $category) }}"><i class="bx bx-edit me-1"></i> Edit</a></li>
                                        @endcan
                                        @can('Delete Categories', auth('seo')->user())
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('seo.categories.destroy', $category) }}" method="POST" 
                                                  onsubmit="return confirm('Are you sure you want to delete this category?')"
                                                  style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="bx bx-trash me-1"></i> Delete
                                                </button>
                                            </form>
                                        </li>
                                        @endcan
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bx bx-category display-4 text-muted mb-2"></i>
                                    <p class="text-muted mb-2">No categories found</p>
                                    @can('Create Categories', auth('seo')->user())
                                    <a href="{{ route('seo.categories.create') }}" class="btn btn-primary btn-sm">
                                        <i class="bx bx-plus"></i> Create First Category
                                    </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Include CSRF token for JavaScript -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    // Get CSRF token from meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Function to update status via AJAX
    function updateStatus(id, status) {
        fetch(`/seo/categories/${id}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                is_active: status ? 1 : 0
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
            } else {
                // Revert the switch if failed
                const switchElement = document.querySelector(`input[onchange="updateStatus(${id}, this.checked)"]`);
                switchElement.checked = !status;
                showAlert('error', data.message || 'Failed to update status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Revert the switch if failed
            const switchElement = document.querySelector(`input[onchange="updateStatus(${id}, this.checked)"]`);
            switchElement.checked = !status;
            showAlert('error', 'An error occurred while updating status');
        });
    }

    // Function to update featured status via AJAX
    function updateFeatured(id, featured) {
        fetch(`/seo/categories/${id}/featured`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                is_featured: featured ? 1 : 0
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
            } else {
                // Revert the switch if failed
                const switchElement = document.querySelector(`input[onchange="updateFeatured(${id}, this.checked)"]`);
                switchElement.checked = !featured;
                showAlert('error', data.message || 'Failed to update featured status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Revert the switch if failed
            const switchElement = document.querySelector(`input[onchange="updateFeatured(${id}, this.checked)"]`);
            switchElement.checked = !featured;
            showAlert('error', 'An error occurred while updating featured status');
        });
    }

    // Function to show alert messages
    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const iconClass = type === 'success' ? 'bx-check-circle' : 'bx-error-circle';
        
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <i class="bx ${iconClass} me-1"></i> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        // Insert alert at the top of page content
        const pageContent = document.querySelector('.page-content');
        const breadcrumb = document.querySelector('.page-breadcrumb');
        breadcrumb.insertAdjacentHTML('afterend', alertHtml);
        
        // Auto-remove alert after 5 seconds
        setTimeout(() => {
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.remove();
            }
        }, 5000);
    }

    // Auto-hide success alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.remove();
            }, 5000);
        }
    });
</script>
@endsection