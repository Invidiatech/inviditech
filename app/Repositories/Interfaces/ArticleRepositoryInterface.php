<?php

namespace App\Repositories\Interfaces;

interface ArticleRepositoryInterface
{
    /**
     * Get all articles with pagination and filters
     *
     * @param int $perPage
     * @param string|null $search
     * @param string|null $status
     * @param int|null $categoryId
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllArticles($perPage = 10, $search = null, $status = null, $categoryId = null);
    
    /**
     * Get article by ID
     *
     * @param int $id
     * @return \App\Models\Article
     */
    public function getArticleById($id);
    
    /**
     * Get article by slug
     *
     * @param string $slug
     * @return \App\Models\Article
     */
    public function getArticleBySlug($slug);
    
    /**
     * Create new article
     *
     * @param array $data
     * @return \App\Models\Article
     */
    public function createArticle(array $data);
    
    /**
     * Update existing article
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\Article
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
     * Get all tags
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllTags();
    
    /**
     * Get article tags
     * 
     * @param int $articleId
     * @return array
     */
    public function getArticleTags($articleId);
    
    /**
     * Get featured articles
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFeaturedArticles($limit = 5);
    
    /**
     * Get popular articles based on views
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPopularArticles($limit = 5);
    
    /**
     * Get recent articles
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecentArticles($limit = 5);
    
    /**
     * Get related articles
     *
     * @param int $articleId
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRelatedArticles($articleId, $limit = 4);
    
    /**
     * Increment article views
     *
     * @param int $articleId
     * @return bool
     */
    public function incrementViews($articleId);
    
    /**
     * Get articles by tag
     *
     * @param string $tagSlug
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getArticlesByTag($tagSlug, $perPage = 10);
    
    /**
     * Get articles by category
     *
     * @param string $categorySlug
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getArticlesByCategory($categorySlug, $perPage = 10);
}