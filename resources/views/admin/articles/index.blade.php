@extends('layouts.admin.master')

@section('title', 'Articles')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<style>
    .product-image {
        width: 60px;
        height: 40px;
        overflow: hidden;
        border-radius: 4px;
    }
    
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .circleIcon {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.3s;
    }
    
    .circleIcon img {
        width: 18px;
        height: 18px;
    }
    
    .table-responsive-lg {
        overflow-x: auto;
    }
    
    .border-left-right {
        border-left: 1px solid #dee2e6;
        border-right: 1px solid #dee2e6;
    }
    
    /* Toggle Switch */
    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    }
    
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
    }
    
    .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
    }
    
    input:checked + .slider {
        background-color: #2196F3;
    }
    
    input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
    }
    
    input:checked + .slider:before {
        transform: translateX(26px);
    }
    
    .slider.round {
        border-radius: 34px;
    }
    
    .slider.round:before {
        border-radius: 50%;
    }
</style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <h4 class="mb-0">
                {{ __('Article List') }}
            </h4>
            <a href="{{ route('admin.articles.create') }}" class="btn py-2.5 btn-primary">
                <i class="bi bi-plus-circle me-1"></i>
                {{ __('Create New') }}
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="my-3 card">
            <div class="card-body">
                <!-- Filter and Search -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <form action="{{ route('admin.articles.index') }}" method="GET" class="d-flex">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search articles..." name="search" value="{{ $search ?? '' }}">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                                @if(isset($search) && $search)
                                    <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-x-lg"></i>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                    
                    <div class="col-md-3">
                        <form action="{{ route('admin.articles.index') }}" method="GET" id="categoryForm">
                            <select class="form-select" id="categoryFilter" name="category_id" onchange="this.form.submit()">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ isset($categoryId) && $categoryId == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if(isset($search) && $search)
                                <input type="hidden" name="search" value="{{ $search }}">
                            @endif
                            @if(isset($status) && $status)
                                <input type="hidden" name="status" value="{{ $status }}">
                            @endif
                        </form>
                    </div>
                    
                    <div class="col-md-3">
                        <form action="{{ route('admin.articles.index') }}" method="GET" id="statusForm">
                            <select class="form-select" id="statusFilter" name="status" onchange="this.form.submit()">
                                <option value="">All Statuses</option>
                                <option value="published" {{ isset($status) && $status == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="draft" {{ isset($status) && $status == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="private" {{ isset($status) && $status == 'private' ? 'selected' : '' }}>Private</option>
                            </select>
                            @if(isset($search) && $search)
                                <input type="hidden" name="search" value="{{ $search }}">
                            @endif
                            @if(isset($categoryId) && $categoryId)
                                <input type="hidden" name="category_id" value="{{ $categoryId }}">
                            @endif
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table border-left-right table-responsive-lg">
                        <thead>
                            <tr>
                                <th class="text-center">{{ __('SL') }}</th>
                                <th>{{ __('Thumbnail') }}</th>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Category') }}</th>
                                <th class="text-center">{{ __('Views') }}</th>
                                <th>{{ __('Created Date') }}</th>
                                <th class="text-center">{{ __('Status') }}</th>
                                <th class="text-center">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($articles as $key => $article)
                                <tr>
                                    <td class="text-center">{{ $articles->firstItem() + $key }}</td>

                                    <td>
                                        <div class="product-image">
                                            @if($article->featured_image)
                                                <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}">
                                            @else
                                                <div class="bg-light h-100 d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-image text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <td>
                                        <div>{{ Str::limit($article->title, 40) }}</div>
                                        <div class="small">
                                            @if($article->is_featured)
                                                <span class="badge bg-success me-1">Featured</span>
                                            @endif
                                            @if($article->is_premium)
                                                <span class="badge bg-warning me-1">Premium</span>
                                            @endif
                                        </div>
                                    </td>

                                    <td>
                                        {{ $article->category?->name ?? 'None' }}
                                    </td>

                                    <td class="text-center">
                                        {{ number_format($article->views_count) }}
                                    </td>

                                    <td>
                                        {{ $article->created_at->format('d M, Y') }} <br>
                                        <small>{{ $article->created_at->diffForHumans() }}</small>
                                    </td>

                                    <td class="text-center">
                                        <label class="switch mb-0" data-bs-toggle="tooltip" data-bs-placement="left"
                                            data-bs-title="{{ __('Status Update') }}">
                                            <a href="{{ route('admin.articles.toggle-status', $article->id) }}">
                                                <input type="checkbox" {{ $article->status == 'published' ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </a>
                                        </label>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="{{ route('admin.articles.edit', $article->id) }}"
                                                class="btn-outline-primary circleIcon" data-bs-toggle="tooltip"
                                                data-bs-placement="left" data-bs-title="{{ __('Edit') }}">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" 
                                                onsubmit="return confirm('Are you sure you want to delete this article?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger circleIcon" data-bs-toggle="tooltip"
                                                    data-bs-placement="left" data-bs-title="{{ __('Delete') }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="8">{{ __('No Data Found') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="my-3">
            {{ $articles->withQueryString()->links() }}
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endsection