@extends('layouts.seo')
@section('seo-content')
<div class="page-content">
    <div id="loading-overlay" class="loading-overlay">
        <div class="spinner-container">
            <div class="pulse-loader">
                <div class="pulse-loader__circle"></div>
                <div class="pulse-loader__circle"></div>
                <div class="pulse-loader__circle"></div>
            </div>
            <h4 class="loading-text">Loading<span class="dot-animation">.</span><span  class="dot-animation">.</span><span class="dot-animation">.</span></h4>
            <div class="progress-bar">
                <div class="progress-bar__fill"></div>
            </div>
        </div>
    </div>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Products</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="d-flex gap-2">
                <a href="{{ route('seo.products.index') }}" class="btn btn-light px-3 rounded-pill">
                    <i class="bx bx-arrow-back"></i> Back
                </a>
                <button type="button" class="btn btn-primary px-3 rounded-pill">
                    <i class="bx bx-upload"></i> Upload Product
                </button>
                <button type="button" class="btn btn-light px-3 rounded-pill">
                    <i class="bx bx-download"></i> Download
                </button>
            </div>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <form action="{{ route('seo.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="productForm">
                @csrf
                @method('PUT')
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="card-title m-0 fw-bold fs-4">Edit Product: {{ $product->title }}</h5>
                </div>

                <div class="row">
                    <!-- Left Column: Image Upload -->
                    <div class="col-md-4 mb-4">
                        <div class="mb-4">
                            <label class="form-label fw-bold mb-3">Upload Main Image</label>
                            <div class="upload-area border rounded-4 d-flex flex-column align-items-center justify-content-center p-4 bg-light" id="mainImageDrop" style="min-height: 200px; cursor: pointer;">
                                <input type="file" class="d-none" id="main_image" name="main_image" accept="image/*" onchange="previewMainImage(this)">
                                <div class="upload-icon mb-3">
                                    <i class="bx bx-upload fs-1 text-primary"></i>
                                </div>
                                <div id="main-image-preview-container" class="text-center w-100 mb-2" style="{{ $product->getMainImageAttribute() ? 'display: block;' : 'display: none;' }}">
                                    <img id="mainImagePreview" src="{{ $product->getMainImageAttribute() ? asset('storage/' . $product->getMainImageAttribute()->filepath) : '' }}" class="img-fluid rounded-3" style="max-height: 150px;">
                                </div>
                                <p class="mb-1 text-center">Drag and drop your file here</p>
                                <p class="text-muted small text-center mb-2">or</p>
                                 @error('main_image')
                                    <div class="text-danger mt-2 small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="form-label fw-bold mb-3">Upload Other Images</label>
                            <div class="upload-area border rounded-4 d-flex flex-column align-items-center justify-content-center p-4 bg-light" id="galleryImagesDrop" style="min-height: 150px; cursor: pointer;">
                                <input type="file" class="d-none" id="gallery_images" name="gallery_images[]" multiple accept="image/*" onchange="previewGalleryImages(this)">
                                <div class="upload-icon mb-2">
                                    <i class="bx bx-images fs-1 text-primary"></i>
                                </div>
                                <p class="mb-1 text-center">Drag and drop your images here</p>
                                <p class="text-muted small text-center mb-2">or</p>
                                 @error('gallery_images')
                                    <div class="text-danger mt-2 small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div id="gallery-preview-container" class="d-flex flex-wrap gap-2 mt-3">
    <!-- Hidden input to store deleted file IDs -->
    <input type="hidden" name="deleted_images" id="deleted-images" value="">

    @foreach($product->files()->where('is_main', false)->get() as $file)
    <div class="gallery-preview">
        <img src="{{ asset('storage/' . $file->filepath) }}" class="shadow-sm" alt="Gallery Image">
        <div class="remove-img" data-file-id="{{ $file->id }}">
            <i class="bx bx-x"></i>
        </div>
    </div>
    @endforeach
