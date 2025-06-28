@extends('website.layouts.app')
@section('title', 'InvidiaTech - Professional Technical Solutions')

@section('content')
@include('website.partials.hero')

<!-- Features Section -->
<section class="py-5 my-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto animate">
                <h6 class="text-uppercase text-accent-custom fw-bold">What We Offer</h6>
                <h2 class="fw-bold">Expert Technology Solutions</h2>
                <p class="lead">Our specialized services cater to modern development needs</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4 animate animate-delay-1">
                <div class="feature-card p-4">
                    <div class="feature-icon bg-accent-custom text-white mx-auto">
                        <i class="fas fa-code fa-lg"></i>
                    </div>
                    <h4 class="mb-3 text-center">Laravel Development</h4>
                    <p class="text-center">Expert PHP Laravel development services with modern best practices and advanced concepts implementation.</p>
                    <div class="text-center mt-4">
                        <a href="{{ route('services') }}" class="btn btn-sm btn-outline-secondary rounded-pill">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4 animate animate-delay-2">
                <div class="feature-card p-4">
                    <div class="feature-icon bg-secondary-custom text-white mx-auto">
                        <i class="fas fa-server fa-lg"></i>
                    </div>
                    <h4 class="mb-3 text-center">Full Stack Solutions</h4>
                    <p class="text-center">Comprehensive full stack development combining robust backend systems with intuitive frontend experiences.</p>
                    <div class="text-center mt-4">
                        <a href="{{ route('services') }}" class="btn btn-sm btn-outline-secondary rounded-pill">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4 animate animate-delay-3">
                <div class="feature-card p-4">
                    <div class="feature-icon bg-primary-custom text-white mx-auto">
                        <i class="fas fa-mobile-alt fa-lg"></i>
                    </div>
                    <h4 class="mb-3 text-center">Responsive Design</h4>
                    <p class="text-center">Mobile-first design approach ensuring your applications work flawlessly across all devices and screen sizes.</p>
                    <div class="text-center mt-4">
                        <a href="{{ route('services') }}" class="btn btn-sm btn-outline-secondary rounded-pill">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Latest Articles Section -->
<section class="py-5 my-5 bg-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-6 animate">
                <h6 class="text-uppercase text-accent-custom fw-bold">Latest Insights</h6>
                <h2 class="fw-bold">Discover Our Latest Articles</h2>
                <p class="text-muted">Stay updated with the latest trends, tutorials, and insights in web development and technology.</p>
            </div>
            <div class="col-lg-6 text-lg-end animate">
                <a href="{{ route('articles') }}" class="btn btn-outline-primary rounded-pill px-4">
                    <i class="fas fa-newspaper me-2"></i>View All Articles
                </a>
            </div>
        </div>
        
        @if($blogs && $blogs->count() > 0)
            <div class="row">
                @foreach($blogs->take(6) as $article)
                    <div class="col-lg-4 col-md-6 mb-4 animate animate-delay-{{ $loop->index + 1 }}">
                        <article class="blog-card h-100 shadow-sm">
                            <div class="position-relative overflow-hidden">
                                @if($article->featured_image)
                                    <img src="{{ asset('storage/' . $article->featured_image) }}" 
                                         alt="{{ $article->featured_image_alt ?? $article->title }}" 
                                         class="blog-img">
                                @else
                                    <div class="blog-img-placeholder d-flex align-items-center justify-content-center">
                                        <i class="fas fa-file-alt fa-3x text-muted"></i>
                                    </div>
                                @endif
                                
                                <!-- Improved Category Badge -->
                                @if($article->category)
                                    @php
                                        $categoryName = is_object($article->category) 
                                            ? $article->category->name 
                                            : (\App\Models\Category::find($article->category)->name ?? 'General');
                                        // Limit category name length
                                        $displayName = Str::limit($categoryName, 12);
                                    @endphp
                                    <span class="position-absolute top-0 end-0 m-2 px-2 py-1 bg-primary bg-opacity-90 text-white rounded small fw-semibold" 
                                          style="font-size: 0.75rem;">
                                        {{ $displayName }}
                                    </span>
                                @endif
                            </div>
                            
                            <div class="p-4">
                                <!-- Article Meta -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="d-flex align-items-center text-muted small">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        <span>{{ $article->publish_date ? $article->publish_date->format('M d, Y') : $article->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="d-flex align-items-center text-muted small">
                                        <i class="far fa-clock me-1"></i>
                                        <span>{{ $article->reading_time ?? 5 }} min</span>
                                    </div>
                                </div>
                                
                                <!-- Article Title -->
                                <h5 class="card-title mb-3">
                                    <a href="{{ route('article.show', $article->slug) }}" 
                                       class="text-decoration-none text-dark stretched-link">
                                        {{ Str::limit($article->title, 60) }}
                                    </a>
                                </h5>
                                
                                <!-- Article Excerpt -->
                                <p class="card-text text-muted mb-3">
                                    {{ Str::limit($article->excerpt ?: strip_tags($article->content), 120) }}
                                </p>
                                
                                <!-- Tags -->
                                @if($article->tags && $article->tags->count() > 0)
                                    <div class="mb-3">
                                        @foreach($article->tags->take(2) as $tag)
                                            <span class="badge bg-light text-muted me-1" style="font-size: 0.7rem;">
                                                {{ Str::limit($tag->name, 10) }}
                                            </span>
                                        @endforeach
                                        @if($article->tags->count() > 2)
                                            <span class="text-muted" style="font-size: 0.7rem;">
                                                +{{ $article->tags->count() - 2 }}
                                            </span>
                                        @endif
                                    </div>
                                @endif
                                
                                <!-- Read More Link -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-accent-custom fw-bold text-decoration-none small">
                                        Read more <i class="fas fa-arrow-right ms-1"></i>
                                    </span>
                                    
                                    <!-- Article Stats -->
                                    <div class="d-flex align-items-center text-muted small">
                                        @if(isset($article->views_count) && $article->views_count > 0)
                                            <span class="me-2">
                                                <i class="far fa-eye me-1"></i>{{ $article->views_count }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
            
            <!-- Featured Article Section -->
            @php
                $featuredArticle = $blogs->where('is_featured', true)->first();
            @endphp

            @if($featuredArticle)
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="featured-article-section">
                            <h3 class="text-center mb-4">
                                <i class="fas fa-star text-warning me-2"></i>Featured Article
                            </h3>
                            <div class="featured-article-card p-4 rounded-3 bg-white shadow">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        @if($featuredArticle->featured_image)
                                            <img src="{{ asset('storage/' . $featuredArticle->featured_image) }}" 
                                                 alt="{{ $featuredArticle->featured_image_alt ?? $featuredArticle->title }}" 
                                                 class="img-fluid rounded">
                                        @else
                                            <div class="placeholder-image bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px;">
                                                <i class="fas fa-image fa-3x text-muted"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-8">
                                        <div class="ms-md-4">
                                            <div class="d-flex align-items-center mb-3">
                                                <span class="badge bg-warning text-dark me-2">
                                                    <i class="fas fa-star me-1"></i>Featured
                                                </span>
                                                @if($featuredArticle->category)
                                                    @php
                                                        $featCategoryName = is_object($featuredArticle->category) 
                                                            ? $featuredArticle->category->name 
                                                            : (\App\Models\Category::find($featuredArticle->category)->name ?? 'General');
                                                    @endphp
                                                    <span class="badge bg-primary">
                                                        {{ Str::limit($featCategoryName, 15) }}
                                                    </span>
                                                @endif
                                            </div>
                                            <h4 class="fw-bold mb-3">{{ $featuredArticle->title }}</h4>
                                            <p class="text-muted mb-3">
                                                {{ Str::limit($featuredArticle->excerpt ?: strip_tags($featuredArticle->content), 200) }}
                                            </p>
                                            <div class="d-flex align-items-center mb-3">
                                                <small class="text-muted me-3">
                                                    <i class="far fa-calendar-alt me-1"></i>
                                                    {{ $featuredArticle->publish_date ? $featuredArticle->publish_date->format('M d, Y') : $featuredArticle->created_at->format('M d, Y') }}
                                                </small>
                                                <small class="text-muted">
                                                    <i class="far fa-clock me-1"></i>
                                                    {{ $featuredArticle->reading_time ?? 5 }} min read
                                                </small>
                                            </div>
                                            <a href="{{ route('article.show', $featuredArticle->slug) }}" 
                                               class="btn btn-primary rounded-pill px-4">
                                                <i class="fas fa-book-open me-2"></i>Read Featured Article
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
            <!-- No Articles State -->
            <div class="row">
                <div class="col-12 text-center py-5">
                    <div class="no-articles-state">
                        <i class="fas fa-newspaper fa-4x text-muted mb-4"></i>
                        <h4 class="text-muted mb-3">No Articles Available</h4>
                        <p class="text-muted mb-4">We're working on creating amazing content for you. Check back soon!</p>
                        <a href="{{ route('contact') }}" class="btn btn-outline-primary rounded-pill px-4">
                            <i class="fas fa-envelope me-2"></i>Get Notified
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

<style>
/* Add these styles to your CSS file */
.blog-card {
    transition: all 0.3s ease;
    border: none;
    border-radius: 0.5rem;
    overflow: hidden;
}

.blog-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
}

.blog-img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.blog-card:hover .blog-img {
    transform: scale(1.05);
}

.blog-img-placeholder {
    width: 100%;
    height: 200px;
    background-color: #f8f9fa;
}

.stretched-link::after {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1;
    content: "";
}

.blog-card .badge {
    z-index: 2;
    position: relative;
}

/* Featured article specific styles */
.featured-article-card {
    border: 2px solid #ffc107;
    transition: all 0.3s ease;
}

.featured-article-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15) !important;
}
</style>
<!-- Statistics Section -->
<section class="py-5 my-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 col-6 mb-4 animate animate-delay-1">
                <div class="stat-card">
                    <div class="stat-number text-primary fw-bold">50+</div>
                    <div class="stat-label text-muted">Projects Completed</div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4 animate animate-delay-2">
                <div class="stat-card">
                    <div class="stat-number text-success fw-bold">{{ $blogs ? $blogs->count() : 0 }}+</div>
                    <div class="stat-label text-muted">Technical Articles</div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4 animate animate-delay-3">
                <div class="stat-card">
                    <div class="stat-number text-warning fw-bold">100%</div>
                    <div class="stat-label text-muted">Client Satisfaction</div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4 animate animate-delay-4">
                <div class="stat-card">
                    <div class="stat-number text-info fw-bold">24/7</div>
                    <div class="stat-label text-muted">Support Available</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Technologies Section -->
