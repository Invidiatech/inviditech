@extends('website.layouts.app')

@section('title', $article->meta_title ?: $article->title)
@section('meta_description', $article->meta_description ?: ($article->excerpt ?: Str::limit(strip_tags($article->content), 160)))

@section('content')    
<style>
/* Code Block Styling */
.ql-syntax {
    font-family: 'JetBrains Mono', 'Fira Code', 'SF Mono', 'Monaco', 'Inconsolata', 'Roboto Mono', 'Consolas', monospace !important;
    font-size: 14px;
    line-height: 1.6;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    color: #e2e8f0;
    padding: 24px 28px;
    border-radius: 12px;
    border: 1px solid #334155;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    position: relative;
    overflow-x: auto;
    font-weight: 400;
    letter-spacing: 0.025em;
    transition: all 0.3s ease;
    margin: 16px 0;
    white-space: pre;
    word-wrap: break-word;
}

.ql-syntax::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #3b82f6, #8b5cf6, #06b6d4);
    border-radius: 12px 12px 0 0;
}

.ql-syntax:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
    border-color: #475569;
}

/* Article Image Styling */
.article-featured-image {
    width: 100%;
    height: 400px;
    object-fit: cover;
    border-radius: 12px;
    margin-bottom: 2rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

/* Article Meta */
.article-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 2rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
    font-size: 0.9rem;
    color: #6c757d;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Article Tags */
.article-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 2rem;
}

.article-tag {
    display: inline-block;
    padding: 0.3rem 0.8rem;
    background: #e3f2fd;
    color: #1976d2;
    text-decoration: none;
    border-radius: 20px;
    font-size: 0.85rem;
    transition: all 0.3s ease;
}

.article-tag:hover {
    background: #1976d2;
    color: white;
    transform: translateY(-1px);
}

/* TOC Enhancements */
.article-toc {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 1.5rem;
    position: sticky;
    top: 100px;
    max-height: calc(100vh - 150px);
    overflow-y: auto;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    border: 1px solid #e9ecef;
    z-index: 10;
}

.article-toc-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e9ecef;
    color: #495057;
}

.article-toc-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.toc-item {
    margin-bottom: 0.3rem;
}

.toc-item a {
    color: #495057;
    text-decoration: none;
    display: block;
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
    transition: all 0.3s ease;
    font-size: 0.9rem;
    line-height: 1.4;
    border-left: 3px solid transparent;
}

.toc-item a:hover,
.toc-item a.active {
    background-color: #e3f2fd;
    color: #1976d2;
    border-left-color: #1976d2;
    transform: translateX(2px);
}

.toc-item.toc-h1 a { font-weight: 600; font-size: 1rem; }
.toc-item.toc-h2 a { padding-left: 1rem; }
.toc-item.toc-h3 a { padding-left: 1.5rem; }
.toc-item.toc-h4 a { padding-left: 2rem; }
.toc-item.toc-h5 a { padding-left: 2.5rem; }
.toc-item.toc-h6 a { padding-left: 3rem; }

/* Heading Enhancement */
.article-content h1, 
.article-content h2, 
.article-content h3, 
.article-content h4, 
.article-content h5, 
.article-content h6 {
    position: relative;
    scroll-margin-top: 120px;
    transition: all 0.3s ease;
    border-radius: 4px;
    padding: 0.5rem 0;
}

.heading-highlighted {
    background: linear-gradient(90deg, rgba(25, 118, 210, 0.1) 0%, transparent 100%);
    padding-left: 1rem !important;
    border-left: 4px solid #1976d2;
    animation: highlight-fade 3s ease-out;
}

@keyframes highlight-fade {
    0% { background-color: rgba(25, 118, 210, 0.2); }
    100% { background-color: transparent; }
}

/* Article Tools */
.article-tools-container {
    position: sticky;
    top: 100px;
    height: fit-content;
}

.article-tools {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    background: white;
    padding: 1rem;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    border: 1px solid #e9ecef;
}

