@extends('layouts.admin.master')

@section('title', 'View Article')

@section('styles')
<style>
    .article-content {
        font-family: 'Georgia', serif;
        font-size: 1.1rem;
        line-height: 1.7;
    }
    
    .article-content img {
        max-width: 100%;
        height: auto;
        border-radius: 0.375rem;
    }
    
    .article-content h2 {
        margin-top: 1.5rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }
    
    .article-content h3 {
        margin-top: 1.25rem;
        margin-bottom: 0.75rem;
        font-weight: 600;
    }
    
    .article-content p {
        margin-bottom: 1.25rem;
    }
    
    .article-content blockquote {
        border-left: 4px solid #e5e7eb;
        padding-left: 1rem;
        margin-left: 0;
        margin-right: 0;
        font-style: italic;
        color: #4b5563;
    }
    
    .article-meta {
        font-size: 0.875rem;
        color: #6b7280;
    }
    
    .tag-badge {
        background-color: #f3f4f6;
        color: #374151;
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .tag-badge:hover {
        background-color: #e5e7eb;
    }
    
    .preview-banner {
        background-color: #fef3c7;
        color: #92400e;
        padding: 0.5rem 1rem;
        text-align: center;
        font-weight: 500;
        border-bottom: 1px solid #f59e0b;
    }
    
    .article-header {
        padding-bottom: 1.5rem;
        margin-bottom: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .article-title {
        font-size: 2.25rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 1rem;
        line-height: 1.2;
    }
    
    .article-image-container {
        margin-bottom: 1.5rem;
        border-radius: 0.5rem;
        overflow: hidden;
    }
    
    .article-featured-image {
        width: 100%;
        height: auto;
        max-height: 500px;
        object-fit: cover;
    }
    
    .audio-player-container {
        background-color: #f9fafb;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
        border: 1px solid #e5e7eb;
    }
    
    .seo-preview-section {
        background-color: #f9fafb;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid #e5e7eb;
    }
</style>
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.articles.index') }}">Articles</a></li>
    <li class="breadcrumb-item active">{{ Str::limit($article->title, 30) }}</li>
@endsection

@section('content')
    @if($article->status != 'published')
        <div class="preview-banner">
            <i class="bi bi-eye me-2"></i> Preview Mode - This article is not published yet
        </div>
    @endif
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Article Preview</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn btn-primary">
                <i class="bi bi-pencil me-1"></i> Edit Article
            </a>
            <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Articles
            </a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-8">
            <div class="admin-card mb-4">
                <div class="admin-card-body">
                    <article>
                        <header class="article-header">
                            <h1 class="article-title">{{ $article->title }}</h1>
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <span class="article-meta">
                                    <i class="bi bi-calendar3 me-1"></i> 
                                    {{ $article->published_at ? $article->published_at->format('M d, Y') : $article->created_at->format('M d, Y') }}
                                </span>
                                <span class="article-meta">
                                    <i class="bi bi-person me-1"></i> 
                                    {{ $article->user->name ?? 'Unknown Author' }}
                                </span>
                                <span class="article-meta">
                                    <i class="bi bi-folder me-1"></i> 
                                    {{ $article->category->name ?? 'Uncategorized' }}
                                </span>
                                <span class="article-meta">
                                    <i class="bi bi-eye me-1"></i> 
                                    {{ $article->views_count ?? 0 }} {{ Str::plural('view', $article->views_count ?? 0) }}
                                </span>
                            </div>
                            
                            @if($article->tags && count($article->tags) > 0)
                                <div class="d-flex flex-wrap gap-1 mb-3">
                                    @foreach($article->tags as $tag)
                                        <span class="tag-badge">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            @endif
                            
                            @if($article->excerpt)
                                <div class="article-excerpt mb-3 fst-italic">
                                    {{ $article->excerpt }}
                                </div>
                            @endif
                        </header>
                        
                        @if($article->featured_image)
                            <div class="article-image-container">
                                <img 
                                    src="{{ asset('storage/' . $article->featured_image) }}" 
                                    alt="{{ $article->featured_image_alt ?? $article->title }}" 
                                    class="article-featured-image">
                            </div>
                        @endif
                        
                        @if($article->audio_file)
                            <div class="audio-player-container">
                                <h5 class="mb-3">
                                    <i class="bi bi-volume-up me-2"></i> Listen to this article
                                </h5>
                                <audio controls class="w-100">
                                    <source src="{{ asset('storage/' . $article->audio_file) }}" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                            </div>
                        @endif
                        
                        <div class="article-content">
                            {!! $article->content !!}
                        </div>
                    </article>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <h5 class="admin-card-title">Article Details</h5>
                </div>
                <div class="admin-card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Status</span>
                            @if($article->status == 'published')
                                <span class="badge badge-published">Published</span>
                            @elseif($article->status == 'draft')
                                <span class="badge badge-draft">Draft</span>
                            @elseif($article->status == 'pending')
                                <span class="badge badge-pending">Pending</span>
                            @endif
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Category</span>
                            <span>{{ $article->category->name ?? 'Uncategorized' }}</span>
                        </li>
                        @if($article->published_at)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Published Date</span>
                            <span>{{ $article->published_at->format('M d, Y g:i A') }}</span>
                        </li>
                        @endif
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Created Date</span>
                            <span>{{ $article->created_at->format('M d, Y g:i A') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Last Updated</span>
                            <span>{{ $article->updated_at->format('M d, Y g:i A') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Author</span>
                            <span>{{ $article->user->name ?? 'Unknown' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Word Count</span>
                            <span>{{ Str::wordCount($article->content) }} words</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Reading Time</span>
                            <span>~{{ ceil(Str::wordCount($article->content) / 200) }} min</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>URL</span>
                            <a href="#" class="text-truncate ms-2" style="max-width: 200px;">
                                {{ url('article/' . $article->slug) }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <h5 class="admin-card-title">SEO Preview</h5>
                </div>
                <div class="admin-card-body">
                    <div class="seo-preview">
                        <div class="seo-preview-title">
                            {{ $article->meta_title ?? $article->title }}
                        </div>
                        <div class="seo-preview-url">
                            {{ config('app.url') }}/article/{{ $article->slug }}
                        </div>
                        <div class="seo-preview-description">
                            {{ $article->meta_description ?? Str::limit(strip_tags($article->content), 160) }}
                        </div>
                    </div>
                    
                    @if($article->meta_title || $article->meta_description || $article->canonical_url)
                        <h6 class="mt-4">SEO Settings</h6>
                        <table class="table table-sm">
                            <tbody>
                                @if($article->meta_title)
                                <tr>
                                    <th scope="row">Meta Title</th>
                                    <td>{{ $article->meta_title }}</td>
                                </tr>
                                @endif
                                
                                @if($article->meta_description)
                                <tr>
                                    <th scope="row">Meta Description</th>
                                    <td>{{ $article->meta_description }}</td>
                                </tr>
                                @endif
                                
                                @if($article->canonical_url)
                                <tr>
                                    <th scope="row">Canonical URL</th>
                                    <td>{{ $article->canonical_url }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
            
            <div class="admin-card">
                <div class="admin-card-header">
                    <h5 class="admin-card-title">Actions</h5>
                </div>
                <div class="admin-card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn btn-primary">
                            <i class="bi bi-pencil me-1"></i> Edit Article
                        </a>
                        
                        @if($article->status == 'published')
                            <a href="#" class="btn btn-outline-success" onclick="alert('Viewing live article')">
                                <i class="bi bi-globe me-1"></i> View Published Article
                            </a>
                        @elseif($article->status == 'draft' || $article->status == 'pending')
                            <form action="{{ route('admin.articles.update', $article->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="published">
                                <button type="submit" class="btn btn-outline-success w-100">
                                    <i class="bi bi-check-circle me-1"></i> Publish Now
                                </button>
                            </form>
                        @endif
                        
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="bi bi-trash me-1"></i> Delete Article
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete "<span class="fw-bold">{{ $article->title }}</span>"?</p>
                    <p class="text-danger">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection