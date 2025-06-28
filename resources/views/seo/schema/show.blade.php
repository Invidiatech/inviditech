@extends('layouts.seo')

@section('title', 'View Schema Markup')

@section('seo-content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">{{ $schema->name }}</h1>
            <p class="text-muted">{{ \App\Models\Seo\SchemaMarkup::SCHEMA_TYPES[$schema->type] ?? $schema->type }} Schema Markup</p>
        </div>
        <div>
            <a href="{{ route('seo.schema.edit', $schema) }}" class="btn btn-primary me-2">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
            <a href="{{ route('seo.schema.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Schema Details -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Schema Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Name:</strong></div>
                        <div class="col-sm-9">{{ $schema->name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Type:</strong></div>
                        <div class="col-sm-9">
                            <span class="badge bg-info">{{ \App\Models\Seo\SchemaMarkup::SCHEMA_TYPES[$schema->type] ?? $schema->type }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Status:</strong></div>
                        <div class="col-sm-9">
                            <span class="badge bg-{{ $schema->status == 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($schema->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Validation:</strong></div>
                        <div class="col-sm-9">
                            @if($schema->validation_status === 'valid')
                                <span class="badge bg-success">
                                    <i class="fas fa-check me-1"></i>Valid
                                </span>
                            @elseif($schema->validation_status === 'invalid')
                                <span class="badge bg-danger">
                                    <i class="fas fa-times me-1"></i>Invalid
                                </span>
                            @else
                                <span class="badge bg-warning">
                                    <i class="fas fa-clock me-1"></i>Pending
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Pages:</strong></div>
                        <div class="col-sm-9">
                            @if($schema->pages && count($schema->pages) > 0)
                                <span class="badge bg-light text-dark">{{ count($schema->pages) }} specific pages</span>
                                <button class="btn btn-sm btn-outline-info ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#pagesList">
                                    View Pages
                                </button>
                                <div class="collapse mt-2" id="pagesList">
                                    <div class="bg-light p-2 rounded">
                                        @foreach($schema->pages as $page)
                                            <div class="mb-1">{{ $page }}</div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <span class="text-muted">Applied to all pages</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Created:</strong></div>
                        <div class="col-sm-9">{{ $schema->created_at->format('M d, Y H:i') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Updated:</strong></div>
                        <div class="col-sm-9">{{ $schema->updated_at->format('M d, Y H:i') }}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3"><strong>Created by:</strong></div>
                        <div class="col-sm-9">{{ $schema->creator->name ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>

            <!-- Validation Errors -->
            @if($schema->validation_status === 'invalid' && $schema->validation_errors)
            <div class="card mt-4">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Validation Errors</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($schema->validation_errors as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <!-- Schema Data -->
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Schema Data</h5>
                    <div>
                        <button class="btn btn-sm btn-outline-primary" id="copySchema">
                            <i class="fas fa-copy me-1"></i>Copy
                        </button>
                        <button class="btn btn-sm btn-outline-success" id="downloadSchema">
                            <i class="fas fa-download me-1"></i>Download
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="bg-light p-3 rounded">
                        <pre id="schemaCode"><code>{{ $schema->generateJsonLd() }}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Implementation Guide -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Implementation Guide</h5>
                </div>
                <div class="card-body">
                    <h6>How to implement this schema:</h6>
                    <ol>
                        <li>Copy the JSON-LD code above</li>
                        <li>Add it to your HTML page inside <code>&lt;script type="application/ld+json"&gt;</code> tags</li>
                        <li>Place it in the <code>&lt;head&gt;</code> section of your page</li>
                        <li>Test with Google's Rich Results Test tool</li>
                    </ol>
                    <h6 class="mt-4">Example HTML:</h6>
                    <div class="bg-light p-3 rounded">
                        <pre><code>&lt;script type="application/ld+json"&gt;
{{ $schema->generateJsonLd() }}
&lt;/script&gt;</code></pre>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('seo.schema.edit', $schema) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Edit Schema
                        </a>
                    </div>
                </div>
            </div>

            <!-- Schema Statistics -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Schema Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-primary">{{ count($schema->schema_data) }}</h4>
                                <small class="text-muted">Properties</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-info">{{ strlen($schema->generateJsonLd()) }}</h4>
                            <small class="text-muted">Characters</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Schema Type Info -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">{{ \App\Models\Seo\SchemaMarkup::SCHEMA_TYPES[$schema->type] ?? $schema->type }} Schema</h5>
                </div>
                <div class="card-body">
                    @switch($schema->type)
                        @case('local_business')
                            <p>Local Business schema helps search engines understand your business location, contact information, and operating hours.</p>
                            <strong>Benefits:</strong>
                            <ul class="small">
                                <li>Enhanced local search visibility</li>
                                <li>Rich snippets with business info</li>
                                <li>Google My Business integration</li>
                            </ul>
                            @break
                        @case('faq')
                            <p>FAQ schema markup helps your frequently asked questions appear directly in search results.</p>
                            <strong>Benefits:</strong>
                            <ul class="small">
                                <li>Expanded search result snippets</li>
                                <li>Increased click-through rates</li>
                                <li>Better user experience</li>
                            </ul>
                            @break
                        @case('article')
                            <p>Article schema provides search engines with detailed information about your articles and blog posts.</p>
                            <strong>Benefits:</strong>
                            <ul class="small">
                                <li>Enhanced article snippets</li>
                                <li>Author and publisher recognition</li>
                                <li>Publication date display</li>
                            </ul>
                            @break
                        @case('product')
                            <p>Product schema helps showcase your products with rich information in search results.</p>
                            <strong>Benefits:</strong>
                            <ul class="small">
                                <li>Product rich snippets</li>
                                <li>Price and availability display</li>
                                <li>Review stars and ratings</li>
                            </ul>
                            @break
                        @case('breadcrumb')
                            <p>Breadcrumb schema helps search engines understand your site's navigation structure.</p>
                            <strong>Benefits:</strong>
                            <ul class="small">
                                <li>Breadcrumb trail in results</li>
                                <li>Better site structure understanding</li>
                                <li>Improved user navigation</li>
                            </ul>
                            @break
                        @case('web_page')
                            <p>WebPage schema provides basic information about your web pages to search engines.</p>
                            <strong>Benefits:</strong>
                            <ul class="small">
                                <li>Better page understanding</li>
                                <li>Enhanced search snippets</li>
                                <li>Improved crawling</li>
                            </ul>
                            @break
                        @default
                            <p>This schema type helps provide structured data to search engines for better understanding of your content.</p>
                    @endswitch
                </div>
            </div>

            <!-- Validation History -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Validation History</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker
                                @if($schema->validation_status === 'valid') bg-success
                                @elseif($schema->validation_status === 'invalid') bg-danger
                                @else bg-warning @endif">
                            </div>
                            <div class="timeline-content">
                                <h6 class="mb-1">
                                    @if($schema->validation_status === 'valid')
                                        Schema Validated Successfully
                                    @elseif($schema->validation_status === 'invalid')
                                        Validation Failed
                                    @else
                                        Validation Pending
                                    @endif
                                </h6>
                                <small class="text-muted">{{ $schema->updated_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Schema Created</h6>
                                <small class="text-muted">{{ $schema->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Copy schema functionality
    document.getElementById('copySchema').addEventListener('click', function() {
        const schemaCode = document.getElementById('schemaCode').textContent;
        navigator.clipboard.writeText(schemaCode).then(function() {
            const btn = document.getElementById('copySchema');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check me-1"></i>Copied!';
            btn.classList.remove('btn-outline-primary');
            btn.classList.add('btn-success');

            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.classList.remove('btn-success');
                btn.classList.add('btn-outline-primary');
            }, 2000);
        }).catch(function() {
            alert('Failed to copy to clipboard');
        });
    });

    // Download schema functionality
    document.getElementById('downloadSchema').addEventListener('click', function() {
        const schemaCode = document.getElementById('schemaCode').textContent;
        const blob = new Blob([schemaCode], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = '{{ $schema->name }}-schema.json';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    });

    // Validate schema functionality
    document.getElementById('validateSchema').addEventListener('click', function() {
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
            body: JSON.stringify({ schema_id: {{ $schema->id }} })
        })
        .then(response => response.json())
        .then(data => {
            if (data.valid) {
                alert('Schema is valid!');
            } else {
                alert('Schema validation failed: ' + (data.errors ? data.errors.join(', ') : data.message));
            }
            location.reload();
        })
        .catch(error => {
            alert('Error validating schema');
            console.error('Error:', error);
        })
        .finally(() => {
            btn.innerHTML = originalHtml;
            btn.disabled = false;
        });
    });

    // Test rich results functionality
    document.getElementById('testRichResults').addEventListener('click', function() {
        const schemaCode = document.getElementById('schemaCode').textContent;
        const encodedSchema = encodeURIComponent(schemaCode);
        const testUrl = `https://search.google.com/test/rich-results?code=${encodedSchema}`;
        window.open(testUrl, '_blank');
    });

    // Duplicate schema functionality
    document.getElementById('duplicateSchema').addEventListener('click', function() {
        if (confirm('This will create a copy of this schema. Continue?')) {
            // Redirect to create page with pre-filled data
            const form = document.createElement('form');
            form.method = 'GET';
            form.action = '{{ route("seo.schema.create") }}';

            const nameInput = document.createElement('input');
            nameInput.type = 'hidden';
            nameInput.name = 'duplicate_name';
            nameInput.value = '{{ $schema->name }} (Copy)';

            const typeInput = document.createElement('input');
            typeInput.type = 'hidden';
            typeInput.name = 'duplicate_type';
            typeInput.value = '{{ $schema->type }}';

            const dataInput = document.createElement('input');
            dataInput.type = 'hidden';
            dataInput.name = 'duplicate_data';
            dataInput.value = document.getElementById('schemaCode').textContent;

            form.appendChild(nameInput);
            form.appendChild(typeInput);
            form.appendChild(dataInput);

            document.body.appendChild(form);
            form.submit();
        }
    });
});
</script>