.article-tool-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0.75rem;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #6c757d;
    position: relative;
}

.article-tool-item:hover {
    background: #f8f9fa;
    color: #495057;
    transform: translateY(-2px);
}

.article-tool-item.active {
    color: #1976d2;
    background: #e3f2fd;
}

.tool-count {
    font-size: 0.8rem;
    margin-top: 0.25rem;
    font-weight: 500;
}

/* Share Menu */
.share-menu {
    position: absolute;
    left: 100%;
    top: 0;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    padding: 0.5rem;
    display: none;
    flex-direction: column;
    gap: 0.5rem;
    z-index: 1000;
    margin-left: 0.5rem;
}

.share-menu a {
    padding: 0.5rem;
    border-radius: 4px;
    color: #6c757d;
    transition: all 0.3s ease;
}

.share-menu a:hover {
    background: #f8f9fa;
    color: #495057;
}

/* Progress Indicator */
.reading-progress {
    position: fixed;
    top: 0;
    left: 0;
    width: 0%;
    height: 3px;
    background: linear-gradient(90deg, #1976d2, #42a5f5);
    z-index: 9999;
    transition: width 0.3s ease;
}

/* Mobile Responsive */
@media (max-width: 991.98px) {
    .article-toc {
        position: relative;
        top: 0;
        max-height: none;
        margin-bottom: 2rem;
    }
    
    .article-tools-container {
        position: relative;
        top: 0;
    }
    
    .article-tools {
        flex-direction: row;
        justify-content: center;
        margin-bottom: 2rem;
    }
    
    .article-featured-image {
        height: 250px;
    }
}

@media (max-width: 576px) {
    .article-meta {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .article-featured-image {
        height: 200px;
        border-radius: 8px;
    }
}
</style>

<!-- Reading Progress Bar -->
<div class="reading-progress" id="readingProgress"></div>

<!-- Main Content -->
<main class="py-5" style="margin-top:60px">
    <div class="container">
        <div class="row">
            <!-- Article Tools (Left Sidebar) -->
            <div class="col-lg-1 d-none d-lg-block article-tools-container d-none">
                <div class="article-tools d-none">
                    <div class="article-tool-item like-button @if($userLiked ?? false) active @endif" 
                         data-article-id="{{ $article->id }}" 
                         data-bs-toggle="tooltip" 
                         data-bs-placement="right" 
                         title="@if($userLiked ?? false) Unlike @else Like @endif"
                         id="likeButton">
                        <i class="@if($userLiked ?? false) fas @else far @endif fa-heart"></i>
                        <span class="tool-count" id="likeCount">{{ $likesCount ?? 0 }}</span>
                    </div>
                    
                    <div class="article-tool-item" 
                         data-bs-toggle="tooltip" 
                         data-bs-placement="right" 
                         title="Comment"
                         onclick="scrollToComments()">
                        <i class="far fa-comment"></i>
                        <span class="tool-count">{{ $article->comments->count() ?? 0 }}</span>
                    </div>
                    
                    <div class="article-tool-item bookmark-button @if($userBookmarked ?? false) active @endif" 
                         data-article-id="{{ $article->id }}" 
                         data-bs-toggle="tooltip" 
                         data-bs-placement="right" 
                         title="@if($userBookmarked ?? false) Remove Bookmark @else Bookmark @endif"
                         id="bookmarkButton">
                        <i class="@if($userBookmarked ?? false) fas @else far @endif fa-bookmark"></i>
                    </div>
                    
                    <div class="article-tool-item" 
                         data-bs-toggle="tooltip" 
                         data-bs-placement="right" 
                         title="Share"
                         onclick="toggleShareMenu()">
                        <i class="fas fa-share-alt"></i>
                        <div class="share-menu" id="shareMenu">
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" target="_blank">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($article->title) }}" target="_blank">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" onclick="copyArticleLink(event)">
                                <i class="fas fa-link"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Article Content -->
            <div class="col-lg-7 animate animate-delay-1">
                <!-- Article Header -->
                <article class="article-content">
                    <h1 class="article-title mb-4">{{ $article->title }}</h1>
                    
                    <!-- Article Meta Information -->
                    <div class="article-meta">
                        <div class="meta-item">
                            <i class="far fa-calendar"></i>
                            <span>{{ $article->created_at->format('F d, Y') }}</span>
                        </div>
                        <div class="meta-item">
                            <i class="far fa-clock"></i>
                            <span>{{ $article->reading_time ?? 5 }} min read</span>
                        </div>
                        <div class="meta-item">
                            <i class="far fa-eye"></i>
                            <span>{{ number_format($article->views_count ?? 0) }} views</span>
                        </div>
                        @if($article->category && is_object($article->category))
                        <div class="meta-item">
                            <i class="far fa-folder"></i>
                            <span>{{ $article->category->name }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Featured Image -->
                    @if($article->featured_image)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $article->featured_image) }}" 
                             alt="{{ $article->featured_image_alt ?? $article->title }}" 
                             class="article-featured-image">
                    </div>
                    @endif

                    <!-- Article Content -->
                    <div class="article-body">
                        {!! $article->content !!}
                    </div>
                </article>

                <!-- Article Tags -->
                @if($article->tags && $article->tags->count() > 0)
                <div class="article-tags mt-4">
                    @foreach($article->tags as $tag)
                        <a href="{{ route('articles', ['tag' => $tag->slug]) }}" class="article-tag">
                            {{ $tag->name }}
                        </a>
                    @endforeach
                </div>
                @endif

                <!-- Article Share -->
                <div class="article-share mt-4 p-3 border rounded">
                    <span class="article-share-title fw-bold">Share this article:</span>
                    <div class="mt-2">
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" class="btn btn-outline-primary btn-sm me-2" title="Share on Twitter" target="_blank">
                            <i class="fab fa-twitter"></i> Twitter
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" class="btn btn-outline-primary btn-sm me-2" title="Share on Facebook" target="_blank">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($article->title) }}" class="btn btn-outline-primary btn-sm me-2" title="Share on LinkedIn" target="_blank">
                            <i class="fab fa-linkedin-in"></i> LinkedIn
                        </a>
                        <button class="btn btn-outline-secondary btn-sm" title="Copy link" id="copyArticleLink" data-clipboard-text="{{ url()->current() }}">
                            <i class="fas fa-link"></i> Copy Link
                        </button>
                    </div>
                </div>

                <!-- Author Bio -->
                <div class="article-author mt-5 p-4 border rounded">
                    <div class="d-flex">
                        <img src="{{ asset('assets/profile/Muhammad Nawaz.jpg') }}" alt="Muhammad Nawaz" class="rounded-circle me-3" style="width: 80px; height: 80px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <h5 class="mb-1">Muhammad Nawaz</h5>
                            <p class="text-muted mb-2">Full Stack Web Developer</p>
                            <p class="mb-3">Welcome to Invidiatech, a freelance-based development studio founded in 2020. I specialize in PHP, Laravel, WordPress, Shopify, HTML, CSS, Bootstrap, and JavaScript.</p>
                            <div class="d-flex gap-2">
                                <a href="https://www.facebook.com/Muhammad.Nawaz.Dev/" class="btn btn-outline-primary btn-sm" target="_blank">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://www.linkedin.com/in/muhammad-nawaz-43a354201/" class="btn btn-outline-primary btn-sm" target="_blank">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a href="https://github.com/nawazfdev" class="btn btn-outline-dark btn-sm" target="_blank">
                                    <i class="fab fa-github"></i>
                                </a>
                                <a href="https://invidiatech.com" class="btn btn-outline-success btn-sm" target="_blank">
                                    <i class="fas fa-globe"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Articles -->
                @if(isset($relatedArticles) && count($relatedArticles) > 0)
                <div class="related-articles mt-5">
                    <h3 class="mb-4">Related Articles</h3>
                    <div class="row">
                        @foreach($relatedArticles as $relatedArticle)
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                @if($relatedArticle->featured_image)
                                    <img src="{{ asset('storage/' . $relatedArticle->featured_image) }}" 
                                         alt="{{ $relatedArticle->featured_image_alt ?? $relatedArticle->title }}" 
                                         class="card-img-top" style="height: 150px; object-fit: cover;">
                                @endif
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <a href="{{ route('article.show', $relatedArticle->slug) }}" class="text-decoration-none">
                                            {{ $relatedArticle->title }}
                                        </a>
                                    </h6>
                                    <small class="text-muted">
                                        <i class="far fa-calendar me-1"></i> {{ $relatedArticle->created_at->format('M d, Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Comments Section -->
                <div class="comments-section mt-5" id="comments">
                    <h3 class="mb-4">Comments ({{ $article->comments->count() ?? 0 }})</h3>
                    
                    @auth
                    <div class="comment-form mb-5">
                        <div class="mb-3">
                            <textarea class="form-control" id="commentTextarea" rows="4" placeholder="Add a comment..."></textarea>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">Please be respectful and constructive in your comments.</div>
                            <button class="btn btn-primary" id="submitComment" data-article-id="{{ $article->id }}">Post Comment</button>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i> <a href="{{ route('login') }}">Log in</a> to add your comment.
                    </div>
                    @endauth
                    
                    <div class="comment-list" id="commentList">
                        @if(isset($article->comments) && $article->comments->count() > 0)
                            @foreach($article->comments->where('parent_id', null) as $comment)
                                @include('website.pages.components.comment', ['comment' => $comment, 'article' => $article])
                            @endforeach
                        @else
                            <div class="alert alert-info" id="noCommentsMessage">
                                No comments yet. Be the first to comment!
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar (Table of Contents) -->
            <div class="col-lg-4 animate animate-delay-2">
                <div class="article-toc">
                    <h3 class="article-toc-title">
                        <i class="fas fa-list me-2"></i>Table of Contents
                    </h3>
                    <ul class="article-toc-list" id="tocList">
                        <!-- Dynamic TOC will be injected here -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all features
    generateTableOfContents();
    initializeReadingProgress();
    initializeScrollSpy();
    initializeShareFunctionality();
    
    // Initialize tooltips if Bootstrap is available
    if (typeof bootstrap !== 'undefined') {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    }
});

/**
 * Generate Table of Contents
 */
function generateTableOfContents() {
    const article = document.querySelector('.article-body');
    const tocList = document.getElementById('tocList');
    
    if (!article || !tocList) return;
    
    const headings = article.querySelectorAll('h1, h2, h3, h4, h5, h6');
    
    if (headings.length === 0) {
        document.querySelector('.article-toc').style.display = 'none';
        return;
    }
    
    // Clear existing TOC
    tocList.innerHTML = '';
    
    headings.forEach((heading, index) => {
        // Create unique ID if not exists
        if (!heading.id) {
            heading.id = 'heading-' + index;
        }
        
        // Create TOC item
        const tocItem = document.createElement('li');
        tocItem.className = `toc-item toc-${heading.tagName.toLowerCase()}`;
        
        const tocLink = document.createElement('a');
        tocLink.href = '#' + heading.id;
        tocLink.textContent = heading.textContent;
        tocLink.className = 'toc-link';
        
        tocItem.appendChild(tocLink);
        tocList.appendChild(tocItem);
        
        // Add click handler
        tocLink.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove previous highlights
            document.querySelectorAll('.heading-highlighted').forEach(el => {
                el.classList.remove('heading-highlighted');
            });
            
            // Scroll to heading with offset
            const targetPosition = heading.offsetTop - 120;
            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
            
            // Highlight the heading
            heading.classList.add('heading-highlighted');
            
            // Update URL without jumping
            history.pushState(null, null, '#' + heading.id);
            
            // Update active TOC link
            updateActiveTocLink(tocLink);
        });
    });
}

