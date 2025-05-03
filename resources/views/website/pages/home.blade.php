 
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
                            <a href="#" class="btn btn-sm btn-outline-secondary rounded-pill">Learn More</a>
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
                            <a href="#" class="btn btn-sm btn-outline-secondary rounded-pill">Learn More</a>
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
                            <a href="#" class="btn btn-sm btn-outline-secondary rounded-pill">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6 text-center mb-4 animate">
                    <div class="stats-counter" data-count="500">50+</div>
                    <div class="stats-text">Projects Completed</div>
                </div>
                <div class="col-md-3 col-6 text-center mb-4 animate animate-delay-1">
                    <div class="stats-counter" data-count="100">50+</div>
                    <div class="stats-text">Happy Clients</div>
                </div>
                <div class="col-md-3 col-6 text-center mb-4 animate animate-delay-2">
                    <div class="stats-counter" data-count="300">100+</div>
                    <div class="stats-text">Articles Published</div>
                </div>
                <div class="col-md-3 col-6 text-center mb-4 animate animate-delay-3">
                    <div class="stats-counter" data-count="15">5</div>
                    <div class="stats-text">Expert Developers</div>
                </div>
            </div>
        </div>
    </section>

<!-- Latest Articles -->
<section class="py-5 my-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-6 animate">
                <h6 class="text-uppercase text-accent-custom fw-bold">Latest Insights</h6>
                <h2 class="fw-bold">Discover Our Latest Articles</h2>
            </div>
            <div class="col-lg-6 text-lg-end animate">
                <a href="{{ route('articles') }}" class="btn btn-outline-primary rounded-pill px-4">View All Articles</a>
            </div>
        </div>
        <div class="row">
            @forelse($latestArticles as $article)
                <div class="col-lg-4 col-md-6 mb-4 animate animate-delay-{{ $loop->index + 1 }}">
                    <div class="blog-card h-100">
                        <div class="position-relative">
                            @if($article->featured_image)
                                <img src="{{ asset('storage/' . $article->featured_image) }}" 
                                     alt="{{ $article->featured_image_alt ?? $article->title }}" 
                                     class="blog-img">
                            @else
                                <img src="/api/placeholder/600/350" alt="{{ $article->title }}" class="blog-img">
                            @endif
                            <span class="blog-tag">{{ $article->category->name }}</span>
                        </div>
                        <div class="p-4">
                            <div class="d-flex justify-content-between mb-3">
                                <small class="text-muted"><i class="far fa-calendar-alt me-1"></i> {{ $article->created_at->format('M d, Y') }}</small>
                                <small class="text-muted"><i class="far fa-clock me-1"></i> {{ $article->reading_time ?? '5' }} min read</small>
                            </div>
                            <h5 class="card-title">{{ $article->title }}</h5>
                            <p class="card-text">{{ Str::limit($article->excerpt, 100) }}</p>
                            <a href="{{ route('article.show', $article->slug) }}" class="text-accent-custom fw-bold">Read more <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>No articles available yet.</p>
                </div>
            @endforelse
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
                    <a href="#" class="btn btn-light btn-lg rounded-pill px-5 fw-bold">Get in Touch</a>
                </div>
            </div>
        </div>
    </section>

@endsection