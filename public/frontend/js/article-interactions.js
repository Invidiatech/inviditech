document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM fully loaded - initializing article scripts');
    
    // Set global authentication flag based on visible user ID
    window.userIsAuthenticated = false;
    
    // Check for user ID paragraph - most reliable authentication check
    const paragraphs = document.querySelectorAll('p');
    paragraphs.forEach(function(paragraph) {
        if (paragraph.textContent && paragraph.textContent.includes('User ID:')) {
            window.userIsAuthenticated = true;
            console.log('User is authenticated via User ID paragraph');
            
            // Extract and store user ID if needed
            const userIdMatch = paragraph.textContent.match(/User ID:\s*(\d+)/);
            if (userIdMatch && userIdMatch[1]) {
                window.currentUserId = userIdMatch[1];
                console.log('Current user ID:', window.currentUserId);
            }
        }
    });
    
    // Create a CSRF token meta tag if it doesn't exist
    ensureCsrfTokenExists();
    
    // Process code blocks
    if (typeof enhanceCodeBlocks === 'function') {
        enhanceCodeBlocks();
    }
    
    // Generate table of contents
    if (typeof generateTableOfContents === 'function') {
        generateTableOfContents();
    }
    
    // Initialize article tools and interactions
    initializeArticleTools();
    
    // Initialize article interactions (likes, bookmarks, etc.)
    initializeArticleInteractions();
    
    // Make sure the scrollToComments function exists
    if (typeof window.scrollToComments !== 'function') {
        window.scrollToComments = scrollToComments;
    }
    
    // Initialize share menu toggling
    setupShareMenu();
});

/**
 * Ensure CSRF token exists in the document
 */
function ensureCsrfTokenExists() {
    // Check if meta tag already exists
    if (!document.querySelector('meta[name="csrf-token"]')) {
        console.log('CSRF token meta tag not found, attempting to create one');
        
        // Try to find token in a form
        const tokenInput = document.querySelector('input[name="_token"]');
        if (tokenInput) {
            const csrfToken = tokenInput.value;
            if (csrfToken) {
                // Create meta tag
                const meta = document.createElement('meta');
                meta.name = 'csrf-token';
                meta.content = csrfToken;
                document.head.appendChild(meta);
                console.log('Created CSRF token meta tag');
            }
        } else {
            console.warn('No CSRF token found in the page. AJAX requests may fail.');
        }
    }
}

/**
 * Initialize share menu toggle
 */
function setupShareMenu() {
    // Add global function for share menu toggle
    window.toggleShareMenu = function() {
        const shareMenu = document.getElementById('shareMenu');
        if (shareMenu) {
            shareMenu.classList.toggle('active');
        }
    };
    
    // Add global function for copying article link
    window.copyArticleLink = function(event) {
        if (event) event.preventDefault();
        const url = window.location.href;
        
        navigator.clipboard.writeText(url).then(function() {
            showToast('Link copied to clipboard!');
        }).catch(function() {
            showToast('Failed to copy link', 'error');
        });
    };
}

/**
 * Scroll to comments section function
 */
function scrollToComments() {
    const commentsSection = document.getElementById('comments');
    if (commentsSection) {
        commentsSection.scrollIntoView({ behavior: 'smooth' });
    } else {
        console.warn('Comments section not found');
    }
}

/**
 * Initialize article interactions (likes, bookmarks, comments, etc.)
 */
function initializeArticleInteractions() {
    console.log('Initializing article interactions');
    
    // Initialize tooltips if Bootstrap is available
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    }
    
    // Like button functionality
    initializeLikeButton();
    
    // Bookmark button functionality
    initializeBookmarkButton();
    
    // Follow button functionality
    initializeFollowButton();
    
    // Comment functionality
    initializeComments();
}

/**
 * Get CSRF token from the page
 */
