<?php

namespace App\Repositories\Interfaces;

interface CategoryRepositoryInterface
{
    /**
     * Get all categories with pagination
     *
     * @param int $perPage
     * @param string $search
     * @param int $parentId
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllCategories($perPage = 10, $search = null, $parentId = null);
    
    /**
     * Get category by ID
     *
     * @param int $id
     * @return \App\Models\Category
     */
    public function getCategoryById($id);
    
    /**
     * Get category by slug
     *
     * @param string $slug
     * @return \App\Models\Category
     */
    public function getCategoryBySlug($slug);
    
    /**
     * Create new category
     *
     * @param array $data
     * @return \App\Models\Category
     */
    public function createCategory(array $data);
    
    /**
     * Update existing category
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\Category
     */
    public function updateCategory($id, array $data);
    
    /**
     * Delete category
     *
     * @param int $id
     * @return bool
     */
    public function deleteCategory($id);
    
    /**
     * Get parent categories for dropdown
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getParentCategories();
    
    /**
     * Get parent categories except the specified ID
     *
     * @param int $exceptId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getParentCategoriesExcept($exceptId);
}