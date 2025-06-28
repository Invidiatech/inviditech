{{-- resources/views/seo/pages/show.blade.php --}}
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
                    <li class="breadcrumb-item active" aria-current="page">{{ $page->title }}</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            @can('Edit Pages', auth('seo')->user())
            <a href="{{ route('seo.pages.edit', $page) }}" class="btn btn-primary me-2">
                <i class="bx bx-edit"></i> Edit Page
            </a>
            @endcan
            @if($page->status == 'published')
            <a href="{{ url($page->slug) }}" target="_blank" class="btn btn-outline-success me-2">
                <i class="bx bx-link-external"></i> View Live
            </a>
            @endif
            <a href="{{ route('seo.pages.index') }}" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back"></i> Back to List
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Page Content -->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="card-title mb-1">{{ $page->title }}</h3>
                            <div class="d-flex gap-2 flex-wrap">
                                <span class="badge bg-{{ $page->status == 'published' ? 'success' : ($page->status == 'draft' ? 'warning' : 'info') }}">
                                    {{ ucfirst($page->status) }}
                                </span>
                                @if($page->focus_keyword)
                                <span class="badge bg-primary">{{ $page->focus_keyword }}</span>
                                @endif
                                <span class="badge bg-light text-dark">
                                    {{ str_word_count(strip_tags($page->content)) }} words
                                </span>
                                <span class="badge bg-light text-dark">
                                    {{ ceil(str_word_count(strip_tags($page->content)) / 200) }} min read
                                </span>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="h2 mb-0">
                                <span class="badge bg-{{ $page->seo_score >= 80 ? 'success' : ($page->seo_score >= 60 ? 'warning' : 'danger') }} fs-6">
                                    SEO: {{ $page->seo_score }}%
                                </span>
                            </div>
                            <small class="text-muted">Readability: {{ $page->readability_score ?? 0 }}/100</small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($page->excerpt)
                    <div class="alert alert-light border-start border-primary border-3 mb-4">
                        <strong>Excerpt:</strong> {{ $page->excerpt }}
                    </div>
                    @endif

                    @if($page->featured_image)
                    <div class="text-center mb-4">
                        <img src="{{ Storage::url($page->featured_image) }}" alt="{{ $page->title }}"
                             class="img-fluid rounded shadow">
                    </div>
                    @endif

                    <div class="content-preview">
                        {!! $page->content !!}
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="text-muted small">Author</div>
                            <div class="fw-bold">{{ $page->creator->name }}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-muted small">Created</div>
                            <div class="fw-bold">{{ $page->created_at->format('M d, Y') }}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-muted small">Last Updated</div>
                            <div class="fw-bold">{{ $page->updated_at->format('M d, Y') }}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-muted small">Publish Date</div>
                            <div class="fw-bold">
                                @if($page->publish_date)
                                    {{ $page->publish_date->format('M d, Y') }}
                                @else
                                    Not scheduled
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO Analysis Details -->
            @if(isset($seoAnalysis))
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Detailed SEO Analysis</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Title Analysis -->
                        <div class="col-md-6 mb-3">
                            <h6 class="text-primary">Title Tag Analysis</h6>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>Length: {{ $seoAnalysis['title_analysis']['length'] }} characters</span>
                                <span class="badge bg-{{ $seoAnalysis['title_analysis']['status'] == 'good' ? 'success' : ($seoAnalysis['title_analysis']['status'] == 'warning' ? 'warning' : 'danger') }}">
                                    {{ $seoAnalysis['title_analysis']['message'] }}
                                </span>
                            </div>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-{{ $seoAnalysis['title_analysis']['status'] == 'good' ? 'success' : ($seoAnalysis['title_analysis']['status'] == 'warning' ? 'warning' : 'danger') }}"
                                     style="width: {{ min(100, ($seoAnalysis['title_analysis']['length'] / 60) * 100) }}%"></div>
                            </div>
                        </div>

                        <!-- Meta Description Analysis -->
                        <div class="col-md-6 mb-3">
                            <h6 class="text-primary">Meta Description Analysis</h6>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>Length: {{ $seoAnalysis['meta_analysis']['length'] }} characters</span>
                                <span class="badge bg-{{ $seoAnalysis['meta_analysis']['status'] == 'good' ? 'success' : ($seoAnalysis['meta_analysis']['status'] == 'warning' ? 'warning' : 'danger') }}">
                                    {{ $seoAnalysis['meta_analysis']['message'] }}
                                </span>
                            </div>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-{{ $seoAnalysis['meta_analysis']['status'] == 'good' ? 'success' : ($seoAnalysis['meta_analysis']['status'] == 'warning' ? 'warning' : 'danger') }}"
                                     style="width: {{ min(100, ($seoAnalysis['meta_analysis']['length'] / 160) * 100) }}%"></div>
                            </div>
                        </div>

                        <!-- Keyword Analysis -->
                        <div class="col-md-6 mb-3">
                            <h6 class="text-primary">Keyword Analysis</h6>
                            <div class="mb-2">
                                <small class="text-muted">Focus Keyword:</small>
                                <span class="badge bg-{{ $seoAnalysis['keyword_analysis']['status'] == 'good' ? 'success' : ($seoAnalysis['keyword_analysis']['status'] == 'warning' ? 'warning' : 'danger') }}">
                                    {{ $page->focus_keyword ?: 'Not set' }}
                                </span>
                            </div>
                            @if($page->focus_keyword)
                            <div class="small mb-1">
                                <i class="bx bx-{{ $seoAnalysis['keyword_analysis']['in_title'] ? 'check text-success' : 'x text-danger' }}"></i>
                                In title
                            </div>
                            <div class="small mb-1">
                                <i class="bx bx-{{ $seoAnalysis['keyword_analysis']['in_meta_description'] ? 'check text-success' : 'x text-danger' }}"></i>
                                In meta description
                            </div>
                            <div class="small">
                                Density: {{ $seoAnalysis['keyword_analysis']['density'] }}%
                                ({{ $seoAnalysis['keyword_analysis']['count'] }}/{{ $seoAnalysis['keyword_analysis']['total_words'] }} words)
                            </div>
                            @endif
                        </div>

                        <!-- Content Analysis -->
                        <div class="col-md-6 mb-3">
                            <h6 class="text-primary">Content Analysis</h6>
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="h6 mb-0">{{ $seoAnalysis['content_analysis']['word_count'] }}</div>
                                    <small class="text-muted">Words</small>
                                </div>
                                <div class="col-6">
                                    <div class="h6 mb-0">{{ $seoAnalysis['content_analysis']['reading_time'] }}</div>
                                    <small class="text-muted">Min read</small>
                                </div>
                                <div class="col-6 mt-2">
                                    <div class="h6 mb-0">{{ $seoAnalysis['content_analysis']['paragraph_count'] }}</div>
                                    <small class="text-muted">Paragraphs</small>
                                </div>
                                <div class="col-6 mt-2">
                                    <div class="h6 mb-0">{{ array_sum($seoAnalysis['content_analysis']['headings']) }}</div>
                                    <small class="text-muted">Headings</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Heading Structure -->
                    @if(array_sum($seoAnalysis['content_analysis']['headings']) > 0)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6 class="text-primary">Heading Structure</h6>
                            <div class="d-flex gap-2 flex-wrap">
                                @foreach($seoAnalysis['content_analysis']['headings'] as $heading => $count)
                                    @if($count > 0)
                                    <span class="badge bg-light text-dark">{{ strtoupper($heading) }}: {{ $count }}</span>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Technical SEO Issues -->
                    @if(!empty($seoAnalysis['technical_analysis']['issues']) || !empty($seoAnalysis['technical_analysis']['warnings']))
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6 class="text-primary">Technical SEO</h6>

                            @if(!empty($seoAnalysis['technical_analysis']['issues']))
                            <div class="mb-2">
                                <small class="text-danger fw-bold">Issues:</small>
                                <ul class="list-unstyled mb-0 ms-3">
                                    @foreach($seoAnalysis['technical_analysis']['issues'] as $issue)
                                    <li class="text-danger small"><i class="bx bx-x-circle me-1"></i>{{ $issue }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            @if(!empty($seoAnalysis['technical_analysis']['warnings']))
                            <div class="mb-2">
                                <small class="text-warning fw-bold">Warnings:</small>
                                <ul class="list-unstyled mb-0 ms-3">
                                    @foreach($seoAnalysis['technical_analysis']['warnings'] as $warning)
                                    <li class="text-warning small"><i class="bx bx-error-circle me-1"></i>{{ $warning }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            @if(!empty($seoAnalysis['technical_analysis']['passed']))
                            <div class="mb-2">
                                <small class="text-success fw-bold">Passed:</small>
                                <ul class="list-unstyled mb-0 ms-3">
                                    @foreach($seoAnalysis['technical_analysis']['passed'] as $passed)
                                    <li class="text-success small"><i class="bx bx-check-circle me-1"></i>{{ $passed }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- SEO Suggestions -->
                    @if(!empty($seoAnalysis['suggestions']))
                    <div class="mt-3">
                        <h6 class="text-primary">SEO Suggestions</h6>
                        <ul class="list-unstyled">
                            @foreach($seoAnalysis['suggestions'] as $suggestion)
                            <li class="mb-2">
                                <i class="bx bx-info-circle text-info me-2"></i>{{ $suggestion }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            <!-- SEO Overview -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">SEO Overview</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="position-relative d-inline-block">
                            <svg width="120" height="120" class="circular-progress">
                                <circle cx="60" cy="60" r="50" fill="none" stroke="#e9ecef" stroke-width="8"/>
                                <circle cx="60" cy="60" r="50" fill="none"
                                        stroke="{{ $page->seo_score >= 80 ? '#198754' : ($page->seo_score >= 60 ? '#ffc107' : '#dc3545') }}"
                                        stroke-width="8" stroke-linecap="round"
                                        stroke-dasharray="{{ 2 * pi() * 50 }}"
                                        stroke-dashoffset="{{ 2 * pi() * 50 * (1 - $page->seo_score / 100) }}"
                                        transform="rotate(-90 60 60)"/>
                            </svg>
                            <div class="position-absolute top-50 start-50 translate-middle">
                                <div class="h3 mb-0">{{ $page->seo_score }}%</div>
                                <small class="text-muted">SEO Score</small>
                            </div>
                        </div>
                    </div>

                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <div class="h5 mb-0 text-{{ ($page->readability_score ?? 0) >= 60 ? 'success' : (($page->readability_score ?? 0) >= 30 ? 'warning' : 'danger') }}">
                                    {{ $page->readability_score ?? 0 }}
                                </div>
                                <small class="text-muted">Readability</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="h5 mb-0 text-info">{{ str_word_count(strip_tags($page->content)) }}</div>
                            <small class="text-muted">Words</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Meta Information -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Meta Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted small">URL Slug</label>
                        <div class="bg-light p-2 rounded small font-monospace">
                            {{ url($page->slug) }}
                        </div>
                    </div>

                    @if($page->meta_title)
                    <div class="mb-3">
                        <label class="form-label text-muted small">Meta Title</label>
                        <div class="bg-light p-2 rounded small">
                            {{ $page->meta_title }}
                        </div>
                        <small class="text-muted">{{ strlen($page->meta_title) }}/60 characters</small>
                    </div>
                    @endif

                    @if($page->meta_description)
                    <div class="mb-3">
                        <label class="form-label text-muted small">Meta Description</label>
                        <div class="bg-light p-2 rounded small">
                            {{ $page->meta_description }}
                        </div>
                        <small class="text-muted">{{ strlen($page->meta_description) }}/160 characters</small>
                    </div>
                    @endif

                    @if($page->meta_keywords)
                    <div class="mb-3">
                        <label class="form-label text-muted small">Keywords</label>
                        <div>
                            @foreach(explode(',', $page->meta_keywords) as $keyword)
                            <span class="badge bg-light text-dark me-1">{{ trim($keyword) }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($page->canonical_url)
                    <div class="mb-3">
                        <label class="form-label text-muted small">Canonical URL</label>
                        <div class="bg-light p-2 rounded small font-monospace">
                            <a href="{{ $page->canonical_url }}" target="_blank">{{ $page->canonical_url }}</a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Social Media Preview -->
            <div class="card d-none">
                <div class="card-header">
                    <h5 class="card-title">Social Media Preview</h5>
                </div>
                <div class="card-body">
                    <!-- Facebook Preview -->
                    <div class="mb-3">
                        <h6 class="text-primary mb-2">Facebook / Open Graph</h6>
                        <div class="border rounded p-3 bg-light">
                            @if($page->featured_image)
                            <img src="{{ Storage::url($page->featured_image) }}" alt="" class="img-fluid rounded mb-2" style="max-height: 120px;">
                            @endif
                            <div class="fw-bold text-primary small">{{ $page->og_title ?: $page->meta_title ?: $page->title }}</div>
                            <div class="text-muted small">{{ $page->og_description ?: $page->meta_description ?: Str::limit(strip_tags($page->content), 100) }}</div>
                            <div class="text-success small">{{ parse_url(url('/'))['host'] }}</div>
                        </div>
                    </div>

                    <!-- Twitter Preview -->
                    <div class="mb-3">
                        <h6 class="text-primary mb-2">Twitter Card</h6>
                        <div class="border rounded p-3 bg-light">
                            <div class="row align-items-center">
                                @if($page->featured_image)
                                <div class="col-4">
                                    <img src="{{ Storage::url($page->featured_image) }}" alt="" class="img-fluid rounded">
                                </div>
                                <div class="col-8">
                                @else
                                <div class="col-12">
                                @endif
                                    <div class="fw-bold small">{{ $page->twitter_title ?: $page->meta_title ?: $page->title }}</div>
                                    <div class="text-muted small">{{ $page->twitter_description ?: $page->meta_description ?: Str::limit(strip_tags($page->content), 80) }}</div>
                                    <div class="text-success small">{{ parse_url(url('/'))['host'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @can('Edit Pages', auth('seo')->user())
                        <a href="{{ route('seo.pages.edit', $page) }}" class="btn btn-primary">
                            <i class="bx bx-edit"></i> Edit Page
                        </a>

                        <form method="POST" action="{{ route('seo.pages.duplicate', $page) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary w-100">
                                <i class="bx bx-copy"></i> Duplicate Page
                            </button>
                        </form>
                        @endcan

                        @if($page->status == 'published')
                        <a href="{{ url($page->slug) }}" target="_blank" class="btn btn-outline-success d-none">
                            <i class="bx bx-link-external"></i> View Live Page
                        </a>
                        @endif
                        @can('Delete Pages', auth('seo')->user())
                        <hr>
                        <form method="POST" action="{{ route('seo.pages.destroy', $page) }}"
                              onsubmit="return confirm('Are you sure you want to delete this page? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="bx bx-trash"></i> Delete Page
                            </button>
                        </form>
                        @endcan
                    </div>
                </div>
            </div>

            <!-- Page Statistics -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Page Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="border-end">
                                <div class="h6 mb-0">{{ str_word_count(strip_tags($page->content)) }}</div>
                                <small class="text-muted">Total Words</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="h6 mb-0">{{ strlen(strip_tags($page->content)) }}</div>
                            <small class="text-muted">Characters</small>
                        </div>
                        <div class="col-6">
                            <div class="border-end">
                                <div class="h6 mb-0">{{ ceil(str_word_count(strip_tags($page->content)) / 200) }}</div>
                                <small class="text-muted">Min to Read</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="h6 mb-0">
                                @if($page->focus_keyword)
                                    {{ substr_count(strtolower($page->content), strtolower($page->focus_keyword)) }}
                                @else
                                    0
                                @endif
                            </div>
                            <small class="text-muted">Keyword Count</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.content-preview {
    line-height: 1.6;
}

.content-preview h1, .content-preview h2, .content-preview h3,
.content-preview h4, .content-preview h5, .content-preview h6 {
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.content-preview p {
    margin-bottom: 1rem;
}

.content-preview img {
    max-width: 100%;
    height: auto;
    margin: 1rem 0;
}

.circular-progress {
    transform: rotate(-90deg);
}

.progress-sm {
    height: 0.5rem;
}
</style>

<script>
function generateSeoReport() {
    // Show loading state
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="bx bx-loader bx-spin"></i> Generating...';
    btn.disabled = true;

    // Simulate report generation (replace with actual AJAX call)
    setTimeout(() => {
        // Reset button
        btn.innerHTML = originalText;
        btn.disabled = false;

        // Show success message
        if (typeof toastr !== 'undefined') {
            toastr.success('SEO report generated successfully!');
        } else {
            alert('SEO report generated successfully!');
        }

        // In a real implementation, you would:
        // 1. Make an AJAX call to generate the report
        // 2. Download or display the report
        // 3. Update any relevant statistics
    }, 2000);
}

function analyzePage() {
    if (confirm('This will re-analyze the page SEO score and readability. Continue?')) {
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="bx bx-loader bx-spin"></i> Analyzing...';
        btn.disabled = true;

        // Make AJAX call to re-analyze the page
        fetch(`{{ route('seo.pages.show', $page) }}/analyze`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            btn.innerHTML = originalText;
            btn.disabled = false;

            if (data.success) {
                if (typeof toastr !== 'undefined') {
                    toastr.success('Page analysis completed!');
                } else {
                    alert('Page analysis completed!');
                }
                // Optionally reload the page to show updated scores
                location.reload();
            } else {
                if (typeof toastr !== 'undefined') {
                    toastr.error('Analysis failed. Please try again.');
                } else {
                    alert('Analysis failed. Please try again.');
                }
            }
        })
        .catch(error => {
            btn.innerHTML = originalText;
            btn.disabled = false;
            if (typeof toastr !== 'undefined') {
                toastr.error('An error occurred during analysis.');
            } else {
                alert('An error occurred during analysis.');
            }
        });
    }
}

// Auto-refresh SEO preview every 30 seconds for draft pages
@if($page->status === 'draft')
setInterval(() => {
    // Optionally refresh certain elements for draft pages
    console.log('Auto-refresh for draft page (if needed)');
}, 30000);
@endif
</script>
@endsection
