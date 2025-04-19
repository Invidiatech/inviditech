@extends('layouts.admin.master')
@section('title', 'Create Category')
@section('content')
<div class="container-fluid py-4 animate-fade-in">
    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center">
                    <i class="bi bi-arrow-left me-1"></i>
                    <span>Back</span>
                </a>
                <h1 class="h3 mb-0">Create New Category</h1>
            </div>
            
            <div>
                <button type="submit" class="btn bg-apple-blue text-white d-inline-flex align-items-center">
                    <i class="bi bi-save me-2"></i>
                    Create Category
                </button>
            </div>
        </div>

        <hr class="mb-4">
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <!-- Main Column -->
            <div class="col-lg-8">
                <!-- Basic Information Card -->
                <div class="card mb-4">
                    <div class="card-header bg-apple-lightgray">
                        <h5 class="card-title mb-0">Basic Information</h5>
                    </div>
                    
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="required-indicator">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="slug" class="form-label d-flex justify-content-between">
                                <span>Slug</span>
                                <small class="text-muted">Auto-generated from name if left empty</small>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">/category/</span>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                    id="slug" name="slug" value="{{ old('slug') }}" placeholder="category-slug">
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="parent_id" class="form-label">Parent Category</label>
                            <select class="form-select @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id">
                                <option value="">None (Top Level Category)</option>
                                @foreach($parentCategories as $parentCategory)
                                    <option value="{{ $parentCategory->id }}" {{ old('parent_id') == $parentCategory->id ? 'selected' : '' }}>
                                        {{ $parentCategory->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Select a parent category if this is a subcategory</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                id="description" name="description" rows="5" 
                                placeholder="Enter category description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Lower numbers will be displayed first</small>
                        </div>
                    </div>
                </div>
                
                <!-- SEO Card -->
                <div class="card mb-4">
                    <div class="card-header bg-apple-lightgray">
                        <h5 class="card-title mb-0">SEO Information</h5>
                    </div>
                    
                    <div class="card-body p-4">
                        <div class="mb-3 position-relative">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                                id="meta_title" name="meta_title" value="{{ old('meta_title') }}" 
                                placeholder="SEO-optimized title (50-60 characters)">
                            <span class="char-counter" id="metaTitleCounter">0/60</span>
                            @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Leave empty to use category name</small>
                        </div>
                        
                        <div class="mb-3 position-relative">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                id="meta_description" name="meta_description" rows="3" 
                                placeholder="SEO-optimized description (120-160 characters)">{{ old('meta_description') }}</textarea>
                            <span class="char-counter" id="metaDescCounter">0/160</span>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Recommended length: 120-160 characters</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar Column -->
            <div class="col-lg-4">
                <!-- Image Card -->
                <div class="card mb-4">
                    <div class="card-header bg-apple-lightgray">
                        <h5 class="card-title mb-0">Category Icon</h5>
                    </div>
                    
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label for="image" class="form-label">Upload Icon</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Recommended size: 600x600px. Max size: 2MB.</small>
                        </div>
                        
                        <div class="image-preview-container mb-3">
                            <img id="imagePreview" src="#" alt="Preview" class="d-none">
                            <div id="imagePlaceholder" class="text-center py-4">
                                <i class="bi bi-image text-muted fs-1 mb-2"></i>
                                <p class="mb-0">Icon preview will appear here</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Settings Card -->
                <div class="card mb-4">
                    <div class="card-header bg-apple-lightgray">
                        <h5 class="card-title mb-0">Settings</h5>
                    </div>
                    
                    <div class="card-body p-4">
                        <div class="mb-0">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" 
                                    id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">Featured Category</label>
                            </div>
                            <small class="form-text text-muted">Featured categories appear in prominent positions</small>
                        </div>
                    </div>
                </div>
                
                <!-- Action Card -->
                <div class="card mb-4">
                    <div class="card-body p-4">
                        <button type="submit" class="btn bg-apple-blue text-white d-block w-100 mb-2">
                            <i class="bi bi-save me-2"></i> Save Category
                        </button>
                        
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary d-block w-100">
                            <i class="bi bi-x-lg me-2"></i> Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection