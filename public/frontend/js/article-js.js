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