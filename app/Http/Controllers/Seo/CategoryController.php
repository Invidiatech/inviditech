<?php

namespace App\Http\Controllers\Seo;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check permission
        if (!auth('seo')->user()->can('View Collection', 'seo')) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::with(['parent', 'articles'])
            ->orderBy('sort_order', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('seo.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check permission
        if (!auth('seo')->user()->can('Create Categories', 'seo')) {
            abort(403, 'Unauthorized action.');
        }

        $parentCategories = Category::parentOnly()->active()->get();
        return view('seo.categories.create', compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        // Check permission
        if (!auth('seo')->user()->can('Create Categories', 'seo')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $data = [
                'name' => $request->name,
                'slug' => $request->slug ?? Str::slug($request->name),
                'description' => $request->description,
                'parent_id' => $request->parent_id,
                'is_active' => $request->has('is_active'),
                'is_featured' => $request->has('is_featured'),
                'sort_order' => $request->sort_order ?? 0,
                'meta_data' => [
                    'meta_title' => $request->meta_title ?? $request->name,
                    'meta_description' => $request->meta_description,
                    'meta_keywords' => $request->meta_keywords
                ]
            ];

            // Handle image upload
            if ($request->hasFile('image')) {
                $data['image'] = $this->handleImageUpload($request->file('image'), $request->name);
            }

            Category::create($data);

            return redirect()->route('seo.categories.index')
                ->with('success', 'Category created successfully.');
                
        } catch (\Exception $e) {
            Log::error('Category creation failed: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create category. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        // Check permission
        if (!auth('seo')->user()->can('View Categories', 'seo')) {
            abort(403, 'Unauthorized action.');
        }

        $category->load(['parent', 'children', 'articles']);
        return view('seo.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        // Check permission
        if (!auth('seo')->user()->can('Edit Categories', 'seo')) {
            abort(403, 'Unauthorized action.');
        }

        $parentCategories = Category::where('id', '!=', $category->id)
            ->parentOnly()
            ->active()
            ->get();

        return view('seo.categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        // Check permission
        if (!auth('seo')->user()->can('Edit Categories', 'seo')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $data = [
                'name' => $request->name,
                'slug' => $request->slug ?? Str::slug($request->name),
                'description' => $request->description,
                'parent_id' => $request->parent_id,
                'is_active' => $request->has('is_active'),
                'is_featured' => $request->has('is_featured'),
                'sort_order' => $request->sort_order ?? 0,
                'meta_data' => [
                    'meta_title' => $request->meta_title ?? $request->name,
                    'meta_description' => $request->meta_description,
                    'meta_keywords' => $request->meta_keywords
                ]
            ];

            // Handle image upload if provided
            if ($request->hasFile('image')) {
                // Remove old image if exists
                if ($category->image && Storage::disk('public')->exists($category->image)) {
                    Storage::disk('public')->delete($category->image);
                }
                // Upload new image
                $data['image'] = $this->handleImageUpload($request->file('image'), $request->name);
            }

            $category->update($data);

            return redirect()->route('seo.categories.index')
                ->with('success', 'Category updated successfully.');
                
        } catch (\Exception $e) {
            Log::error('Category update failed: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update category. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Check permission
        if (!auth('seo')->user()->can('Delete Categories', 'seo')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            // Check if category has children
            if ($category->hasChildren()) {
                return redirect()->route('seo.categories.index')
                    ->with('error', 'Cannot delete category with child categories. Please delete child categories first.');
            }

            // Check if category has articles
            if ($category->hasArticles()) {
                return redirect()->route('seo.categories.index')
                    ->with('error', 'Cannot delete category with articles. Please remove articles from this category first.');
            }

            // Delete image if exists
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            // Delete category
            $category->delete();

            return redirect()->route('seo.categories.index')
                ->with('success', 'Category deleted successfully.');
                
        } catch (\Exception $e) {
            Log::error('Category deletion failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to delete category. Please try again.');
        }
    }

    /**
     * Update the status of the specified resource.
     */
    public function updateStatus(Request $request, Category $category)
    {
        // Check permission
        if (!auth('seo')->user()->can('Edit Categories', 'seo')) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'is_active' => 'required|boolean',
        ]);

        try {
            $category->update([
                'is_active' => $validated['is_active']
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Status updated successfully'
                ]);
            }

            return redirect()->back()->with('success', 'Status updated successfully');
            
        } catch (\Exception $e) {
            Log::error('Status update failed: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update status'
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to update status');
        }
    }

    /**
     * Update the featured status of the specified resource.
     */
    public function updateFeatured(Request $request, Category $category)
    {
        // Check permission
        if (!auth('seo')->user()->can('Edit Categories', 'seo')) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'is_featured' => 'required|boolean',
        ]);

        try {
            $category->update([
                'is_featured' => $validated['is_featured']
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Featured status updated successfully'
                ]);
            }

            return redirect()->back()->with('success', 'Featured status updated successfully');
            
        } catch (\Exception $e) {
            Log::error('Featured status update failed: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update featured status'
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to update featured status');
        }
    }

    /**
     * Handle image upload for category
     */
    private function handleImageUpload($file, $categoryName)
    {
        try {
            $filename = Str::slug($categoryName) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('categories', $filename, 'public');
            
            Log::info('Category image uploaded successfully:', [
                'filename' => $filename,
                'path' => $path
            ]);

            return $path;

        } catch (\Exception $e) {
            Log::error('Category image upload failed: ' . $e->getMessage());
            throw $e;
        }
    }
}