@extends('layouts.seo')
@section('seo-content')
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Products</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Product Details</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="d-flex gap-2">
                <a href="{{ route('seo.products.index') }}" class="btn btn-light px-3 rounded-pill">
                    <i class="bx bx-arrow-back"></i> Back
                </a>
                <a href="{{ route('seo.products.edit', $product->id) }}" class="btn btn-primary px-3 rounded-pill">
                    <i class="bx bx-edit"></i> Edit
                </a>
                <form action="{{ route('seo.products.destroy', $product->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-3 rounded-pill" onclick="return confirm('Are you sure you want to delete this product?')">
                        <i class="bx bx-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
    <!--end breadcrumb-->

    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bx bx-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Product Details -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-header text-white py-3"  style="background: #53C0CA;">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-white">{{ $product->title }}</h5>
                <div class="badges">
                    @if($product->status == '1')
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Inactive</span>
                    @endif

                    @if($product->is_featured)
                        <span class="badge bg-warning">Featured</span>
                    @endif

                    @if($product->is_bestseller)
                        <span class="badge bg-info">Bestseller</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            <div class="row">
                <!-- Left Column: Images -->
                <div class="col-md-4 mb-4">
                    <!-- Main Image -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Main Image</h6>
                        <div class="main-image-container text-center bg-light rounded-4 p-3">
                            @if($product->getMainImageAttribute())
                                <img src="{{ asset('storage/' . $product->getMainImageAttribute()->filepath) }}" alt="{{ $product->title }}" class="img-fluid rounded-3" style="max-height: 300px;">
                            @else
                                <div class="p-5 text-muted">
                                    <i class="bx bx-image fs-1"></i>
                                    <p>No image available</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Gallery Images -->
                    <div>
                        <h6 class="fw-bold mb-3">Gallery Images</h6>
                        <div class="gallery-container d-flex flex-wrap gap-2">
                            @foreach($product->files()->where('is_main', false)->get() as $file)
                                <div class="gallery-image">
                                    <img src="{{ asset('storage/' . $file->filepath) }}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                </div>
                            @endforeach

                            @if($product->files()->where('is_main', false)->count() == 0)
                                <div class="bg-light p-3 rounded-3 text-muted w-100 text-center">
                                    <i class="bx bx-images fs-3"></i>
                                    <p class="mb-0">No gallery images</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column: Details -->
                <div class="col-md-8">
                    <!-- Basic Information -->
                    <div class="card shadow-none border mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0 fw-bold">Basic Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <p class="mb-1 fw-bold text-muted small">Product ID</p>
                                    <p>{{ $product->id }}</p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <p class="mb-1 fw-bold text-muted small">Slug</p>
                                    <p>{{ $product->slug }}</p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <p class="mb-1 fw-bold text-muted small">Category</p>
                                    <p>{{ $product->category->name ?? 'None' }}</p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <p class="mb-1 fw-bold text-muted small">Sub/Child Category</p>
                                    <p>
                                        {{ $product->subCategory->name ?? 'None' }}
                                        {{ $product->childCategory ? ' / ' . $product->childCategory->name : '' }}
                                    </p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <p class="mb-1 fw-bold text-muted small">SKU</p>
                                    <p>{{ $product->SKU ?? 'Not set' }}</p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <p class="mb-1 fw-bold text-muted small">Barcode</p>
                                    <p>{{ $product->barcode ?? 'Not set' }}</p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <p class="mb-1 fw-bold text-muted small">Template</p>
                                    <p>
                                        @if($product->product_template == 1)
                                            Standard Template
                                        @elseif($product->product_template == 2)
                                            Medical Template
                                        @elseif($product->product_template == 3)
                                            Weight Loss Template
                                        @else
                                            Unknown Template
                                        @endif
                                    </p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <p class="mb-1 fw-bold text-muted small">Risk Level</p>
                                    <p>
                                        @if($product->high_risk == '1')
                                            <span class="badge bg-danger">High Risk</span>
                                        @else
                                            <span class="badge bg-success">Low Risk</span>
                                        @endif
                                    </p>
                                </div>

                                <div class="col-12 mb-3">
                                    <p class="mb-1 fw-bold text-muted small">Tags</p>
                                    <div>
                                        @if(is_array($product->tags) && count($product->tags) > 0)
                                            @foreach($product->tags as $tag)
                                                <span class="badge bg-light text-dark me-1">{{ $tag }}</span>
                                            @endforeach
                                        @else
                                            <p>No tags set</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing & Inventory -->
                    <div class="card shadow-none border mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0 fw-bold">Pricing & Inventory</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <p class="mb-1 fw-bold text-muted small">Price</p>
                                    <p class="fw-bold text-primary">${{ number_format($product->price, 2) }}</p>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <p class="mb-1 fw-bold text-muted small">Sale Price</p>
                                    <p>
                                    @if($product->cut_price)
                                            <span class="fw-bold text-success">${{ number_format($product->cut_price, 2) }}</span>
                                            <span class="text-muted ms-2 small text-decoration-line-through">${{ number_format($product->price, 2) }}</span>
                                            @if($product->hasDiscount())
                                                <span class="badge bg-danger ms-2">{{ $product->getDiscountPercentAttribute() }}% Off</span>
                                            @endif
                                        @else
                                            <span class="text-muted">No sale price</span>
                                        @endif
                                    </p>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <p class="mb-1 fw-bold text-muted small">Stock Status</p>
                                    <p>
                                        @if($product->stock_status == 'IN')
                                            <span class="badge bg-success">In Stock</span>
                                        @elseif($product->stock_status == 'OUT')
                                            <span class="badge bg-danger">Out of Stock</span>
                                        @else
                                            <span class="badge bg-warning">Pre-Order</span>
                                        @endif
                                    </p>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <p class="mb-1 fw-bold text-muted small">Inventory</p>
                                    <p>{{ $product->stock ?? 'Not limited' }}</p>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <p class="mb-1 fw-bold text-muted small">Low Stock Limit</p>
                                    <p>{{ $product->low_limit }}</p>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <p class="mb-1 fw-bold text-muted small">Weight</p>
                                    <p>{{ $product->weight }}g</p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <p class="mb-1 fw-bold text-muted small">Purchase Limits</p>
                                    <p>
                                        Min: {{ $product->min_buy ?? 'Not set' }}
                                        @if($product->max_buy)
                                            / Max: {{ $product->max_buy }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description Sections -->
            <div class="row mt-4">
                <div class="col-md-6 mb-4">
                    <div class="card shadow-none border h-100">
                        <div class="card-header bg-light">
                            <h6 class="mb-0 fw-bold">Short Description</h6>
                        </div>
                        <div class="card-body">
                            @if($product->short_desc)
                                <p>{{ $product->short_desc }}</p>
                            @else
                                <p class="text-muted">No short description provided</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card shadow-none border h-100">
                        <div class="card-header bg-light">
                            <h6 class="mb-0 fw-bold">Product Specifications</h6>
                        </div>
                        <div class="card-body">
                            @if(isset($product->additional_info) && is_array($product->additional_info) && count($product->additional_info) > 0)
                                <table class="table table-sm">
                                    <tbody>
                                        @foreach($product->additional_info as $spec)
                                            <tr>
                                                <td class="fw-bold" style="width: 40%;">{{ $spec['key'] }}</td>
                                                <td>{{ $spec['value'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-muted">No specifications available</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="card shadow-none border">
                        <div class="card-header bg-light">
                            <h6 class="mb-0 fw-bold">Full Description</h6>
                        </div>
                        <div class="card-body">
                            @if($product->desc)
                                {!! $product->desc !!}
                            @else
                                <p class="text-muted">No description available</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card shadow-none border h-100">
                        <div class="card-header bg-light">
                            <h6 class="mb-0 fw-bold">Usage Instructions</h6>
                        </div>
                        <div class="card-body">
                            @if(isset($product->usage_instructions) && is_array($product->usage_instructions) && count($product->usage_instructions) > 0)
                                <ol class="ps-3">
                                    @foreach($product->usage_instructions as $instruction)
                                        <li class="mb-2">{{ $instruction }}</li>
                                    @endforeach
                                </ol>
                            @else
                                <p class="text-muted">No usage instructions available</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card shadow-none border h-100">
                        <div class="card-header bg-light">
                            <h6 class="mb-0 fw-bold">Ingredients</h6>
                        </div>
                        <div class="card-body">
                            @if(isset($product->ingredients) && is_array($product->ingredients) && count($product->ingredients) > 0)
                                <ul class="ps-3">
                                    @foreach($product->ingredients as $ingredient)
                                        <li class="mb-1">{{ $ingredient }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">No ingredients listed</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO Information -->
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card shadow-none border">
                        <div class="card-header bg-light">
                            <h6 class="mb-0 fw-bold">SEO Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <p class="mb-1 fw-bold text-muted small">Meta Title</p>
                                    <p>{{ $product->meta_data['meta_title'] ?? 'Not set' }}</p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <p class="mb-1 fw-bold text-muted small">Meta Keywords</p>
                                    <p>{{ $product->meta_data['meta_keywords'] ?? 'Not set' }}</p>
                                </div>

                                <div class="col-12">
                                    <p class="mb-1 fw-bold text-muted small">Meta Description</p>
                                    <p>{{ $product->meta_data['meta_description'] ?? 'Not set' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Variants -->
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card shadow-none border">
                        <div class="card-header bg-light">
                            <h6 class="mb-0 fw-bold">Product Variants ({{ $product->variants->count() }})</h6>
                        </div>
                        <div class="card-body">
                            @if($product->variants->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Image</th>
                                                <th>Variant</th>
                                                <th>Price</th>
                                                <th>SKU</th>
                                                <th>Barcode</th>
                                                <th>Stock</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($product->variants as $variant)
                                                <tr>
                                                    <td style="width: 80px;">
                                                        @if($variant->getMainImageAttribute())
                                                            <img src="{{ asset('storage/' . $variant->getMainImageAttribute()->filepath) }}"
                                                                class="img-thumbnail" alt="Variant Image" style="width: 50px; height: 50px; object-fit: cover;">
                                                        @else
                                                            <div class="text-center bg-light rounded" style="width: 50px; height: 50px; line-height: 50px;">
                                                                <i class="bx bx-image-alt"></i>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold">{{ $variant->title }}</span>
                                                        @if(isset($variant->options) && is_array($variant->options))
                                                            <div class="small text-muted">
                                                                @foreach($variant->options as $option)
                                                                    {{ $option['name'] ?? '' }}: {{ $option['value'] ?? '' }}
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($variant->cut_price)
                                                            <span class="fw-bold text-success">${{ number_format($variant->cut_price, 2) }}</span>
                                                            <span class="text-muted d-block small text-decoration-line-through">${{ number_format($variant->price, 2) }}</span>
                                                        @else
                                                            <span class="fw-bold">${{ number_format($variant->price, 2) }}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $variant->SKU ?? 'Not set' }}</td>
                                                    <td>{{ $variant->barcode ?? 'Not set' }}</td>
                                                    <td>
                                                        @if($variant->stock)
                                                            {{ $variant->stock }}
                                                        @else
                                                            <span class="text-muted">—</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($variant->stock_status == 'IN')
                                                            <span class="badge bg-success">In Stock</span>
                                                        @elseif($variant->stock_status == 'OUT')
                                                            <span class="badge bg-danger">Out of Stock</span>
                                                        @else
                                                            <span class="badge bg-warning">Pre-Order</span>
                                                        @endif

                                                        @if($variant->is_default)
                                                            <span class="badge bg-primary ms-1">Default</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info mb-0">
                                    <i class="bx bx-info-circle me-1"></i> No variants have been created for this product.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Created & Updated Info -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-none border">
                        <div class="card-body bg-light">
                            <div class="d-flex justify-content-between small text-muted">
                                <div>
                                    <span>Created: {{ $product->created_at->format('M d, Y h:i A') }}</span>
                                    @if($product->creator)
                                        <span> by {{ $product->creator->name }}</span>
                                    @endif
                                </div>
                                <div>
                                    <span>Last Updated: {{ $product->updated_at->format('M d, Y h:i A') }}</span>
                                    @if($product->updater)
                                        <span> by {{ $product->updater->name }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card-title {
        margin-bottom: 0;
    }
</style>
@endsection
