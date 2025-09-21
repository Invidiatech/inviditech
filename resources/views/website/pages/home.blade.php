@extends('website.layouts.app')
@section('title', 'InvidiaTech - Technology Knowledge & Learning Platform')

@section('content')
@include('website.partials.hero')

<!-- Knowledge Areas Section -->
<section class="py-5 my-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto animate">
                <span class="badge bg-primary-gradient text-white px-3 py-2 rounded-pill mb-3">
                    <i class="fas fa-brain me-2"></i>Knowledge Sharing Platform
                </span>
                <h2 class="fw-bold text-primary-custom mb-4">Technology Expertise & Insights</h2>
                <p class="lead text-muted">Sharing in-depth knowledge and practical insights across modern web development technologies and best practices</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6 animate animate-delay-1">
                <div class="feature-card h-100 p-4 text-center">
                    <div class="feature-icon-wrapper mb-4">
                        <div class="feature-icon bg-primary-gradient text-white">
                            <i class="fab fa-laravel fa-2x"></i>
                        </div>
                        <div class="feature-icon-bg"></div>
                    </div>
                    <h4 class="mb-3 text-primary-custom">Laravel Mastery</h4>
                    <p class="text-muted mb-4">Deep dive into Laravel ecosystem, advanced patterns, performance optimization, and enterprise-level architecture design principles.</p>
                    <div class="feature-technologies mb-3">
                        <span class="tech-badge">PHP 8+</span>
                        <span class="tech-badge">Laravel 10</span>
                        <span class="tech-badge">Eloquent ORM</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 animate animate-delay-2">
                <div class="feature-card h-100 p-4 text-center">
                    <div class="feature-icon-wrapper mb-4">
                        <div class="feature-icon bg-secondary-gradient text-white">
                            <i class="fas fa-layer-group fa-2x"></i>
                        </div>
                        <div class="feature-icon-bg"></div>
                    </div>
                    <h4 class="mb-3 text-primary-custom">Full Stack Architecture</h4>
                    <p class="text-muted mb-4">Comprehensive guides on building scalable full-stack applications with modern frontend frameworks and robust backend systems.</p>
                    <div class="feature-technologies mb-3">
                        <span class="tech-badge">React</span>
                        <span class="tech-badge">Vue.js</span>
                        <span class="tech-badge">Node.js</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 animate animate-delay-3">
                <div class="feature-card h-100 p-4 text-center">
                    <div class="feature-icon-wrapper mb-4">
                        <div class="feature-icon bg-accent-gradient text-white">
                            <i class="fas fa-code fa-2x"></i>
                        </div>
                        <div class="feature-icon-bg"></div>
                    </div>
                    <h4 class="mb-3 text-primary-custom">Modern Development</h4>
                    <p class="text-muted mb-4">Latest trends in web development, DevOps practices, API design, and industry best practices for maintainable code.</p>
                    <div class="feature-technologies mb-3">
                        <span class="tech-badge">API Design</span>
                        <span class="tech-badge">DevOps</span>
                        <span class="tech-badge">Testing</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Knowledge Platform Section -->
