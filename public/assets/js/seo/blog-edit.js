/**
 * Blog Edit Page JavaScript
 * Handles Quill editor, tags, SEO analysis, and form interactions
 */

document.addEventListener('DOMContentLoaded', function () {
    // Get blog data from data attributes
    const blogForm = document.getElementById('blog-form');
    const blogData = {
        existingTags: blogForm?.dataset.existingTags || '',
        baseUrl: blogForm?.dataset.baseUrl || window.location.origin,
        publishDate: blogForm?.dataset.publishDate || new Date().toISOString(),
        authorName: blogForm?.dataset.authorName || 'Admin',
        appName: blogForm?.dataset.appName || 'InvidiaTech',
        blogSlug: blogForm?.dataset.blogSlug || '',
        featuredImage: blogForm?.dataset.featuredImage || ''
    };

    // Initialize Quill Editor
    if (document.getElementById('editor-container')) {
        const quill = new Quill('#editor-container', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    [{ 'font': [] }],
                    ['bold', 'italic', 'underline', 'strike', 'blockquote'],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    [{ 'align': [] }],
                    [{ 'script': 'sub' }, { 'script': 'super' }],
                    [{ 'indent': '-1' }, { 'indent': '+1' }],
                    [{ 'direction': 'rtl' }],
                    [{ 'color': [] }, { 'background': [] }],
                    ['link', 'image', 'video', 'formula']
                ]
            },
            placeholder: 'Write your content here...',
            bounds: '#editor-container'
        });

        // Set initial content
        const contentInput = document.getElementById('content');
        if (contentInput && contentInput.value) {
            quill.root.innerHTML = contentInput.value;
        }

        // Update hidden input on text change
        quill.on('text-change', function () {
            if (contentInput) {
                contentInput.value = quill.root.innerHTML;
            }
            
            // Update word count and reading time
            const text = quill.getText().trim();
            const wordCount = text ? text.split(/\s+/).length : 0;
            const wordCountEl = document.getElementById('word-count');
            const readingTimeEl = document.getElementById('reading-time');
            
            if (wordCountEl) wordCountEl.textContent = wordCount;
            if (readingTimeEl) readingTimeEl.textContent = Math.ceil(wordCount / 200);
            
            // Trigger SEO analysis
            performSeoAnalysis(quill);
        });

        // Trigger initial word count
        quill.emitter.emit('text-change');

        // Store quill instance globally for SEO analysis
        window.quillEditor = quill;
    }

    // Tags Management
    let selectedTags = [];

    // Load existing tags
    if (blogData.existingTags) {
        selectedTags = blogData.existingTags.split(',').map(tag => tag.trim()).filter(tag => tag.length > 0);
    }

    function updateTagsDisplay() {
        const container = document.getElementById('selected-tags');
        const input = document.getElementById('tags-input');
        
        if (!container || !input) return;
        
        container.innerHTML = '';
        selectedTags.forEach((tag, index) => {
            const tagElement = document.createElement('span');
            tagElement.className = 'badge bg-primary d-flex align-items-center gap-1';
            tagElement.innerHTML = `
                ${tag}
                <button type="button" class="btn-close btn-close-white" style="font-size: 0.7em;" data-index="${index}"></button>
            `;
            tagElement.querySelector('button').addEventListener('click', function() {
                removeTag(parseInt(this.dataset.index));
            });
            container.appendChild(tagElement);
        });
        
        input.value = selectedTags.join(',');
    }

    function addTag(tagName) {
        const trimmedTag = tagName.trim();
        if (trimmedTag && !selectedTags.includes(trimmedTag)) {
            selectedTags.push(trimmedTag);
            updateTagsDisplay();
        }
    }

    function removeTag(index) {
        selectedTags.splice(index, 1);
        updateTagsDisplay();
    }

    // Make removeTag globally accessible
    window.removeTag = removeTag;

    // Manual tag input
    const tagsManualInput = document.getElementById('tags-manual');
    if (tagsManualInput) {
        tagsManualInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const tags = this.value.split(',');
                tags.forEach(tag => addTag(tag));
                this.value = '';
            }
        });
    }

    // Suggested tags click
    document.querySelectorAll('.tag-suggestion').forEach(badge => {
        badge.addEventListener('click', function() {
            addTag(this.dataset.tag);
            this.style.opacity = '0.5';
            this.style.pointerEvents = 'none';
        });
    });

    // Character counters
    function setupCharCounter(inputSelector, counterSelector, max) {
        const inputElement = document.querySelector(inputSelector);
        const counterElement = document.querySelector(counterSelector);
        
        if (inputElement && counterElement) {
            inputElement.addEventListener('input', function() {
                const length = this.value.length;
                counterElement.textContent = length;

                counterElement.className = '';
                if (length > max) {
                    counterElement.classList.add('text-danger');
                } else if (length > max * 0.8) {
                    counterElement.classList.add('text-warning');
                } else {
                    counterElement.classList.add('text-success');
                }
            });
        }
    }

    setupCharCounter('#title', '#title-count', 60);
    setupCharCounter('#meta_title', '#meta-title-count', 60);
    setupCharCounter('#meta_description', '#meta-desc-count', 160);
    setupCharCounter('#excerpt', '#excerpt-count', 500);

    // Auto-update SEO preview
    ['#title', '#meta_title', '#meta_description', '#slug', '#focus_keyword'].forEach(selector => {
        const element = document.querySelector(selector);
        if (element) {
            element.addEventListener('input', updateSeoPreview);
        }
    });

    function updateSeoPreview() {
        const title = document.getElementById('meta_title')?.value || document.getElementById('title')?.value || 'Your Blog Title';
        const description = document.getElementById('meta_description')?.value || document.getElementById('excerpt')?.value || 'Your meta description will appear here...';
        const slug = document.getElementById('slug')?.value || 'your-blog-title';

        const previewTitle = document.getElementById('preview-title');
        const previewDescription = document.getElementById('preview-description');
        const previewUrl = document.getElementById('preview-url');

        if (previewTitle) previewTitle.textContent = title;
        if (previewDescription) previewDescription.textContent = description;
        if (previewUrl) previewUrl.textContent = `${blogData.baseUrl}/${slug}`;

        // Trigger SEO analysis
        if (window.quillEditor) {
            performSeoAnalysis(window.quillEditor);
        }
    }

    // Featured image preview
    const featuredImageInput = document.getElementById('featured_image');
    if (featuredImageInput) {
        featuredImageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('featured-preview');
                    const img = document.getElementById('featured-img');
                    if (img) img.src = e.target.result;
                    if (preview) preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Status change handler
    const statusSelect = document.getElementById('status');
    if (statusSelect) {
        statusSelect.addEventListener('change', function() {
            const publishDateGroup = document.getElementById('publish-date-group');
            const publishedAtInput = document.getElementById('published_at');
            
            if (this.value === 'scheduled') {
                if (publishDateGroup) publishDateGroup.style.display = 'block';
                if (publishedAtInput) publishedAtInput.required = true;
            } else {
                if (publishDateGroup) publishDateGroup.style.display = 'none';
                if (publishedAtInput) publishedAtInput.required = false;
            }
        });
    }

    // Add new category
    const addCategoryBtn = document.getElementById('add-category');
    if (addCategoryBtn) {
        addCategoryBtn.addEventListener('click', function() {
            const categoryName = document.getElementById('new-category-name')?.value.trim();
            const categorySelect = document.getElementById('category');
            
            if (categoryName && categorySelect) {
                const option = document.createElement('option');
                option.value = categoryName;
                option.textContent = categoryName;
                option.selected = true;
                categorySelect.appendChild(option);
                
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('newCategoryModal'));
                if (modal) modal.hide();
                
                // Clear form
                const nameInput = document.getElementById('new-category-name');
                const descInput = document.getElementById('new-category-description');
                if (nameInput) nameInput.value = '';
                if (descInput) descInput.value = '';
            }
        });
    }

    // Auto-generate schema markup
    const generateSchemaBtn = document.getElementById('generate-schema');
    if (generateSchemaBtn) {
        generateSchemaBtn.addEventListener('click', function() {
            const title = document.getElementById('title')?.value || '';
            const content = document.getElementById('content')?.value || '';
            const excerpt = document.getElementById('excerpt')?.value || '';
            const metaDescription = document.getElementById('meta_description')?.value || '';
            const slug = document.getElementById('slug')?.value || '';
            const categorySelect = document.getElementById('category');
            const focusKeyword = document.getElementById('focus_keyword')?.value || '';

            if (!title || !content) {
                alert('Please fill in title and content first');
                return;
            }

            const articleUrl = `${blogData.baseUrl}/blog/${slug}`;
            const categoryName = categorySelect?.options[categorySelect.selectedIndex]?.text || 'Technology';
            const wordCount = content.replace(/<[^>]*>/g, '').split(/\s+/).length;
            const readingTime = Math.ceil(wordCount / 200);

            const schema = {
                "@context": "https://schema.org",
                "@type": "BlogPosting",
                "headline": title,
                "description": metaDescription || excerpt || content.replace(/<[^>]*>/g, '').substring(0, 160),
                "author": {
                    "@type": "Person",
                    "name": blogData.authorName
                },
                "publisher": {
                    "@type": "Organization",
                    "name": blogData.appName,
                    "logo": {
                        "@type": "ImageObject",
                        "url": `${blogData.baseUrl}/frontend/images/logo/invidiatech-software-engineer.png`
                    }
                },
                "datePublished": blogData.publishDate,
                "dateModified": new Date().toISOString(),
                "mainEntityOfPage": {
                    "@type": "WebPage",
                    "@id": articleUrl
                },
                "articleSection": categoryName,
                "wordCount": wordCount,
                "timeRequired": `PT${readingTime}M`,
                "inLanguage": "en-US",
                "url": articleUrl,
                "keywords": focusKeyword || title,
                "articleBody": content.replace(/<[^>]*>/g, '').substring(0, 500) + "..."
            };

            // Add featured image if available
            if (blogData.featuredImage) {
                schema.image = blogData.featuredImage;
            }

            const schemaMarkup = document.getElementById('schema_markup');
            if (schemaMarkup) {
                schemaMarkup.value = JSON.stringify(schema, null, 2);
            }

            // Show success feedback
            const button = this;
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="bx bx-check me-1"></i>Schema Generated!';
            button.classList.remove('btn-outline-secondary');
            button.classList.add('btn-success');

            setTimeout(() => {
                button.innerHTML = originalText;
                button.classList.remove('btn-success');
                button.classList.add('btn-outline-secondary');
            }, 2000);
        });
    }

    // Validate schema markup
    const validateSchemaBtn = document.getElementById('validate-schema');
    if (validateSchemaBtn) {
        validateSchemaBtn.addEventListener('click', function() {
            const schema = document.getElementById('schema_markup')?.value;
            if (!schema || !schema.trim()) {
                alert('Please enter schema markup to validate');
                return;
            }

            try {
                JSON.parse(schema);
                alert('Schema markup is valid JSON');
            } catch (e) {
                alert('Invalid JSON in schema markup: ' + e.message);
            }
        });
    }

    // SEO Analysis
    function performSeoAnalysis(quill) {
        const title = document.getElementById('title')?.value || '';
        const content = quill ? quill.getText() : '';
        const metaDesc = document.getElementById('meta_description')?.value || '';
        const focusKeyword = document.getElementById('focus_keyword')?.value || '';

        let score = 0;
        let recommendations = [];

        // Title check (20 points)
        if (title.length >= 30 && title.length <= 60) {
            score += 20;
        } else if (title.length > 0) {
            score += 10;
            recommendations.push(`Title should be 30-60 characters (currently ${title.length})`);
        } else {
            recommendations.push('Add a title for your blog post');
        }

        // Meta description check (20 points)
        if (metaDesc.length >= 120 && metaDesc.length <= 160) {
            score += 20;
        } else if (metaDesc.length > 0) {
            score += 10;
            recommendations.push(`Meta description should be 120-160 characters (currently ${metaDesc.length})`);
        } else {
            recommendations.push('Add a meta description');
        }

        // Content length check (20 points)
        const text = content.trim();
        const wordCount = text.split(/\s+/).filter(word => word.length > 0).length;
        if (wordCount >= 300) {
            score += 20;
        } else if (wordCount > 0) {
            score += Math.round((wordCount / 300) * 20);
            recommendations.push(`Content should be at least 300 words (currently ${wordCount})`);
        } else {
            recommendations.push('Add content to your blog post');
        }

        // Focus keyword checks (40 points total)
        if (focusKeyword) {
            score += 10;

            if (title.toLowerCase().includes(focusKeyword.toLowerCase())) {
                score += 10;
            } else {
                recommendations.push('Include focus keyword in title');
            }

            if (metaDesc.toLowerCase().includes(focusKeyword.toLowerCase())) {
                score += 10;
            } else {
                recommendations.push('Include focus keyword in meta description');
            }

            if (text.toLowerCase().includes(focusKeyword.toLowerCase())) {
                score += 10;
            } else {
                recommendations.push('Include focus keyword in content');
            }
        } else {
            recommendations.push('Add a focus keyword');
        }

        // Update score badge
        let badgeClass = 'bg-danger';
        if (score >= 80) badgeClass = 'bg-success';
        else if (score >= 60) badgeClass = 'bg-warning';

        const scoreElement = document.getElementById('seo-score');
        if (scoreElement) {
            scoreElement.className = scoreElement.className.replace(/bg-\w+/g, '') + ' ' + badgeClass;
            scoreElement.textContent = `Score: ${score}%`;
        }

        // Show recommendations
        const recommendationsContainer = document.getElementById('seo-recommendations');
        if (recommendationsContainer) {
            if (recommendations.length > 0) {
                let html = '<div class="alert alert-info"><strong>SEO Recommendations:</strong><ul class="mb-0 mt-2">';
                recommendations.forEach(rec => {
                    html += `<li>${rec}</li>`;
                });
                html += '</ul></div>';
                recommendationsContainer.innerHTML = html;
            } else {
                recommendationsContainer.innerHTML = '<div class="alert alert-success">Great! Your blog post follows SEO best practices.</div>';
            }
        }
    }

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Form submission with loading state
    if (blogForm) {
        blogForm.addEventListener('submit', function() {
            const submitBtn = document.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i>Updating...';
                submitBtn.disabled = true;
            }
        });
    }

    // Initial setup
    updateTagsDisplay();
    updateSeoPreview();
});
