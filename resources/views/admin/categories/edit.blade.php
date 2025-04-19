@extends('layouts.admin.master')

@section('title', 'Edit Category')

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
    
    .form-label {
        font-weight: 500;
    }
    
    .form-text {
        margin-top: 0.25rem;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    
    .required-indicator {
        color: #dc3545;
    }
    
    .image-preview-container {
        aspect-ratio: 1/1;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
        border: 1px dashed #dee2e6;
        border-radius: 0.375rem;
        overflow: hidden;
        transition: all 0.3s;
        max-width: 300px;
        margin: 0 auto;
    }
    
    .image-preview-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .char-counter {
        position: absolute;
        right: 10px;
        top: 0;
        font-size: 0.8rem;
        color: #6c757d;
    }
    
    .char-counter.warning {
        color: #fd7e14;
    }
    
    .char-counter.danger {
        color: #dc3545;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4 animate-fade-in">
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center">
                    <i class="bi bi-arrow-left me-1"></i>
                    <span>Back</span>
                </a>
                <h1 class="h3 mb-0">Edit Category: {{ $category->name }}</h1>
            </div>
            
            <div>
                <button type="submit" class="btn bg-apple-blue text-white d-inline-flex align-items-center">
                    <i class="bi bi-save me-2"></i>
                    Update Category
                </button>
            </div>
        </div>

        <hr class="mb-4">
        
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
                                id="name" name="name" value="{{ old('name', $category->name) }}" required>
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
                                    id="slug" name="slug" value="{{ old('slug', $category->slug) }}" placeholder="category-slug">
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
                                    <option value="{{ $parentCategory->id }}" {{ old('parent_id', $category->parent_id) == $parentCategory->id ? 'selected' : '' }}>
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
                                placeholder="Enter category description">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                id="sort_order" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}" min="0">
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
                                id="meta_title" name="meta_title" value="{{ old('meta_title', $category->meta_title) }}" 
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
                                placeholder="SEO-optimized description (120-160 characters)">{{ old('meta_description', $category->meta_description) }}</textarea>
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
                            @if($category->icon)
                                <img id="imagePreview" src="{{ Storage::url($category->icon) }}" alt="{{ $category->name }}">
                                <div id="imagePlaceholder" class="text-center py-4 d-none">
                                    <i class="bi bi-image text-muted fs-1 mb-2"></i>
                                    <p class="mb-0">No icon uploaded</p>
                                </div>
                            @else
                                <img id="imagePreview" src="#" alt="Preview" class="d-none">
                                <div id="imagePlaceholder" class="text-center py-4">
                                    <i class="bi bi-image text-muted fs-1 mb-2"></i>
                                    <p class="mb-0">No icon uploaded</p>
                                </div>
                            @endif
                        </div>
                        
                        @if($category->icon)
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remove_image" name="remove_image" value="1">
                                <label class="form-check-label" for="remove_image">Remove current icon</label>
                            </div>
                        @endif
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
                                    id="is_featured" name="is_featured" value="1" {{ old('is_featured', $category->is_featured) ? 'checked' : '' }}>
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
                            <i class="bi bi-save me-2"></i> Update Category
                        </button>
                        
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary d-block w-100">
                            <i class="bi bi-x-lg me-2"></i> Cancel
                        </a>
                    </div>
                </div>
                
                <!-- Delete Card -->
                <div class="card mb-4 border-danger">
                    <div class="card-header bg-danger text-white">
                        <h5 class="card-title mb-0">Danger Zone</h5>
                    </div>
                    
                    <div class="card-body p-4">
                        <p class="text-danger mb-3">Deleting this category cannot be undone. This will not delete any articles associated with this category.</p>
                        
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger d-block w-100">
                                <i class="bi bi-trash me-2"></i> Delete Category
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image preview
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');
        const imagePlaceholder = document.getElementById('imagePlaceholder');
        const removeImageCheckbox = document.getElementById('remove_image');
        
        if (imageInput) {
            imageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.classList.remove('d-none');
                        if (imagePlaceholder) {
                            imagePlaceholder.classList.add('d-none');
                        }
                        
                        // If there was a checkbox to remove the image, uncheck it
                        if (removeImageCheckbox) {
                            removeImageCheckbox.checked = false;
                        }
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
        
        // Handle remove image checkbox
        if (removeImageCheckbox) {
            removeImageCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    // Hide the image preview when "remove" is checked
                    imagePreview.classList.add('d-none');
                    if (imagePlaceholder) {
                        imagePlaceholder.classList.remove('d-none');
                    }
                } else {
                    // Show the image preview again when "remove" is unchecked
                    if (imagePreview.getAttribute('src') != '#') {
                        imagePreview.classList.remove('d-none');
                        if (imagePlaceholder) {
                            imagePlaceholder.classList.add('d-none');
                        }
                    }
                }
            });
        }
        
        // Character counters
        const metaTitle = document.getElementById('meta_title');
        const metaTitleCounter = document.getElementById('metaTitleCounter');
        const metaDesc = document.getElementById('meta_description');
        const metaDescCounter = document.getElementById('metaDescCounter');
        
        function updateCharCounter(input, counter, max) {
            if (input && counter) {
                input.addEventListener('input', function() {
                    const count = this.value.length;
                    counter.textContent = count + '/' + max;
                    
                    if (count > max) {
                        counter.classList.add('danger');
                        counter.classList.remove('warning');
                    } else if (count > max * 0.8) {
                        counter.classList.add('warning');
                        counter.classList.remove('danger');
                    } else {
                        counter.classList.remove('warning', 'danger');
                    }
                });
                
                // Trigger on load
                input.dispatchEvent(new Event('input'));
            }
        }
        
        updateCharCounter(metaTitle, metaTitleCounter, 60);
        updateCharCounter(metaDesc, metaDescCounter, 160);
        
        // Slug generation
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');
        
        function createSlug(text) {
            return text
                .toString()
                .toLowerCase()
                .trim()
                .replace(/\s+/g, '-')
                .replace(/[^\w\-]+/g, '')
                .replace(/\-\-+/g, '-');
        }
        
        if (nameInput && slugInput && slugInput.value === '') {
            nameInput.addEventListener('blur', function() {
                if (!slugInput.value) {
                    slugInput.value = createSlug(this.value);
                }
            });
        }
    });
</script>
@endsection