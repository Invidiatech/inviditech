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
                        <li class="breadcrumb-item active" aria-current="page">Blog Management</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- SEO Statistics Cards -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 d-none">
            <div class="col">
                <div class="card radius-10 border-start border-0 border-3 border-info">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Total Blogs</p>
                                <h4 class="my-1 text-info">{{ $seoStats['total_blogs'] }}</h4>
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto">
                                <i class='bx bx-book-open'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 border-start border-0 border-3 border-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Published</p>
                                <h4 class="my-1 text-success">{{ $seoStats['published_blogs'] }}</h4>
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                                <i class='bx bx-check-circle'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 border-start border-0 border-3 border-warning">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Avg SEO Score</p>
                                <h4 class="my-1 text-warning">{{ number_format($seoStats['avg_seo_score'], 1) }}%</h4>
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-blooker text-white ms-auto">
                                <i class='bx bx-trending-up'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 border-start border-0 border-3 border-danger">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Need SEO Fix</p>
                                <h4 class="my-1 text-danger">{{ $seoStats['blogs_missing_meta'] + $seoStats['blogs_missing_focus_keyword'] }}</h4>
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto">
                                <i class='bx bx-error-circle'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0">
                        <i class="bx bx-book-open me-2"></i>Blog Management
                    </h5>
                    @can('Create Blogs', auth('seo')->user())
                    <a href="{{ route('seo.blogs.create') }}" class="btn btn-primary">
                        <i class="bx bx-plus me-1"></i>Create New Blog
                    </a>
                    @endcan
                </div>
            </div>

            <div class="card-body">
                <!-- Filters -->
                <div class="row mb-4 d-none">
                    <div class="col-md-3">
                        <input type="text" name="search" class="form-control" placeholder="Search blogs..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="category" class="form-select">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ ucfirst($category) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" placeholder="From Date">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" placeholder="To Date">
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-outline-primary w-100">
                            <i class="bx bx-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Blogs Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead >
                            <tr>
                                <th width="5%">#</th>
                                <th width="30%">Title</th>
                                <th width="10%">Category</th>
                                <th width="10%">SEO Score</th>
                                <th width="10%">Status</th>
                                <th width="10%">Reading Time</th>
                                <th width="10%">Created</th>
                                <th width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($blogs as $blog)
                            <tr>
                                <td>{{ $loop->iteration + ($blogs->currentPage() - 1) * $blogs->perPage() }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($blog->featured_image)
                                        <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="Featured" class="rounded me-2" width="40" height="40" style="object-fit: cover;">
                                        @else
                                        <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="bx bx-image text-muted"></i>
                                        </div>
                                        @endif
                                        <div>
                                            <a href="{{ route('seo.blogs.show', $blog) }}" class="text-decoration-none fw-bold">
                                                {{ Str::limit($blog->title, 50) }}
                                            </a>
                                            @if($blog->focus_keyword)
                                            <br><small class="text-muted">Keyword: {{ $blog->focus_keyword }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($blog->category)
                                    <span class="badge bg-secondary">{{ ucfirst($blog->category) }}</span>
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($blog->seo_score > 0)
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 60px; height: 8px;">
                                            <div class="progress-bar
                                                @if($blog->seo_score >= 80) bg-success
                                                @elseif($blog->seo_score >= 60) bg-warning
                                                @else bg-danger
                                                @endif"
                                                role="progressbar"
                                                style="width: {{ $blog->seo_score }}%">
                                            </div>
                                        </div>
                                        <span class="small
                                            @if($blog->seo_score >= 80) text-success
                                            @elseif($blog->seo_score >= 60) text-warning
                                            @else text-danger
                                            @endif">
                                            {{ $blog->seo_score }}%
                                        </span>
                                    </div>
                                    @else
                                    <span class="text-muted">Not analyzed</span>
                                    @endif
                                </td>
                                <td>
                                @if ($blog->status == 'draft')
                                   <span class="badge bg-secondary">Draft</span>
                                     @elseif ($blog->status == 'published')
                                     <span class="badge bg-success">Published</span>
                                     @elseif ($blog->status == 'scheduled')
                                    <span class="badge bg-info text-dark">Scheduled</span>
                                     @endif
                                    </td>
                                <td>
                                    <i class="bx bx-time text-muted me-1"></i>
                                    {{ $blog->reading_time ?? 0 }} min
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $blog->created_at->format('M d, Y') }}
                                        <br>{{ $blog->created_at->format('h:i A') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        @can('View Blogs', auth('seo')->user())
                                        <a href="{{ route('seo.blogs.show', $blog->id) }}" class="btn btn-sm btn-outline-info d-none" title="View">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        @endcan

                                        @can('Edit Blogs', auth('seo')->user())
                                        <a href="{{ route('seo.blogs.edit', $blog->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        @endcan

                                        @can('Create Blogs', auth('seo')->user())
                                        <form action="{{ route('seo.blogs.duplicate', $blog->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-secondary d-none" title="Duplicate">
                                                <i class="bx bx-copy"></i>
                                            </button>
                                        </form>
                                        @endcan

                                        @can('Delete Blogs', auth('seo')->user())
                                        <form action="{{ route('seo.blogs.destroy', $blog->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bx bx-book-open display-4"></i>
                                        <p class="mt-3">No blogs found</p>
                                        @can('Create Blogs', auth('seo')->user())
                                        <a href="{{ route('seo.blogs.create') }}" class="btn btn-primary">
                                            <i class="bx bx-plus me-1"></i>Create Your First Blog
                                        </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($blogs->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $blogs->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

@push('styles')
<style>
.status-select {
    width: auto;
    min-width: 100px;
}
.progress {
    background-color: #f0f0f0;
}
.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Status update via AJAX
    $('.status-select').change(function() {
        let blogId = $(this).data('blog-id');
        let status = $(this).val();

        $.ajax({
            url: `/seo/blogs/${blogId}/status`,
            method: 'PATCH',
            data: {
                _token: '{{ csrf_token() }}',
                status: status
            },
            success: function(response) {
                if(response.success) {
                    toastr.success(response.message);
                }
            },
            error: function() {
                toastr.error('Failed to update status');
                location.reload();
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

    // Filter form auto-submit
    $('input[name="search"], select[name="status"], select[name="category"], input[name="date_from"], input[name="date_to"]').change(function() {
        $(this).closest('form').submit();
    });
});
</script>
@endpush
@endsection