<section class="py-5 my-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto animate">
                <h6 class="text-uppercase text-accent-custom fw-bold">Technologies</h6>
                <h2 class="fw-bold">Our Tech Stack</h2>
                <p class="lead">We work with cutting-edge technologies to deliver exceptional results</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="tech-grid">
                    <div class="tech-item animate animate-delay-1">
                        <i class="fab fa-laravel fa-2x text-danger"></i>
                        <span class="tech-name">Laravel</span>
                    </div>
                    <div class="tech-item animate animate-delay-2">
                        <i class="fab fa-php fa-2x text-primary"></i>
                        <span class="tech-name">PHP</span>
                    </div>
                    <div class="tech-item animate animate-delay-3">
                        <i class="fab fa-js-square fa-2x text-warning"></i>
                        <span class="tech-name">JavaScript</span>
                    </div>
                    <div class="tech-item animate animate-delay-4">
                        <i class="fab fa-vue fa-2x text-success"></i>
                        <span class="tech-name">Vue.js</span>
                    </div>
                    <div class="tech-item animate animate-delay-5">
                        <i class="fab fa-react fa-2x text-info"></i>
                        <span class="tech-name">React</span>
                    </div>
                    <div class="tech-item animate animate-delay-6">
                        <i class="fab fa-node-js fa-2x text-success"></i>
                        <span class="tech-name">Node.js</span>
                    </div>
                    <div class="tech-item animate animate-delay-7">
                        <i class="fas fa-database fa-2x text-secondary"></i>
                        <span class="tech-name">MySQL</span>
                    </div>
                    <div class="tech-item animate animate-delay-8">
                        <i class="fab fa-aws fa-2x text-orange"></i>
                        <span class="tech-name">AWS</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Fiverr Reviews Section -->
