@extends('website.layouts.app')

@section('title', $article->meta_title ?: $article->title)
@section('meta_description', $article->meta_description ?: ($article->excerpt ?: Str::limit(strip_tags($article->content), 160)))
@section('meta_keywords', $article->focus_keyword ?: 'Laravel, PHP, Web Development, InvidiaTech')

@section('content')    
<style>
:root {
    --article-font-size: 18px;
    --article-line-height: 1.8;
    --reading-bg: #ffffff;
    --reading-text: #1f2937;
    --reading-border: #e5e7eb;
    --reading-accent: #3b82f6;
}

body.reading-mode-dark {
    --reading-bg: #1a1a1a;
    --reading-text: #e5e7eb;
    --reading-border: #374151;
    --reading-accent: #60a5fa;
}

/* Enhanced Code Block Styling */
.ql-syntax {
    font-family: 'JetBrains Mono', 'Fira Code', 'SF Mono', 'Monaco', 'Inconsolata', 'Roboto Mono', 'Consolas', monospace !important;
    font-size: 14px;
    line-height: 1.6;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    color: #e2e8f0;
    padding: 48px 28px 24px 28px;
    border-radius: 12px;
    border: 1px solid #334155;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    position: relative;
    overflow-x: auto;
    font-weight: 400;
    letter-spacing: 0.025em;
    transition: all 0.3s ease;
    margin: 24px 0;
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

.ql-syntax::after {
    content: 'Copy Code';
    position: absolute;
    top: 12px;
    right: 12px;
    background: rgba(59, 130, 246, 0.9);
    color: white;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    opacity: 0;
    pointer-events: none;
}

.ql-syntax:hover::after {
    opacity: 1;
    pointer-events: all;
}

.ql-syntax.copied::after {
    content: 'Copied!';
    background: rgba(34, 197, 94, 0.9);
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
    cursor: zoom-in;
    transition: transform 0.3s ease;
}

.article-featured-image:hover {
    transform: scale(1.02);
}

/* Image Zoom Modal */
.image-zoom-modal {
    display: none;
    position: fixed;
    z-index: 10000;
    padding: 50px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.95);
    cursor: zoom-out;
}

.image-zoom-modal img {
    margin: auto;
    display: block;
    max-width: 90%;
    max-height: 90vh;
    object-fit: contain;
}

.image-zoom-close {
    position: absolute;
    top: 20px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
}

/* Enhanced Article Content */
.article-body {
    font-size: var(--article-font-size);
    line-height: var(--article-line-height);
    color: var(--reading-text);
}

.article-body p {
    margin-bottom: 1.5em;
}

.article-body img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1.5rem 0;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    cursor: zoom-in;
}

.article-body blockquote {
    border-left: 4px solid var(--reading-accent);
    padding: 1rem 1.5rem;
    margin: 1.5rem 0;
    background: rgba(59, 130, 246, 0.05);
    border-radius: 0 8px 8px 0;
    font-style: italic;
}

.article-body ul, .article-body ol {
    margin: 1.5rem 0;
    padding-left: 2rem;
}

.article-body li {
    margin-bottom: 0.75rem;
}

/* Floating Reading Controls */
.reading-controls {
    position: fixed;
    bottom: 30px;
    right: 30px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    z-index: 1000;
}

.reading-control-btn {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: white;
    border: 1px solid #e5e7eb;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #6b7280;
    font-size: 18px;
}

.reading-control-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 25px rgba(0, 0, 0, 0.2);
    color: #3b82f6;
    border-color: #3b82f6;
}