<section class="py-5 my-5 bg-light-custom">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 animate">
                <div class="knowledge-content">
                    <span class="badge bg-accent-gradient text-white px-3 py-2 rounded-pill mb-3">
                        <i class="fas fa-graduation-cap me-2"></i>Learning Hub
                    </span>
                    <h2 class="fw-bold text-primary-custom mb-4">Empowering Developers Through Knowledge</h2>
                    <p class="lead text-muted mb-4">InvidiaTech serves as a comprehensive learning platform where I share practical development insights, advanced techniques, and real-world solutions gained through hands-on experience.</p>
                    
                    <div class="knowledge-features">
                        <div class="knowledge-feature d-flex align-items-center mb-3">
                            <div class="feature-check bg-primary-custom text-white rounded-circle me-3">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="text-muted">In-depth technical tutorials and step-by-step guides</span>
                        </div>
                        <div class="knowledge-feature d-flex align-items-center mb-3">
                            <div class="feature-check bg-primary-custom text-white rounded-circle me-3">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="text-muted">Real-world project case studies and lessons learned</span>
                        </div>
                        <div class="knowledge-feature d-flex align-items-center mb-3">
                            <div class="feature-check bg-primary-custom text-white rounded-circle me-3">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="text-muted">Latest technology trends and emerging best practices</span>
                        </div>
                        <div class="knowledge-feature d-flex align-items-center mb-3">
                            <div class="feature-check bg-primary-custom text-white rounded-circle me-3">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="text-muted">Performance optimization techniques and scalability insights</span>
                        </div>
                    </div>
                    
                    <a href="{{ route('articles') }}" class="btn btn-primary-custom btn-lg rounded-pill px-5 mt-3">
                        <i class="fas fa-book-open me-2"></i>Explore Knowledge Base
                    </a>
                </div>
            </div>
            <div class="col-lg-6 animate animate-delay-1">
                <div class="knowledge-visual">
                    <div class="knowledge-card">
                        <div class="knowledge-card-header bg-primary-gradient">
                            <div class="knowledge-card-dots">
                                <span></span><span></span><span></span>
                            </div>
                            <span class="knowledge-card-title">InvidiaTech Knowledge Hub</span>
                        </div>
                        <div class="knowledge-card-body">
                            <div class="article-preview mb-3">
                                <div class="article-icon bg-accent-custom rounded"></div>
                                <div class="article-info">
                                    <h6 class="mb-1">Laravel Performance Optimization</h6>
                                    <small class="text-muted">Advanced caching and query optimization</small>
                                </div>
                            </div>
                            <div class="article-preview mb-3">
                                <div class="article-icon bg-secondary-custom rounded"></div>
                                <div class="article-info">
                                    <h6 class="mb-1">Modern PHP Practices</h6>
                                    <small class="text-muted">Clean code and design patterns</small>
                                </div>
                            </div>
                            <div class="article-preview">
                                <div class="article-icon bg-primary-custom rounded"></div>
                                <div class="article-info">
                                    <h6 class="mb-1">API Development Mastery</h6>
                                    <small class="text-muted">RESTful design and GraphQL insights</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Latest Articles Section -->
