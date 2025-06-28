@extends('layouts.seo')
@section('seo-content')
     <div class="page-content">
        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">SEO</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('seo.dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('seo.blogs.index') }}">Blogs</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($blog->title, 40) }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Blog Header -->
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <h4 class="card-title mb-2">{{ $blog->title }}</h4>
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <span class="badge bg-{{ $blog->status == 'published' ? 'success' : ($blog->status == 'draft' ? 'secondary' : 'warning') }}">
                                {{ ucfirst($blog->status) }}
                            </span>
                            @if($blog->category)
                            <span class="badge bg-info">{{ ucfirst($blog->category) }}</span>
                            @endif
                            @if($blog->focus_keyword)
                            <span class="badge bg-primary">Keyword: {{ $blog->focus_keyword }}</span>
                            @endif
                            <span class="text-muted small">
                                <i class="bx bx-time me-1"></i>{{ $blog->reading_time ?? 0 }} min read
                            </span>
                            <span class="text-muted small">
                                <i class="bx bx-calendar me-1"></i>{{ $blog->created_at->format('M d, Y') }}
                            </span>
                        </div>
                    </div>

                    <div class="dropdown d-none">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu">
                            @can('Edit Blogs', auth('seo')->user())
                            <li><a class="dropdown-item" href="{{ route('seo.blogs.edit', $blog) }}">
                                <i class="bx bx-edit me-2"></i>Edit Blog
                            </a></li>
                            @endcan
                            @can('Create Blogs', auth('seo')->user())
                            <li>
                                <form action="{{ route('seo.blogs.duplicate', $blog) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bx bx-copy me-2"></i>Duplicate
                                    </button>
                                </form>
                            </li>
                            @endcan
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" onclick="window.open('{{ url('/' . $blog->slug) }}', '_blank')">
                                <i class="bx bx-link-external me-2"></i>View Live
                            </a></li>
                            @can('Delete Blogs', auth('seo')->user())
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('seo.blogs.destroy', $blog) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bx bx-trash me-2"></i>Delete
                                    </button>
                                </form>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Featured Image -->
                @if($blog->featured_image)
                <div class="card">
                    <div class="card-body p-0">
                        <img src="{{ asset('storage/' . $blog->featured_image) }}"
                             alt="{{ $blog->title }}"
                             class="img-fluid w-100"
                             style="max-height: 400px; object-fit: cover;">
                    </div>
                </div>
                @endif

                <!-- Blog Content -->
                <div class="card {{ $blog->featured_image ? 'mt-4' : '' }}">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-file-text me-2"></i>Content
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($blog->excerpt)
                        <div class="alert alert-light">
                            <h6 class="alert-heading">Excerpt</h6>
                            <p class="mb-0">{{ $blog->excerpt }}</p>
                        </div>
                        @endif

                        <div class="blog-content">
                            {!! $blog->content !!}
                        </div>

                        @if($blog->tags)
                        <div class="mt-4 pt-3 border-top">
                            <h6 class="mb-2">Tags:</h6>
                            @foreach(explode(',', $blog->tags) as $tag)
                            <span class="badge bg-secondary me-2 mb-2">{{ trim($tag) }}</span>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Schema Markup -->
                @if($blog->schema_markup)
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-code-alt me-2"></i>Schema Markup
                        </h5>
                    </div>
                    <div class="card-body">
                        <pre class="bg-light p-3 rounded"><code>{{ $blog->schema_markup }}</code></pre>
                        <div class="mt-3">
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="copyToClipboard('schema-markup')">
                                <i class="bx bx-copy me-1"></i>Copy Schema
                            </button>
                            <a href="https://search.google.com/test/rich-results" target="_blank" class="btn btn-outline-info btn-sm">
                                <i class="bx bx-link-external me-1"></i>Test in Google
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- SEO Score -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0">
                            <i class="bx bx-trending-up me-2"></i>SEO Analysis
                        </h6>
                        {{-- <button type="button" class="btn btn-sm btn-outline-primary" id="refresh-seo">
                            <i class="bx bx-refresh"></i>
                        </button> --}}
                    </div>
                    <div class="card-body">
                        <!-- SEO Score Circle -->
                        <div class="text-center mb-4">
                            <div class="seo-score-circle mx-auto" data-score="{{ $seoData['score'] }}">
                                <div class="score-text">
                                    <span class="score">{{ $seoData['score'] }}</span>
                                    <span class="percent">%</span>
                                </div>
                            </div>
                            <h6 class="mt-2 mb-0">SEO Score</h6>
                            <small class="text-muted">
                                @if($seoData['score'] >= 80)
                                Excellent optimization!
                                @elseif($seoData['score'] >= 60)
                                Good, but can be improved
                                @else
                                Needs optimization
                                @endif
                            </small>
                        </div>

                        <!-- SEO Checklist -->
                        <div class="seo-checklist">
                            @foreach($seoData['analysis'] as $check => $result)
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3">
                                    <i class="bx bx-{{ $result['passed'] ? 'check-circle text-success' : 'x-circle text-danger' }} fs-5"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-medium">{{ $result['title'] ?? ucfirst(str_replace('_', ' ', $check)) }}</div>
                                    <small class="text-muted">{{ $result['message'] }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Blog Details -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="card-title mb-0">
                            <i class="bx bx-info-circle me-2"></i>Blog Details
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="text-center">
                                    <h4 class="text-primary mb-1">{{ str_word_count(strip_tags($blog->content)) }}</h4>
                                    <small class="text-muted">Words</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center">
                                    <h4 class="text-info mb-1">{{ $blog->reading_time ?? 0 }}</h4>
                                    <small class="text-muted">Min Read</small>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="small">
                            <div class="mb-2">
                                <strong>Created:</strong><br>
                                {{ $blog->created_at->format('F d, Y \a\t h:i A') }}
                            </div>
                            <div class="mb-2">
                                <strong>Last Updated:</strong><br>
                                {{ $blog->updated_at->format('F d, Y \a\t h:i A') }}
                            </div>
                            @if($blog->published_at)
                            <div class="mb-2">
                                <strong>Published:</strong><br>
                                {{ $blog->published_at->format('F d, Y \a\t h:i A') }}
                            </div>
                            @endif
                            @if($blog->author_id)
                            <div>
                                <strong>Author:</strong><br>
                                {{ $blog->author->name ?? 'Unknown' }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Search Preview -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="card-title mb-0">
                            <i class="bx bx-search me-2"></i>Search Engine Preview
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="google-preview">
                            <div class="google-url text-success small mb-1">
                                {{ url('/' . $blog->slug) }}
                            </div>
                            <h6 class="google-title text-primary mb-1">
                                {{ $blog->meta_title ?: $blog->title }}
                            </h6>
                            <p class="google-description text-muted small mb-0">
                                {{ $blog->meta_description ?: Str::limit(strip_tags($blog->content), 160) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Social Media Preview -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="card-title mb-0">
                            <i class="bx bx-share-alt me-2"></i>Social Media Preview
                        </h6>
                    </div>
                    <div class="card-body">
                        <!-- Facebook Preview -->
                        <div class="social-preview facebook-preview mb-3">
                            <h6 class="small text-primary mb-2">Facebook</h6>
                            <div class="border rounded p-2">
                                @if($blog->og_image || $blog->featured_image)
                                <img src="{{ asset('storage/' . ($blog->og_image ?: $blog->featured_image)) }}"
                                     alt="OG Image" class="img-fluid rounded mb-2" style="max-height: 120px; width: 100%; object-fit: cover;">
                                @endif
                                <div class="small">
                                    <div class="text-muted">{{ parse_url(url('/'), PHP_URL_HOST) }}</div>
                                    <div class="fw-bold">{{ $blog->og_title ?: $blog->title }}</div>
                                    <div class="text-muted">{{ $blog->og_description ?: $blog->meta_description ?: Str::limit(strip_tags($blog->content), 100) }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Twitter Preview -->
                        <div class="social-preview twitter-preview">
                            <h6 class="small text-info mb-2">Twitter</h6>
                            <div class="border rounded p-2">
                                @if($blog->featured_image)
                                <img src="{{ asset('storage/' . $blog->featured_image) }}"
                                     alt="Twitter Image" class="img-fluid rounded mb-2" style="max-height: 120px; width: 100%; object-fit: cover;">
                                @endif
                                <div class="small">
                                    <div class="fw-bold">{{ $blog->twitter_title ?: $blog->title }}</div>
                                    <div class="text-muted mb-1">{{ $blog->twitter_description ?: $blog->meta_description ?: Str::limit(strip_tags($blog->content), 100) }}</div>
                                    <div class="text-muted">{{ parse_url(url('/'), PHP_URL_HOST) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card mt-4 d-none">
                    <div class="card-header">
                        <h6 class="card-title mb-0">
                            <i class="bx bx-zap me-2"></i>Quick Actions
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            @can('Edit Blogs', auth('seo')->user())
                            <a href="{{ route('seo.blogs.edit', $blog) }}" class="btn btn-primary btn-sm">
                                <i class="bx bx-edit me-1"></i>Edit Blog
                            </a>
                            @endcan

                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="window.open('{{ url('/' . $blog->slug) }}', '_blank')">
                                <i class="bx bx-link-external me-1"></i>View Live
                            </button>

                            <button type="button" class="btn btn-outline-info btn-sm" onclick="shareOnSocial('facebook')">
                                <i class="bx bxl-facebook me-1"></i>Share on Facebook
                            </button>

                            <button type="button" class="btn btn-outline-info btn-sm" onclick="shareOnSocial('twitter')">
                                <i class="bx bxl-twitter me-1"></i>Share on Twitter
                            </button>

                            <button type="button" class="btn btn-outline-success btn-sm" onclick="copyToClipboard('blog-url')">
                                <i class="bx bx-copy me-1"></i>Copy URL
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@push('styles')
<style>
.blog-content {
    line-height: 1.8;
    font-size: 16px;
}

.blog-content h1, .blog-content h2, .blog-content h3 {
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.blog-content p {
    margin-bottom: 1.2rem;
}

.google-preview {
    border: 1px solid #e0e0e0;
    padding: 15px;
    border-radius: 8px;
    background: #fff;
}

.google-url { font-size: 14px; }
.google-title {
    font-size: 18px;
    cursor: pointer;
    line-height: 1.3;
}
.google-title:hover { text-decoration: underline; }
.google-description {
    font-size: 14px;
    line-height: 1.4;
}

.seo-score-circle {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    background: conic-gradient(
        #28a745 0deg,
        #28a745 calc(var(--score) * 3.6deg),
        #e9ecef calc(var(--score) * 3.6deg),
        #e9ecef 360deg
    );
}

.seo-score-circle::before {
    content: '';
    position: absolute;
    width: 90px;
    height: 90px;
    background: white;
    border-radius: 50%;
}

.score-text {
    position: relative;
    z-index: 2;
    text-align: center;
}

.score-text .score {
    font-size: 2rem;
    font-weight: bold;
    color: #333;
}

.score-text .percent {
    font-size: 1rem;
    color: #666;
}

.seo-checklist .bx-check-circle {
    color: #28a745 !important;
}

.seo-checklist .bx-x-circle {
    color: #dc3545 !important;
}

.social-preview img {
    border-radius: 4px;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

pre code {
    font-size: 12px;
    white-space: pre-wrap;
    word-wrap: break-word;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Set SEO score circle
    const scoreElement = $('.seo-score-circle');
    const score = scoreElement.data('score');
    scoreElement.css('--score', score);

    // Update circle color based on score
    let color = '#dc3545'; // red
    if (score >= 80) color = '#28a745'; // green
    else if (score >= 60) color = '#ffc107'; // yellow

    scoreElement.css('background', `conic-gradient(${color} 0deg, ${color} calc(${score} * 3.6deg), #e9ecef calc(${score} * 3.6deg), #e9ecef 360deg)`);

    // Refresh SEO analysis
    $('#refresh-seo').click(function() {
        const $btn = $(this);
        $btn.html('<i class="bx bx-loader-alt bx-spin"></i>');
        $btn.prop('disabled', true);

        $.ajax({
            url: `/seo/blogs/{{ $blog->id }}/analyze-seo`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                toastr.success('SEO analysis refreshed!');
                setTimeout(() => {
                    location.reload();
                }, 1000);
            },
            error: function() {
                toastr.error('Failed to refresh SEO analysis');
            },
            complete: function() {
                $btn.html('<i class="bx bx-refresh"></i>');
                $btn.prop('disabled', false);
            }
        });
    });

    // Delete confirmation
    $('.delete-form').submit(function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "This blog will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
});

// Copy to clipboard function
function copyToClipboard(type) {
    let text = '';

    switch(type) {
        case 'blog-url':
            text = '{{ url("/blog/" . $blog->slug) }}';
            break;
        case 'schema-markup':
            text = `{{ $blog->schema_markup }}`;
            break;
    }

    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(function() {
            toastr.success('Copied to clipboard!');
        });
    } else {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        toastr.success('Copied to clipboard!');
    }
}

// Social sharing functions
function shareOnSocial(platform) {
    const url = '{{ url("/blog/" . $blog->slug) }}';
    const title = '{{ addslashes($blog->title) }}';
    const description = '{{ addslashes($blog->meta_description ?: Str::limit(strip_tags($blog->content), 160)) }}';

    let shareUrl = '';

    switch(platform) {
        case 'facebook':
            shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
            break;
        case 'twitter':
            shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`;
            break;
    }

    if (shareUrl) {
        window.open(shareUrl, '_blank', 'width=600,height=400');
    }
}
</script>
@endpush
@endsection
