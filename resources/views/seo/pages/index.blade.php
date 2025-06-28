@extends('layouts.seo')
@section('seo-content')
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">SEO</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('seo.dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pages</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            @can('Create Pages', auth('seo')->user())
            <a href="{{ route('seo.pages.create') }}" class="btn btn-primary">
                <i class="bx bx-plus"></i> Add New Page
            </a>
            @endcan
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">All Pages</h5>
        </div>
        <div class="card-body">
            <!-- Search and Filter Form -->
            <form method="GET" class="row g-3 mb-4 d-none">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search pages..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary">Filter</button>
                </div>
            </form>

            <!-- Pages Table -->
            <div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Status</th>
                            <th>SEO Score</th>
                            <th>Focus Keyword</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pages as $page)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($page->featured_image)
                                    <img src="{{ Storage::url($page->featured_image) }}" alt="" class="rounded-circle" width="40" height="40">
                                    @endif
                                    <div class="ms-2">
                                        <h6 class="mb-0">{{ $page->title }}</h6>
                                        <small class="text-muted">{{ Str::limit($page->excerpt, 50) }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $page->status == 'published' ? 'success' : ($page->status == 'draft' ? 'warning' : 'info') }}">
                                    {{ ucfirst($page->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="progress me-2" style="width: 60px; height: 6px;">
                                        <div class="progress-bar bg-{{ $page->seo_score >= 80 ? 'success' : ($page->seo_score >= 60 ? 'warning' : 'danger') }}"
                                             style="width: {{ $page->seo_score }}%"></div>
                                    </div>
                                    <span class="text-{{ $page->seo_score >= 80 ? 'success' : ($page->seo_score >= 60 ? 'warning' : 'danger') }}">
                                        {{ $page->seo_score }}%
                                    </span>
                                </div>
                            </td>
                            <td>
                                @if($page->focus_keyword)
                                    <span class="badge bg-light text-dark">{{ $page->focus_keyword }}</span>
                                @else
                                    <span class="text-muted">Not set</span>
                                @endif
                            </td>
                            <td>{{ $page->created_at->format('M d, Y') }}</td>
                            <td>
                                <div>
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu">
                                        @can('View Pages', auth('seo')->user())
                                        <li><a class="dropdown-item" href="{{ route('seo.pages.show', $page) }}"><i class="bx bx-show"></i> View</a></li>
                                        @endcan
                                        @can('Edit Pages', auth('seo')->user())
                                        <li><a class="dropdown-item" href="{{ route('seo.pages.edit', $page) }}"><i class="bx bx-edit"></i> Edit</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('seo.pages.duplicate', $page) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="dropdown-item"><i class="bx bx-copy"></i> Duplicate</button>
                                            </form>
                                        </li>
                                        @endcan
                                        @can('Delete Pages', auth('seo')->user())
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('seo.pages.destroy', $page) }}" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"><i class="bx bx-trash"></i> Delete</button>
                                            </form>
                                        </li>
                                        @endcan
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="bx bx-file display-4"></i>
                                    <p class="mt-2">No pages found.</p>
                                    @can('Create Pages', auth('seo')->user())
                                    <a href="{{ route('seo.pages.create') }}" class="btn btn-primary">Create Your First Page</a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            {{ $pages->links() }}
        </div>
    </div>
</div>
@endsection