</div>

                        </div>
                    </div>

                    <!-- Right Column: Product Details -->
                    <div class="col-md-8">
                        <div class="row">
                            <!-- Product Title -->
                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label fw-bold">Product Title <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control rounded-pill @error('title') is-invalid @enderror"
                                        id="title" name="title" placeholder="Product title..." value="{{ old('title', $product->title) }}" required>
                                    <span class="input-group-text bg-transparent border-0">
                                        <i class="bx bx-check-circle text-success"></i>
                                    </span>
                                </div>
                                @error('title')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Select Product Category -->
                            <div class="col-md-6 mb-3">
                                <label for="category_id" class="form-label fw-bold">Select Product Category <span class="text-danger">*</span></label>
                                <select class="form-select rounded-pill @error('category_id') is-invalid @enderror"
                                    id="category_id" name="category_id" required>
                                    <option value="">Category</option>
                                    @foreach($categories['mainCategories'] as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Price -->
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label fw-bold">Price <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.01" min="0" class="form-control rounded-pill @error('price') is-invalid @enderror"
                                        id="price" name="price" value="{{ old('price', $product->price) }}" required readonly>
                                    <span class="input-group-text bg-transparent border-0">
                                        <i class="bx bx-check-circle text-success"></i>
                                    </span>
                                </div>
                                @error('price')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Sale Price -->
                            <div class="col-md-6 mb-3">
                                <label for="cut_price" class="form-label fw-bold">Sale Price</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" min="0" class="form-control rounded-pill @error('cut_price') is-invalid @enderror"
                                        id="cut_price" name="cut_price" value="{{ old('cut_price', $product->cut_price) }}" readonly>
                                    <span class="input-group-text bg-transparent border-0">
                                        <i class="bx bx-check-circle text-success"></i>
                                    </span>
                                </div>
                                @error('cut_price')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                      <!-- Inventory -->
                      <div class="col-md-6 mb-3">
                                <label for="stock" class="form-label fw-bold">Inventory</label>
                                <div class="input-group">
                                    <input type="number" step="1" min="0" class="form-control rounded-pill @error('stock') is-invalid @enderror"
                                        id="stock" name="stock" value="{{ old('stock', $product->stock) }}">
                                    <span class="input-group-text bg-transparent border-0">
                                        <i class="bx bx-check-circle text-success"></i>
                                    </span>
                                </div>
                                @error('stock')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Stock Status -->
                            <div class="col-md-6 mb-3">
                                <label for="stock_status" class="form-label fw-bold">Stock Status <span class="text-danger">*</span></label>
                                <select class="form-select rounded-pill @error('stock_status') is-invalid @enderror"
                                    id="stock_status" name="stock_status" required>
                                    <option value="IN" {{ old('stock_status', $product->stock_status) == 'IN' ? 'selected' : '' }}>In Stock</option>
                                    <option value="OUT" {{ old('stock_status', $product->stock_status) == 'OUT' ? 'selected' : '' }}>Out of Stock</option>
                                    <option value="PREORDER" {{ old('stock_status', $product->stock_status) == 'PREORDER' ? 'selected' : '' }}>Pre-Order</option>
                                </select>
                                @error('stock_status')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Barcode -->
                            <div class="col-md-6 mb-3">
                                <label for="barcode" class="form-label fw-bold">Barcode</label>
                                <div class="input-group">
                                    <input type="text" class="form-control rounded-pill @error('barcode') is-invalid @enderror"
                                        id="barcode" name="barcode" placeholder="Type..." value="{{ old('barcode', $product->barcode) }}">
                                    <span class="input-group-text bg-transparent border-0">
                                        <i class="bx bx-check-circle text-success"></i>
                                    </span>
                                </div>
                                @error('barcode')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- SKU -->
                            <div class="col-md-6 mb-3">
                                <label for="SKU" class="form-label fw-bold">SKU</label>
                                <div class="input-group">
                                    <input type="text" class="form-control rounded-pill @error('SKU') is-invalid @enderror"
                                        id="SKU" name="SKU" placeholder="Type..." value="{{ old('SKU', $product->SKU) }}">
                                    <span class="input-group-text bg-transparent border-0">
                                        <i class="bx bx-check-circle text-success"></i>
                                    </span>
                                </div>
                                @error('SKU')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Extra Tax -->
                            <div class="col-md-6 mb-3 d-none">
                                <label for="tax" class="form-label fw-bold">Extra Tax</label>
                                <div class="input-group">
                                    <select class="form-select rounded-pill" id="tax" name="tax">
                                        <option value="type">Type</option>
                                        <option value="no_tax" {{ old('tax', $product->tax ?? '') == 'no_tax' ? 'selected' : '' }}>No Tax</option>
                                        <option value="standard" {{ old('tax', $product->tax ?? '') == 'standard' ? 'selected' : '' }}>Standard Rate (20%)</option>
                                        <option value="reduced" {{ old('tax', $product->tax ?? '') == 'reduced' ? 'selected' : '' }}>Reduced Rate (5%)</option>
                                    </select>
                                    <span class="input-group-text bg-transparent border-0">
                                        <i class="bx bx-check-circle text-success"></i>
                                    </span>
                                </div>
                            </div>

                            <!-- Min/Max Buy -->
                            <div class="col-md-6 mb-3">
                                <label for="min_buy" class="form-label fw-bold">Min Purchase Quantity</label>
                                <input type="number" min="1" class="form-control rounded-pill @error('min_buy') is-invalid @enderror"
                                    id="min_buy" name="min_buy" value="{{ old('min_buy', $product->min_buy) }}">
                                @error('min_buy')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="max_buy" class="form-label fw-bold">Max Purchase Quantity</label>
                                <input type="number" min="1" class="form-control rounded-pill @error('max_buy') is-invalid @enderror"
                                    id="max_buy" name="max_buy" value="{{ old('max_buy', $product->max_buy) }}">
                                @error('max_buy')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Weight -->
                            <div class="col-md-6 mb-3">
                                <label for="weight" class="form-label fw-bold">Weight (g)</label>
                                <input type="number" min="0" class="form-control rounded-pill @error('weight') is-invalid @enderror"
                                    id="weight" name="weight" value="{{ old('weight', $product->weight) }}">
                                @error('weight')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Low Stock Limit -->
                            <div class="col-md-6 mb-3">
                                <label for="low_limit" class="form-label fw-bold">Low Stock Alert Limit</label>
                                <input type="number" min="0" class="form-control rounded-pill @error('low_limit') is-invalid @enderror"
                                    id="low_limit" name="low_limit" value="{{ old('low_limit', $product->low_limit) }}">
                                @error('low_limit')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Sub/Child Categories -->
                            <div class="col-md-6 mb-3 d-none">
                                <label for="sub_category" class="form-label fw-bold">Sub Category</label>
                                <select class="form-select rounded-pill @error('sub_category') is-invalid @enderror"
                                    id="sub_category" name="sub_category">
                                    <option value="">Select Sub Category</option>
                                    <!-- Will be populated via JavaScript -->
                                </select>
                                @error('sub_category')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3  d-none">
                                <label for="child_category" class="form-label fw-bold">Child Category</label>
                                <select class="form-select rounded-pill @error('child_category') is-invalid @enderror"
                                    id="child_category" name="child_category">
                                    <option value="">Select Child Category</option>
                                    <!-- Will be populated via JavaScript -->
                                </select>
                                @error('child_category')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Risk Level -->
                            <div class="col-md-6 mb-3  d-none">
                                <label for="high_risk" class="form-label fw-bold">High Risk Product</label>
                                <select class="form-select rounded-pill @error('high_risk') is-invalid @enderror"
                                    id="high_risk" name="high_risk">
                                    <option value="0" {{ old('high_risk', $product->high_risk) == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ old('high_risk', $product->high_risk) == '1' ? 'selected' : '' }}>Yes</option>
                                </select>
                                @error('high_risk')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3  d-none">
                                <label for="question_risk" class="form-label fw-bold">Question Risk Level</label>
                                <select class="form-select rounded-pill @error('question_risk') is-invalid @enderror"
                                    id="question_risk" name="question_risk">
                                    <option value="Low_risk" {{ old('question_risk', $product->question_risk) == 'Low_risk' ? 'selected' : '' }}>Low Risk</option>
                                    <option value="High_risk" {{ old('question_risk', $product->question_risk) == 'High_risk' ? 'selected' : '' }}>High Risk</option>
                                </select>
                                @error('question_risk')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Product Template -->
                            <div class="col-md-6 mb-3  d-none">
                                <label for="product_template" class="form-label fw-bold">Product Template <span class="text-danger">*</span></label>
                                <select class="form-select rounded-pill @error('product_template') is-invalid @enderror"
                                    id="product_template" name="product_template" required>
                                    <option value="1" {{ old('product_template', $product->product_template) == '1' ? 'selected' : '' }}>Standard Template</option>
                                    <option value="2" {{ old('product_template', $product->product_template) == '2' ? 'selected' : '' }}>Medical Template</option>
                                    <option value="3" {{ old('product_template', $product->product_template) == '3' ? 'selected' : '' }}>Weight Loss Template</option>
                                </select>
                                @error('product_template')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Leaflet Link -->
                            <div class="col-md-6 mb-3  d-none">
                                <label for="leaflet_link" class="form-label fw-bold">Leaflet Link</label>
                                <input type="url" class="form-control rounded-pill @error('leaflet_link') is-invalid @enderror"
                                    id="leaflet_link" name="leaflet_link" placeholder="https://example.com/leaflet.pdf" value="{{ old('leaflet_link', $product->leaflet_link) }}">
                                @error('leaflet_link')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tags -->
                            <div class="col-md-6 mb-3  d-none">
                                <label for="tags" class="form-label fw-bold">Product Tags</label>
                                <input type="text" class="form-control rounded-pill @error('tags') is-invalid @enderror"
                                    id="tags" name="tags" placeholder="Enter tags separated by commas" value="{{ old('tags', is_array($product->tags) ? implode(', ', $product->tags) : $product->tags) }}">
                                @error('tags')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Status Fields -->
                        <div class="d-flex gap-4 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="status" name="status" value="1"
                                    {{ old('status', $product->status) == '1' ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="status">Active</label>
                            </div>

                            <div class="form-check form-switch">

                                <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1"
                                    {{ old('is_featured', $product->is_featured) == '1' ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="is_featured">Featured</label>
                            </div>

                            <div class="form-check form-switch">

                                <input class="form-check-input" type="checkbox" id="is_week_deal" name="is_week_deal" value="1"
                                    {{ old('is_week_deal', $product->is_week_deal) == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_week_deal">Deal Of Week</label>
                            </div>

                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_bestseller" name="is_bestseller" value="1"
                                    {{ old('is_bestseller', $product->is_bestseller) == '1' ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="is_bestseller">Bestseller</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Description -->
                <div class="row mt-4">
                    <div class="col-12 mb-4">
                        <label for="short_desc" class="form-label fw-bold">Short Description</label>
                        <textarea class="form-control @error('short_desc') is-invalid @enderror"
                            id="short_desc" name="short_desc" rows="2" placeholder="Enter short description">{{ old('short_desc', $product->short_desc) }}</textarea>
                        @error('short_desc')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 mb-4">
                        <label for="desc" class="form-label fw-bold">Full Description <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('desc') is-invalid @enderror"
                            id="desc" name="desc" rows="6" placeholder="Enter full product description">{{ old('desc', $product->desc) }}</textarea>
                        @error('desc')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="row mt-2  d-none">
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold">Product Specifications</label>
                        <div id="specifications-container">
                            @if(old('specifications'))
                                @foreach(old('specifications') as $index => $spec)
                                    <div class="row mb-2 specification-row">
                                        <div class="col-md-5">
                                            <input type="text" class="form-control rounded-pill @error('specifications.'.$index.'.key') is-invalid @enderror"
                                                name="specifications[{{ $index }}][key]" placeholder="Feature" value="{{ $spec['key'] ?? '' }}">
                                            @error('specifications.'.$index.'.key')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control rounded-pill @error('specifications.'.$index.'.value') is-invalid @enderror"
                                                name="specifications[{{ $index }}][value]" placeholder="Value" value="{{ $spec['value'] ?? '' }}">
                                            @error('specifications.'.$index.'.value')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-outline-danger btn-sm rounded-pill" onclick="removeSpecification(this)">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @elseif(isset($product->additional_info) && is_array($product->additional_info))
                                @foreach($product->additional_info as $index => $spec)
                                    <div class="row mb-2 specification-row">
                                        <div class="col-md-5">
                                            <input type="text" class="form-control rounded-pill" name="specifications[{{ $index }}][key]" placeholder="Feature" value="{{ $spec['key'] ?? '' }}">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control rounded-pill" name="specifications[{{ $index }}][value]" placeholder="Value" value="{{ $spec['value'] ?? '' }}">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-outline-danger btn-sm rounded-pill" onclick="removeSpecification(this)">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="row mb-2 specification-row">
                                    <div class="col-md-5">
                                        <input type="text" class="form-control rounded-pill" name="specifications[0][key]" placeholder="Feature">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control rounded-pill" name="specifications[0][value]" placeholder="Value">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-danger btn-sm rounded-pill" onclick="removeSpecification(this)">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill mt-2" onclick="addSpecification()">
                            <i class="bx bx-plus"></i> Add Specification
                        </button>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold">Usage Instructions</label>
                        <div id="instructions-container">
                            @if(old('usage_instructions'))
                                @foreach(old('usage_instructions') as $index => $instruction)
                                    <div class="row mb-2 instruction-row">
                                        <div class="col-md-10">
                                            <input type="text" class="form-control rounded-pill @error('usage_instructions.'.$index) is-invalid @enderror"
                                                name="usage_instructions[]" placeholder="Instruction" value="{{ $instruction }}">
                                            @error('usage_instructions.'.$index)
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-outline-danger btn-sm rounded-pill" onclick="removeInstruction(this)">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @elseif(isset($product->usage_instructions) && is_array($product->usage_instructions))
                                @foreach($product->usage_instructions as $index => $instruction)
                                    <div class="row mb-2 instruction-row">
                                        <div class="col-md-10">
                                            <input type="text" class="form-control rounded-pill" name="usage_instructions[]" placeholder="Instruction" value="{{ $instruction }}">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-outline-danger btn-sm rounded-pill" onclick="removeInstruction(this)">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="row mb-2 instruction-row">
                                    <div class="col-md-10">
                                        <input type="text" class="form-control rounded-pill" name="usage_instructions[]" placeholder="Instruction">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-danger btn-sm rounded-pill" onclick="removeInstruction(this)">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill mt-2" onclick="addInstruction()">
                            <i class="bx bx-plus"></i> Add Instruction
                        </button>
                    </div>
                </div>

                <!-- SEO Information -->
                <div class="row mt-2">
                    <div class="col-12 mb-3">
                        <h5 class="fw-bold">SEO Information</h5>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="meta_title" class="form-label fw-bold">Meta Title</label>
                        <input type="text" class="form-control rounded-pill @error('meta_title') is-invalid @enderror"
                            id="meta_title" name="meta_title" placeholder="Enter meta title"
                            value="{{ old('meta_title', $product->meta_data['meta_title'] ?? '') }}">
                        @error('meta_title')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="meta_keywords" class="form-label fw-bold">Meta Keywords</label>
                        <input type="text" class="form-control rounded-pill @error('meta_keywords') is-invalid @enderror"
                            id="meta_keywords" name="meta_keywords" placeholder="Enter meta keywords (comma separated)"
                            value="{{ old('meta_keywords', $product->meta_data['meta_keywords'] ?? '') }}">
                        @error('meta_keywords')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label for="meta_description" class="form-label fw-bold">Meta Description</label>
                        <textarea class="form-control @error('meta_description') is-invalid @enderror"
                            id="meta_description" name="meta_description" rows="3" placeholder="Enter meta description">{{ old('meta_description', $product->meta_data['meta_description'] ?? '') }}</textarea>
                        @error('meta_description')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                     <div class="col-12 mb-3">
                        <label for="meta_description" class="form-label fw-bold">Product Slug</label>
                        <textarea class="form-control @error('slug') is-invalid @enderror"
                            id="slug" name="slug" rows="3" placeholder="Enter meta description">{{ old('slug', $product->slug ?? '') }}</textarea>
                        @error('slug')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Variants Section -->
                <div class="mt-5 mb-3">
                    <div class="d-flex align-items-center mb-4">
                        <h5 class="card-title m-0 fw-bold fs-5">Product Variants</h5>
                        <button type="button" class="btn btn-primary btn-sm rounded-pill ms-auto" id="addVariantBtn">
                            <i class="bx bx-plus"></i> Add
                        </button>
                    </div>

                    <div id="variants-container">
                        @if($product->variants->count() > 0)
                            @foreach($product->variants as $index => $variant)
                            <div class="variant-row bg-light p-3 rounded-4 mb-3">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <div class="upload-area border rounded-4 d-flex flex-column align-items-center justify-content-center p-3 bg-white variant-image-area" style="min-height: 150px; cursor: pointer;">
                                            <input type="file" class="d-none variant-image" name="variant_images[]" accept="image/*" onchange="previewVariantImage(this)">
                                            <div class="upload-icon mb-2">
                                                <i class="bx bx-upload fs-3 text-primary"></i>
                                            </div>
                                            <div class="variant-image-preview-container text-center w-100 mb-2" style="{{ $variant->getMainImageAttribute() ? 'display: block;' : 'display: none;' }}">
                                                <img src="{{ $variant->getMainImageAttribute() ? asset('storage/' . $variant->getMainImageAttribute()->filepath) : '' }}" class="variant-image-preview img-fluid rounded-3" style="max-height: 100px;">
                                            </div>
                                            <p class="mb-0 text-center small">Upload Variant Image</p>
                                            <p class="text-muted small text-center">Drag and drop or browse</p>
                                        </div>
                                    </div>

                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label small fw-bold">Variant Price</label>
                                                <input type="number" step="0.01" class="form-control form-control-sm rounded-pill" name="variant_prices[]" placeholder="0.00" value="{{ $variant->price }}" Price  readonly>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label small fw-bold">Variant Name</label>
                                                <input type="text" class="form-control form-control-sm rounded-pill" name="variant_names[]" placeholder="e.g. Size, Color" value="{{ isset($variant->options[0]['name']) ? $variant->options[0]['name'] : '' }}">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label small fw-bold">Variant Value</label>
                                                <input type="text" class="form-control form-control-sm rounded-pill" name="variant_values[]" placeholder="e.g. Large, Red" value="{{ isset($variant->options[0]['value']) ? $variant->options[0]['value'] : '' }}">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label small fw-bold">Bar Code</label>
                                                <input type="text" class="form-control form-control-sm rounded-pill" name="variant_barcodes[]" placeholder="Variant Barcode" value="{{ $variant->barcode }}">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label small fw-bold">Inventory</label>
                                                <input type="number" class="form-control form-control-sm rounded-pill" name="variant_stocks[]" placeholder="0" value="{{ $variant->stock }}">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label small fw-bold">SKU</label>
                                                <input type="text" class="form-control form-control-sm rounded-pill" name="variant_skus[]" placeholder="Variant SKU" value="{{ $variant->SKU }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-pill remove-variant">
                                            <i class="bx bx-trash"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <!-- Initial variant fields will be added here -->
                            <div class="variant-row bg-light p-3 rounded-4 mb-3">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <div class="upload-area border rounded-4 d-flex flex-column align-items-center justify-content-center p-3 bg-white variant-image-area" style="min-height: 150px; cursor: pointer;">
                                            <input type="file" class="d-none variant-image" name="variant_images[]" accept="image/*" onchange="previewVariantImage(this)">
                                            <div class="upload-icon mb-2">
                                                <i class="bx bx-upload fs-3 text-primary"></i>
                                            </div>
                                            <div class="variant-image-preview-container text-center w-100 mb-2" style="display: none;">
                                                <img src="" class="variant-image-preview img-fluid rounded-3" style="max-height: 100px;">
                                            </div>
                                            <p class="mb-0 text-center small">Upload Main Image</p>
                                            <p class="text-muted small text-center">Drag and drop or browse</p>
                                        </div>
                                    </div>

                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label small fw-bold">Variant Price</label>
                                                <input type="number" step="0.01" class="form-control form-control-sm rounded-pill" name="variant_prices[]" placeholder="0.00">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label small fw-bold">Variant Name</label>
                                                <input type="text" class="form-control form-control-sm rounded-pill" name="variant_names[]" placeholder="e.g. Size, Color">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label small fw-bold">Variant Value</label>
                                                <input type="text" class="form-control form-control-sm rounded-pill" name="variant_values[]" placeholder="e.g. Large, Red">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label small fw-bold">Bar Code</label>
                                                <input type="text" class="form-control form-control-sm rounded-pill" name="variant_barcodes[]" placeholder="Variant Barcode">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label small fw-bold">Inventory</label>
                                                <input type="number" class="form-control form-control-sm rounded-pill" name="variant_stocks[]" placeholder="0">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label small fw-bold">SKU</label>
                                                <input type="text" class="form-control form-control-sm rounded-pill" name="variant_skus[]" placeholder="Variant SKU">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-pill remove-variant">
                                            <i class="bx bx-trash"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary py-2 px-4 rounded-pill">
                        <i class="bx bx-save me-1"></i> Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Include CKEditor 5 -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Track deleted image IDs
    let deletedImages = [];

    // Attach event listeners to existing remove buttons
    document.querySelectorAll('.remove-img').forEach(btn => {
        btn.addEventListener('click', function() {
            const fileId = this.dataset.fileId;
            if (fileId) {
                deletedImages.push(fileId);
                document.getElementById('deleted-images').value = deletedImages.join(',');
            }

            // Remove the image container from DOM
            this.closest('.gallery-preview').remove();
        });
    });

    // Function to preview new gallery images
    window.previewGalleryImages = function(input) {
        const container = document.getElementById('gallery-preview-container');

        if (input.files && input.files.length > 0) {
            for (let i = 0; i < input.files.length; i++) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const imgContainer = document.createElement('div');
                    imgContainer.className = 'gallery-preview';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'shadow-sm';

                    const removeBtn = document.createElement('div');
                    removeBtn.className = 'remove-img';
                    removeBtn.innerHTML = '<i class="bx bx-x"></i>';
                    removeBtn.onclick = function() {
                        imgContainer.remove();
                    };

                    imgContainer.appendChild(img);
                    imgContainer.appendChild(removeBtn);
                    container.appendChild(imgContainer);
                };

                reader.readAsDataURL(input.files[i]);
            }
        }
    };
});
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize CKEditor
        ClassicEditor
            .create(document.querySelector('#desc'), {
                toolbar: [
                    'heading', '|', 'bold', 'italic', 'underline', '|',
                    'bulletedList', 'numberedList', '|', 'link', 'blockQuote', '|',
                    'undo', 'redo'
                ],
                removePlugins: ['CKFinderUploadAdapter', 'CKFinder']
            })
            .catch(error => {
                console.error('Error initializing CKEditor:', error);
            });

        // Drag and drop functionality for main image
        const mainImageDrop = document.getElementById('mainImageDrop');
        const mainImageInput = document.getElementById('main_image');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            mainImageDrop.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            mainImageDrop.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            mainImageDrop.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            mainImageDrop.classList.add('border-primary');
        }

        function unhighlight() {
            mainImageDrop.classList.remove('border-primary');
        }

        mainImageDrop.addEventListener('drop', handleMainImageDrop, false);

        function handleMainImageDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;

            if (files.length) {
                mainImageInput.files = files;
                previewMainImage(mainImageInput);
            }
        }

        mainImageDrop.addEventListener('click', function() {
            mainImageInput.click();
        });

        // Drag and drop for gallery images
        const galleryImagesDrop = document.getElementById('galleryImagesDrop');
        const galleryImagesInput = document.getElementById('gallery_images');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            galleryImagesDrop.addEventListener(eventName, preventDefaults, false);
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            galleryImagesDrop.addEventListener(eventName, function() {
                galleryImagesDrop.classList.add('border-primary');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            galleryImagesDrop.addEventListener(eventName, function() {
                galleryImagesDrop.classList.remove('border-primary');
            }, false);
        });

        galleryImagesDrop.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt.files;

            if (files.length) {
                galleryImagesInput.files = files;
                previewGalleryImages(galleryImagesInput);
            }
        }, false);

        galleryImagesDrop.addEventListener('click', function() {
            galleryImagesInput.click();
        });

        // Setup variant image area drop and click events
        setupVariantImageEvents();

        // Add variant button functionality
        const addVariantBtn = document.getElementById('addVariantBtn');
        const variantsContainer = document.getElementById('variants-container');

        addVariantBtn.addEventListener('click', function() {
            const variantTemplate = variantsContainer.querySelector('.variant-row').cloneNode(true);

            // Reset the form field values
            variantTemplate.querySelectorAll('input[type="text"], input[type="number"]').forEach(input => {
                input.value = '';
            });

            // Reset the image preview
            const previewContainer = variantTemplate.querySelector('.variant-image-preview-container');
            if (previewContainer) {
                previewContainer.style.display = 'none';
            }

            // Setup new variant image area
            setupVariantImageArea(variantTemplate.querySelector('.variant-image-area'));

            // Setup remove button
            variantTemplate.querySelector('.remove-variant').addEventListener('click', function() {
                this.closest('.variant-row').remove();
            });

            variantsContainer.appendChild(variantTemplate);
        });

        // Setup initial variant remove buttons
        document.querySelectorAll('.remove-variant').forEach(button => {
            button.addEventListener('click', function() {
                if (variantsContainer.querySelectorAll('.variant-row').length > 1) {
                    this.closest('.variant-row').remove();
                } else {
                    alert('You need at least one variant option');
                }
            });
        });

        // Setup gallery image removal
        document.querySelectorAll('.gallery-preview .remove-img').forEach(button => {
            button.addEventListener('click', function() {
                const fileId = this.dataset.fileId;
                if (fileId) {
                    // Create a hidden input to mark this file for deletion
                    const deleteInput = document.createElement('input');
                    deleteInput.type = 'hidden';
                    deleteInput.name = 'delete_files[]';
                    deleteInput.value = fileId;
                    document.getElementById('productForm').appendChild(deleteInput);
                }
                this.closest('.gallery-preview').remove();
            });
        });

        // Handle category hierarchy
        const mainCategorySelect = document.getElementById('category_id');
        const subCategorySelect = document.getElementById('sub_category');
        const childCategorySelect = document.getElementById('child_category');

        // Category data from database
        const categories = {!! json_encode($categories['allCategories']) !!};

        // Populate subcategories when main category changes
        if (mainCategorySelect) {
            mainCategorySelect.addEventListener('change', function() {
                const selectedMainId = this.value;
                populateSubCategories(selectedMainId);
                // Reset child category
                childCategorySelect.innerHTML = '<option value="">Select Child Category</option>';
            });
        }

        // Populate child categories when sub category changes
        if (subCategorySelect) {
            subCategorySelect.addEventListener('change', function() {
                const selectedSubId = this.value;
                populateChildCategories(selectedSubId);
            });
        }

        // Initial population if values are already selected
        if (mainCategorySelect.value) {
            populateSubCategories(mainCategorySelect.value);

            // Set the selected sub category value after populating options
            setTimeout(() => {
                if ({{ old('sub_category', $product->sub_category ?? 'null') }}) {
                    subCategorySelect.value = {{ old('sub_category', $product->sub_category ?? 'null') }};
                    populateChildCategories(subCategorySelect.value);

                    // Set the selected child category value after populating options
                    setTimeout(() => {
                        if ({{ old('child_category', $product->child_category ?? 'null') }}) {
                            childCategorySelect.value = {{ old('child_category', $product->child_category ?? 'null') }};
                        }
                    }, 100);
                }
            }, 100);
        }

        // Function to populate subcategories dropdown
        function populateSubCategories(parentId) {
            subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>';

            if (!parentId) return;

            const subCategories = categories.filter(cat => cat.parent_id == parentId);

            subCategories.forEach(cat => {
                const option = document.createElement('option');
                option.value = cat.id;
                option.textContent = cat.name;
                subCategorySelect.appendChild(option);
            });
        }

        // Function to populate child categories dropdown
        function populateChildCategories(parentId) {
            childCategorySelect.innerHTML = '<option value="">Select Child Category</option>';

            if (!parentId) return;

            const childCategories = categories.filter(cat => cat.parent_id == parentId);

            childCategories.forEach(cat => {
                const option = document.createElement('option');
                option.value = cat.id;
                option.textContent = cat.name;
                childCategorySelect.appendChild(option);
            });
        }
    });

    // Setup variant image areas (for drag, drop and click events)
    function setupVariantImageEvents() {
        const variantImageAreas = document.querySelectorAll('.variant-image-area');
        variantImageAreas.forEach(area => {
            setupVariantImageArea(area);
        });
    }

    // Setup individual variant image area
    function setupVariantImageArea(area) {
        const variantImageInput = area.querySelector('.variant-image');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            area.addEventListener(eventName, function(e) {
                e.preventDefault();
                e.stopPropagation();
            }, false);
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            area.addEventListener(eventName, function() {
                area.classList.add('border-primary');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            area.addEventListener(eventName, function() {
                area.classList.remove('border-primary');
            }, false);
        });

        area.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt.files;

            if (files.length) {
                variantImageInput.files = files;
                previewVariantImage(variantImageInput);
            }
        }, false);

        area.addEventListener('click', function() {
            variantImageInput.click();
        });
    }

    // Preview main image before upload
    function previewMainImage(input) {
        const previewContainer = document.getElementById('main-image-preview-container');
        const preview = document.getElementById('mainImagePreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.style.display = 'block';
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            previewContainer.style.display = 'none';
        }
    }

    // Preview gallery images before upload
    function previewGalleryImages(input) {
        const container = document.getElementById('gallery-preview-container');
        let removedImages = [];

function removeImage(fileId, element) {
    // Add the image ID to the removed list
    removedImages.push(fileId);
    document.getElementById('removed-images').value = JSON.stringify(removedImages);

    // Remove image from the view
    element.closest('.gallery-preview').remove();
}

        if (input.files && input.files.length > 0) {
            for (let i = 0; i < input.files.length; i++) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const imgContainer = document.createElement('div');
                    imgContainer.className = 'gallery-preview';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'shadow-sm';

                    const removeBtn = document.createElement('div');
                    removeBtn.className = 'remove-img';
                    removeBtn.innerHTML = '<i class="bx bx-x"></i>';
                    removeBtn.onclick = function() {
                        // This is just visual removal, doesn't affect the file input
                        imgContainer.remove();
                    }

                    imgContainer.appendChild(img);
                    imgContainer.appendChild(removeBtn);
                    container.appendChild(imgContainer);
                }

                reader.readAsDataURL(input.files[i]);
            }
        }
    }

    // Preview variant image
    function previewVariantImage(input) {
        const variantRow = input.closest('.variant-row');
        const previewContainer = variantRow.querySelector('.variant-image-preview-container');
        const preview = variantRow.querySelector('.variant-image-preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.style.display = 'block';
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            previewContainer.style.display = 'none';
        }
    }

    // Add specification row
    function addSpecification() {
        const container = document.getElementById('specifications-container');
        const rowCount = container.querySelectorAll('.specification-row').length;

        const row = document.createElement('div');
        row.className = 'row mb-2 specification-row';
        row.innerHTML = `
            <div class="col-md-5">
                <input type="text" class="form-control rounded-pill" name="specifications[${rowCount}][key]" placeholder="Feature">
            </div>
            <div class="col-md-5">
                <input type="text" class="form-control rounded-pill" name="specifications[${rowCount}][value]" placeholder="Value">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-outline-danger btn-sm rounded-pill" onclick="removeSpecification(this)">
                    <i class="bx bx-trash"></i>
                </button>
            </div>
        `;

        container.appendChild(row);
    }

    // Remove specification row
    function removeSpecification(button) {
        const row = button.closest('.specification-row');
        row.remove();

        // Reindex remaining specifications
        const container = document.getElementById('specifications-container');
        const rows = container.querySelectorAll('.specification-row');

        rows.forEach((row, index) => {
            const keyInput = row.querySelector('input[name^="specifications"][name$="[key]"]');
            const valueInput = row.querySelector('input[name^="specifications"][name$="[value]"]');

            keyInput.name = `specifications[${index}][key]`;
            valueInput.name = `specifications[${index}][value]`;
        });
    }

    // Add instruction row
    function addInstruction() {
        const container = document.getElementById('instructions-container');

        const row = document.createElement('div');
        row.className = 'row mb-2 instruction-row';
        row.innerHTML = `
            <div class="col-md-10">
                <input type="text" class="form-control rounded-pill" name="usage_instructions[]" placeholder="Instruction">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-outline-danger btn-sm rounded-pill" onclick="removeInstruction(this)">
                    <i class="bx bx-trash"></i>
                </button>
            </div>
        `;

        container.appendChild(row);
    }

    // Remove instruction row
    function removeInstruction(button) {
        const row = button.closest('.instruction-row');
        row.remove();
    }
</script>
@endsection