/**
 * Initialize Reading Progress Bar
 */
function initializeReadingProgress() {
    const progressBar = document.getElementById('readingProgress');
    if (!progressBar) return;
    
    window.addEventListener('scroll', function() {
        const article = document.querySelector('.article-body');
        if (!article) return;
        
        const articleStart = article.offsetTop;
        const articleHeight = article.offsetHeight;
        const windowHeight = window.innerHeight;
        const scrollTop = window.pageYOffset;
        
        const articleEnd = articleStart + articleHeight - windowHeight;
        const progress = Math.max(0, Math.min(100, ((scrollTop - articleStart + 100) / (articleEnd - articleStart + 100)) * 100));
        
        progressBar.style.width = progress + '%';
    });
}

/**
 * Initialize Scroll Spy for TOC
 */
function initializeScrollSpy() {
    const headings = document.querySelectorAll('.article-body h1, .article-body h2, .article-body h3, .article-body h4, .article-body h5, .article-body h6');
    const tocLinks = document.querySelectorAll('.toc-link');
    
    if (headings.length === 0 || tocLinks.length === 0) return;
    
    window.addEventListener('scroll', function() {
        let currentHeading = null;
        
        headings.forEach(heading => {
            const rect = heading.getBoundingClientRect();
            if (rect.top <= 150 && rect.bottom >= 150) {
                currentHeading = heading;
            }
        });
        
        if (currentHeading) {
            const activeLink = document.querySelector(`.toc-link[href="#${currentHeading.id}"]`);
            updateActiveTocLink(activeLink);
        }
    });
}

