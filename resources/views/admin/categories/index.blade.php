@extends('layouts.admin.master')

@section('title', 'Categories')
@section('page-title', 'Categories')

@section('content')
<div class="container-fluid px-4">
    <!-- Header with action buttons -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manage Categories</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add New Category
        </a>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Categories Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header py-3 bg-light">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="m-0 font-weight-bold">All Categories</h6>
                </div>
                <div class="col-auto">
                    <form class="d-flex" action="{{ route('admin.categories.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search categories..." name="search" value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3" style="width: 50px">#</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Parent</th>
                            <th class="text-center">Featured</th>
                            <th class="text-center">Sort Order</th>
                            <th class="text-center">Articles</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td class="ps-3">{{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if ($category->image)
                                            <div class="me-3">
                                                <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="rounded" width="40">
                                            </div>
                                        @else
                                            <div class="me-3">
                                                <div class="bg-light rounded d-flex justify-content-center align-items-center" style="width: 40px; height: 40px">
                                                    <i class="bi bi-folder text-primary"></i>
                                                </div>
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-0">{{ $category->name }}</h6>
                                            @if ($category->description)
                                                <small class="text-muted">{{ Str::limit($category->description, 50) }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $category->slug }}</td>
                                <td>{{ $category->parent ? $category->parent->name : 'None' }}</td>
                                <td class="text-center">
                                    @if ($category->is_featured)
                                        <span class="badge bg-success">Yes</span>
                                    @else
                                        <span class="badge bg-secondary">No</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $category->sort_order ?: 'N/A' }}</td>
                                <td class="text-center">{{ $category->articles->count() }}</td>
                                <td class="text-end pe-3">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $category->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $category->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $category->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $category->id }}">Confirm Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-start">
                                                    <p>Are you sure you want to delete the category <strong>{{ $category->name }}</strong>?</p>
                                                    @if ($category->children->count() > 0)
                                                        <div class="alert alert-warning">
                                                            <i class="bi bi-exclamation-triangle me-2"></i>
                                                            This category has {{ $category->children->count() }} child categories that will need to be reassigned.
                                                        </div>
                                                    @endif
                                                    @if ($category->articles->count() > 0)
                                                        <div class="alert alert-warning">
                                                            <i class="bi bi-exclamation-triangle me-2"></i>
                                                            This category is assigned to {{ $category->articles->count() }} articles.
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="bi bi-folder-x text-muted mb-2" style="font-size: 2rem;"></i>
                                        <h5>No categories found</h5>
                                        <p class="text-muted">Get started by creating a new category</p>
                                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                                            <i class="bi bi-plus-circle me-1"></i> Add New Category
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($categories->hasPages())
            <div class="card-footer">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</div>
@endsection