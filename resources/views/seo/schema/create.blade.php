@extends('layouts.seo')

@section('title', 'Create Schema Markup')

@section('seo-content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Create Schema Markup</h1>
            <p class="text-muted">Add structured data to improve search engine visibility</p>
        </div>
        <a href="{{ route('seo.schema.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <!-- Debug Information -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <h4>Validation Errors:</h4>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Create Form -->
    <form action="{{ route('seo.schema.store') }}" method="POST" id="schemaForm">
        @csrf
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
                                   id="name" name="name" value="{{ old('name') }}" required>
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
                                    <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>{{ $label }}</option>
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
                            <!-- JSON Editor Container -->
                            <div class="json-editor-container">
                                <textarea class="form-control @error('schema_data') is-invalid @enderror"
                                          id="schema_data" name="schema_data" rows="20" required
                                          style="font-family: 'Monaco', 'Consolas', 'Courier New', monospace; font-size: 14px;">{{ old('schema_data') }}</textarea>
                            </div>
                            @error('schema_data')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text d-flex justify-content-between">
                                <span>
                                    <i class="fas fa-info-circle"></i>
                                    Make sure your JSON is valid. Use Format JSON to clean up the formatting.
                                </span>
                                <span id="json-status" class="text-muted"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Schema Preview -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Schema Preview</h5>
                    </div>
                    <div class="card-body">
                        <div id="schemaPreview" class="bg-light p-3 rounded">
                            <p class="text-muted mb-0">Enter schema data to see preview</p>
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
                                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Actions -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="fas fa-save me-2"></i>Create Schema
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Quick Test Schema -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Quick Test</h5>
                    </div>
                    <div class="card-body">
                        <p class="small">Click to load a simple test schema:</p>
                        <button type="button" class="btn btn-sm btn-outline-success w-100 mb-2" id="loadTestSchema">
                            Load Test Schema
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-info w-100" id="clearSchema">
                            Clear Schema
                        </button>
                    </div>
                </div>

                <!-- JSON Help -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">JSON Tips</h5>
                    </div>
                    <div class="card-body">
                        <ul class="small mb-0">
                            <li>Use double quotes for strings</li>
                            <li>No trailing commas</li>
                            <li>Use @context and @type for schema.org</li>
                            <li>Format button fixes indentation</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const schemaDataTextarea = document.getElementById('schema_data');
    const loadTemplateBtn = document.getElementById('loadTemplate');
     const loadTestBtn = document.getElementById('loadTestSchema');
    const clearBtn = document.getElementById('clearSchema');
    const formatBtn = document.getElementById('formatJson');
    const submitBtn = document.getElementById('submitBtn');
    const jsonStatus = document.getElementById('json-status');
    const previewDiv = document.getElementById('schemaPreview');

    // Load test schema functionality
    if (loadTestBtn) {
        loadTestBtn.addEventListener('click', function() {
            const testSchema = {
                "@context": "https://schema.org",
                "@type": "LocalBusiness",
                "name": "Test Weight Loss Clinic",
                "description": "Test clinic for weight loss treatments",
                "url": "https://example.com",
                "telephone": "+44 20 1234 5678"
            };

            document.getElementById('name').value = 'Test Local Business';
            document.getElementById('type').value = 'local_business';
            schemaDataTextarea.value = JSON.stringify(testSchema, null, 2);
            updatePreview();
            validateJson();
        });
    }

    // Clear schema functionality
    if (clearBtn) {
        clearBtn.addEventListener('click', function() {
            schemaDataTextarea.value = '';
            updatePreview();
            updateJsonStatus('');
        });
    }

    // Load template functionality
    if (loadTemplateBtn) {
        loadTemplateBtn.addEventListener('click', function() {
            const selectedType = typeSelect.value;
            if (!selectedType) {
                alert('Please select a schema type first');
                return;
            }

            const templates = {
                'local_business': {
                    "@context": "https://schema.org",
                    "@type": "LocalBusiness",
                    "name": "",
                    "description": "",
                    "url": "",
                    "telephone": ""
                },
                'faq': {
                    "@context": "https://schema.org",
                    "@type": "FAQPage",
                    "mainEntity": [
                        {
                            "@type": "Question",
                            "name": "Your question here?",
                            "acceptedAnswer": {
                                "@type": "Answer",
                                "text": "Your answer here."
                            }
                        }
                    ]
                },
                'article': {
                    "@context": "https://schema.org",
                    "@type": "BlogPosting",
                    "headline": "",
                    "description": "",
                    "author": {
                        "@type": "Person",
                        "name": ""
                    },
                    "publisher": {
                        "@type": "Organization",
                        "name": ""
                    },
                    "datePublished": "",
                    "dateModified": ""
                },
                'product': {
                    "@context": "https://schema.org",
                    "@type": "Product",
                    "name": "",
                    "description": "",
                    "offers": {
                        "@type": "Offer",
                        "price": "",
                        "priceCurrency": "GBP",
                        "availability": "https://schema.org/InStock"
                    }
                },
                'breadcrumb': {
                    "@context": "https://schema.org",
                    "@type": "BreadcrumbList",
                    "itemListElement": [
                        {
                            "@type": "ListItem",
                            "position": 1,
                            "name": "Home",
                            "item": "https://example.com"
                        }
                    ]
                },
                'web_page': {
                    "@context": "https://schema.org",
                    "@type": "WebPage",
                    "name": "",
                    "description": "",
                    "url": ""
                }
            };

            if (templates[selectedType]) {
                schemaDataTextarea.value = JSON.stringify(templates[selectedType], null, 2);
                updatePreview();
                validateJson();
            }
        });
    }

    // Format JSON functionality
    if (formatBtn) {
        formatBtn.addEventListener('click', function() {
            try {
                const jsonData = JSON.parse(schemaDataTextarea.value);
                schemaDataTextarea.value = JSON.stringify(jsonData, null, 2);
                updatePreview();
                validateJson();
            } catch (error) {
                alert('Cannot format invalid JSON: ' + error.message);
            }
        });
    }



    // Real-time validation
    schemaDataTextarea.addEventListener('input', debounce(function() {
        validateJson();
        updatePreview();
    }, 500));

    // Form submission
    document.getElementById('schemaForm').addEventListener('submit', function(e) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating...';

        try {
            JSON.parse(schemaDataTextarea.value);
        } catch (error) {
            e.preventDefault();
            alert('Please fix JSON syntax errors before submitting: ' + error.message);
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Create Schema';
            return false;
        }
    });

    function validateJson() {
        try {
            const jsonData = JSON.parse(schemaDataTextarea.value);
            updateJsonStatus('Valid JSON ✓', true);
            schemaDataTextarea.classList.remove('is-invalid');
            schemaDataTextarea.classList.add('is-valid');
            return true;
        } catch (error) {
            if (schemaDataTextarea.value.trim() === '') {
                updateJsonStatus('');
                schemaDataTextarea.classList.remove('is-invalid', 'is-valid');
            } else {
                updateJsonStatus('Invalid JSON: ' + error.message, false);
                schemaDataTextarea.classList.remove('is-valid');
                schemaDataTextarea.classList.add('is-invalid');
            }
            return false;
        }
    }

    function updateJsonStatus(message, isValid = null) {
        if (jsonStatus) {
            jsonStatus.textContent = message;
            jsonStatus.classList.remove('json-status-valid', 'json-status-invalid');
            if (isValid === true) {
                jsonStatus.classList.add('json-status-valid');
            } else if (isValid === false) {
                jsonStatus.classList.add('json-status-invalid');
            }
        }
    }

    function updatePreview() {
        try {
            const jsonData = JSON.parse(schemaDataTextarea.value);
            previewDiv.innerHTML = '<pre><code>' + JSON.stringify(jsonData, null, 2) + '</code></pre>';
        } catch (error) {
            if (schemaDataTextarea.value.trim() === '') {
                previewDiv.innerHTML = '<p class="text-muted mb-0">Enter schema data to see preview</p>';
            } else {
                previewDiv.innerHTML = '<p class="text-danger mb-0">Invalid JSON: ' + error.message + '</p>';
            }
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

    // Initial validation
    if (schemaDataTextarea.value.trim()) {
        validateJson();
        updatePreview();
    }
});
</script>

@endsection