<section class="py-5 my-5 reviews-section">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto animate">
                <h6 class="text-uppercase text-accent fw-bold">Client Success</h6>
                <h2 class="fw-bold section-title">Our Client Reviews</h2>
                <p class="lead">Real feedback from satisfied clients across our platforms</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12 animate">
                <div class="review-slider-wrapper">
                    <div id="reviewsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
                        <!-- Indicators -->
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#reviewsCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Review 1"></button>
                            <button type="button" data-bs-target="#reviewsCarousel" data-bs-slide-to="1" aria-label="Review 2"></button>
                            <button type="button" data-bs-target="#reviewsCarousel" data-bs-slide-to="2" aria-label="Review 3"></button>
                            <button type="button" data-bs-target="#reviewsCarousel" data-bs-slide-to="3" aria-label="Review 4"></button>
                            <button type="button" data-bs-target="#reviewsCarousel" data-bs-slide-to="4" aria-label="Review 5"></button>
                            <button type="button" data-bs-target="#reviewsCarousel" data-bs-slide-to="5" aria-label="Review 6"></button>
                            <button type="button" data-bs-target="#reviewsCarousel" data-bs-slide-to="6" aria-label="Review 7"></button>
                            <button type="button" data-bs-target="#reviewsCarousel" data-bs-slide-to="7" aria-label="Review 8"></button>
                            <button type="button" data-bs-target="#reviewsCarousel" data-bs-slide-to="8" aria-label="Review 9"></button>
                            <button type="button" data-bs-target="#reviewsCarousel" data-bs-slide-to="9" aria-label="Review 10"></button>
                            <button type="button" data-bs-target="#reviewsCarousel" data-bs-slide-to="10" aria-label="Review 11"></button>
                            <button type="button" data-bs-target="#reviewsCarousel" data-bs-slide-to="11" aria-label="Review 12"></button>
                            <button type="button" data-bs-target="#reviewsCarousel" data-bs-slide-to="12" aria-label="Review 13"></button>
                            <button type="button" data-bs-target="#reviewsCarousel" data-bs-slide-to="13" aria-label="Review 14"></button>
                            <button type="button" data-bs-target="#reviewsCarousel" data-bs-slide-to="14" aria-label="Review 15"></button>
                            <button type="button" data-bs-target="#reviewsCarousel" data-bs-slide-to="15" aria-label="Review 16"></button>
                        </div>
                        
                        <!-- Slides -->
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="review-image-container">
                                    <img src="{{ asset('assets/client-review/paull_mann.png') }}" alt="Fiverr Review" class="img-fluid review-image">
                                </div>
                            </div>
                            
                            <div class="carousel-item">
                                <div class="review-image-container">
                                    <img src="{{ asset('assets/client-review/ryder.png') }}" alt="Fiverr Review" class="img-fluid review-image">
                                </div>
                            </div>
                            
                            <div class="carousel-item">
                                <div class="review-image-container">
                                    <img src="{{ asset('assets/client-review/ryder2.png') }}" alt="Fiverr Review" class="img-fluid review-image">
                                </div>
                            </div>
                            
                            <div class="carousel-item">
                                <div class="review-image-container">
                                    <img src="{{ asset('assets/client-review/ryder3.png') }}" alt="Fiverr Review" class="img-fluid review-image">
                                </div>
                            </div>
                            
                            <div class="carousel-item">
                                <div class="review-image-container">
                                    <img src="{{ asset('assets/client-review/ryder4.png') }}" alt="Fiverr Review" class="img-fluid review-image">
                                </div>
                            </div>
                            
                            <div class="carousel-item">
                                <div class="review-image-container">
                                    <img src="{{ asset('assets/client-review/ryder5.png') }}" alt="Fiverr Review" class="img-fluid review-image">
                                </div>
                            </div>
                            
                            <div class="carousel-item">
                                <div class="review-image-container">
                                    <img src="{{ asset('assets/client-review/ryder6.png') }}" alt="Fiverr Review" class="img-fluid review-image">
                                </div>
                            </div>
                            
                            <div class="carousel-item">
                                <div class="review-image-container">
                                    <img src="{{ asset('assets/client-review/amit.png') }}" alt="Fiverr Review" class="img-fluid review-image">
                                </div>
                            </div>
                            
                            <div class="carousel-item">
                                <div class="review-image-container">
                                    <img src="{{ asset('assets/client-review/ashleygledhill.png') }}" alt="Fiverr Review" class="img-fluid review-image">
                                </div>
                            </div>
                            
                            <div class="carousel-item">
                                <div class="review-image-container">
                                    <img src="{{ asset('assets/client-review/avelino.png') }}" alt="Fiverr Review" class="img-fluid review-image">
                                </div>
                            </div>
                            
                            <div class="carousel-item">
                                <div class="review-image-container">
                                    <img src="{{ asset('assets/client-review/avelino2.png') }}" alt="Fiverr Review" class="img-fluid review-image">
                                </div>
                            </div>
                            
                            <div class="carousel-item">
                                <div class="review-image-container">
                                    <img src="{{ asset('assets/client-review/diamondlcredit.png') }}" alt="Fiverr Review" class="img-fluid review-image">
                                </div>
                            </div>
                            
                            <div class="carousel-item">
                                <div class="review-image-container">
                                    <img src="{{ asset('assets/client-review/erinthompson.png') }}" alt="Fiverr Review" class="img-fluid review-image">
                                </div>
                            </div>
                            
                            <div class="carousel-item">
                                <div class="review-image-container">
                                    <img src="{{ asset('assets/client-review/evadaboh.png') }}" alt="Fiverr Review" class="img-fluid review-image">
                                </div>
                            </div>
                            
                            <div class="carousel-item">
                                <div class="review-image-container">
                                    <img src="{{ asset('assets/client-review/freelancer.png') }}" alt="Fiverr Review" class="img-fluid review-image">
                                </div>
                            </div>
                            
                            <div class="carousel-item">
                                <div class="review-image-container">
                                    <img src="{{ asset('assets/client-review/lizzie.png') }}" alt="Fiverr Review" class="img-fluid review-image">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Controls -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#reviewsCarousel" data-bs-slide="prev">
                            <div class="control-circle">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </div>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#reviewsCarousel" data-bs-slide="next">
                            <div class="control-circle">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </div>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    
                    <!-- Additional decorative elements -->
                    <div class="review-decoration review-decoration-1"></div>
                    <div class="review-decoration review-decoration-2"></div>
                </div>
                
                <!-- Counter and platform indicator -->
                <div class="review-platform-indicator text-center mt-5">
                    <div class="fiverr-badge">
                        <i class="fas fa-star text-warning me-2"></i>
                        <span>Verified Fiverr Reviews</span>
                        <span class="badge bg-success ms-2">5.0 Rating</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="cta-pattern"></div>
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8 text-white animate">
                <h2 class="fw-bold mb-4">Ready to Build Your Next Project?</h2>
                <p class="lead mb-5">Partner with Invidiatech for cutting-edge solutions that transform your business</p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="{{ route('contact') }}" class="btn btn-light btn-lg rounded-pill px-5 fw-bold">
                        <i class="fas fa-envelope me-2"></i>Get in Touch
                    </a>
                    <a href="{{ route('services') }}" class="btn btn-outline-light btn-lg rounded-pill px-5 fw-bold">
                        <i class="fas fa-eye me-2"></i>View Services
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Enhanced Article Card Styles */
.blog-card {
    border: none;
    border-radius: 15px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    background: white;
}

