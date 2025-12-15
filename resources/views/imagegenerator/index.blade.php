<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Featured Image Generator</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 20px;
            background: #f1f5f9;
            color: #334155;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .controls {
            background: #f8fafc;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #1e293b;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        input[type="text"]:focus, textarea:focus {
            outline: none;
            border-color: #3b82f6;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .template-selector {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .template-option {
            padding: 15px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            cursor: pointer;
            text-align: center;
            transition: all 0.3s ease;
        }

        .template-option:hover {
            border-color: #3b82f6;
        }

        .template-option.active {
            border-color: #3b82f6;
            background: #eff6ff;
        }

        .download-btn {
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .download-btn:hover {
            transform: translateY(-2px);
        }

        /* Featured Image Canvas */
        .featured-image {
            width: 1200px;
            height: 630px;
            position: relative;
            margin: 20px auto;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        /* Dark Professional Template */
        .template-dark {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            color: white;
            position: relative;
        }

        .template-dark::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(139, 92, 246, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(6, 182, 212, 0.05) 0%, transparent 50%);
        }

        .template-dark .content {
            position: relative;
            z-index: 2;
            padding: 60px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            max-width: 1000px;
        }

        .template-dark .main-title {
            font-size: 48px;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #ffffff, #e2e8f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-align: center;
            color: #ffffff;
        }

        .template-dark .subtitle {
            font-size: 20px;
            color: #94a3b8;
            font-weight: 400;
            margin-bottom: 40px;
            text-align: center;
        }

        .template-dark .brand-footer {
            position: absolute;
            bottom: 40px;
            left: 60px;
            right: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .template-dark .company-section {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .template-dark .logo {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 20px;
            color: white;
        }

        .template-dark .company-info h3 {
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 4px 0;
            color: white;
        }

        .template-dark .company-info p {
            font-size: 14px;
            margin: 0;
            color: #64748b;
        }

        .template-dark .social-links {
            display: flex;
            gap: 16px;
            text-align: center;
            font-size: 11px;
            color: #94a3b8;
            line-height: 1.3;
            justify-content: center;
            align-items: center;
            flex-wrap: nowrap;
        }

        .template-dark .social-id {
            font-weight: 500;
            color: #e2e8f0;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .template-dark .social-id i {
            font-size: 14px;
            color: #60a5fa;
            width: 16px;
            text-align: center;
        }

        .template-dark .author-section {
            text-align: right;
        }

        .template-dark .author-name {
            font-size: 18px;
            font-weight: 600;
            color: white;
            margin: 0 0 4px 0;
        }

        .template-dark .author-title {
            font-size: 14px;
            color: #94a3b8;
            margin: 0;
        }

        /* Light Clean Template */
        .template-light {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            color: #1e293b;
            position: relative;
        }

        .template-light::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6, #06b6d4);
        }

        .template-light .content {
            padding: 60px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            max-width: 1000px;
        }

        .template-light .main-title {
            font-size: 48px;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 20px;
            color: #0f172a;
            text-align: center;
        }

        .template-light .subtitle {
            font-size: 20px;
            color: #64748b;
            font-weight: 400;
            margin-bottom: 40px;
            text-align: center;
        }

        .template-light .brand-footer {
            position: absolute;
            bottom: 40px;
            left: 60px;
            right: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .template-light .company-section {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .template-light .logo {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 20px;
            color: white;
        }

        .template-light .company-info h3 {
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 4px 0;
            color: #1e293b;
        }

        .template-light .company-info p {
            font-size: 14px;
            margin: 0;
            color: #64748b;
        }

        .template-light .social-links {
            display: flex;
            gap: 16px;
            text-align: center;
            font-size: 11px;
            color: #64748b;
            line-height: 1.3;
            justify-content: center;
            align-items: center;
            flex-wrap: nowrap;
        }

        .template-light .social-id {
            font-weight: 500;
            color: #1e293b;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .template-light .social-id i {
            font-size: 14px;
            color: #3b82f6;
            width: 16px;
            text-align: center;
        }

        .template-light .author-section {
            text-align: right;
        }

        .template-light .author-name {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin: 0 0 4px 0;
        }

        .template-light .author-title {
            font-size: 14px;
            color: #64748b;
            margin: 0;
        }

        /* Responsive adjustments */
        @media (max-width: 1250px) {
            .featured-image {
                width: 100%;
                height: auto;
                aspect-ratio: 1200/630;
            }
        }

        @media (max-width: 768px) {
            .template-dark .main-title,
            .template-light .main-title {
                font-size: 36px;
            }
            
            .template-dark .content,
            .template-light .content {
                padding: 40px;
            }
            
            .template-dark .brand-footer,
            .template-light .brand-footer {
                bottom: 30px;
                left: 40px;
                right: 40px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 style="text-align: center; margin-bottom: 30px; color: #1e293b;">Blog Featured Image Generator</h1>
        <div class="controls">
            <div class="form-group">
                <label for="blogTitle">Blog Post Title:</label>
                <textarea id="blogTitle" placeholder="Enter your blog post title here...">Laravel Accessors: A Powerful Feature for Custom Attribute Handling</textarea>
            </div>
            
            <div class="form-group">
                <label for="subtitle">Subtitle (Optional):</label>
                <input type="text" id="subtitle" placeholder="Brief description or category" value="Complete Guide to Modern Web Development">
            </div>
            
            <div class="form-group">
                <label>Template Style:</label>
                <div class="template-selector">
                    <div class="template-option active" data-template="dark">
                        <strong>Dark Professional</strong><br>
                        <small>Modern & Sleek Design</small>
                    </div>
                    <div class="template-option" data-template="light">
                        <strong>Light Clean</strong><br>
                        <small>Minimal & Professional</small>
                    </div>
                </div>
            </div>
            
            <button class="download-btn" onclick="downloadImage()">
                <i class="fas fa-download"></i> Download Featured Image (1200x630)
            </button>
        </div>

        <!-- Dark Professional Template -->
        <div class="featured-image template-dark" id="template-dark">
            <div class="content">
                <h1 class="main-title" id="title-dark">Laravel Accessors: A Powerful Feature for Custom Attribute Handling</h1>
                <p class="subtitle" id="subtitle-dark">Complete Guide to Modern Web Development</p>
            </div>
            <div class="brand-footer">
                <div class="company-section">
                    <div class="logo">IT</div>
                    <div class="company-info">
                        <h3>INVIDIATECH</h3>
                        <p>Full Stack Web Development Studio</p>
                    </div>
                </div>
                <div class="social-links">
                    <div class="social-row">
                        <div class="social-id">
                            <i class="fab fa-linkedin-in"></i>
                            linkedin.com/in/muhammad-nawaz-43a354201
                        </div>
                        <div class="social-id">
                            <i class="fab fa-github"></i>
                            github.com/nawazfdev
                        </div>
                    </div>
                    <div class="social-id">
                        <i class="fab fa-facebook-f"></i>
                        facebook.com/Muhammad.Nawaz.Dev
                    </div>
                </div>
                <div class="author-section">
                    <h4 class="author-name">Muhammad Nawaz</h4>
                    <p class="author-title">Full Stack Developer</p>
                </div>
            </div>
        </div>

        <!-- Light Clean Template -->
        <div class="featured-image template-light" id="template-light" style="display: none;">
            <div class="content">
                <h1 class="main-title" id="title-light">Laravel Accessors: A Powerful Feature for Custom Attribute Handling</h1>
                <p class="subtitle" id="subtitle-light">Complete Guide to Modern Web Development</p>
            </div>
            <div class="brand-footer">
                <div class="company-section">
                    <div class="logo">IT</div>
                    <div class="company-info">
                        <h3>INVIDIATECH</h3>
                        <p>Full Stack Web Development Studio</p>
                    </div>
                </div>
                <div class="social-links">
                    <div class="social-row">
                        <div class="social-id">
                            <i class="fab fa-linkedin-in"></i>
                            linkedin.com/in/muhammad-nawaz-43a354201
                        </div>
                        <div class="social-id">
                            <i class="fab fa-github"></i>
                            github.com/nawazfdev
                        </div>
                    </div>
                    <div class="social-id">
                        <i class="fab fa-facebook-f"></i>
                        facebook.com/Muhammad.Nawaz.Dev
                    </div>
                </div>
                <div class="author-section">
                    <h4 class="author-name">Muhammad Nawaz</h4>
                    <p class="author-title">Full Stack Developer</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        let currentTemplate = 'dark';

        // Update content when typing
        document.getElementById('blogTitle').addEventListener('input', function() {
            const title = this.value || 'Your Blog Post Title Here';
            document.getElementById('title-dark').textContent = title;
            document.getElementById('title-light').textContent = title;
        });

        document.getElementById('subtitle').addEventListener('input', function() {
            const subtitle = this.value || 'Brief description or category';
            document.getElementById('subtitle-dark').textContent = subtitle;
            document.getElementById('subtitle-light').textContent = subtitle;
        });

        // Template selection
        document.querySelectorAll('.template-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.template-option').forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                
                const templateName = this.dataset.template;
                currentTemplate = templateName;
                
                document.querySelectorAll('.featured-image').forEach(img => img.style.display = 'none');
                document.getElementById(`template-${templateName}`).style.display = 'flex';
            });
        });

        // Download function
        async function downloadImage() {
            const element = document.getElementById(`template-${currentTemplate}`);
            
            // Show loading state
            const btn = document.querySelector('.download-btn');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating...';
            btn.disabled = true;
            
            try {
                const canvas = await html2canvas(element, {
                    width: 1200,
                    height: 630,
                    scale: 2,
                    backgroundColor: null,
                    logging: false,
                    useCORS: true,
                    allowTaint: true
                });

                const link = document.createElement('a');
                const timestamp = new Date().toISOString().slice(0, 19).replace(/:/g, '-');
                link.download = `blog-featured-image-${timestamp}.png`;
                link.href = canvas.toDataURL('image/png', 1.0);
                link.click();
                
            } catch (error) {
                console.error('Error generating image:', error);
                alert('Error generating image. Please try again.');
            } finally {
                // Reset button
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        }
    </script>
</body>
</html>