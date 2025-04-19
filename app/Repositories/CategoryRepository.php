<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryRepository implements CategoryRepositoryInterface
{
    protected $category;
    
    public function __construct(Category $category)
    {
        $this->category = $category;
    }
    
    /**
     * Get all categories with pagination
     *
     * @param int $perPage
     * @param string $search
     * @param int $parentId
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllCategories($perPage = 10, $search = null, $parentId = null)
    {
        $query = $this->category->with('parent');
        
        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Apply parent filter
        if ($parentId) {
            $query->where('parent_id', $parentId);
        }
        
        return $query->orderBy('sort_order')
                    ->orderBy('name')
                    ->paginate($perPage);
    }
    
    /**
     * Get category by ID
     *
     * @param int $id
     * @return Category
     */
    public function getCategoryById($id)
    {
        return $this->category->findOrFail($id);
    }
    
    /**
     * Get category by slug
     *
     * @param string $slug
     * @return Category
     */
    public function getCategoryBySlug($slug)
    {
        return $this->category->where('slug', $slug)->firstOrFail();
    }
    
    /**
     * Create new category
     *
     * @param array $data
     * @return Category
     */
    public function createCategory(array $data)
    {
        // Handle image upload - save to icon field
        if (isset($data['image']) && $data['image']) {
            $data['icon'] = $this->uploadImage($data['image']);
            unset($data['image']); // Remove the image key since we don't have this column
        }
        
        // Set meta title if not provided
        if (!isset($data['meta_title']) || empty($data['meta_title'])) {
            $data['meta_title'] = $data['name'];
        }
        
        // Set meta description if not provided
        if (!isset($data['meta_description']) || empty($data['meta_description'])) {
            $data['meta_description'] = $data['description'] ?? Str::limit($data['name'], 160);
        }
        
        // Create category
        return $this->category->create($data);
    }
    
    /**
     * Update existing category
     *
     * @param int $id
     * @param array $data
     * @return Category
     */
    public function updateCategory($id, array $data)
    {
        $category = $this->getCategoryById($id);
        
        // Handle image upload - save to icon field
        if (isset($data['image']) && $data['image']) {
            // Delete old icon if exists
            if ($category->icon) {
                Storage::disk('public')->delete($category->icon);
            }
            
            $data['icon'] = $this->uploadImage($data['image']);
            unset($data['image']); // Remove the image key since we don't have this column
        }
        
        // Handle image removal
        if (isset($data['remove_image']) && $data['remove_image'] && $category->icon) {
            Storage::disk('public')->delete($category->icon);
            $data['icon'] = null;
            unset($data['remove_image']); // Remove this key as it's not a column
        }
        
        // Update category
        $category->update($data);
        
        return $category;
    }
    
    /**
     * Delete category
     *
     * @param int $id
     * @return bool
     */
    public function deleteCategory($id)
    {
        $category = $this->getCategoryById($id);
        
        // Update child categories to have null parent_id
        $this->category->where('parent_id', $id)->update(['parent_id' => null]);
        
        // Delete icon if exists
        if ($category->icon) {
            Storage::disk('public')->delete($category->icon);
        }
        
        return $category->delete();
    }
    
    /**
     * Upload and store image
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @return string
     */
    protected function uploadImage($image)
    {
        return $image->store('categories', 'public');
    }
    
    /**
     * Get parent categories for dropdown
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getParentCategories()
    {
        return $this->category->whereNull('parent_id')
                            ->orWhere(function($query) {
                                $query->whereHas('children');
                            })
                            ->orderBy('name')
                            ->get();
    }
    
    /**
     * Get parent categories except the specified ID
     *
     * @param int $exceptId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getParentCategoriesExcept($exceptId)
    {
        // Get all categories except the current one and its children
        return $this->category->where('id', '!=', $exceptId)
                            ->whereNotIn('id', function($query) use ($exceptId) {
                                $query->select('id')
                                    ->from('categories')
                                    ->where('parent_id', $exceptId);
                            })
                            ->orderBy('name')
                            ->get();
    }
}