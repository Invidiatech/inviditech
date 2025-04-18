 
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
                    <div class="stats-counter" data-count="500">500+</div>
                    <div class="stats-text">Projects Completed</div>
                </div>
                <div class="col-md-3 col-6 text-center mb-4 animate animate-delay-1">
                    <div class="stats-counter" data-count="100">100+</div>
                    <div class="stats-text">Happy Clients</div>
                </div>
                <div class="col-md-3 col-6 text-center mb-4 animate animate-delay-2">
                    <div class="stats-counter" data-count="300">300+</div>
                    <div class="stats-text">Articles Published</div>
                </div>
                <div class="col-md-3 col-6 text-center mb-4 animate animate-delay-3">
                    <div class="stats-counter" data-count="15">15+</div>
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
                <a href="#" class="btn btn-outline-primary rounded-pill px-4">View All Articles</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4 animate animate-delay-1">
                <div class="blog-card h-100">
                    <div class="position-relative">
                        <img src="{{ asset('frontend/assets/images/home/invidaitech-blog-1.png') }}" alt="Blog Image" class="blog-img">
                        <span class="blog-tag">Laravel</span>
                    </div>
                    <div class="p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <small class="text-muted"><i class="far fa-calendar-alt me-1"></i> Mar 10, 2025</small>
                            <small class="text-muted"><i class="far fa-clock me-1"></i> 5 min read</small>
                        </div>
                        <h5 class="card-title">Advanced Laravel Eloquent Techniques</h5>
                        <p class="card-text">Explore advanced Eloquent ORM features that can supercharge your Laravel applications...</p>
                        <a href="#" class="text-accent-custom fw-bold">Read more <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4 animate animate-delay-2">
                <div class="blog-card h-100">
                    <div class="position-relative">
                        <img src="{{ asset('frontend/assets/images/home/invidaitech-blog-2.png') }}" alt="Blog Image" class="blog-img">
                        <span class="blog-tag">DevOps</span>
                    </div>
                    <div class="p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <small class="text-muted"><i class="far fa-calendar-alt me-1"></i> Mar 08, 2025</small>
                            <small class="text-muted"><i class="far fa-clock me-1"></i> 7 min read</small>
                        </div>
                        <h5 class="card-title">CI/CD Pipeline for Laravel Applications</h5>
                        <p class="card-text">Build a robust continuous integration and deployment pipeline for your Laravel projects...</p>
                        <a href="#" class="text-accent-custom fw-bold">Read more <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4 animate animate-delay-3">
                <div class="blog-card h-100">
                    <div class="position-relative">
                        <img src="{{ asset('frontend/assets/images/home/invidaitech-blog-4.png') }}" alt="Blog Image" class="blog-img">
                        <span class="blog-tag">API</span>
                    </div>
                    <div class="p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <small class="text-muted"><i class="far fa-calendar-alt me-1"></i> Mar 05, 2025</small>
                            <small class="text-muted"><i class="far fa-clock me-1"></i> 6 min read</small>
                        </div>
                        <h5 class="card-title">RESTful API Design Best Practices</h5>
                        <p class="card-text">Learn how to design clean, efficient and developer-friendly RESTful APIs for your projects...</p>
                        <a href="#" class="text-accent-custom fw-bold">Read more <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


    <!-- Clients Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto animate">
                    <h6 class="text-uppercase text-accent-custom fw-bold">Trusted Partners</h6>
                    <h2 class="fw-bold">Companies We Collaborate With</h2>
                </div>
            </div>
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-2 col-md-3 col-6 mb-4 animate">
                    <img src="/api/placeholder/120/60" alt="Client Logo" class="client-logo mx-auto d-block">
                </div>
                <div class="col-lg-2 col-md-3 col-6 mb-4 animate animate-delay-1">
                    <img src="/api/placeholder/120/60" alt="Client Logo" class="client-logo mx-auto d-block">
                </div>
                <div class="col-lg-2 col-md-3 col-6 mb-4 animate animate-delay-2">
                    <img src="/api/placeholder/120/60" alt="Client Logo" class="client-logo mx-auto d-block">
                </div>
                <div class="col-lg-2 col-md-3 col-6 mb-4 animate animate-delay-3">
                    <img src="/api/placeholder/120/60" alt="Client Logo" class="client-logo mx-auto d-block">
                </div>
                <div class="col-lg-2 col-md-3 col-6 mb-4 animate">
                    <img src="/api/placeholder/120/60" alt="Client Logo" class="client-logo mx-auto d-block">
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