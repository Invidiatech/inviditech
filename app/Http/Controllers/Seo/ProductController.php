<?php

namespace App\Http\Controllers\Seo;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\ProductRequest;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->productRepository->getAllProducts();
        return view('seo.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->productRepository->getCategoriesForDropdown();
        return view('seo.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try {
            // Create product
            $product = $this->productRepository->createProduct($request->except([
                'main_image',
                'gallery_images',
                'variant_names',
                'variant_values',
                'variant_prices',
                'variant_stocks',
                'variant_skus',
                'variant_barcodes',
                'variant_images'
            ]));

            // Handle main image upload
            if ($request->hasFile('main_image')) {
                $this->productRepository->uploadProductImage($product, $request->file('main_image'), true);
            }

            // Handle gallery images upload
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $image) {
                    $this->productRepository->uploadProductImage($product, $image, false);
                }
            }

            // Handle variants
            if ($request->has('variant_names') && is_array($request->variant_names) && count($request->variant_names) > 0) {
                $variantData = [
                    'variant_names' => $request->variant_names,
                    'variant_values' => $request->variant_values,
                    'variant_prices' => $request->variant_prices,
                    'variant_stocks' => $request->variant_stocks,
                    'variant_skus' => $request->variant_skus,
                    'variant_barcodes' => $request->variant_barcodes,
                    'variant_images' => $request->file('variant_images') ?? []
                ];

                $this->productRepository->createVariants($product, $variantData);
            }

            return redirect()->route('seo.products.index')
                ->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating product: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error creating product: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = $this->productRepository->getProductById($id);
        return view('seo.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = $this->productRepository->getProductById($id);
        $categories = $this->productRepository->getCategoriesForDropdown();

        return view('seo.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, $id)
    {
        try {
            // Update product
            $product = $this->productRepository->updateProduct($id, $request->except([
                'main_image',
                'gallery_images',
                'deleted_images',
                'variant_names',
                'variant_values',
                'variant_prices',
                'variant_stocks',
                'variant_skus',
                'variant_barcodes',
                'variant_images'
            ]));

            // Handle main image upload
            if ($request->hasFile('main_image')) {
                $this->productRepository->uploadProductImage($product, $request->file('main_image'), true);
            }

            // Handle deleted images
            if ($request->filled('deleted_images')) {
                $deletedIds = explode(',', $request->deleted_images);
                $this->productRepository->deleteProductImages($product, $deletedIds);
            }

            // Handle gallery images upload
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $image) {
                    $this->productRepository->uploadProductImage($product, $image, false);
                }
            }

            // Handle variants
            if ($request->has('variant_names') && is_array($request->variant_names) && count($request->variant_names) > 0) {
                $variantData = [
                    'variant_names' => $request->variant_names,
                    'variant_values' => $request->variant_values,
                    'variant_prices' => $request->variant_prices,
                    'variant_stocks' => $request->variant_stocks,
                    'variant_skus' => $request->variant_skus,
                    'variant_barcodes' => $request->variant_barcodes,
                    'variant_images' => $request->file('variant_images') ?? []
                ];

                $this->productRepository->updateVariants($product, $variantData);
            }

            return redirect()->route('seo.products.index')
                ->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating product: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error updating product: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->productRepository->deleteProduct($id);

        return redirect()->route('seo.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Update the status of the specified product.
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:0,1',
        ]);

        $product = $this->productRepository->getProductById($id);
        $product->update([
            'status' => $validated['status']
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully'
            ]);
        }

        return redirect()->back()->with('success', 'Status updated successfully');
    }

    /**
     * Update the featured status of the specified product.
     */
    public function updateFeatured(Request $request, $id)
    {
        $validated = $request->validate([
            'is_featured' => 'required|boolean',
        ]);

        $product = $this->productRepository->getProductById($id);
        $product->update([
            'is_featured' => $validated['is_featured']
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Featured status updated successfully'
            ]);
        }

        return redirect()->back()->with('success', 'Featured status updated successfully');
    }

    /**
     * Update the bestseller status of the specified product.
     */
    public function updateBestseller(Request $request, $id)
    {
        $validated = $request->validate([
            'is_bestseller' => 'required|boolean',
        ]);

        $product = $this->productRepository->getProductById($id);
        $product->update([
            'is_bestseller' => $validated['is_bestseller']
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Bestseller status updated successfully'
            ]);
        }

        return redirect()->back()->with('success', 'Bestseller status updated successfully');
    }

    /**
     * Get categories for dropdown (used for AJAX calls)
     */
    public function getCategories()
    {
        $categories = $this->productRepository->getCategoriesForDropdown();
        return response()->json($categories);
    }
}