.blog-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}

.blog-img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 15px 15px 0 0;
}

.blog-img-placeholder {
    width: 100%;
    height: 200px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 15px 15px 0 0;
}

.blog-tag {
    font-size: 0.75rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2);
}

.featured-badge {
    backdrop-filter: blur(10px);
    background: rgba(255,255,255,0.9);
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.featured-article-card {
    border: 2px solid #ffc107;
    position: relative;
    overflow: hidden;
}

.featured-article-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #ffc107, #ff9800);
}

/* Statistics Section */
.stat-card {
    padding: 2rem 1rem;
}

.stat-number {
    font-size: 3rem;
    font-weight: 700;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* Tech Grid */
.tech-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 2rem;
    align-items: center;
}

.tech-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
}

.tech-item:hover {
    transform: translateY(-5px);
}

.tech-name {
    font-weight: 600;
    color: #495057;
}

/* No Articles State */
.no-articles-state {
    padding: 4rem 2rem;
}

/* Responsive Improvements */
@media (max-width: 768px) {
    .blog-card {
        margin-bottom: 2rem;
    }
    
    .featured-article-card .row {
        text-align: center;
    }
    
    .featured-article-card .col-md-4,
    .featured-article-card .col-md-8 {
        margin-bottom: 1rem;
    }
    
    .tech-grid {
        grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
        gap: 1rem;
    }
    
    .stat-number {
        font-size: 2rem;
    }
}

/* Animation Enhancements */
.animate {
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 0.6s ease forwards;
}

.animate-delay-1 { animation-delay: 0.1s; }
.animate-delay-2 { animation-delay: 0.2s; }
.animate-delay-3 { animation-delay: 0.3s; }
.animate-delay-4 { animation-delay: 0.4s; }
.animate-delay-5 { animation-delay: 0.5s; }
.animate-delay-6 { animation-delay: 0.6s; }
.animate-delay-7 { animation-delay: 0.7s; }
.animate-delay-8 { animation-delay: 0.8s; }

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
            }
        });
    }, observerOptions);

    // Observe all animatable elements
    document.querySelectorAll('.animate').forEach(el => {
        observer.observe(el);
    });

    // Enhanced carousel controls
    const carousel = document.getElementById('reviewsCarousel');
    if (carousel) {
        carousel.addEventListener('slide.bs.carousel', function(event) {
            // Add custom slide effects here if needed
        });
    }
});
</script>

@endsection