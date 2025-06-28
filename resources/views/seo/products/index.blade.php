@extends('layouts.seo')
@section('seo-content')
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
<style>
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
        -webkit-transition: .4s;
        transition: .4s;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #53C0CA;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #53C0CA;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    .custom-dropdown-btn {
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
        color: #212529;
    }

    .dropdown-menu-custom {
        min-width: 120px;
        padding: 0.5rem 0;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        border: none;
    }

    .dropdown-menu-custom .dropdown-item {
        padding: 0.5rem 1rem;
    }

    .recent-product-img {
        width: 50px;
        height: 50px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Products</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Products</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a class="d-none" href="{{ route('seo.products.create') }}"  class="btn submit-btn p-2">
                <i class="bx bx-plus"></i> Add New Product
            </a>
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

    <!-- Error Message -->
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bx bx-error-circle me-1"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card radius-10">
        <div class="card-body">
            <h5 class="card-title">Products</h5>
            <hr>
            <div class="table-responsive">
                <table class="table align-middle mb-0" id="dataTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Detail</th>
                            <th>Price</th>
                            <th>Inventory</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>#{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="recent-product-img">
                                        @if($product->getMainImageAttribute())
                                        <img src="{{ asset('storage/' . $product->getMainImageAttribute()->filepath) }}"
     alt="{{ $product->title }}"
     class="rounded"
     width="150" height="150"
     style="object-fit: cover;">

                                        @else
                                            <div class="rounded bg-light d-flex align-items-center justify-content-center"
                                                style="width: 50px; height: 50px;">
                                                <i class="bx bx-image text-muted"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ms-2">
                                        <h6 class="mb-1 font-14">{{ Str::limit($product->title, 30) }}</h6>
                                        <p class="mb-0 text-muted small">{{ Str::limit($product->short_desc, 50) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold">£{{ number_format($product->price, 2) }}</span>
                                    @if($product->hasDiscount())
                                        <span class="text-decoration-line-through text-muted small">${{ number_format($product->cut_price, 2) }}</span>
                                        <span class="badge bg-danger">{{ $product->getDiscountPercentAttribute() }}% Off</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($product->stock_status == 'IN')
                                    <span class="badge bg-success">In Stock</span>
                                    @if($product->stock)
                                        <small class="d-block mt-1">{{ $product->stock }} units</small>
                                    @endif
                                @elseif($product->stock_status == 'OUT')
                                    <span class="badge bg-danger">Out of Stock</span>
                                @else
                                    <span class="badge bg-warning">Pre-Order</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $product->category->name ?? 'None' }}</span>
                                @if($product->subCategory)
                                    <span class="badge bg-info mt-1">{{ $product->subCategory->name }}</span>
                                @endif
                            </td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" class="status-switch" {{ $product->status ? 'checked' : '' }}
                                           onchange="updateStatus({{ $product->id }}, this.checked)">
                                    <span class="slider"></span>
                                </label>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle custom-dropdown-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-custom" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="{{ route('seo.products.edit', $product->id) }}"><i class="bx bx-edit me-1"></i> Edit</a></li>
                                        <li><a class="dropdown-item" href="{{ route('seo.products.show', $product->id) }}"><i class="bx bx-show me-1"></i> View</a></li>

                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                        @if(count($products) == 0)
                        <tr>
                            <td colspan="7" class="text-center">No products found</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            {{-- <div class="mt-3">
                {{ $products->links() }}
            </div> --}}
        </div>
    </div>
</div>
<script>
    // Function to update status via AJAX with form submit
    function updateStatus(id, status) {
        // Create a form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/seo/products/${id}/status`;
        form.style.display = 'none';

        // Add CSRF token - find it in any existing form
        let token = '';
        const forms = document.querySelectorAll('form');
        for (let i = 0; i < forms.length; i++) {
            const formToken = forms[i].querySelector('input[name="_token"]');
            if (formToken) {
                token = formToken.value;
                break;
            }
        }

        const csrfField = document.createElement('input');
        csrfField.type = 'hidden';
        csrfField.name = '_token';
        csrfField.value = token;

        // Add status field
        const statusField = document.createElement('input');
        statusField.type = 'hidden';
        statusField.name = 'status';
        statusField.value = status ? 1 : 0;

        // Append fields to form
        form.appendChild(csrfField);
        form.appendChild(statusField);

        // Append form to document and submit
        document.body.appendChild(form);
        form.submit();
    }
</script>
@endsection
