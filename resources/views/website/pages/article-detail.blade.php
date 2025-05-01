@extends('website.layouts.app')
@section('title', $article->title . ' - InvidiaTech')

<!-- Enhanced Code Block Styling -->
<style>
 .ql-code-block-container {
  background: #1e1e1e;
  padding: 1.25rem 1rem 1rem;
  margin: 1.5rem 0;
  border-radius: 10px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  overflow-x: auto;
  position: relative;
  border: 1px solid #333;
  transition: all 0.3s ease;
}

.ql-code-block-container:hover {
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
  border-color: #444;
}

/* Language label with dynamic colors */
.code-language-label {
  position: absolute;
  top: 10px;
  left: 15px;
  font-size: 0.75rem;
  background: #66d9ef;
  color: #000;
  padding: 2px 8px;
  border-radius: 4px;
  font-family: sans-serif;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

/* Language-specific coloring */
.lang-js, .lang-javascript { background: #f7df1e; color: #000; }
.lang-php { background: #8892bf; color: #fff; }
.lang-python { background: #3776ab; color: #fff; }
.lang-html { background: #e34c26; color: #fff; }
.lang-css { background: #264de4; color: #fff; }
.lang-sql { background: #f29111; color: #fff; }
.lang-bash, .lang-shell { background: #4eaa25; color: #fff; }
.lang-json { background: #f8c307; color: #000; }
.lang-typescript { background: #007acc; color: #fff; }

/* Actual code block styling */
.ql-code-block {
  background: transparent;
  color: #f8f8f2;
  font-family: 'Fira Code', 'JetBrains Mono', 'Courier New', monospace;
  font-size: 0.95rem;
  line-height: 1.6;
  white-space: pre;
  margin: 0;
  padding-top: 1rem;
}

/* Line numbers for code blocks */
.ql-code-block.with-line-numbers {
  counter-reset: line;
  padding-left: 3.5rem;
}

.ql-code-block.with-line-numbers > div {
  position: relative;
}

.ql-code-block.with-line-numbers > div::before {
  counter-increment: line;
  content: counter(line);
  position: absolute;
  left: -3rem;
  width: 2rem;
  text-align: right;
  color: #606366;
  user-select: none;
}

/* Copy button styling */
.copy-btn {
  position: absolute;
  top: 10px;
  right: 15px;
  background-color: #66d9ef;
  color: #000;
  border: none;
  padding: 4px 12px;
  font-size: 0.75rem;
  border-radius: 4px;
  cursor: pointer;
  font-weight: bold;
  transition: all 0.2s ease;
  display: flex;
  align-items: center;
  gap: 4px;
}

.copy-btn:hover {
  background-color: #4ec5de;
  transform: translateY(-1px);
}

.copy-btn:active {
  transform: translateY(1px);
}

.copy-btn i {
  font-size: 0.8rem;
}

/* Copy success animation */
.copy-btn.copied {
  background-color: #50fa7b;
  animation: pulse 0.5s;
}

@keyframes pulse {
  0% { transform: scale(1); }
  50% { transform: scale(1.1); }
  100% { transform: scale(1); }
}

/* Custom scrollbar for overflow */
.ql-code-block-container::-webkit-scrollbar {
  height: 6px;
}

.ql-code-block-container::-webkit-scrollbar-track {
  background: #2a2a2a;
  border-radius: 3px;
}

.ql-code-block-container::-webkit-scrollbar-thumb {
  background-color: #555;
  border-radius: 3px;
}

.ql-code-block-container::-webkit-scrollbar-thumb:hover {
  background-color: #777;
}

/* Syntax highlighting classes for common languages */
.ql-code-block .keyword { color: #ff79c6; }
.ql-code-block .function { color: #50fa7b; }
.ql-code-block .string { color: #f1fa8c; }
.ql-code-block .number { color: #bd93f9; }
.ql-code-block .comment { color: #6272a4; font-style: italic; }
.ql-code-block .operator { color: #ff79c6; }
.ql-code-block .variable { color: #f8f8f2; }
.ql-code-block .property { color: #8be9fd; }
.ql-code-block .tag { color: #ff79c6; }
.ql-code-block .attr-name { color: #50fa7b; }
.ql-code-block .attr-value { color: #f1fa8c; }

/* Dark mode adjustments */
body.dark-mode .ql-code-block-container {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
}
</style>

@section('content')    
     <!-- Main Content -->
     <main class="py-5" style="margin-top:60px">
        <div class="container">
            <div class="row">
 
<!-- Article Tools (Left Sidebar) -->
<div class="col-lg-1 d-none d-lg-block article-tools-container">
    <div class="article-tools">
        <div class="article-tool-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Like">
            <i class="far fa-heart"></i>
        </div>
        <div class="article-tool-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Comment">
            <i class="far fa-comment"></i>
        </div>
        <div class="article-tool-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Save">
            <i class="far fa-bookmark"></i>
        </div>
        <div class="article-tool-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Share">
            <i class="fas fa-share-alt"></i>
        </div>
        <div class="article-tool-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Download PDF" id="downloadPdf">
            <i class="fas fa-file-pdf"></i>
        </div>
        <div class="article-tool-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Dark Mode" id="darkModeToggle">
            <i class="fas fa-moon"></i>
        </div>
    </div>
</div>

                <!-- Article Content -->
                <div class="col-lg-7 animate animate-delay-1">
                    <!-- Audio Player -->
                    @if($article->audio_path)
                    <div class="audio-player mb-4">
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
                        <div class="d-flex align-items-center mb-3">
                            <button class="audio-player-btn-play">
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
                    @endif

                    <!-- Article Content -->
                    <article class="article-content">
                        {!! $article->content !!}
                    </article>

                    <!-- Article Tags -->
                    <div class="article-tags">
                        <a href="{{ route('articles', ['category' => $article->category->slug]) }}" class="article-tag">{{ $article->category->name }}</a>
                        @foreach($article->tags as $tag)
                            <a href="{{ route('articles', ['tag' => $tag->slug]) }}" class="article-tag">{{ $tag->name }}</a>
                        @endforeach
                    </div>

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

                    <!-- Author Bio -->
                    <div class="article-author">
                        <img src="{{ $article->user->avatar ?? '/api/placeholder/100/100' }}" alt="{{ $article->user->name }}" class="article-author-img">
                        <div>
                            <h4 class="article-author-name">{{ $article->user->name }}</h4>
                            <p class="article-author-bio">{{ $article->user->bio ?? 'Author at InvidiaTech' }}</p>
                            <div class="article-author-social">
                                @if($article->user->twitter)
                                <a href="{{ $article->user->twitter }}" class="article-author-social-link" title="Twitter" target="_blank">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                @endif
                                @if($article->user->linkedin)
                                <a href="{{ $article->user->linkedin }}" class="article-author-social-link" title="LinkedIn" target="_blank">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                @endif
                                @if($article->user->github)
                                <a href="{{ $article->user->github }}" class="article-author-social-link" title="GitHub" target="_blank">
                                    <i class="fab fa-github"></i>
                                </a>
                                @endif
                                @if($article->user->website)
                                <a href="{{ $article->user->website }}" class="article-author-social-link" title="Personal Website" target="_blank">
                                    <i class="fas fa-globe"></i>
                                </a>
                                @endif
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
                    <div class="comments-section mt-5">
                        <h3 class="mb-4">Comments ({{ $article->comments->count() }})</h3>
                        
                        <!-- Comment Form -->
                        <div class="comment-form mb-5">
                            <div class="mb-3">
                                <textarea class="form-control" rows="4" placeholder="Add a comment..."></textarea>
                            </div>
                            <button class="btn btn-accent-custom">Post Comment</button>
                        </div>
                        
                        <!-- Comment List -->
                        <div class="comment-list">
                            @forelse($article->comments as $comment)
                            <div class="comment">
                                <div class="comment-header">
                                    <img src="{{ $comment->user->avatar ?? '/api/placeholder/50/50' }}" alt="{{ $comment->user->name }}" class="comment-img">
                                    <div class="comment-meta">
                                        <div class="comment-name">
                                            {{ $comment->user->name }}
                                            @if($comment->user_id == $article->user_id)
                                            <span class="badge bg-accent-custom ms-2">Author</span>
                                            @endif
                                        </div>
                                        <div class="comment-date">{{ $comment->created_at->format('F d, Y') }}</div>
                                    </div>
                                </div>
                                <div class="comment-content">
                                    <p>{{ $comment->content }}</p>
                                </div>
                                <div class="comment-actions mt-2">
                                    <a href="#" class="me-3"><i class="far fa-thumbs-up me-1"></i> Like ({{ $comment->likes_count ?? 0 }})</a>
                                    <a href="#"><i class="far fa-reply me-1"></i> Reply</a>
                                </div>
                                
                                <!-- Comment Replies -->
                                @foreach($comment->replies as $reply)
                                <div class="comment-reply mt-3">
                                    <div class="comment-header">
                                        <img src="{{ $reply->user->avatar ?? '/api/placeholder/50/50' }}" alt="{{ $reply->user->name }}" class="comment-img">
                                        <div class="comment-meta">
                                            <div class="comment-name">
                                                {{ $reply->user->name }}
                                                @if($reply->user_id == $article->user_id)
                                                <span class="badge bg-accent-custom ms-2">Author</span>
                                                @endif
                                            </div>
                                            <div class="comment-date">{{ $reply->created_at->format('F d, Y') }}</div>
                                        </div>
                                    </div>
                                    <div class="comment-content">
                                        <p>{{ $reply->content }}</p>
                                    </div>
                                    <div class="comment-actions mt-2">
                                        <a href="#" class="me-3"><i class="far fa-thumbs-up me-1"></i> Like ({{ $reply->likes_count ?? 0 }})</a>
                                        <a href="#"><i class="far fa-reply me-1"></i> Reply</a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @empty
                            <div class="alert alert-info">
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
@endsection