.reading-control-btn.active {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

/* Font Size Adjuster */
.font-size-controls {
    position: fixed;
    top: 100px;
    right: 30px;
    background: white;
    border-radius: 12px;
    padding: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    display: flex;
    gap: 8px;
    z-index: 1000;
}

.font-size-btn {
    padding: 8px 12px;
    border: 1px solid #e5e7eb;
    background: white;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 600;
}

.font-size-btn:hover {
    background: #f3f4f6;
    border-color: #3b82f6;
}

.font-size-btn.active {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

/* Highlight to Share */
.highlight-share-tooltip {
    position: absolute;
    display: none;
    background: #1f2937;
    border-radius: 8px;
    padding: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    z-index: 1000;
}

.highlight-share-tooltip button {
    background: none;
    border: none;
    color: white;
    padding: 6px 10px;
    cursor: pointer;
    border-radius: 4px;
    transition: background 0.2s;
}

.highlight-share-tooltip button:hover {
    background: rgba(255, 255, 255, 0.1);
}

/* Article Meta */
.article-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 12px;
    font-size: 0.95rem;
    color: #6c757d;
    border: 1px solid #dee2e6;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.5rem 1rem;
    background: white;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.meta-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.meta-item i {
    color: #3b82f6;
}

/* Breadcrumb */
.article-breadcrumb {
    margin-bottom: 2rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
    font-size: 0.9rem;
}

.article-breadcrumb a {
    color: #3b82f6;
    text-decoration: none;
}

.article-breadcrumb a:hover {
    text-decoration: underline;
}

/* Article Navigation */
.article-navigation {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-top: 3rem;
    padding-top: 3rem;
    border-top: 2px solid #e9ecef;
}

.article-nav-item {
    padding: 1.5rem;
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    transition: all 0.3s ease;
    text-decoration: none;
    color: inherit;
}

.article-nav-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    border-color: #3b82f6;
}

.article-nav-label {
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #6b7280;
    font-weight: 600;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.article-nav-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1f2937;
    line-height: 1.4;
}

/* Reaction Buttons */
.article-reactions {
    display: flex;
    gap: 1rem;
    margin: 2rem 0;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 12px;
    flex-wrap: wrap;
}

.reaction-btn {
    padding: 0.75rem 1.5rem;
    border: 2px solid #e5e7eb;
    background: white;
    border-radius: 50px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 1.2rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.reaction-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.reaction-btn.active {
    border-color: #3b82f6;
    background: #eff6ff;
    animation: reaction-pop 0.3s ease;
}

@keyframes reaction-pop {
    0% { transform: scale(1); }
    50% { transform: scale(1.3); }
    100% { transform: scale(1); }
}

/* Article Tags */
.article-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin-bottom: 2rem;
}

.article-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.2rem;
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    color: #1976d2;
    text-decoration: none;
    border-radius: 25px;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.article-tag:hover {
    background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(25, 118, 210, 0.3);
}

.article-tag i {
    font-size: 0.8rem;
}

/* Enhanced TOC */
.article-toc {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    position: sticky;
    top: 100px;
    max-height: calc(100vh - 150px);
    overflow-y: auto;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    border: 1px solid #e9ecef;
    z-index: 10;
    transition: all 0.3s ease;
}

.article-toc:hover {
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.article-toc-title {
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #e9ecef;
    color: #1f2937;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.toc-toggle-btn {
    background: none;
    border: none;
    font-size: 1rem;
    cursor: pointer;
    color: #6b7280;
    margin-left: auto;
}

.article-toc-list {
    list-style: none;
    padding: 0;
    margin: 0;
    transition: all 0.3s ease;
}

.article-toc-list.collapsed {
    max-height: 0;
    overflow: hidden;
}

.toc-item {
    margin-bottom: 0.5rem;
}

.toc-item a {
    color: #6b7280;
    text-decoration: none;
    display: block;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    transition: all 0.3s ease;
    font-size: 0.95rem;
    line-height: 1.5;
    border-left: 3px solid transparent;
}

.toc-item a:hover {
    background-color: #f3f4f6;
    color: #3b82f6;
    border-left-color: #3b82f6;
    transform: translateX(4px);
}

.toc-item a.active {
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    color: #3b82f6;
    border-left-color: #3b82f6;
    font-weight: 600;
}

.toc-item.toc-h1 a { font-weight: 600; font-size: 1rem; }
.toc-item.toc-h2 a { padding-left: 1.25rem; }
.toc-item.toc-h3 a { padding-left: 1.75rem; font-size: 0.9rem; }
.toc-item.toc-h4 a { padding-left: 2.25rem; font-size: 0.85rem; }
.toc-item.toc-h5 a { padding-left: 2.75rem; font-size: 0.85rem; }
.toc-item.toc-h6 a { padding-left: 3.25rem; font-size: 0.85rem; }

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

.article-body h1, .article-body h2, .article-body h3 {
    margin-top: 2.5rem;
    margin-bottom: 1.5rem;
    font-weight: 700;
    line-height: 1.3;
}

.article-body h1 { font-size: 2.5rem; }
.article-body h2 { font-size: 2rem; }
.article-body h3 { font-size: 1.5rem; }
.article-body h4 { font-size: 1.25rem; }
.article-body h5 { font-size: 1.1rem; }
.article-body h6 { font-size: 1rem; }

.heading-highlighted {
    background: linear-gradient(90deg, rgba(59, 130, 246, 0.1) 0%, transparent 100%);
    padding-left: 1rem !important;
    border-left: 4px solid #3b82f6;
    animation: highlight-fade 3s ease-out;
}

@keyframes highlight-fade {
    0% { background-color: rgba(59, 130, 246, 0.2); }
    100% { background-color: transparent; }
}

/* Progress Ring */
.progress-ring-circle {
    transition: stroke-dashoffset 0.3s;
    transform: rotate(-90deg);
    transform-origin: 50% 50%;
}

/* Estimated Time Remaining */
.time-remaining-badge {
    position: fixed;
    top: 120px;
    left: 30px;
    background: white;
    padding: 1rem 1.5rem;
    border-radius: 50px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    z-index: 1000;
    transition: all 0.3s ease;
}

.time-remaining-badge:hover {
    transform: scale(1.05);
}

.time-remaining-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

/* Article Tools */
.article-tools-container {
    position: sticky;
    top: 120px;
    height: fit-content;
}

.article-tools {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    background: white;
    padding: 1rem;
    border-radius: 16px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    border: 1px solid #e9ecef;
}

.article-tool-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 1rem;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #6c757d;
    position: relative;
    font-size: 1.3rem;
}

.article-tool-item:hover {
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    color: #3b82f6;
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.article-tool-item.active {
    color: #3b82f6;
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
}

.article-tool-item.active.like-button {
    color: #ef4444;
    animation: heartbeat 0.5s ease;
}

@keyframes heartbeat {
    0%, 100% { transform: scale(1); }
    25% { transform: scale(1.2); }
    50% { transform: scale(1.1); }
    75% { transform: scale(1.15); }
}

.tool-count {
    font-size: 0.85rem;
    margin-top: 0.5rem;
    font-weight: 600;
}

/* Share Menu Enhanced */
.share-menu {
    position: absolute;
    left: 100%;
    top: 0;
    background: white;
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
    padding: 0.75rem;
    display: none;
    flex-direction: column;
    gap: 0.5rem;
    z-index: 1000;
    margin-left: 1rem;
    border: 1px solid #e9ecef;
}

.share-menu a {
    padding: 0.75rem;
    border-radius: 8px;
    color: #6c757d;
    transition: all 0.3s ease;
    font-size: 1.2rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.share-menu a:hover {
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    color: #3b82f6;
    transform: scale(1.1);
}

/* Progress Indicator */
.reading-progress {
    position: fixed;
    top: 0;
    left: 0;
    width: 0%;
    height: 4px;
    background: linear-gradient(90deg, #3b82f6, #8b5cf6, #06b6d4);
    z-index: 9999;
    transition: width 0.1s ease;
    box-shadow: 0 0 10px rgba(59, 130, 246, 0.5);
}

/* Print Styles */
@media print {
    .reading-controls,
    .font-size-controls,
    .article-tools,
    .article-toc,
    .article-share,
    .comments-section,
    .article-navigation,
    .time-remaining-badge {
        display: none !important;
    }
    
    .article-body {
        font-size: 12pt;
        line-height: 1.6;
    }
    
    .ql-syntax {
        background: #f5f5f5 !important;
        color: #000 !important;
        border: 1px solid #ddd !important;
        page-break-inside: avoid;
    }
}

/* Mobile Responsive */
@media (max-width: 991.98px) {
    .article-toc {
        position: relative;
        top: 0;
        max-height: 400px;
        margin-bottom: 2rem;
    }
    
    .article-tools-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
    }
    
    .article-tools {
        flex-direction: row;
        padding: 0.75rem;
    }
    
    .article-tool-item {
        padding: 0.75rem;
        font-size: 1.1rem;
    }
    
    .tool-count {
        font-size: 0.7rem;
    }
    
    .article-featured-image {
        height: 250px;
    }
    
    .font-size-controls {
        top: auto;
        bottom: 90px;
        right: 20px;
    }
    
    .time-remaining-badge {
        display: none;
    }
    
    .reading-controls {
        bottom: 90px;
        right: 20px;
    }
    
    .article-navigation {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 576px) {
    .article-meta {
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .article-featured-image {
        height: 200px;
        border-radius: 8px;
    }
    
    .article-body {
        font-size: 16px;
    }
    
    .reading-controls {
        bottom: 20px;
        right: 15px;
        gap: 8px;
    }
    
    .reading-control-btn {
        width: 45px;
        height: 45px;
        font-size: 16px;
    }
}

/* Smooth Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate {
    animation: fadeInUp 0.6s ease-out;
}

.animate-delay-1 {
    animation-delay: 0.1s;
}

.animate-delay-2 {
    animation-delay: 0.2s;
}

@keyframes fadeOut {
    from {
        opacity: 1;
        transform: translateY(0);
    }
    to {
        opacity: 0;
        transform: translateY(10px);
    }
}
</style>

<!-- Reading Progress Bar -->
<div class="reading-progress" id="readingProgress"></div>

<!-- Image Zoom Modal -->
<div class="image-zoom-modal" id="imageZoomModal">
    <span class="image-zoom-close" onclick="closeImageZoom()">&times;</span>
    <img id="zoomedImage" src="" alt="Zoomed image">
</div>

<!-- Font Size Controls -->
<div class="font-size-controls">
    <button class="font-size-btn" onclick="changeFontSize('small')" title="Decrease font size">A-</button>
    <button class="font-size-btn active" onclick="changeFontSize('medium')" title="Default font size">A</button>
    <button class="font-size-btn" onclick="changeFontSize('large')" title="Increase font size">A+</button>
</div>

<!-- Floating Reading Controls -->
<div class="reading-controls">
    <!-- Back to Top -->
    <button class="reading-control-btn" id="backToTop" onclick="scrollToTop()" title="Back to top" style="display: none;">
        <i class="fas fa-arrow-up"></i>
    </button>
    
    <!-- Print Article -->
    <button class="reading-control-btn" onclick="window.print()" title="Print article">
        <i class="fas fa-print"></i>
    </button>
    
    <!-- Text to Speech (placeholder) -->
    <button class="reading-control-btn" id="textToSpeech" onclick="toggleTextToSpeech()" title="Listen to article">
        <i class="fas fa-volume-up"></i>
    </button>
</div>

<!-- Estimated Time Remaining -->
<div class="time-remaining-badge" id="timeRemainingBadge" style="display: none;">
    <div class="time-remaining-icon">
        <i class="fas fa-clock"></i>
    </div>
    <div>
        <div style="font-size: 0.75rem; color: #6b7280; font-weight: 500;">Time Left</div>
        <div style="font-size: 1rem; font-weight: 700; color: #1f2937;" id="timeRemainingText">3 min</div>
    </div>
</div>

<!-- Highlight to Share Tooltip -->
<div class="highlight-share-tooltip" id="highlightShareTooltip">
    <button onclick="shareHighlightedText('twitter')" title="Share on Twitter">
        <i class="fab fa-twitter"></i>
    </button>
    <button onclick="shareHighlightedText('copy')" title="Copy quote">
        <i class="fas fa-copy"></i>
    </button>
</div>

<!-- Main Content -->
<main class="py-5" style="margin-top:60px">
    <div class="container">
        <!-- Breadcrumb -->
        <div class="article-breadcrumb animate">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="/blog">Blog</a></li>
                    @if($article->category && is_object($article->category))
                    <li class="breadcrumb-item"><a href="{{ route('articles', ['category' => $article->category->slug]) }}">{{ $article->category->name }}</a></li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($article->title, 50) }}</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <!-- Article Tools (Left Sidebar) -->
            <div class="col-lg-1 d-none d-lg-block article-tools-container">
                <div class="article-tools">
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
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" target="_blank" title="Share on Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" title="Share on Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($article->title) }}" target="_blank" title="Share on LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($article->title . ' ' . url()->current()) }}" target="_blank" title="Share on WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <a href="#" onclick="copyArticleLink(event)" title="Copy link">
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
                             class="article-featured-image"
                             onclick="zoomImage(this.src)">
                    </div>
                    @endif

                    <!-- Article Content -->
                    <div class="article-body" id="articleBody">
                        {!! $article->content !!}
                    </div>

                    <!-- Article Reactions -->
                    <div class="article-reactions">
                        <div style="font-weight: 600; margin-bottom: 0.5rem; color: #4b5563;">Was this article helpful?</div>
                        <button class="reaction-btn" onclick="addReaction('helpful')" data-reaction="helpful">
                            👍 <span class="reaction-count">0</span>
                        </button>
                        <button class="reaction-btn" onclick="addReaction('love')" data-reaction="love">
                            ❤️ <span class="reaction-count">0</span>
                        </button>
                        <button class="reaction-btn" onclick="addReaction('insightful')" data-reaction="insightful">
                            💡 <span class="reaction-count">0</span>
                        </button>
                        <button class="reaction-btn" onclick="addReaction('bookmark')" data-reaction="bookmark">
                            🔖 <span class="reaction-count">0</span>
                        </button>
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
                <div class="article-share mt-4 p-4 border rounded-3 bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="article-share-title fw-bold"><i class="fas fa-share-nodes me-2"></i>Share this article:</span>
                    </div>
                    <div class="mt-3 d-flex flex-wrap gap-2">
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" class="btn btn-primary btn-sm" title="Share on Twitter" target="_blank">
                            <i class="fab fa-twitter me-1"></i> Twitter
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" class="btn btn-primary btn-sm" title="Share on Facebook" target="_blank">
                            <i class="fab fa-facebook-f me-1"></i> Facebook
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($article->title) }}" class="btn btn-primary btn-sm" title="Share on LinkedIn" target="_blank">
                            <i class="fab fa-linkedin-in me-1"></i> LinkedIn
                        </a>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($article->title . ' ' . url()->current()) }}" class="btn btn-success btn-sm" title="Share on WhatsApp" target="_blank">
                            <i class="fab fa-whatsapp me-1"></i> WhatsApp
                        </a>
                        <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" class="btn btn-info btn-sm" title="Share on Telegram" target="_blank">
                            <i class="fab fa-telegram me-1"></i> Telegram
                        </a>
                        <a href="https://reddit.com/submit?url={{ urlencode(url()->current()) }}&title={{ urlencode($article->title) }}" class="btn btn-danger btn-sm" title="Share on Reddit" target="_blank">
                            <i class="fab fa-reddit me-1"></i> Reddit
                        </a>
                        <button class="btn btn-secondary btn-sm" title="Copy link" id="copyArticleLink" data-clipboard-text="{{ url()->current() }}">
                            <i class="fas fa-link me-1"></i> Copy Link
                        </button>
                    </div>
                </div>

                <!-- Author Bio -->
                <div class="article-author mt-5 p-4 border rounded-3 shadow-sm bg-white">
                    <div class="d-flex flex-column flex-md-row gap-3">
                        <img src="{{ asset('assets/profile/Muhammad Nawaz.jpg') }}" alt="Muhammad Nawaz" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <h5 class="mb-0">Muhammad Nawaz</h5>
                                <span class="badge bg-primary">Author</span>
                            </div>
                            <p class="text-muted mb-2 fw-semibold">Full Stack Web Developer</p>
                            <p class="mb-3">Welcome to Invidiatech! I specialize in PHP, Laravel, WordPress, Shopify, HTML, CSS, Bootstrap, and JavaScript. Building scalable web applications since 2022.</p>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="https://www.facebook.com/Muhammad.Nawaz.Dev/" class="btn btn-outline-primary btn-sm" target="_blank">
                                    <i class="fab fa-facebook-f me-1"></i> Facebook
                                </a>
                                <a href="https://www.linkedin.com/in/muhammad-nawaz-43a354201/" class="btn btn-outline-primary btn-sm" target="_blank">
                                    <i class="fab fa-linkedin-in me-1"></i> LinkedIn
                                </a>
                                <a href="https://github.com/nawazfdev" class="btn btn-outline-dark btn-sm" target="_blank">
                                    <i class="fab fa-github me-1"></i> GitHub
                                </a>
                                <a href="https://invidiatech.com" class="btn btn-outline-success btn-sm" target="_blank">
                                    <i class="fas fa-globe me-1"></i> Website
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Article Navigation (Previous/Next) -->
                @if(isset($previousArticle) || isset($nextArticle))
                <div class="article-navigation">
                    @if(isset($previousArticle))
                    <a href="{{ route('article.show', $previousArticle->slug) }}" class="article-nav-item">
                        <div class="article-nav-label">
                            <i class="fas fa-arrow-left"></i> Previous Article
                        </div>
                        <div class="article-nav-title">{{ $previousArticle->title }}</div>
                    </a>
                    @else
                    <div></div>
                    @endif

                    @if(isset($nextArticle))
                    <a href="{{ route('article.show', $nextArticle->slug) }}" class="article-nav-item text-end">
                        <div class="article-nav-label">
                            Next Article <i class="fas fa-arrow-right"></i>
                        </div>
                        <div class="article-nav-title">{{ $nextArticle->title }}</div>
                    </a>
                    @endif
                </div>
                @endif

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
                        <button class="toc-toggle-btn" onclick="toggleTOC()" title="Toggle TOC">
                            <i class="fas fa-chevron-up" id="tocToggleIcon"></i>
                        </button>
                    </h3>
                    <ul class="article-toc-list" id="tocList">
                        <!-- Dynamic TOC will be injected here -->
                    </ul>
                </div>

                <!-- Newsletter Subscription Widget -->
                <div class="mt-4 p-4 border rounded-3 shadow-sm bg-white" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);">
                    <div class="text-center">
                        <div style="width: 60px; height: 60px; margin: 0 auto 1rem; background: linear-gradient(135deg, #3b82f6, #8b5cf6); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-envelope text-white" style="font-size: 1.5rem;"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Subscribe to Newsletter</h5>
                        <p class="text-muted mb-3" style="font-size: 0.9rem;">Get the latest articles delivered to your inbox</p>
                        <form id="newsletterForm">
                            <div class="mb-2">
                                <input type="email" class="form-control" placeholder="Your email address" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-paper-plane me-1"></i> Subscribe
                            </button>
                        </form>
                        <small class="text-muted d-block mt-2">No spam, unsubscribe anytime</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
// Global variables
let selectedText = '';
let speechSynthesis = window.speechSynthesis;
let currentUtterance = null;
let isSpeaking = false;

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all features
    generateTableOfContents();
    initializeReadingProgress();
    initializeScrollSpy();
    initializeShareFunctionality();
    initializeCodeBlockCopy();
    initializeImageZoom();
    initializeHighlightShare();
    initializeBackToTop();
    calculateTimeRemaining();
    loadSavedReadingPosition();
    initializeReactions();
    
    // Initialize tooltips if Bootstrap is available
    if (typeof bootstrap !== 'undefined') {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    }
    
    // Save reading position periodically
    setInterval(saveReadingPosition, 5000);
    
    // Load saved font size
    const savedFontSize = localStorage.getItem('articleFontSize') || 'medium';
    changeFontSizeProgrammatic(savedFontSize);
});

/**
 * Change Font Size
 */
function changeFontSize(size) {
    changeFontSizeProgrammatic(size);
}

function changeFontSizeProgrammatic(size) {
    const article = document.querySelector('.article-body');
    const buttons = document.querySelectorAll('.font-size-btn');
    
    buttons.forEach(btn => btn.classList.remove('active'));
    
    const sizes = {
        'small': '16px',
        'medium': '18px',
        'large': '20px'
    };
    
    if (article) {
        document.documentElement.style.setProperty('--article-font-size', sizes[size]);
    }
    
    // Update active button
    const sizeIndex = { 'small': 0, 'medium': 1, 'large': 2 };
    if (buttons[sizeIndex[size]]) {
        buttons[sizeIndex[size]].classList.add('active');
    }
    
    localStorage.setItem('articleFontSize', size);
}

/**
 * Initialize Code Block Copy
 */
function initializeCodeBlockCopy() {
    const codeBlocks = document.querySelectorAll('.ql-syntax');
    
    codeBlocks.forEach((block, index) => {
        block.style.cursor = 'pointer';
        block.addEventListener('click', function(e) {
            // Only trigger on the code block itself
            const rect = this.getBoundingClientRect();
            if (e.clientX > rect.right - 120 && e.clientY < rect.top + 50) {
                copyCodeBlock(this);
            }
        });
    });
}

function copyCodeBlock(codeBlock) {
    const code = codeBlock.textContent;
    
    navigator.clipboard.writeText(code).then(() => {
        codeBlock.classList.add('copied');
        showNotification('Code copied to clipboard!');
        setTimeout(() => {
            codeBlock.classList.remove('copied');
        }, 2000);
    });
}

/**
 * Initialize Image Zoom
 */
function initializeImageZoom() {
    const images = document.querySelectorAll('.article-body img, .article-featured-image');
    images.forEach(img => {
        img.style.cursor = 'zoom-in';
        img.addEventListener('click', () => zoomImage(img.src));
    });
}

function zoomImage(src) {
    const modal = document.getElementById('imageZoomModal');
    const zoomedImg = document.getElementById('zoomedImage');
    if (modal && zoomedImg) {
        modal.style.display = 'block';
        zoomedImg.src = src;
        document.body.style.overflow = 'hidden';
    }
}

function closeImageZoom() {
    const modal = document.getElementById('imageZoomModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

// Close zoom on click
document.getElementById('imageZoomModal')?.addEventListener('click', closeImageZoom);

/**
 * Initialize Highlight to Share
 */
function initializeHighlightShare() {
    const article = document.querySelector('.article-body');
    const tooltip = document.getElementById('highlightShareTooltip');
    
    if (!article || !tooltip) return;
    
    document.addEventListener('mouseup', function(e) {
        setTimeout(() => {
            const selection = window.getSelection();
            selectedText = selection.toString().trim();
            
            if (selectedText.length > 10 && article.contains(selection.anchorNode)) {
                const range = selection.getRangeAt(0);
                const rect = range.getBoundingClientRect();
                
                tooltip.style.display = 'flex';
                tooltip.style.left = rect.left + (rect.width / 2) - 50 + 'px';
                tooltip.style.top = rect.top - 50 + window.scrollY + 'px';
            } else {
                tooltip.style.display = 'none';
            }
        }, 10);
    });
    
    // Hide tooltip when clicking outside
    document.addEventListener('mousedown', function(e) {
        if (!tooltip.contains(e.target)) {
            tooltip.style.display = 'none';
        }
    });
}

function shareHighlightedText(platform) {
    const articleUrl = window.location.href;
    const articleTitle = document.querySelector('.article-title')?.textContent || '';
    
    if (platform === 'twitter') {
        const tweetText = `"${selectedText}" - ${articleTitle}`;
        window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(tweetText)}&url=${encodeURIComponent(articleUrl)}`, '_blank');
    } else if (platform === 'copy') {
        navigator.clipboard.writeText(selectedText).then(() => {
            showNotification('Quote copied to clipboard!');
        });
    }
    
    document.getElementById('highlightShareTooltip').style.display = 'none';
    window.getSelection().removeAllRanges();
}

/**
 * Initialize Back to Top
 */
function initializeBackToTop() {
    const backToTopBtn = document.getElementById('backToTop');
    
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTopBtn.style.display = 'flex';
        } else {
            backToTopBtn.style.display = 'none';
        }
    });
}

function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

/**
 * Calculate Time Remaining
 */
function calculateTimeRemaining() {
    const article = document.querySelector('.article-body');
    const badge = document.getElementById('timeRemainingBadge');
    const timeText = document.getElementById('timeRemainingText');
    
    if (!article || !badge) return;
    
    const readingSpeed = 200; // words per minute
    const totalWords = article.textContent.split(/\s+/).length;
    const totalMinutes = Math.ceil(totalWords / readingSpeed);
    
    window.addEventListener('scroll', function() {
        const articleStart = article.offsetTop;
        const articleHeight = article.offsetHeight;
        const scrollTop = window.pageYOffset;
        const windowHeight = window.innerHeight;
        
        if (scrollTop > articleStart - 100) {
            badge.style.display = 'flex';
            
            const progress = (scrollTop - articleStart + windowHeight) / articleHeight;
            const minutesRemaining = Math.max(0, Math.ceil(totalMinutes * (1 - progress)));
            
            if (minutesRemaining > 0) {
                timeText.textContent = minutesRemaining + ' min';
            } else {
                timeText.textContent = 'Complete!';
            }
        } else {
            badge.style.display = 'none';
        }
    });
}

/**
 * Toggle TOC
 */
function toggleTOC() {
    const tocList = document.getElementById('tocList');
    const icon = document.getElementById('tocToggleIcon');
    
    if (tocList && icon) {
        tocList.classList.toggle('collapsed');
        icon.classList.toggle('fa-chevron-up');
        icon.classList.toggle('fa-chevron-down');
    }
}

/**
 * Save & Load Reading Position
 */
function saveReadingPosition() {
    const articleId = '{{ $article->id }}';
    const scrollPosition = window.scrollY;
    localStorage.setItem(`reading_position_${articleId}`, scrollPosition);
}

function loadSavedReadingPosition() {
    const articleId = '{{ $article->id }}';
    const savedPosition = localStorage.getItem(`reading_position_${articleId}`);
    
    if (savedPosition && parseInt(savedPosition) > 500) {
        setTimeout(() => {
            const continueReading = confirm('Would you like to continue from where you left off?');
            if (continueReading) {
                window.scrollTo({
                    top: parseInt(savedPosition),
                    behavior: 'smooth'
                });
            } else {
                // Clear saved position if user declines
                localStorage.removeItem(`reading_position_${articleId}`);
            }
        }, 1000);
    }
}

/**
 * Text to Speech
 */
function toggleTextToSpeech() {
    const btn = document.getElementById('textToSpeech');
    
    if (isSpeaking) {
        speechSynthesis.cancel();
        btn.classList.remove('active');
        btn.querySelector('i').classList.remove('fa-pause');
        btn.querySelector('i').classList.add('fa-volume-up');
        isSpeaking = false;
    } else {
        const articleText = document.querySelector('.article-body').textContent;
        currentUtterance = new SpeechSynthesisUtterance(articleText);
        currentUtterance.rate = 1.0;
        currentUtterance.pitch = 1.0;
        
        currentUtterance.onend = function() {
            btn.classList.remove('active');
            btn.querySelector('i').classList.remove('fa-pause');
            btn.querySelector('i').classList.add('fa-volume-up');
            isSpeaking = false;
        };
        
        speechSynthesis.speak(currentUtterance);
        btn.classList.add('active');
        btn.querySelector('i').classList.remove('fa-volume-up');
        btn.querySelector('i').classList.add('fa-pause');
        isSpeaking = true;
        
        showNotification('Playing article audio...');
    }
}

/**
 * Initialize Reactions
 */
function initializeReactions() {
    const articleId = '{{ $article->id }}';
    const savedReactions = JSON.parse(localStorage.getItem(`reactions_${articleId}`) || '{}');
    
    // Load saved reactions
    Object.keys(savedReactions).forEach(reaction => {
        const btn = document.querySelector(`[data-reaction="${reaction}"]`);
        if (btn) {
            btn.classList.add('active');
        }
    });
}

function addReaction(reactionType) {
    const articleId = '{{ $article->id }}';
    const btn = event.currentTarget;
    const isActive = btn.classList.contains('active');
    
    // Toggle reaction
    if (isActive) {
        btn.classList.remove('active');
        const reactions = JSON.parse(localStorage.getItem(`reactions_${articleId}`) || '{}');
        delete reactions[reactionType];
        localStorage.setItem(`reactions_${articleId}`, JSON.stringify(reactions));
    } else {
        btn.classList.add('active');
        const reactions = JSON.parse(localStorage.getItem(`reactions_${articleId}`) || '{}');
        reactions[reactionType] = true;
        localStorage.setItem(`reactions_${articleId}`, JSON.stringify(reactions));
        
        // Animate the reaction
        btn.style.animation = 'reaction-pop 0.5s ease';
        setTimeout(() => {
            btn.style.animation = '';
        }, 500);
    }
    
    // You can send this to backend via AJAX here
    // Example: fetch('/api/article-reactions', { method: 'POST', body: JSON.stringify({ article_id: articleId, reaction: reactionType, active: !isActive }) });
}

/**
 * Show Notification
 */
function showNotification(message) {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        background: linear-gradient(135deg, #1f2937, #111827);
        color: white;
        padding: 1rem 2rem;
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
        z-index: 10000;
        animation: fadeInUp 0.4s ease;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    `;
    notification.innerHTML = `<i class="fas fa-check-circle" style="color: #10b981;"></i>${message}`;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'fadeOut 0.4s ease';
        setTimeout(() => notification.remove(), 400);
    }, 3000);
}

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