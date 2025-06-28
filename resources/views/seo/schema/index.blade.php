@extends('layouts.seo')
@section('title', 'Schema Markup Management')
@section('seo-content')
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">SEO</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('seo.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Schema Management</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Header -->

        <!-- Statistics Cards -->
        <div class="row mb-4 d-none">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-1">{{ $stats['total'] ?? 0 }}</h4>
                                <p class="mb-0">Total Schemas</p>
                            </div>
                            <i class="fas fa-code fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-1">{{ $stats['active'] ?? 0 }}</h4>
                                <p class="mb-0">Active</p>
                            </div>
                            <i class="fas fa-check-circle fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-1">{{ $stats['valid'] ?? 0 }}</h4>
                                <p class="mb-0">Valid</p>
                            </div>
                            <i class="fas fa-shield-alt fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-1">{{ $stats['invalid'] ?? 0 }}</h4>
                                <p class="mb-0">Invalid</p>
                            </div>
                            <i class="fas fa-exclamation-triangle fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4 d-none">
            <div class="card-body">
                <form method="GET" action="{{ route('seo.schema.index') }}">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Search</label>
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                                placeholder="Search schemas...">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Type</label>
                            <select name="type" class="form-select">
                                <option value="">All Types</option>
                                @foreach (\App\Models\Seo\SchemaMarkup::SCHEMA_TYPES as $key => $label)
                                    <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Validation</label>
                            <select name="validation_status" class="form-select">
                                <option value="">All</option>
                                <option value="valid" {{ request('validation_status') == 'valid' ? 'selected' : '' }}>
                                    Valid</option>
                                <option value="invalid" {{ request('validation_status') == 'invalid' ? 'selected' : '' }}>
                                    Invalid</option>
                                <option value="pending" {{ request('validation_status') == 'pending' ? 'selected' : '' }}>
                                    Pending</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-outline-primary">Filter</button>
                                <a href="{{ route('seo.schema.index') }}" class="btn btn-outline-secondary">Clear</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
             <!-- Schema List -->
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between w-100">
                    <h5 class="card-title mb-0">
                        <i class="bx bx-book-open me-2"></i>Schema Management
                    </h5>

                    @can('Create Schema Markup', auth('seo')->user())
                        <a href="{{ route('seo.schema.create') }}" class="btn btn-primary ms-auto">
                            <i class="fas fa-plus me-2"></i>Create Schema
                        </a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                @if ($schemas->count() > 0)
                    <div class="table-wrapper" style="overflow-x: auto; overflow-y: visible; position: relative;">
                        <table class="table table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Validation</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schemas as $schema)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">{{ $schema->name }}</div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">
                                                {{ \App\Models\Seo\SchemaMarkup::SCHEMA_TYPES[$schema->type] ?? $schema->type }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $schema->status == 'active' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($schema->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($schema->validation_status == 'valid')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>Valid
                                                </span>
                                            @elseif($schema->validation_status == 'invalid')
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times me-1"></i>Invalid
                                                </span>
                                            @else
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-clock me-1"></i>Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $schema->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="btn-group {{ $loop->iteration > $schemas->count() - 2 ? 'dropstart' : '' }}">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                    type="button" data-bs-toggle="dropdown" data-bs-boundary="viewport">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu {{ $loop->iteration > $schemas->count() - 2 ? 'dropdown-menu-end' : '' }}"
                                                    style="z-index: 1055 !important;">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('seo.schema.show', $schema) }}">
                                                            <i class="fas fa-eye me-2"></i>View
                                                        </a>
                                                    </li>
                                                    @can('Edit Schema Markup', auth('seo')->user())
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('seo.schema.edit', $schema) }}">
                                                                <i class="fas fa-edit me-2"></i>Edit
                                                            </a>
                                                        </li>
                                                    @endcan
                                                    <li><hr class="dropdown-divider"></li>
                                                    @can('Delete Schema Markup', auth('seo')->user())
                                                        <li>
                                                            <button type="button" class="dropdown-item text-danger delete-schema"
                                                                data-schema-id="{{ $schema->id }}">
                                                                <i class="fas fa-trash me-2"></i>Delete
                                                            </button>
                                                        </li>
                                                    @endcan
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($schemas->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $schemas->links() }}
                        </div>
                    @endif

                @else
                    <div class="text-center py-5">
                        <i class="fas fa-code fa-3x text-muted mb-3"></i>
                        <h5>No Schema Markups Found</h5>
                        <p class="text-muted">Create your first schema markup to improve SEO.</p>
                        @can('Create Schema Markup', auth('seo')->user())
                            <a href="{{ route('seo.schema.create') }}" class="btn btn-primary">Create Schema</a>
                        @endcan
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this schema markup? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
<style>
    .table-wrapper {
        overflow-x: auto;
        overflow-y: visible;
        position: relative;
    }

    .dropdown-menu {
        z-index: 1055 !important;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .btn-group.dropstart .dropdown-menu {
        right: 0;
        left: auto;
    }

    /* Ensure dropdown doesn't get clipped */
    .card-body {
        overflow: visible;
    }

    /* Mobile responsiveness for actions */
    @media (max-width: 768px) {
        .table-wrapper {
            overflow-x: scroll;
        }

        .btn-group {
            position: static;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Bootstrap dropdowns with boundary configuration
        const dropdownElementList = document.querySelectorAll('.dropdown-toggle');
        const dropdownList = [...dropdownElementList].map(dropdownToggleEl => {
            return new bootstrap.Dropdown(dropdownToggleEl, {
                boundary: 'viewport',
                popperConfig: {
                    strategy: 'fixed',
                    modifiers: [
                        {
                            name: 'preventOverflow',
                            options: {
                                boundary: 'viewport',
                            },
                        },
                        {
                            name: 'flip',
                            options: {
                                fallbackPlacements: ['top', 'right', 'bottom', 'left'],
                            },
                        },
                    ],
                }
            });
        });

        // Dynamic dropdown positioning based on screen position
        dropdownElementList.forEach(dropdown => {
            dropdown.addEventListener('click', function(e) {
                const rect = this.getBoundingClientRect();
                const dropdownMenu = this.nextElementSibling;
                const viewportWidth = window.innerWidth;

                // If dropdown is near the right edge, align it to the right
                if (rect.right > viewportWidth - 250) {
                    dropdownMenu.classList.add('dropdown-menu-end');
                    this.closest('.btn-group').classList.add('dropstart');
                } else {
                    dropdownMenu.classList.remove('dropdown-menu-end');
                    this.closest('.btn-group').classList.remove('dropstart');
                }
            });
        });

        // Delete functionality
        document.querySelectorAll('.delete-schema').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const schemaId = this.dataset.schemaId;
                const deleteForm = document.getElementById('deleteForm');
                deleteForm.action = `/seo/schema/${schemaId}`;

                const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                deleteModal.show();
            });
        });

        // Validate functionality
        document.querySelectorAll('.validate-schema').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const schemaId = this.dataset.schemaId;
                const btn = this;
                const originalHtml = btn.innerHTML;

                btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Validating...';
                btn.disabled = true;

                fetch('/seo/schema/validate', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            schema_id: schemaId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.valid) {
                            showAlert('Schema is valid!', 'success');
                        } else {
                            showAlert('Schema validation failed: ' + (data.errors ? data.errors.join(', ') : data.message), 'danger');
                        }
                        // Reload page after 2 seconds
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    })
                    .catch(error => {
                        showAlert('Error validating schema', 'danger');
                        console.error('Error:', error);
                    })
                    .finally(() => {
                        btn.innerHTML = originalHtml;
                        btn.disabled = false;
                    });
            });
        });

        // Helper function to show alerts
        function showAlert(message, type) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            // Insert at the top of the page content
            const pageContent = document.querySelector('.page-content');
            pageContent.insertBefore(alertDiv, pageContent.firstChild);

            // Auto dismiss after 5 seconds
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 5000);
        }
    });
</script>
@endpush