/**
 * Update Active TOC Link
 */
function updateActiveTocLink(activeLink) {
    // Remove active class from all links
    document.querySelectorAll('.toc-link').forEach(link => {
        link.classList.remove('active');
    });
    
    // Add active class to current link
    if (activeLink) {
        activeLink.classList.add('active');
    }
}

/**
 * Initialize Share Functionality
 */
function initializeShareFunctionality() {
    // Copy link functionality
    const copyLinkBtn = document.getElementById('copyArticleLink');
    if (copyLinkBtn) {
        copyLinkBtn.addEventListener('click', function() {
            const url = this.getAttribute('data-clipboard-text');
            
            navigator.clipboard.writeText(url).then(function() {
                // Show success feedback
                const originalText = copyLinkBtn.innerHTML;
                copyLinkBtn.innerHTML = '<i class="fas fa-check"></i> Copied!';
                copyLinkBtn.classList.add('btn-success');
                
                setTimeout(function() {
                    copyLinkBtn.innerHTML = originalText;
                    copyLinkBtn.classList.remove('btn-success');
                }, 2000);
            }).catch(function() {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = url;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                
                alert('Link copied to clipboard!');
            });
        });
    }
}

/**
 * Toggle Share Menu
 */
function toggleShareMenu() {
    const shareMenu = document.getElementById('shareMenu');
    if (shareMenu) {
        shareMenu.style.display = shareMenu.style.display === 'flex' ? 'none' : 'flex';
    }
}

/**
 * Copy Article Link
 */
function copyArticleLink(event) {
    event.preventDefault();
    const url = window.location.href;
    
    navigator.clipboard.writeText(url).then(function() {
        alert('Link copied to clipboard!');
    });
}

/**
 * Scroll to Comments
 */
function scrollToComments() {
    const commentsSection = document.getElementById('comments');
    if (commentsSection) {
        commentsSection.scrollIntoView({ behavior: 'smooth' });
    }
}

// Close share menu when clicking outside
document.addEventListener('click', function(event) {
    const shareMenu = document.getElementById('shareMenu');
    const shareButton = event.target.closest('[onclick="toggleShareMenu()"]');
    
    if (shareMenu && !shareButton && !shareMenu.contains(event.target)) {
        shareMenu.style.display = 'none';
    }
});
</script>

@endsection