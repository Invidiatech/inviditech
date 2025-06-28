@extends('layouts.seo')

@section('title', 'Edit Schema Markup')

@section('seo-content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Edit Schema Markup</h1>
            <p class="text-muted">Update structured data for "{{ $schema->name }}"</p>
        </div>
        <div>
            <a href="{{ route('seo.schema.show', $schema) }}" class="btn btn-outline-info me-2">
                <i class="fas fa-eye me-2"></i>View
            </a>
            <a href="{{ route('seo.schema.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <form action="{{ route('seo.schema.update', $schema) }}" method="POST" id="schemaForm">
        @csrf
        @method('PUT')
        <div class="row">
            <!-- Main Form -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Schema Information</h5>
                    </div>
                    <div class="card-body">
                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Schema Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $schema->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Type -->
                        <div class="mb-3">
                            <label for="type" class="form-label">Schema Type <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror"
                                    id="type" name="type" required>
                                <option value="">Select Schema Type</option>
                                @foreach($schemaTypes as $key => $label)
                                    <option value="{{ $key }}" {{ old('type', $schema->type) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Schema Data -->
                        <div class="mb-3">
                            <label for="schema_data" class="form-label">Schema Data <span class="text-danger">*</span></label>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">Enter your JSON-LD structured data</small>
                                <div>
                                    <button type="button" class="btn btn-sm btn-outline-primary me-2" id="loadTemplate">
                                        Load Template
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-success" id="formatJson">
                                        Format JSON
                                    </button>
                                </div>
                            </div>
                            <textarea class="form-control @error('schema_data') is-invalid @enderror"
                                      id="schema_data" name="schema_data" rows="20" required>{{ old('schema_data', json_encode($schema->schema_data, JSON_PRETTY_PRINT)) }}</textarea>
                            @error('schema_data')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle"></i>
                                Make sure your JSON is valid. Use the format button to clean up formatting.
                            </div>
                        </div>

                        <!-- Pages -->
                        <div class="mb-3">
                            <label for="pages" class="form-label">Apply to Pages (Optional)</label>
                            <textarea class="form-control @error('pages') is-invalid @enderror"
                                      id="pages" name="pages" rows="3"
                                      placeholder="Enter page URLs (one per line) or leave empty to apply to all pages">{{ old('pages', $schema->pages ? implode("\n", $schema->pages) : '') }}</textarea>
                            @error('pages')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Leave empty to apply to all pages, or enter specific URLs (one per line)
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Validation Status -->
                @if($schema->validation_status !== 'pending')
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Validation Status</h5>
                    </div>
                    <div class="card-body">
                        @if($schema->validation_status === 'valid')
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>
                                <strong>Schema is Valid</strong>
                                <p class="mb-0 mt-2">This schema markup passed validation and is ready for use.</p>
                            </div>
                        @elseif($schema->validation_status === 'invalid')
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Schema has Validation Errors</strong>
                                @if($schema->validation_errors)
                                    <ul class="mb-0 mt-2">
                                        @foreach($schema->validation_errors as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Schema Preview -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Schema Preview</h5>
                    </div>
                    <div class="card-body">
                        <div id="schemaPreview" class="bg-light p-3 rounded">
                            <pre><code>{{ json_encode($schema->schema_data, JSON_PRETTY_PRINT) }}</code></pre>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Settings -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Settings</h5>
                    </div>
                    <div class="card-body">
                        <!-- Status -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror"
                                    id="status" name="status" required>
                                <option value="active" {{ old('status', $schema->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $schema->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Current Validation Status -->
                        <div class="mb-3">
                            <label class="form-label">Current Validation</label>
                            <div>
                                @if($schema->validation_status === 'valid')
                                    <span class="badge bg-success fs-6">
                                        <i class="fas fa-check me-1"></i>Valid
                                    </span>
                                @elseif($schema->validation_status === 'invalid')
                                    <span class="badge bg-danger fs-6">
                                        <i class="fas fa-times me-1"></i>Invalid
                                    </span>
                                @else
                                    <span class="badge bg-warning fs-6">
                                        <i class="fas fa-clock me-1"></i>Pending
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Schema
                            </button>
                            <button type="button" class="btn btn-outline-info" id="validateSchema">
                                <i class="fas fa-check-double me-2"></i>Validate JSON
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Schema Info -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Schema Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-5"><strong>Created:</strong></div>
                            <div class="col-sm-7">{{ $schema->created_at->format('M d, Y H:i') }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-5"><strong>Updated:</strong></div>
                            <div class="col-sm-7">{{ $schema->updated_at->format('M d, Y H:i') }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-5"><strong>Created by:</strong></div>
                            <div class="col-sm-7">{{ $schema->creator->name ?? 'N/A' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-5"><strong>Type:</strong></div>
                            <div class="col-sm-7">
                                <span class="badge bg-info">{{ $schemaTypes[$schema->type] ?? $schema->type }}</span>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </form>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the schema markup "<strong>{{ $schema->name }}</strong>"?</p>
                <p class="text-danger"><strong>This action cannot be undone.</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('seo.schema.destroy', $schema) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Schema</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const schemaDataTextarea = document.getElementById('schema_data');
    const loadTemplateBtn = document.getElementById('loadTemplate');
    const validateBtn = document.getElementById('validateSchema');
    const revalidateBtn = document.getElementById('revalidateSchema');
    const formatBtn = document.getElementById('formatJson');
    const previewDiv = document.getElementById('schemaPreview');

    // Load template functionality
    loadTemplateBtn.addEventListener('click', function() {
        const selectedType = typeSelect.value;
        if (!selectedType) {
            alert('Please select a schema type first');
            return;
        }

        if (confirm('This will replace the current schema data. Are you sure?')) {
            fetch(`/seo/schema/template?type=${selectedType}`)
                .then(response => response.json())
                .then(data => {
                    schemaDataTextarea.value = data.formatted;
                    updatePreview();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error loading template');
                });
        }
    });

    // Format JSON functionality
    formatBtn.addEventListener('click', function() {
        try {
            const jsonData = JSON.parse(schemaDataTextarea.value);
            schemaDataTextarea.value = JSON.stringify(jsonData, null, 2);
            updatePreview();
        } catch (error) {
            alert('Invalid JSON: ' + error.message);
        }
    });

    // Validate JSON functionality
    validateBtn.addEventListener('click', function() {
        try {
            const jsonData = JSON.parse(schemaDataTextarea.value);
            alert('JSON is valid!');
            updatePreview();
        } catch (error) {
            alert('Invalid JSON: ' + error.message);
        }
    });


    // Update preview on data change
    schemaDataTextarea.addEventListener('input', debounce(updatePreview, 500));

    // Convert pages textarea to array before submit
    document.getElementById('schemaForm').addEventListener('submit', function(e) {
        // Validate JSON before submitting
        try {
            const schemaData = JSON.parse(schemaDataTextarea.value);
        } catch (error) {
            e.preventDefault();
            alert('Please fix JSON syntax errors before submitting: ' + error.message);
            return false;
        }

        // The form will submit the JSON as a string, and the controller will convert it to array
        return true;
    });
        }
    });

    function updatePreview() {
        try {
            const jsonData = JSON.parse(schemaDataTextarea.value);
            previewDiv.innerHTML = `<pre><code>${JSON.stringify(jsonData, null, 2)}</code></pre>`;
        } catch (error) {
            previewDiv.innerHTML = `<p class="text-danger">Invalid JSON: ${error.message}</p>`;
        }
    }

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
});
</script>

<style>
#schemaPreview pre {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    padding: 1rem;
    font-size: 0.875rem;
    max-height: 400px;
    overflow-y: auto;
}

#schemaPreview code {
    color: #e83e8c;
}
</style>
@endpush
