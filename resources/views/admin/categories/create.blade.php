@extends('layouts.admin.master')

@section('title', 'Create Category')
@section('page-title', 'Create Category')

@section('styles')
<style>
    .preview-image {
        max-width: 100%;
        max-height: 200px;
        object-fit: contain;
    }
    .image-preview-container {
        background-color: #f8f9fa;
        border-radius: 0.25rem;
        padding: 1rem;
        text-align: center;
    }
    .slug-preview {
        background-color: #e9ecef;
        border-radius: 0.25rem;
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        color: #495057;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <!-- Header with breadcrumb -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Create New Category</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to Categories
        </a>
    </div>

    <!-- Form Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header py-3 bg-light">
            <h6 class="m-0 font-weight-bold">Category Information</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <div class="input-group">
                                <span class="input-group-text">/category/</span>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug') }}">
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">Leave empty to generate automatically from the name.</small>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Brief description of this category for organizational purposes.</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="parent_id" class="form-label">Parent Category</label>
                                    <select class="form-select @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id">
                                        <option value="">None (Top Level Category)</option>
                                        @foreach ($parentCategories as $parentCategory)
                                            <option value="{{ $parentCategory->id }}" {{ old('parent_id') == $parentCategory->id ? 'selected' : '' }}>
                                                {{ $parentCategory->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sort_order" class="form-label">Sort Order</label>
                                    <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}">
                                    @error('sort_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Categories with lower numbers appear first.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-4">
                        <div class="card border shadow-sm mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Category Options</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">Featured Category</label>
                                    <div class="form-text">Featured categories may be highlighted in special sections.</div>
                                </div>
                            </div>
                        </div>

                        <div class="card border shadow-sm mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Category Image</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Upload Image</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Recommended size: 600x400px. Max size: 2MB.</small>
                                </div>
                                <div class="image-preview-container">
                                    <img id="preview" src="{{ asset('img/placeholder-image.png') }}" alt="Preview" class="preview-image d-none">
                                    <div id="placeholder" class="text-center py-4">
                                        <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                        <p class="mb-0">Image preview will appear here</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card border shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">SEO Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="meta_title" class="form-label">Meta Title</label>
                                    <input type="text" class="form-control @error('meta_title') is-invalid @enderror" id="meta_title" name="meta_title" value="{{ old('meta_title') }}">
                                    @error('meta_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="meta_description" class="form-label">Meta Description</label>
                                    <textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description" name="meta_description" rows="3">{{ old('meta_description') }}</textarea>
                                    @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Recommended length: 120-160 characters</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4 border-top pt-3">
                    <button type="reset" class="btn btn-light me-2">Reset</button>
                    <button type="submit" class="btn btn-primary">Create Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Name to slug conversion
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');
        
        nameInput.addEventListener('keyup', function() {
            if (!slugInput.value) {
                slugInput.value = nameInput.value
                    .toLowerCase()
                    .replace(/\s+/g, '-')
                    .replace(/[^\w\-]+/g, '')
                    .replace(/\-\-+/g, '-')
                    .replace(/^-+/, '')
                    .replace(/-+$/, '');
            }
        });
        
        // Image preview
        const imageInput = document.getElementById('image');
        const previewImage = document.getElementById('preview');
        const placeholderDiv = document.getElementById('placeholder');
        
        imageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.classList.remove('d-none');
                    placeholderDiv.classList.add('d-none');
                }
                
                reader.readAsDataURL(this.files[0]);
            } else {
                previewImage.classList.add('d-none');
                placeholderDiv.classList.remove('d-none');
            }
        });
        
        // Copy name to meta title if empty
        nameInput.addEventListener('blur', function() {
            const metaTitleInput = document.getElementById('meta_title');
            if (!metaTitleInput.value) {
                metaTitleInput.value = nameInput.value;
            }
        });
    });
</script>
@endsection