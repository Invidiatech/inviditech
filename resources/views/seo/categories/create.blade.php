@extends('layouts.seo')
@section('seo-content')
@include('loader.loader')
<link rel="stylesheet" href="{{ asset('assets/css/backend/category.css') }}" />

<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Categories</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('seo.dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('seo.categories.index') }}">Categories</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Category</li>
                </ol>
            </nav>
        </div>
    </div>

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bx bx-error-circle me-1"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-xl-9 mx-auto">
            <div class="card">
                <div class="card-body">
                    <div class="border p-4 rounded">
                        <div class="card-title d-flex align-items-center">
                            <div><i class="bx bx-plus me-1 font-22 text-primary"></i></div>
                            <h5 class="mb-0 text-primary">Create New Category</h5>
                        </div>
                        <hr/>

                        <form action="{{ route('seo.categories.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Parent Category</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                                        <option value="">Select Parent Category (Optional)</option>
                                        @foreach($parentCategories as $parent)
                                        <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Description</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                              rows="3" placeholder="Enter category description">{{ old('description') }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Category Image</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" 
                                           accept="image/*">
                                    <small class="text-muted">Accepted formats: JPG, PNG, GIF, WEBP. Max size: 2MB</small>
                                    @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Sort Order</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror" 
                                           value="{{ old('sort_order', 0) }}" min="0">
                                    <small class="text-muted">Higher numbers appear first</small>
                                    @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Status Toggles -->
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Status</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_active" 
                                               id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">Active</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Featured</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_featured" 
                                               id="is_featured" {{ old('is_featured') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_featured">Featured Category</label>
                                    </div>
                                </div>
                            </div>

                            <!-- SEO Meta Data -->
                            <hr>
                            <h6 class="mb-3 text-primary">SEO Meta Data</h6>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Meta Title</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" name="meta_title" class="form-control @error('meta_title') is-invalid @enderror" 
                                           value="{{ old('meta_title') }}" placeholder="SEO meta title">
                                    <small class="text-muted">Leave empty to use category name</small>
                                    @error('meta_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Meta Description</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <textarea name="meta_description" class="form-control @error('meta_description') is-invalid @enderror" 
                                              rows="2" placeholder="SEO meta description">{{ old('meta_description') }}</textarea>
                                    @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Meta Keywords</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" name="meta_keywords" class="form-control @error('meta_keywords') is-invalid @enderror" 
                                           value="{{ old('meta_keywords') }}" placeholder="keyword1, keyword2, keyword3">
                                    <small class="text-muted">Separate keywords with commas</small>
                                    @error('meta_keywords')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9 text-secondary">
                                    <button type="submit" class="btn btn-primary px-4">Create Category</button>
                                    <a href="{{ route('seo.categories.index') }}" class="btn btn-secondary px-4 ms-2">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate slug from name
    const nameInput = document.querySelector('input[name="name"]');
    const slugInput = document.querySelector('input[name="slug"]');
    
    nameInput.addEventListener('input', function() {
        if (!slugInput.value || slugInput.dataset.autoGenerated) {
            const slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
            
            slugInput.value = slug;
            slugInput.dataset.autoGenerated = 'true';
        }
    });
    
    slugInput.addEventListener('input', function() {
        // Remove auto-generated flag when user manually edits
        delete this.dataset.autoGenerated;
    });
});
</script>
@endsection3">
                                    <h6 class="mb-0">Category Name <span class="text-danger">*</span></h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name') }}" placeholder="Enter category name" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Slug</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" 
                                           value="{{ old('slug') }}" placeholder="Auto-generated from name">
                                    <small class="text-muted">Leave empty to auto-generate from name</small>
                                    @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-