document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize Quill Editor
    var quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ header: [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['blockquote', 'code-block'],
                [{ align: [] }],
                ['link', 'image'],
                ['clean']
            ]
        },
        placeholder: 'Write your blog content here...'
    });

    // Load existing content
    var contentField = document.getElementById('content');
    if (contentField.value) {
        quill.root.innerHTML = contentField.value;
    }

    // Update hidden input on text change
    quill.on('text-change', function() {
        contentField.value = quill.root.innerHTML;
        updateWordCount();
        updateSEOPreview();
    });

    // Character counter for Title
    var titleInput = document.getElementById('title');
    titleInput.addEventListener('input', function() {
        document.getElementById('title-char').textContent = this.value.length;
        updateSEOPreview();
    });

    // Character counter for Excerpt
    var excerptInput = document.getElementById('excerpt');
    excerptInput.addEventListener('input', function() {
        document.getElementById('excerpt-char').textContent = this.value.length;
    });

    // Character counter for Meta Title
    var metaTitleInput = document.getElementById('meta_title');
    metaTitleInput.addEventListener('input', function() {
        document.getElementById('meta-char').textContent = this.value.length;
        updateSEOPreview();
    });

    // Character counter for Meta Description
    var metaDescInput = document.getElementById('meta_description');
    metaDescInput.addEventListener('input', function() {
        document.getElementById('desc-char').textContent = this.value.length;
        updateSEOPreview();
    });

    // Featured image preview
    var featuredImageInput = document.getElementById('featured_image');
    featuredImageInput.addEventListener('change', function(e) {
        var file = e.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-image').src = e.target.result;
                document.getElementById('preview-container').classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    });

    // Status change handler - Show/hide publish date
    var statusSelect = document.getElementById('status');
    statusSelect.addEventListener('change', function() {
        var dateGroup = document.getElementById('publish-date-group');
        if (this.value === 'scheduled') {
            dateGroup.classList.remove('d-none');
        } else {
            dateGroup.classList.add('d-none');
        }
    });

    // Generate Schema
    var generateSchemaBtn = document.getElementById('generate-schema');
    generateSchemaBtn.addEventListener('click', function() {
        var title = document.getElementById('title').value;
        var content = document.getElementById('content').value;
        
        if (!title || !content) {
            alert('Please fill in title and content first');
            return;
        }

        var baseUrl = window.location.origin;
        var slug = document.getElementById('slug').value || title.toLowerCase().replace(/[^a-z0-9]+/g, '-');
        
        var schema = {};
        schema['@context'] = 'https://schema.org';
        schema['@type'] = 'BlogPosting';
        schema['headline'] = title;
        schema['description'] = document.getElementById('meta_description').value || document.getElementById('excerpt').value;
        schema['datePublished'] = new Date().toISOString();
        schema['url'] = baseUrl + '/blog/' + slug;

        document.getElementById('schema_markup').value = JSON.stringify(schema, null, 2);
        
        // Show success feedback
        var original = this.innerHTML;
        this.innerHTML = '<i class="bx bx-check me-1"></i>Generated!';
        this.classList.add('btn-success');
        this.classList.remove('btn-outline-secondary');
        
        var btn = this;
        setTimeout(function() {
            btn.innerHTML = original;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-secondary');
        }, 2000);
    });

    // Update word count and reading time
    function updateWordCount() {
        var text = quill.getText();
        var words = text.trim().split(/\s+/).filter(function(w) { return w.length > 0; }).length;
        var readTime = Math.ceil(words / 200);
        
        document.getElementById('word-count').textContent = words;
        document.getElementById('read-time').textContent = readTime;
    }

    // Update SEO Preview
    function updateSEOPreview() {
        var title = document.getElementById('title').value || 'Your Blog Title';
        var desc = document.getElementById('meta_description').value || 'Your meta description...';
        var slug = document.getElementById('slug').value || 'your-slug';
        
        document.getElementById('preview-title').textContent = title;
        document.getElementById('preview-desc').textContent = desc;
        document.getElementById('preview-url').textContent = 'example.com/blog/' + slug;
    }

});