<section class="py-5 my-5">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 animate">
                <span class="badge bg-primary-gradient text-white px-3 py-2 rounded-pill mb-3">
                    <i class="fas fa-newspaper me-2"></i>Latest Insights
                </span>
                <h2 class="fw-bold text-primary-custom mb-3">Featured Articles & Tutorials</h2>
                <p class="text-muted">Stay updated with cutting-edge development techniques, industry best practices, and innovative solutions from my hands-on experience.</p>
            </div>
            <div class="col-lg-6 text-lg-end animate animate-delay-1">
                <a href="{{ route('articles') }}" class="btn btn-outline-primary-custom btn-lg rounded-pill px-5">
                    <i class="fas fa-library me-2"></i>View All Articles
                </a>
            </div>
        </div>
        
        @if($blogs && $blogs->count() > 0)
            <div class="row g-4">
                @foreach($blogs->take(6) as $article)
                    <div class="col-lg-4 col-md-6 animate animate-delay-{{ ($loop->index % 3) + 1 }}">
                        <article class="blog-card h-100 shadow-sm">
                            <div class="blog-image-wrapper position-relative overflow-hidden">
                                @if($article->featured_image)
                                    <img src="{{ asset('storage/' . $article->featured_image) }}" 
                                         alt="{{ $article->featured_image_alt ?? $article->title }}" 
                                         class="blog-img">
                                @else
                                    <div class="blog-img-placeholder d-flex align-items-center justify-content-center">
                                        <div class="placeholder-content text-center">
                                            <i class="fas fa-code fa-3x text-muted mb-2"></i>
                                            <p class="text-muted mb-0">Technical Insight</p>
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- Enhanced Category Badge -->
                                @if($article->category)
                                    @php
                                        $categoryName = is_object($article->category) 
                                            ? $article->category->name 
                                            : (\App\Models\Category::find($article->category)->name ?? 'General');
                                        $displayName = Str::limit($categoryName, 15);
                                    @endphp
                                    <span class="blog-category-badge">
                                        <i class="fas fa-folder me-1"></i>{{ $displayName }}
                                    </span>
                                @endif
                                
                                <!-- Read Time Badge -->
                                <span class="blog-time-badge">
                                    <i class="far fa-clock me-1"></i>{{ $article->reading_time ?? 5 }} min
                                </span>
                            </div>
                            
                            <div class="blog-content p-4">
                                <!-- Article Meta -->
                                <div class="blog-meta d-flex align-items-center mb-3">
                                    <div class="author-avatar bg-primary-gradient rounded-circle me-2">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                    <div class="meta-info">
                                        <small class="text-muted d-block">
                                            {{ $article->publish_date ? $article->publish_date->format('M d, Y') : $article->created_at->format('M d, Y') }}
                                        </small>
                                    </div>
                                    <div class="ms-auto">
                                        @if(isset($article->views_count) && $article->views_count > 0)
                                            <small class="text-muted">
                                                <i class="far fa-eye me-1"></i>{{ number_format($article->views_count) }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Article Title -->
                                <h5 class="blog-title mb-3">
                                    <a href="{{ route('article.show', $article->slug) }}" 
                                       class="text-decoration-none text-primary-custom stretched-link">
                                        {{ Str::limit($article->title, 65) }}
                                    </a>
                                </h5>
                                
                                <!-- Article Excerpt -->
                                <p class="blog-excerpt text-muted mb-3">
                                    {{ Str::limit($article->excerpt ?: strip_tags($article->content), 120) }}
                                </p>
                                
                                <!-- Tags -->
                                @if($article->tags && $article->tags->count() > 0)
                                    <div class="blog-tags mb-3">
                                        @foreach($article->tags->take(2) as $tag)
                                            <span class="tag-badge">
                                                {{ Str::limit($tag->name, 12) }}
                                            </span>
                                        @endforeach
                                        @if($article->tags->count() > 2)
                                            <span class="tag-badge-more">
                                                +{{ $article->tags->count() - 2 }}
                                            </span>
                                        @endif
                                    </div>
                                @endif
                                
                                <!-- Read More -->
                                <div class="blog-footer d-flex align-items-center justify-content-between">
                                    <span class="read-more-link text-accent-custom fw-bold">
                                        Read Article <i class="fas fa-arrow-right ms-1"></i>
                                    </span>
                                    <div class="article-difficulty">
                                        <span class="difficulty-badge bg-light-custom text-primary-custom">
                                            <i class="fas fa-signal me-1"></i>Intermediate
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
            
            <!-- Featured Article Spotlight -->
            @php
                $featuredArticle = $blogs->where('is_featured', true)->first();
            @endphp

            @if($featuredArticle)
                <div class="row mt-5">
                    <div class="col-12 animate animate-delay-2">
                        <div class="featured-spotlight">
                            <div class="spotlight-header text-center mb-4">
                                <span class="badge bg-gradient-warning text-dark px-4 py-2 rounded-pill fs-6">
                                    <i class="fas fa-star me-2"></i>Featured Knowledge Article
                                </span>
                            </div>
                            <div class="featured-article-enhanced bg-white rounded-4 shadow-lg overflow-hidden">
                                <div class="row g-0">
                                    <div class="col-lg-5">
                                        <div class="featured-image-wrapper">
                                            @if($featuredArticle->featured_image)
                                                <img src="{{ asset('storage/' . $featuredArticle->featured_image) }}" 
                                                     alt="{{ $featuredArticle->featured_image_alt ?? $featuredArticle->title }}" 
                                                     class="featured-image">
                                            @else
                                                <div class="featured-placeholder bg-primary-gradient d-flex align-items-center justify-content-center">
                                                    <div class="text-center text-white">
                                                        <i class="fas fa-lightbulb fa-4x mb-3"></i>
                                                        <h5>Featured Knowledge</h5>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="featured-overlay">
                                                <span class="featured-badge">
                                                    <i class="fas fa-star me-2"></i>Featured
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="featured-content p-5">
                                            <div class="featured-meta mb-3">
                                                @if($featuredArticle->category)
                                                    @php
                                                        $featCategoryName = is_object($featuredArticle->category) 
                                                            ? $featuredArticle->category->name 
                                                            : (\App\Models\Category::find($featuredArticle->category)->name ?? 'General');
                                                    @endphp
                                                    <span class="category-badge-large bg-primary-custom text-white">
                                                        {{ Str::limit($featCategoryName, 20) }}
                                                    </span>
                                                @endif
                                            </div>
                                            <h3 class="featured-title text-primary-custom fw-bold mb-3">
                                                {{ $featuredArticle->title }}
                                            </h3>
                                            <p class="featured-excerpt text-muted mb-4 fs-5">
                                                {{ Str::limit($featuredArticle->excerpt ?: strip_tags($featuredArticle->content), 180) }}
                                            </p>
                                            <div class="featured-stats d-flex align-items-center mb-4">
                                                <div class="stat-item me-4">
                                                    <i class="far fa-calendar-alt text-primary-custom me-2"></i>
                                                    <span class="text-muted">
                                                        {{ $featuredArticle->publish_date ? $featuredArticle->publish_date->format('M d, Y') : $featuredArticle->created_at->format('M d, Y') }}
                                                    </span>
                                                </div>
                                                <div class="stat-item me-4">
                                                    <i class="far fa-clock text-primary-custom me-2"></i>
                                                    <span class="text-muted">{{ $featuredArticle->reading_time ?? 5 }} min read</span>
                                                </div>
                                                <div class="stat-item">
                                                    <i class="far fa-eye text-primary-custom me-2"></i>
                                                    <span class="text-muted">{{ number_format($featuredArticle->views_count ?? 0) }} views</span>
                                                </div>
                                            </div>
                                            <a href="{{ route('article.show', $featuredArticle->slug) }}" 
                                               class="btn btn-primary-custom btn-lg rounded-pill px-5">
                                                <i class="fas fa-book-reader me-2"></i>Read Featured Article
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        @else
            <!-- Enhanced No Articles State -->
            <div class="row">
                <div class="col-12 text-center py-5">
                    <div class="no-articles-state">
                        <div class="no-articles-icon bg-light-custom rounded-circle mx-auto mb-4">
                            <i class="fas fa-lightbulb fa-4x text-primary-custom"></i>
                        </div>
                        <h4 class="text-primary-custom mb-3">Knowledge Base Coming Soon</h4>
                        <p class="text-muted mb-4 fs-5">I'm preparing comprehensive technical content and in-depth tutorials to share valuable development insights with the community.</p>
                        <a href="{{ route('contact') }}" class="btn btn-primary-custom rounded-pill px-5">
                            <i class="fas fa-bell me-2"></i>Get Notified
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Technologies Section -->
<section class="py-5 my-5 bg-light-custom">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto animate">
                <span class="badge bg-accent-gradient text-white px-3 py-2 rounded-pill mb-3">
                    <i class="fas fa-cogs me-2"></i>Technology Expertise
                </span> 
                <h2 class="fw-bold text-primary-custom mb-4">My Technology Stack</h2>
                <p class="lead text-muted">Technologies I work with and share knowledge about through practical experience and continuous learning</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="tech-grid">
                    <div class="tech-item animate animate-delay-1">
                        <div class="tech-icon-wrapper">
                            <i class="fab fa-laravel fa-3x text-danger"></i>
                            <div class="tech-glow"></div>
                        </div>
                        <span class="tech-name">Laravel</span>
                        <span class="tech-level">Expert</span>
                    </div>
                    <div class="tech-item animate animate-delay-2">
                        <div class="tech-icon-wrapper">
                            <i class="fab fa-php fa-3x text-primary"></i>
                            <div class="tech-glow"></div>
                        </div>
                        <span class="tech-name">PHP</span>
                        <span class="tech-level">Advanced</span>
                    </div>
                    <div class="tech-item animate animate-delay-3">
                        <div class="tech-icon-wrapper">
                            <i class="fab fa-js-square fa-3x text-warning"></i>
                            <div class="tech-glow"></div>
                        </div>
                        <span class="tech-name">JavaScript</span>
                        <span class="tech-level">Expert</span>
                    </div>
                    <div class="tech-item animate animate-delay-4">
                        <div class="tech-icon-wrapper">
                            <i class="fab fa-vue fa-3x text-success"></i>
                            <div class="tech-glow"></div>
                        </div>
                        <span class="tech-name">Vue.js</span>
                        <span class="tech-level">Advanced</span>
                    </div>
                    <div class="tech-item animate animate-delay-5">
                        <div class="tech-icon-wrapper">
                            <i class="fab fa-react fa-3x text-info"></i>
                            <div class="tech-glow"></div>
                        </div>
                        <span class="tech-name">React</span>
                        <span class="tech-level">Advanced</span>
                    </div>
                    <div class="tech-item animate animate-delay-6">
                        <div class="tech-icon-wrapper">
                            <i class="fab fa-node-js fa-3x text-success"></i>
                            <div class="tech-glow"></div>
                        </div>
                        <span class="tech-name">Node.js</span>
                        <span class="tech-level">Intermediate</span>
                    </div>
                    <div class="tech-item animate animate-delay-7">
                        <div class="tech-icon-wrapper">
                            <i class="fas fa-database fa-3x text-secondary"></i>
                            <div class="tech-glow"></div>
                        </div>
                        <span class="tech-name">MySQL</span>
                        <span class="tech-level">Expert</span>
                    </div>
                    <div class="tech-item animate animate-delay-8">
                        <div class="tech-icon-wrapper">
                            <i class="fab fa-aws fa-3x text-orange"></i>
                            <div class="tech-glow"></div>
                        </div>
                        <span class="tech-name">AWS</span>
                        <span class="tech-level">Intermediate</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="cta-section bg-primary-custom text-white">
    <div class="cta-pattern"></div>
    <div class="container position-relative">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8 animate">
                <div class="cta-content">
                    <span class="badge bg-white text-primary-custom px-3 py-2 rounded-pill mb-4 fs-6">
                        <i class="fas fa-lightbulb me-2"></i>Learn & Grow Together
                    </span>
                    <h2 class="fw-bold mb-4 display-5" style="color:white">Join the Knowledge Community</h2>
                    <p class="lead mb-5 opacity-90">Explore comprehensive tutorials, practical insights, and cutting-edge development techniques shared from real-world experience</p>
                    
                    <div class="cta-features d-flex justify-content-center flex-wrap gap-4 mb-5">
                        <div class="cta-feature">
                            <i class="fas fa-check-circle me-2"></i>
                            <span>In-Depth Technical Guides</span>
                        </div>
                        <div class="cta-feature">
                            <i class="fas fa-check-circle me-2"></i>
                            <span>Real-World Case Studies</span>
                        </div>
                        <div class="cta-feature">
                            <i class="fas fa-check-circle me-2"></i>
                            <span>Industry Best Practices</span>
                        </div>
                    </div>
                    
                    <div class="cta-buttons d-flex justify-content-center gap-3 flex-wrap">
                        <a href="{{ route('articles') }}" class="btn btn-white btn-lg rounded-pill px-5 fw-bold">
                            <i class="fas fa-book-open me-2"></i>Explore Articles
                        </a>
                        <a href="{{ route('contact') }}" class="btn btn-outline-white btn-lg rounded-pill px-5 fw-bold">
                            <i class="fas fa-envelope me-2"></i>Connect With Me
                        </a>
                    </div>
                    
                    <div class="cta-contact-info mt-4">
                        <p class="mb-0 opacity-75">
                            <i class="fas fa-share-alt me-2"></i>Sharing Knowledge & Building Community
                            <span class="mx-3">|</span>
                            <i class="fas fa-globe me-2"></i>Learning Together Worldwide
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
                
                // Add special effects for feature cards
                if (entry.target.classList.contains('feature-card')) {
                    setTimeout(() => {
                        entry.target.classList.add('feature-hover-ready');
                    }, 500);
                }
            }
        });
    }, observerOptions);

    // Observe all animatable elements
    document.querySelectorAll('.animate').forEach(el => {
        observer.observe(el);
    });

    // Add smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add interactive hover effects for tech items
    document.querySelectorAll('.tech-item').forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.05)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Enhanced knowledge card animation
    document.querySelectorAll('.knowledge-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 20px 40px rgba(0,0,0,0.1)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 10px 30px rgba(0,0,0,0.05)';
        });
    });

    // Dynamic stats counter animation for future use
    function animateCounter(element, target) {
        let current = 0;
        const increment = target / 100;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current) + (target >= 1000 ? 'K+' : '+');
        }, 20);
    }

    // Add parallax effect to CTA section
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const rate = scrolled * -0.5;
        const ctaPattern = document.querySelector('.cta-pattern');
        if (ctaPattern) {
            ctaPattern.style.transform = `translateY(${rate}px)`;
        }
    });
});
</script>

@endsection