function getCsrfToken() {
    // Try meta tag first
    const metaElement = document.querySelector('meta[name="csrf-token"]');
    if (metaElement) {
        return metaElement.getAttribute('content');
    }
    
    // Try hidden input in a form
    const tokenInput = document.querySelector('input[name="_token"]');
    if (tokenInput) {
        return tokenInput.value;
    }
    
    // No token found
    console.warn('CSRF token not found in page');
    return null;
}

/**
 * Initialize like button functionality
 */
function initializeLikeButton() {
    const likeButtons = document.querySelectorAll('.like-button');
    
    likeButtons.forEach(button => {
        button.addEventListener('click', function() {
            if (!isLoggedIn()) return;
            
            // Safely get article ID
            const articleId = this.getAttribute('data-article-id');
            if (!articleId) {
                console.error('No article ID found on like button');
                return;
            }
            
            const csrfToken = getCsrfToken();
            const headers = {
                'Content-Type': 'application/json'
            };
            
            // Only add CSRF token if available
            if (csrfToken) {
                headers['X-CSRF-TOKEN'] = csrfToken;
            }
            
            fetch('/articles/like', {
                method: 'POST',
                headers: headers,
                body: JSON.stringify({
                    article_id: articleId
                })
            })
            .then(response => {
                if (!response.ok) {
                    if (response.status === 419) {
                        throw new Error('CSRF token mismatch. Please refresh the page.');
                    }
                    throw new Error('Server returned ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                // Update button state
                if (data.liked) {
                    this.classList.add('active');
                    const icon = this.querySelector('i');
                    if (icon) icon.className = 'fas fa-heart';
                    this.setAttribute('title', 'Unlike');
                } else {
                    this.classList.remove('active');
                    const icon = this.querySelector('i');
                    if (icon) icon.className = 'far fa-heart';
                    this.setAttribute('title', 'Like');
                }
                
                // Update count
                const likeCount = document.getElementById('likeCount');
                if (likeCount) {
                    likeCount.textContent = data.count;
                }
                
                // Refresh tooltip
                if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                    const tooltip = bootstrap.Tooltip.getInstance(this);
                    if (tooltip) {
                        tooltip.dispose();
                    }
                    new bootstrap.Tooltip(this);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast(error.message || 'Something went wrong', 'error');
            });
        });
    });
}

/**
 * Initialize bookmark button functionality
 */
function initializeBookmarkButton() {
    const bookmarkButtons = document.querySelectorAll('.bookmark-button');
    
    bookmarkButtons.forEach(button => {
        button.addEventListener('click', function() {
            if (!isLoggedIn()) return;
            
            // Safely get article ID
            const articleId = this.getAttribute('data-article-id');
            if (!articleId) {
                console.error('No article ID found on bookmark button');
                return;
            }
            
            const csrfToken = getCsrfToken();
            const headers = {
                'Content-Type': 'application/json'
            };
            
            // Only add CSRF token if available
            if (csrfToken) {
                headers['X-CSRF-TOKEN'] = csrfToken;
            }
            
            fetch('/articles/bookmark', {
                method: 'POST',
                headers: headers,
                body: JSON.stringify({
                    article_id: articleId
                })
            })
            .then(response => {
                if (!response.ok) {
                    if (response.status === 419) {
                        throw new Error('CSRF token mismatch. Please refresh the page.');
                    }
                    throw new Error('Server returned ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                // Update button state
                if (data.bookmarked) {
                    this.classList.add('active');
                    const icon = this.querySelector('i');
                    if (icon) icon.className = 'fas fa-bookmark';
                    this.setAttribute('title', 'Remove Bookmark');
                    showToast('Article bookmarked successfully!');
                } else {
                    this.classList.remove('active');
                    const icon = this.querySelector('i');
                    if (icon) icon.className = 'far fa-bookmark';
                    this.setAttribute('title', 'Bookmark');
                    showToast('Bookmark removed!');
                }
                
                // Refresh tooltip
                if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                    const tooltip = bootstrap.Tooltip.getInstance(this);
                    if (tooltip) {
                        tooltip.dispose();
                    }
                    new bootstrap.Tooltip(this);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast(error.message || 'Something went wrong', 'error');
            });
        });
    });
}

/**
 * Initialize follow button functionality
 */
function initializeFollowButton() {
    const followButtons = document.querySelectorAll('.follow-button');
    
    followButtons.forEach(button => {
        button.addEventListener('click', function() {
            if (!isLoggedIn()) return;
            
            // Safely get user ID
            const userId = this.getAttribute('data-user-id');
            if (!userId) {
                console.error('No user ID found on follow button');
                return;
            }
            
            const csrfToken = getCsrfToken();
            const headers = {
                'Content-Type': 'application/json'
            };
            
            // Only add CSRF token if available
            if (csrfToken) {
                headers['X-CSRF-TOKEN'] = csrfToken;
            }
            
            fetch('/articles/follow', {
                method: 'POST',
                headers: headers,
                body: JSON.stringify({
                    user_id: userId
                })
            })
            .then(response => {
                if (!response.ok) {
                    if (response.status === 419) {
                        throw new Error('CSRF token mismatch. Please refresh the page.');
                    }
                    throw new Error('Server returned ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                // Update button state
                if (data.following) {
                    this.classList.add('active');
                    const icon = this.querySelector('i');
                    if (icon) icon.className = 'fas fa-user-circle';
                    const textSpan = this.querySelector('span');
                    if (textSpan) textSpan.textContent = 'Following';
                    this.setAttribute('title', 'Unfollow Author');
                    showToast('You are now following this author!');
                } else {
                    this.classList.remove('active');
                    const icon = this.querySelector('i');
                    if (icon) icon.className = 'far fa-user-circle';
                    const textSpan = this.querySelector('span');
                    if (textSpan) textSpan.textContent = 'Follow';
                    this.setAttribute('title', 'Follow Author');
                    showToast('You unfollowed this author!');
                }
                
                // Update follower count display
                if (data.followerCount !== undefined) {
                    const followerCountElement = document.querySelector('.author-followers');
                    if (followerCountElement) {
                        followerCountElement.innerHTML = `<i class="fas fa-user-friends"></i> ${data.followerCount} Followers`;
                    }
                }
                
                // Refresh tooltip
                if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                    const tooltip = bootstrap.Tooltip.getInstance(this);
                    if (tooltip) {
                        tooltip.dispose();
                    }
                    new bootstrap.Tooltip(this);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast(error.message || 'Something went wrong', 'error');
            });
        });
    });
}

/**
 * Initialize comments functionality
 */
function initializeComments() {
    // Submit main comment
    const submitButton = document.getElementById('submitComment');
    if (submitButton) {
        submitButton.addEventListener('click', function() {
            if (!isLoggedIn()) return;
            
            const articleId = this.getAttribute('data-article-id');
            if (!articleId) {
                console.error('No article ID found on submit comment button');
                return;
            }
            
            const commentTextarea = document.getElementById('commentTextarea');
            if (!commentTextarea) {
                console.error('Comment textarea not found');
                return;
            }
            
            const content = commentTextarea.value.trim();
            
            if (!content) {
                showToast('Please write a comment first', 'warning');
                return;
            }
            
            submitComment(articleId, content);
        });
    }
    
    // Reply button click handlers
    document.addEventListener('click', function(e) {
        // Reply button handler
        if (e.target.classList.contains('comment-reply-btn') || e.target.closest('.comment-reply-btn')) {
            e.preventDefault();
            const target = e.target.classList.contains('comment-reply-btn') ? e.target : e.target.closest('.comment-reply-btn');
            const commentId = target.getAttribute('data-comment-id');
            
            if (!commentId) {
                console.error('No comment ID found on reply button');
                return;
            }
            
            // Show reply form
            const replyForm = document.getElementById('reply-form-' + commentId);
            if (replyForm) {
                replyForm.style.display = 'block';
            }
        }
        
        // Cancel reply handler
        if (e.target.classList.contains('cancel-reply') || e.target.closest('.cancel-reply')) {
            e.preventDefault();
            const target = e.target.classList.contains('cancel-reply') ? e.target : e.target.closest('.cancel-reply');
            const commentId = target.getAttribute('data-comment-id');
            
            if (!commentId) {
                console.error('No comment ID found on cancel reply button');
                return;
            }
            
            // Hide reply form
            const replyForm = document.getElementById('reply-form-' + commentId);
            if (replyForm) {
                replyForm.style.display = 'none';
                const textarea = replyForm.querySelector('textarea');
                if (textarea) textarea.value = '';
            }
        }
        
        // Submit reply handler
        if (e.target.classList.contains('submit-reply') || e.target.closest('.submit-reply')) {
            e.preventDefault();
            const target = e.target.classList.contains('submit-reply') ? e.target : e.target.closest('.submit-reply');
            const commentId = target.getAttribute('data-comment-id');
            const articleId = target.getAttribute('data-article-id');
            
            if (!commentId || !articleId) {
                console.error('Missing comment or article ID on submit reply button');
                return;
            }
            
            const replyForm = document.getElementById('reply-form-' + commentId);
            if (replyForm) {
                const textarea = replyForm.querySelector('textarea');
                if (!textarea) {
                    console.error('Reply textarea not found');
                    return;
                }
                
                const content = textarea.value.trim();
                
                if (!content) {
                    showToast('Please write a reply first', 'warning');
                    return;
                }
                
                submitComment(articleId, content, commentId);
            }
        }
    });
}

/**
 * Submit a comment or reply
 */
function submitComment(articleId, content, parentId = null) {
    if (!isLoggedIn()) return;
    
    const csrfToken = getCsrfToken();
    const headers = {
        'Content-Type': 'application/json'
    };
    
    // Only add CSRF token if available
    if (csrfToken) {
        headers['X-CSRF-TOKEN'] = csrfToken;
    }
    
    const data = {
        article_id: articleId,
        content: content
    };
    
    if (parentId) {
        data.parent_id = parentId;
    }
    
    fetch('/articles/comment', {
        method: 'POST',
        headers: headers,
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            if (response.status === 419) {
                throw new Error('CSRF token mismatch. Please refresh the page.');
            }
            throw new Error('Server returned ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Clear text area
            if (parentId) {
                const replyForm = document.getElementById('reply-form-' + parentId);
                const textarea = replyForm.querySelector('textarea');
                if (textarea) textarea.value = '';
                replyForm.style.display = 'none';
                
                // Add reply to DOM
                const repliesContainer = document.getElementById('replies-' + parentId);
                if (repliesContainer) {
                    repliesContainer.insertAdjacentHTML('beforeend', data.html);
                }
            } else {
                // Clear main comment textarea
                const commentTextarea = document.getElementById('commentTextarea');
                if (commentTextarea) commentTextarea.value = '';
                
                // Add comment to DOM
                const commentList = document.getElementById('commentList');
                if (commentList) {
                    // Remove 'no comments' message if exists
                    const noCommentsMsg = document.getElementById('noCommentsMessage');
                    if (noCommentsMsg) {
                        noCommentsMsg.remove();
                    }
                    
                    commentList.insertAdjacentHTML('afterbegin', data.html);
                }
            }
            
            // Update comment count
            updateCommentCount(1);
            
            showToast(parentId ? 'Reply submitted successfully!' : 'Comment submitted successfully!');
        } else {
            showToast('Failed to submit comment', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast(error.message || 'Something went wrong', 'error');
    });
}

/**
 * Update comment count display
 */
function updateCommentCount(increment) {
    // Update count in heading
    const commentHeading = document.querySelector('.comments-section h3');
    if (commentHeading) {
        const match = commentHeading.textContent.match(/Comments\s*\((\d+)\)/);
        if (match) {
            const currentCount = parseInt(match[1]) + increment;
            commentHeading.textContent = `Comments (${currentCount})`;
        }
    }
    
    // Update count in sidebar
    const commentCounter = document.querySelector('.article-tool-item [title="Comment"] .tool-count');
    if (commentCounter) {
        commentCounter.textContent = parseInt(commentCounter.textContent) + increment;
    }
}

/**
 * Initialize article tools and interactive elements
 */
function initializeArticleTools() {
    console.log('Initializing article tools');
    
    // Initialize dark mode toggle
    const darkModeToggle = document.getElementById('darkModeToggle');
    if (darkModeToggle) {
        // Check local storage for preference
        const darkMode = localStorage.getItem('darkMode') === 'enabled';
        if (darkMode) {
            document.body.classList.add('dark-mode');
            const icon = darkModeToggle.querySelector('i');
            if (icon) icon.className = 'fas fa-sun';
        }
        
        // Toggle dark mode
        darkModeToggle.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            
            // Update icon
            const isDarkMode = document.body.classList.contains('dark-mode');
            const icon = darkModeToggle.querySelector('i');
            if (icon) icon.className = isDarkMode ? 'fas fa-sun' : 'fas fa-moon';
            
            // Save preference
            localStorage.setItem('darkMode', isDarkMode ? 'enabled' : 'disabled');
        });
    }
    
    // Initialize PDF download
    const downloadPdf = document.getElementById('downloadPdf');
    if (downloadPdf) {
        downloadPdf.addEventListener('click', function() {
            // Get current article slug from URL
            const path = window.location.pathname;
            const slug = path.substring(path.lastIndexOf('/') + 1);
            
            if (slug) {
                window.location.href = '/articles/' + slug + '/pdf';
            } else {
                showToast('Cannot generate PDF, article slug not found', 'error');
            }
        });
    }
    
    // Add estimated reading time
    addReadingTime();
}

/**
 * Add estimated reading time to article
 */
function addReadingTime() {
    const article = document.querySelector('.article-content');
    if (!article) return;
    
    // Skip if reading time element already exists
    if (article.querySelector('.article-reading-time')) return;
    
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
    if (title) {
        if (title.nextSibling) {
            article.insertBefore(readingTime, title.nextSibling);
        } else {
            article.appendChild(readingTime);
        }
    } else {
        article.insertBefore(readingTime, article.firstChild);
    }
}

/**
 * Fixed check if user is logged in function
 */
function isLoggedIn() {
    // Use the globally set flag if available
    if (window.userIsAuthenticated === true) {
        return true;
    }
    
    // Fallback detection methods
    
    // Method 1: Look for User ID paragraph
    const paragraphs = document.querySelectorAll('p');
    for (let i = 0; i < paragraphs.length; i++) {
        if (paragraphs[i].textContent && paragraphs[i].textContent.includes('User ID:')) {
            window.userIsAuthenticated = true;
            return true;
        }
    }
    
    // Method 2: Check if comment form is visible (typically only shown to logged-in users)
    const commentForm = document.querySelector('.comment-form');
    if (commentForm && window.getComputedStyle(commentForm).display !== 'none') {
        window.userIsAuthenticated = true;
        return true;
    }
    
    // User is not logged in
    showToast('Please log in to interact with this article', 'warning');
    return false;
}

/**
 * Show toast notification
 */
function showToast(message, type = 'success') {
    console.log('Toast:', message, type);
    
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
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'}"></i>
        </div>
        <div class="toast-content">${message}</div>
        <button class="toast-close">×</button>
    `;
    
    // Close button
    const closeButton = toast.querySelector('.toast-close');
    if (closeButton) {
        closeButton.addEventListener('click', () => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        });
    }
    
    // Add to container
    toastContainer.appendChild(toast);
    
    // Show toast
    setTimeout(() => toast.classList.add('show'), 10);
    
    // Auto hide after 3 seconds
    setTimeout(() => {
        if (toast.parentNode) {
            toast.classList.remove('show');
            setTimeout(() => {
                if (toast.parentNode) toast.remove();
            }, 300);
        }
    }, 3000);
}