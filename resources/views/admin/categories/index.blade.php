@extends('layouts.admin.master')

@section('title', 'Categories')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<style>
    .animate-fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    .bg-apple-blue {
        background-color: #0071e3;
    }
    
    .bg-apple-blue:hover {
        background-color: #0077ed;
    }
    
    .bg-apple-lightgray {
        background-color: #f5f5f7;
    }
    
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .card-header {
        background-color: #f5f5f7;
        font-weight: 500;
        padding: 0.75rem 1rem;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0, 113, 227, 0.05);
    }
    
    .dropdown-item:active {
        background-color: #0071e3;
    }
    
    .form-select:focus, .form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    
    .category-image {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 4px;
    }
    
    .nested-category {
        padding-left: 1.5rem;
        position: relative;
    }
    
    .nested-category:before {
        content: "";
        position: absolute;
        left: 0.5rem;
        top: 0;
        height: 100%;
        border-left: 1px solid #dee2e6;
    }
    
    .action-btn {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        margin-right: 5px;
    }
    
    .action-btn:last-child {
        margin-right: 0;
    }
    
    .action-btn i {
        font-size: 0.875rem;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4 animate-fade-in">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0">Categories</h1>
        
        <a href="{{ route('admin.categories.create') }}" class="btn bg-apple-blue text-white d-inline-flex align-items-center">
            <i class="bi bi-plus-lg me-2"></i>
            Create Category
        </a>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="card mb-4">
        <div class="card-header bg-apple-lightgray">
            <div class="row g-3 align-items-center">
                <div class="col-12 col-md-4">
                    <form action="{{ route('admin.categories.index') }}" method="GET" class="d-flex">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search categories..." name="search" value="{{ $search ?? '' }}">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                            @if(isset($search) && $search)
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
                
                <div class="col-12 col-md-3">
                    <form action="{{ route('admin.categories.index') }}" method="GET" id="filterForm">
                        <select class="form-select" id="parentFilter" name="parent_id" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                            @foreach($parentCategories as $parentCategory)
                                <option value="{{ $parentCategory->id }}" {{ isset($parentId) && $parentId == $parentCategory->id ? 'selected' : '' }}>
                                    {{ $parentCategory->name }}
                                </option>
                            @endforeach
                        </select>
                        @if(isset($search) && $search)
                            <input type="hidden" name="search" value="{{ $search }}">
                        @endif
                    </form>
                </div>
                
                <div class="col-12 col-md-5 text-md-end">
                    <span class="text-muted">{{ $categories->total() }} categories found</span>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            @if($categories->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-folder2-open display-4 text-muted mb-3"></i>
                    <p class="lead text-muted">No categories found.</p>
                    @if(isset($search) || isset($parentId))
                        <p>Try adjusting your search criteria.</p>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary mt-2">
                            <i class="bi bi-arrow-repeat me-1"></i> Reset Filters
                        </a>
                    @else
                        <a href="{{ route('admin.categories.create') }}" class="btn bg-apple-blue text-white mt-2">
                            <i class="bi bi-plus-lg me-1"></i> Create New Category
                        </a>
                    @endif
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th scope="col" width="60">#</th>
                                <th scope="col" width="80">Icon</th>
                                <th scope="col">Name</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Parent</th>
                                <th scope="col" width="100">Featured</th>
                                <th scope="col" width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $index => $category)
                                <tr>
                                    <td>{{ $categories->firstItem() + $index }}</td>
                                    <td>
                                        @if($category->icon)
                                            <img src="{{ Storage::url($category->icon) }}" class="category-image" alt="{{ $category->name }}">
                                        @else
                                            <div class="category-image bg-light d-flex align-items-center justify-content-center">
                                                <i class="bi bi-folder text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $category->name }}</div>
                                        @if($category->description)
                                            <div class="small text-muted">{{ Str::limit($category->description, 50) }}</div>
                                        @endif
                                    </td>
                                    <td>{{ $category->slug }}</td>
                                    <td>
                                        @if($category->parent)
                                            <a href="{{ route('admin.categories.index', ['parent_id' => $category->parent_id]) }}" class="text-decoration-none">
                                                {{ $category->parent->name }}
                                            </a>
                                        @else
                                            <span class="text-muted">None</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($category->is_featured)
                                            <span class="badge bg-success">Featured</span>
                                        @else
                                            <span class="badge bg-light text-dark">No</span>
                                        @endif
                                    </td>
                                    <td>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
            <i class="bi bi-pencil"></i>
        </a>
        
        <a href="{{ route('admin.categories.index', ['parent_id' => $category->id]) }}" class="btn btn-sm btn-outline-secondary" title="View Subcategories">
            <i class="bi bi-filter"></i>
        </a>
        
        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger" 
                title="Delete" 
                onclick="return confirm('Are you sure you want to delete this category?');">
                <i class="bi bi-trash"></i>
            </button>
        </form>
    </div>
</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-between align-items-center p-3 border-top">
                    <div>
                        <span class="text-muted">
                            Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} categories
                        </span>
                    </div>
                    <div>
                        {{ $categories->withQueryString()->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection