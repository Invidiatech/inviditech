@extends('website.layouts.app')
@section('title', $article->title . ' - InvidiaTech')
     <link rel="stylesheet" href="{{ asset('frontend/css/article-detail.css') }}">

@section('content')    
     <!-- Main Content -->
     <main class="py-5" style="margin-top:60px">
        <div class="container">
            <div class="row">
            @auth
@endauth
<style>
   /* Import professional monospace fonts */
@import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Fira+Code:wght@400;500&display=swap');

/* Dark Theme for ql-syntax code blocks */
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

/* Top accent bar */
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

/* Syntax highlighting colors for dark theme */
.ql-syntax .comment {
    color: #64748b;
    font-style: italic;
}

.ql-syntax .keyword {
    color: #f472b6;
    font-weight: 500;
}

.ql-syntax .string {
    color: #34d399;
}

.ql-syntax .function {
    color: #60a5fa;
    font-weight: 500;
}

.ql-syntax .variable {
    color: #fbbf24;
}

.ql-syntax .operator {
    color: #f97316;
}

.ql-syntax .number {
    color: #a78bfa;
}

.ql-syntax .property {
    color: #38bdf8;
}

/* Hover effect */
.ql-syntax:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
    border-color: #475569;
}

/* Enhanced scrollbar for dark theme */
.ql-syntax::-webkit-scrollbar {
    height: 8px;
}

.ql-syntax::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.2);
    border-radius: 4px;
}

.ql-syntax::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 4px;
}

.ql-syntax::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.5);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .ql-syntax {
        font-size: 13px;
        padding: 16px 20px;
        border-radius: 8px;
    }
}

@media (max-width: 480px) {
    .ql-syntax {
        font-size: 12px;
        padding: 12px 16px;
        margin: 12px 0;
    }
}
</style>
<!-- Article Tools (Left Sidebar) -->
<div class="col-lg-1 d-none d-lg-block article-tools-container">
    <div class="article-tools">
        <div class="article-tool-item like-button @if($userLiked) active @endif" 
             data-article-id="{{ $article->id }}" 
             data-bs-toggle="tooltip" 
             data-bs-placement="right" 
             title="@if($userLiked) Unlike @else Like @endif"
             id="likeButton">
            <i class="@if($userLiked) fas @else far @endif fa-heart"></i>
            <span class="tool-count" id="likeCount">{{ $likesCount }}</span>
        </div>
        
        <div class="article-tool-item" 
             data-bs-toggle="tooltip" 
             data-bs-placement="right" 
             title="Comment"
             onclick="scrollToComments()">
            <i class="far fa-comment"></i>
            <span class="tool-count">{{ $article->comments->count() }}</span>
        </div>
        
        <div class="article-tool-item bookmark-button @if($userBookmarked) active @endif" 
             data-article-id="{{ $article->id }}" 
             data-bs-toggle="tooltip" 
             data-bs-placement="right" 
             title="@if($userBookmarked) Remove Bookmark @else Bookmark @endif"
             id="bookmarkButton">
            <i class="@if($userBookmarked) fas @else far @endif fa-bookmark"></i>
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
        
  
        @if($article->user_id != auth()->id())
        <div class="article-tool-item follow-button @if($userFollowing) active @endif" 
             data-user-id="{{ $article->user_id }}" 
             data-bs-toggle="tooltip" 
             data-bs-placement="right" 
             title="@if($userFollowing) Unfollow @else Follow @endif Author"
             id="followButton">
            <i class="@if($userFollowing) fas @else far @endif fa-user-circle"></i>
        </div>
        @endif
    </div>
</div>
                <!-- Article Content -->
                <div class="col-lg-7 animate animate-delay-1">
                 <!-- Audio Player -->
<div class="audio-player mb-4 d-none">
    <div class="audio-player-header">
        <h4 class="audio-player-title">Listen to this article</h4>
        <div class="audio-player-controls">
            <button class="audio-player-btn" title="Speed">
                <i class="fas fa-tachometer-alt"></i> 1.0x
            </button>
            <button class="audio-player-btn" title="Volume">
                <i class="fas fa-volume-up"></i>
            </button>
        </div>
    </div>

    <!-- 🔊 Actual Audio Element -->
    <audio id="audio-player" preload="metadata" controls style="width: 100%; display: none;">
        <source src="{{ asset('storage/audio/kEh7LWlpSVKYDPB1JqIhHKLoNQezU1I420AYGlR0.webm') }}" type="audio/webm">
        Your browser does not support the audio element.
    </audio>

    <div class="d-flex align-items-center mb-3">
        <button class="audio-player-btn-play" onclick="document.getElementById('audio-player').play()">
            <i class="fas fa-play"></i>
        </button>
        <div class="w-100">
            <div class="audio-player-progress">
                <div class="audio-player-progress-fill"></div>
                <div class="audio-player-progress-handle"></div>
            </div>
            <div class="audio-player-time">
                <span>00:00</span>
                <span>{{ $article->reading_time ?? '00:00' }}</span>
            </div>
        </div>
    </div>
</div>

                    <!-- Article Content -->
                    <article class="article-content">
                    <h1 class="article-title">{{ $article->title }}</h1>
                        {!! $article->content !!}
                    </article>

                    {{-- Article Tags 
                    <div class="article-tags">
                        <a href="{{ route('articles', ['category' => $article->category->slug]) }}" class="article-tag">{{ $article->category->name }}</a>
                        @foreach($article->tags as $tag)
                            <a href="{{ route('articles', ['tag' => $tag->slug]) }}" class="article-tag">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                    --}}
                    <!-- Article Share -->
                    <div class="article-share">
                        <span class="article-share-title">Share this article:</span>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" class="article-share-link twitter" title="Share on Twitter" target="_blank">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" class="article-share-link facebook" title="Share on Facebook" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($article->title) }}" class="article-share-link linkedin" title="Share on LinkedIn" target="_blank">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="article-share-link" title="Copy link" id="copyArticleLink" data-clipboard-text="{{ url()->current() }}">
                            <i class="fas fa-link"></i>
                        </a>
                    </div>

<!-- Enhanced Author Bio with TikTok-style Follow Button -->
<div class="article-author">
    <img  src="{{ asset('assets/profile/Muhammad Nawaz.jpg') }}" alt="Muhammad Nawaz" class="article-author-img">
    <div class="article-author-info">
        <div class="author-header">
            <div>
                <h4 class="article-author-name">Muhammad Nawaz</h4>
                <p class="article-author-position">Full Stack Web Developer</p>
                <p class="author-stats">
                    <span class="author-followers d-none"><i class="fas fa-user-friends"></i> {{ $userFollowing ?? 0 }} Followers</span>
                    <!-- <span class="author-articles"><i class="fas fa-file-alt"></i> {{ $articleCount ?? 0 }} Articles</span> -->
                </p>
            </div>
            @if(auth()->check() && auth()->id() != $article->user_id)
            <button class="author-follow-btn follow-button @if($userFollowing) active @endif" 
                   data-user-id="{{ $article->user_id }}">
                <i class="@if($userFollowing) fas @else far @endif fa-user-circle"></i>
                <span>@if($userFollowing) Following @else Follow @endif</span>
            </button>
            @elseif(!auth()->check())
            <a class="d-none" href="{{ route('login') }}" class="author-follow-btn">
                <i class="far fa-user-circle"></i>
                <span>Login to Follow</span>
            </a>
            @endif
        </div>
        <p class="article-author-bio">Welcome to Invidiatech, a freelance-based development studio founded in 2020. I specialize in PHP, Laravel, WordPress, Shopify, HTML, CSS, Bootstrap, and JavaScript. I transform business challenges into efficient digital experiences with dedicated personal attention on every project.</p>
        <div class="article-author-social">
            <a href="https://www.facebook.com/Muhammad.Nawaz.Dev/" class="article-author-social-link facebook" title="Follow on Facebook" target="_blank">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="https://www.linkedin.com/in/muhammad-nawaz-43a354201/" class="article-author-social-link linkedin" title="Connect on LinkedIn" target="_blank">
                <i class="fab fa-linkedin-in"></i>
            </a>
            <a href="https://github.com/nawazfdev" class="article-author-social-link github" title="Follow on GitHub" target="_blank">
                <i class="fab fa-github"></i>
            </a>
            <a href="https://invidiatech.com" class="article-author-social-link website" title="Visit Website" target="_blank">
                <i class="fas fa-globe"></i>
            </a>
        </div>
    </div>
</div>

                    <!-- Related Articles -->
                    @if(count($relatedArticles) > 0)
                    <div class="related-articles">
                        <h3 class="related-articles-title">Related Articles</h3>
                        @foreach($relatedArticles as $relatedArticle)
                        <div class="related-article">
                            @if($relatedArticle->featured_image)
                                <img src="{{ asset('storage/' . $relatedArticle->featured_image) }}" 
                                     alt="{{ $relatedArticle->featured_image_alt ?? $relatedArticle->title }}" 
                                     class="related-article-img">
                            @else
                                <img src="/api/placeholder/100/100" alt="{{ $relatedArticle->title }}" class="related-article-img">
                            @endif
                            <div>
                                <a href="{{ route('article.show', $relatedArticle->slug) }}" class="related-article-title">{{ $relatedArticle->title }}</a>
                                <div class="related-article-meta">
                                    <span><i class="far fa-user me-1"></i> {{ $relatedArticle->user->name }}</span>
                                    <span class="ms-2"><i class="far fa-calendar me-1"></i> {{ $relatedArticle->created_at->format('F d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                  <!-- Comments Section -->
<div class="comments-section mt-5" id="comments">
    <h3 class="mb-4">Comments ({{ $article->comments->count() }})</h3>
    
    <!-- Comment Form -->
    @auth
    <div class="comment-form mb-5">
        <div class="mb-3">
            <textarea class="form-control" id="commentTextarea" rows="4" placeholder="Add a comment..."></textarea>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <div class="text-muted">Please be respectful and constructive in your comments.</div>
            <button class="btn btn-accent-custom" id="submitComment" data-article-id="{{ $article->id }}">Post Comment</button>
        </div>
    </div>
    @else
    <div class="alert alert-info mb-4">
        <i class="fas fa-info-circle me-2"></i> <a href="{{ route('login') }}">Log in</a> to add your comment.
    </div>
    @endauth
    
    <!-- Comment List -->
    <div class="comment-list" id="commentList">
        @forelse($article->comments->where('parent_id', null) as $comment)
            @include('website.pages.components.comment', ['comment' => $comment, 'article' => $article])
        @empty
            <div class="alert alert-info" id="noCommentsMessage">
                No comments yet. Be the first to comment!
            </div>
        @endforelse
    </div>
</div>
                </div>

                <!-- Sidebar (Table of Contents) -->
                <div class="col-lg-4 animate animate-delay-2">
                    <div class="article-toc">
                        <h3 class="article-toc-title">Table of Contents</h3>
                        <ul class="article-toc-list">
                            <!-- Dynamic TOC will be injected here -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>

 <script>
document.addEventListener('DOMContentLoaded', () => {
  // Process code blocks
  enhanceCodeBlocks();
  
  // Generate table of contents
  generateTableOfContents();
  
  // Initialize other functionality
  initializeArticleTools();
});

/**
 * Enhance code blocks with language detection, copy buttons, and line numbers
 */
function enhanceCodeBlocks() {
  // Find all code blocks (both standalone and in containers)
  const standaloneBlocks = document.querySelectorAll('.ql-code-block:not(.ql-code-block-container .ql-code-block)');
  
  // Process standalone blocks - wrap them in containers
  standaloneBlocks.forEach(block => {
    // Skip empty blocks
    if (!block.textContent.trim()) return;
    
    // Create container
    const container = document.createElement('div');
    container.className = 'ql-code-block-container';
    
    // Replace the block with the container
    const parent = block.parentNode;
    parent.insertBefore(container, block);
    container.appendChild(block);
  });
  
  // Find all containers now (both pre-existing and newly created)
  const codeContainers = document.querySelectorAll('.ql-code-block-container');
  
  codeContainers.forEach(container => {
    const codeBlock = container.querySelector('.ql-code-block');
    if (!codeBlock) return;
    
    // Get language from data attribute or detect it
    let language = codeBlock.getAttribute('data-language') || detectLanguage(codeBlock.textContent);
    
    // Add language label
    const languageLabel = document.createElement('span');
    languageLabel.className = `code-language-label lang-${language}`;
    languageLabel.textContent = language;
    container.appendChild(languageLabel);
    
    // Create the copy button with icon
    const copyButton = document.createElement('button');
    copyButton.className = 'copy-btn';
    copyButton.innerHTML = '<i class="far fa-copy"></i> Copy';
    container.appendChild(copyButton);
    
    // Add line numbers
    addLineNumbers(codeBlock);
    
    // Add syntax highlighting classes
    applySyntaxHighlighting(codeBlock, language);
    
    // Copy functionality
    copyButton.addEventListener('click', () => {
      const code = codeBlock.innerText;
      if (!code) return;
      
      navigator.clipboard.writeText(code).then(() => {
        copyButton.innerHTML = '<i class="fas fa-check"></i> Copied!';
        copyButton.classList.add('copied');
        
        setTimeout(() => {
          copyButton.innerHTML = '<i class="far fa-copy"></i> Copy';
          copyButton.classList.remove('copied');
        }, 2000);
      });
    });
  });
}

 
function addLineNumbers(codeBlock) {
  if (!codeBlock) return;
  
  // Add the line numbers class
  codeBlock.classList.add('with-line-numbers');
  
  // Split content by lines and wrap each in a div
  const content = codeBlock.innerHTML;
  const lines = content.split('\n');
  
  // Create HTML with line number divs
  let wrappedContent = '';
  lines.forEach(line => {
    wrappedContent += `<div>${line}</div>`;
  });
  
  codeBlock.innerHTML = wrappedContent;
}

/**
 * Apply basic syntax highlighting classes
 */
function applySyntaxHighlighting(codeBlock, language) {
  if (!codeBlock || !language) return;
  
  // Only apply for specific languages
  if (!['javascript', 'php', 'html', 'css', 'sql', 'python'].includes(language)) return;
  
  // Get all text nodes
  const walker = document.createTreeWalker(
    codeBlock,
    NodeFilter.SHOW_TEXT,
    null,
    false
  );
  
  const nodes = [];
  let node;
  while (node = walker.nextNode()) {
    nodes.push(node);
  }
  
  // Apply highlighting patterns based on language
  nodes.forEach(node => {
    let html = node.textContent;
    
    // Language-specific patterns
    if (language === 'javascript') {
      html = html
        .replace(/\b(var|let|const|function|return|if|else|for|while|switch|case|break|continue|new|this|class|extends|import|export|default|try|catch|throw|async|await)\b/g, '<span class="keyword">$1</span>')
        .replace(/\b(console)\b/g, '<span class="property">$1</span>')
        .replace(/("[^"]*"|'[^']*'|`[^`]*`)/g, '<span class="string">$1</span>')
        .replace(/\b(\d+)\b/g, '<span class="number">$1</span>')
        .replace(/\/\/.*|\/\*[\s\S]*?\*\//g, '<span class="comment">$&</span>');
    }
    
    else if (language === 'php') {
      html = html
        .replace(/\b(function|return|if|else|foreach|for|while|switch|case|break|continue|new|class|extends|implements|public|private|protected|static|echo|print|include|require|namespace|use)\b/g, '<span class="keyword">$1</span>')
        .replace(/(\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)/g, '<span class="variable">$1</span>')
        .replace(/("[^"]*"|'[^']*')/g, '<span class="string">$1</span>')
        .replace(/\b(\d+)\b/g, '<span class="number">$1</span>')
        .replace(/\/\/.*|\/\*[\s\S]*?\*\//g, '<span class="comment">$&</span>');
    }
    
    // Replace the text node with the highlighted HTML
    if (html !== node.textContent) {
      const span = document.createElement('span');
      span.innerHTML = html;
      node.parentNode.replaceChild(span, node);
    }
  });
}

/**
 * Generate table of contents from article headings
 */
function generateTableOfContents() {
  const article = document.querySelector('.article-content');
  const tocList = document.querySelector('.article-toc-list');
  
  if (!article || !tocList) return;
  
  // Find all headings
  const headings = article.querySelectorAll('h1, h2, h3, h4, h5, h6');
  
  if (headings.length === 0) {
    // Hide TOC if no headings
    const tocContainer = document.querySelector('.article-toc');
    if (tocContainer) tocContainer.style.display = 'none';
    return;
  }
  
  // Clear existing TOC items
  tocList.innerHTML = '';
  
  // Process each heading
  headings.forEach((heading, index) => {
    // Create id if not exists
    if (!heading.id) {
      heading.id = 'heading-' + index;
    }
    
    // Create TOC item
    const tocItem = document.createElement('li');
    tocItem.className = `toc-item toc-${heading.tagName.toLowerCase()}`;
    
    // Indent based on heading level
    const headingLevel = parseInt(heading.tagName.substring(1));
    tocItem.style.paddingLeft = ((headingLevel - 1) * 12) + 'px';
    
    // Create link
    const tocLink = document.createElement('a');
    tocLink.href = '#' + heading.id;
    tocLink.textContent = heading.textContent;
    tocItem.appendChild(tocLink);
    
    // Add to TOC
    tocList.appendChild(tocItem);
    
    // Add click handler for smooth scrolling
    tocLink.addEventListener('click', (e) => {
      e.preventDefault();
      
      // Smooth scroll to heading
      heading.scrollIntoView({ behavior: 'smooth' });
      
      // Update URL without jumping
      history.pushState(null, null, '#' + heading.id);
      
      // Highlight heading
      heading.classList.add('highlight-heading');
      setTimeout(() => {
        heading.classList.remove('highlight-heading');
      }, 2000);
    });
  });
}

/**
 * Initialize article tools and interactive elements
 */
function initializeArticleTools() {
  // Initialize copy article link
  const copyLinkBtn = document.getElementById('copyArticleLink');
  if (copyLinkBtn) {
    copyLinkBtn.addEventListener('click', (e) => {
      e.preventDefault();
      const url = copyLinkBtn.getAttribute('data-clipboard-text');
      
      navigator.clipboard.writeText(url).then(() => {
        showToast('Link copied to clipboard!');
      });
    });
  }
  
  // Initialize dark mode toggle
  const darkModeToggle = document.getElementById('darkModeToggle');
  if (darkModeToggle) {
    // Check local storage for preference
    const darkMode = localStorage.getItem('darkMode') === 'enabled';
    if (darkMode) {
      document.body.classList.add('dark-mode');
      darkModeToggle.querySelector('i').className = 'fas fa-sun';
    }
    
    // Toggle dark mode
    darkModeToggle.addEventListener('click', () => {
      document.body.classList.toggle('dark-mode');
      
      // Update icon
      const isDarkMode = document.body.classList.contains('dark-mode');
      darkModeToggle.querySelector('i').className = isDarkMode ? 'fas fa-sun' : 'fas fa-moon';
      
      // Save preference
      localStorage.setItem('darkMode', isDarkMode ? 'enabled' : 'disabled');
    });
  }
  
  // Initialize PDF download
  const downloadPdfBtn = document.getElementById('downloadPdfBtn');
  const downloadPdfIcon = document.getElementById('downloadPdf');
  
  const handlePdfDownload = () => {
    showToast('Preparing PDF download...', 'info');
    
    // Here you would implement actual PDF generation
    // For example using a library like html2pdf.js or a server-side endpoint
    
    // Simulated delay for demo purposes
    setTimeout(() => {
      showToast('PDF downloaded successfully!', 'success');
    }, 2000);
  };
  
  if (downloadPdfBtn) downloadPdfBtn.addEventListener('click', handlePdfDownload);
  if (downloadPdfIcon) downloadPdfIcon.addEventListener('click', handlePdfDownload);
  
  // Initialize tooltips if Bootstrap is available
  if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
  }
  
  // Add estimated reading time
  addReadingTime();
}

/**
 * Show toast notification
 */
function showToast(message, type = 'success') {
  // Create toast container if not exists
  let toastContainer = document.querySelector('.toast-container');
  if (!toastContainer) {
    toastContainer = document.createElement('div');
    toastContainer.className = 'toast-container';
    document.body.appendChild(toastContainer);
  }
  
  // Create toast
  const toast = document.createElement('div');
  toast.className = `toast toast-${type}`;
  toast.innerHTML = `
    <div class="toast-icon">
      <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
    </div>
    <div class="toast-content">${message}</div>
    <button class="toast-close">×</button>
  `;
  
  // Close button
  toast.querySelector('.toast-close').addEventListener('click', () => {
    toast.classList.remove('show');
    setTimeout(() => toast.remove(), 300);
  });
  
  // Add to container
  toastContainer.appendChild(toast);
  
  // Show toast
  setTimeout(() => toast.classList.add('show'), 10);
  
  // Auto hide after 3 seconds
  setTimeout(() => {
    toast.classList.remove('show');
    setTimeout(() => toast.remove(), 300);
  }, 3000);
}

/**
 * Add estimated reading time to article
 */
function addReadingTime() {
  const article = document.querySelector('.article-content');
  if (!article) return;
  
  // Count words (rough estimate)
  const text = article.textContent || article.innerText;
  const wordCount = text.trim().split(/\s+/).length;
  
  // Calculate reading time (average reading speed: 200 words per minute)
  const readingTimeMinutes = Math.ceil(wordCount / 200);
  
  // Create reading time element
  const readingTime = document.createElement('div');
  readingTime.className = 'article-reading-time';
  readingTime.innerHTML = `<i class="far fa-clock me-1"></i> ${readingTimeMinutes} min read`;
  
  // Find where to insert it (after title)
  const title = article.querySelector('h1');
  if (title && title.nextSibling) {
    article.insertBefore(readingTime, title.nextSibling);
  } else {
    article.insertBefore(readingTime, article.firstChild);
  }
}
</script>

<!-- Additional CSS for new features -->
<style>
/* Toast notifications */
.toast-container {
  position: fixed;
  bottom: 20px;
  right: 20px;
  z-index: 9999;
}

.toast {
  display: flex;
  align-items: center;
  background: white;
  border-left: 4px solid #3498db;
  border-radius: 4px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  margin-top: 10px;
  max-width: 350px;
  opacity: 0;
  overflow: hidden;
  padding: 12px 15px;
  transform: translateY(10px);
  transition: all 0.3s ease;
}

.toast.show {
  opacity: 1;
  transform: translateY(0);
}

.toast-success { border-left-color: #2ecc71; }
.toast-error { border-left-color: #e74c3c; }
.toast-info { border-left-color: #3498db; }

.toast-icon {
  margin-right: 10px;
  font-size: 1.25rem;
}

.toast-success .toast-icon { color: #2ecc71; }
.toast-error .toast-icon { color: #e74c3c; }
.toast-info .toast-icon { color: #3498db; }

.toast-content {
  flex: 1;
}

.toast-close {
  background: transparent;
  border: none;
  color: #999;
  cursor: pointer;
  font-size: 18px;
  padding: 0 5px;
}

/* Heading highlight animation */
.highlight-heading {
  animation: highlight-pulse 2s ease-out;
}

@keyframes highlight-pulse {
  0%, 100% { background-color: transparent; }
  20% { background-color: rgba(255, 193, 7, 0.2); }
}

/* TOC styling */
.article-toc {
  background-color: #f8f9fa;
  border-radius: 10px;
  padding: 1.5rem;
  position: sticky;
  top: 2rem;
  max-height: calc(100vh - 4rem);
  overflow-y: auto;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  border: 1px solid #eee;
}

.article-toc-title {
  font-size: 1.25rem;
  margin-bottom: 1rem;
  padding-bottom: 0.5rem;
  border-bottom: 2px solid #e9ecef;
}

.article-toc-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.toc-item {
  margin-bottom: 0.5rem;
  font-size: 0.95rem;
}

.toc-item a {
  color: #495057;
  text-decoration: none;
  display: block;
  padding: 0.25rem 0.5rem;
  border-radius: 4px;
  transition: all 0.2s ease;
}

.toc-item a:hover {
  background-color: #e9ecef;
  color: #212529;
}

.toc-h1 { font-weight: bold; }
.toc-h2 { padding-left: 0.75rem; }
.toc-h3 { padding-left: 1.5rem; }
.toc-h4 { padding-left: 2.25rem; }
.toc-h5 { padding-left: 3rem; }
.toc-h6 { padding-left: 3.75rem; }

/* Reading time indicator */
.article-reading-time {
  color: #6c757d;
  font-size: 0.9rem;
  margin-bottom: 1.5rem;
  display: inline-block;
  padding: 0.25rem 0.75rem;
  background-color: #f8f9fa;
  border-radius: 4px;
}

/* Dark mode adjustments */
body.dark-mode .article-toc {
  background-color: #2a2a2a;
  border-color: #333;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

body.dark-mode .article-toc-title {
  border-bottom-color: #444;
}

body.dark-mode .toc-item a {
  color: #e9ecef;
}

body.dark-mode .toc-item a:hover {
  background-color: #333;
  color: #fff;
}

body.dark-mode .article-reading-time {
  background-color: #2a2a2a;
  color: #adb5bd;
}

body.dark-mode .toast {
  background-color: #2a2a2a;
  color: #f8f9fa;
}

/* Responsive adjustments */
@media (max-width: 991.98px) {
  .article-toc {
    position: relative;
    top: 0;
    max-height: none;
    margin-bottom: 2rem;
  }
}
</style>
<script>
// Audio Player Implementation
document.addEventListener('DOMContentLoaded', function() {
    // Get elements
    const audioElement = document.getElementById('audio-player');
    if (!audioElement) return;

    const playButton = document.querySelector('.audio-player-btn-play');
    const playIcon = playButton.querySelector('i');
    const progressBar = document.querySelector('.audio-player-progress');
    const progressFill = document.querySelector('.audio-player-progress-fill');
    const progressHandle = document.querySelector('.audio-player-progress-handle');
    const timeDisplay = document.querySelector('.audio-player-time');
    const currentTime = timeDisplay.querySelectorAll('span')[0];
    const durationTime = timeDisplay.querySelectorAll('span')[1];
    const speedButton = document.querySelector('.audio-player-btn[title="Speed"]');
    const speedText = speedButton.innerHTML.trim(); // Store original text
    const volumeButton = document.querySelector('.audio-player-btn[title="Volume"]');
    const volumeIcon = volumeButton.querySelector('i');

    // Variables
    let isDragging = false;
    let playbackRates = [0.5, 0.75, 1.0, 1.25, 1.5, 1.75, 2.0];
    let currentRateIndex = 2; // Default to 1.0x
    let isMuted = false;
    let previousVolume = 1;

    // ===== FUNCTIONS =====

    // Format time in seconds to MM:SS
    function formatTime(seconds) {
        if (isNaN(seconds) || !isFinite(seconds)) return "00:00";
        const mins = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
    }

    // Update progress bar and time
    function updateProgress() {
        if (!isDragging && audioElement.duration) {
            const percent = (audioElement.currentTime / audioElement.duration) * 100;
            progressFill.style.width = `${percent}%`;
            progressHandle.style.left = `${percent}%`;
            currentTime.textContent = formatTime(audioElement.currentTime);
        }
    }

    // Toggle play/pause
    function togglePlay() {
        if (audioElement.paused) {
            const playPromise = audioElement.play();
            if (playPromise !== undefined) {
                playPromise.then(() => {
                    playIcon.classList.remove('fa-play');
                    playIcon.classList.add('fa-pause');
                }).catch(error => {
                    console.error('Error playing audio:', error);
                });
            }
        } else {
            audioElement.pause();
            playIcon.classList.remove('fa-pause');
            playIcon.classList.add('fa-play');
        }
    }

    // Update when audio ends
    function onEnded() {
        playIcon.classList.remove('fa-pause');
        playIcon.classList.add('fa-play');
        progressFill.style.width = '0%';
        progressHandle.style.left = '0%';
        audioElement.currentTime = 0;
    }

    // Seek in the audio when clicking progress bar
    function seekAudio(e) {
        const rect = progressBar.getBoundingClientRect();
        const pos = (e.clientX - rect.left) / rect.width;
        if (audioElement.duration) {
            audioElement.currentTime = pos * audioElement.duration;
        }
    }

    // Start dragging progress handle
    function startDrag(e) {
        isDragging = true;
        document.body.classList.add('no-select'); // Prevent text selection
    }

    // Drag progress handle
    function drag(e) {
        if (!isDragging) return;
        
        // Get mouse position
        let clientX = e.type.includes('touch') ? e.touches[0].clientX : e.clientX;
        
        const rect = progressBar.getBoundingClientRect();
        let pos = (clientX - rect.left) / rect.width;
        pos = Math.max(0, Math.min(1, pos)); // Clamp between 0 and 1
        
        // Update UI
        progressFill.style.width = `${pos * 100}%`;
        progressHandle.style.left = `${pos * 100}%`;
        
        // Update time display
        if (audioElement.duration) {
            currentTime.textContent = formatTime(pos * audioElement.duration);
        }
    }

    // End dragging and set position
    function endDrag(e) {
        if (!isDragging) return;
        
        // Get final position
        let clientX = e.type.includes('touch') ? e.changedTouches[0].clientX : e.clientX;
        
        const rect = progressBar.getBoundingClientRect();
        let pos = (clientX - rect.left) / rect.width;
        pos = Math.max(0, Math.min(1, pos)); // Clamp between 0 and 1
        
        // Set audio position
        if (audioElement.duration) {
            audioElement.currentTime = pos * audioElement.duration;
        }
        
        // End drag state
        isDragging = false;
        document.body.classList.remove('no-select');
    }

    // Change playback speed
    function changeSpeed() {
        currentRateIndex = (currentRateIndex + 1) % playbackRates.length;
        const rate = playbackRates[currentRateIndex];
        audioElement.playbackRate = rate;
        speedButton.innerHTML = `<i class="fas fa-tachometer-alt"></i> ${rate.toFixed(1)}x`;
    }

    // Toggle mute
    function toggleMute() {
        if (audioElement.volume > 0 && !isMuted) {
            previousVolume = audioElement.volume;
            audioElement.volume = 0;
            isMuted = true;
            volumeIcon.classList.remove('fa-volume-up');
            volumeIcon.classList.add('fa-volume-mute');
        } else {
            audioElement.volume = previousVolume;
            isMuted = false;
            volumeIcon.classList.remove('fa-volume-mute');
            volumeIcon.classList.add('fa-volume-up');
        }
    }

    // Update duration display when metadata is loaded
    function updateDuration() {
        if (audioElement.duration && !isNaN(audioElement.duration)) {
            durationTime.textContent = formatTime(audioElement.duration);
        }
    }

    // ===== EVENT LISTENERS =====

    // Audio events
    audioElement.addEventListener('timeupdate', updateProgress);
    audioElement.addEventListener('ended', onEnded);
    audioElement.addEventListener('loadedmetadata', updateDuration);
    audioElement.addEventListener('durationchange', updateDuration);

    // UI controls
    playButton.addEventListener('click', togglePlay);
    progressBar.addEventListener('click', seekAudio);
    speedButton.addEventListener('click', changeSpeed);
    volumeButton.addEventListener('click', toggleMute);

    // Progress handle drag events
    progressHandle.addEventListener('mousedown', startDrag);
    document.addEventListener('mousemove', drag);
    document.addEventListener('mouseup', endDrag);

    // Touch events for mobile
    progressHandle.addEventListener('touchstart', startDrag);
    document.addEventListener('touchmove', drag);
    document.addEventListener('touchend', endDrag);

    // Replace the default onclick handler with our toggle function
    playButton.removeAttribute('onclick');
    
    // Initialize duration display if available
    updateDuration();
});
</script>
@endsection