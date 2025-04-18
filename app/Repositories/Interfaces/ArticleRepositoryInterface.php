<?php

namespace App\Repositories\Interfaces;

use App\Models\Article;

interface ArticleRepositoryInterface
{
    /**
     * Get all articles with pagination
     *
     * @param int $perPage
     * @param string $search
     * @param string $status
     * @param int $categoryId
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllArticles($perPage = 10, $search = null, $status = null, $categoryId = null);
    
    /**
     * Get article by ID
     *
     * @param int $id
     * @return Article
     */
    public function getArticleById($id);
    
    /**
     * Get article by slug
     *
     * @param string $slug
     * @return Article
     */
    public function getArticleBySlug($slug);
    
    /**
     * Create new article
     *
     * @param array $data
     * @return Article
     */
    public function createArticle(array $data);
    
    /**
     * Update existing article
     *
     * @param int $id
     * @param array $data
     * @return Article
     */
    public function updateArticle($id, array $data);
    
    /**
     * Delete article
     *
     * @param int $id
     * @return bool
     */
    public function deleteArticle($id);
    
    /**
     * Get categories for dropdown
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCategoriesForDropdown();
    
    /**
     * Get tags for article
     *
     * @param int $articleId
     * @return array
     */
    public function getArticleTags($articleId);
}