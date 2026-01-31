 
@extends('website.layouts.app')

@section('title', 'Blog - InvidiaTech')
@section('meta_title', 'InvidiaTech Blog - Web Development Insights')
@section('meta_description', 'Read the latest InvidiaTech blog posts on Laravel, PHP, JavaScript, and modern web development best practices.')
@section('meta_keywords', 'Tech Blog, Laravel Articles, PHP Tutorials, Web Development, InvidiaTech')

@section('content')
    @include('website.partials.hero', [
        'title' => 'InvidiaTech Blog',
        'subtitle' => 'Latest news, insights, and updates from the world of technology.',
        'primaryButtonText' => 'Latest Articles',
        'secondaryButtonText' => 'Categories',
        'heroImage' => 'assets/images/blog-hero.jpg'
    ])

    <!-- Blog Posts Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <div class="mb-5">
                        <article class="card mb-4">
                            <img src="{{ asset('placeholder/800/400') }}" class="card-img-top" alt="Article Featured Image">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="badge bg-primary">Laravel</span>
                                    <small class="text-muted">March 1, 2024</small>
                                </div>
                                <h2 class="card-title">What's New in Laravel 11: Features and Improvements</h2>
                                <p class="card-text">Laravel 11 brings significant changes to the framework's structure with a more minimalist approach. This article explores the key features and improvements in this major release.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('placeholder/40/40') }}" class="rounded-circle me-2" alt="Author">
                                        <span>John Developer</span>
                                    </div>
                                    <a href="#" class="btn btn-outline-primary">Read More</a>
                                </div>
                            </div>
                        </article>
                        
                        <article class="card mb-4">
                            <img src="{{ asset('placeholder/800/400') }}" class="card-img-top" alt="Article Featured Image">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="badge bg-primary">Web Development</span>
                                    <small class="text-muted">February 25, 2024</small>
                                </div>
                                <h2 class="card-title">Modern Authentication Practices for Web Applications</h2>
                                <p class="card-text">Authentication is a critical aspect of web application security. This article discusses modern authentication techniques and best practices for securing your applications.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('placeholder/40/40') }}" class="rounded-circle me-2" alt="Author">
                                        <span>Sarah Engineer</span>
                                    </div>
                                    <a href="#" class="btn btn-outline-primary">Read More</a>
                                </div>
                            </div>
                        </article>
                        
                        <article class="card mb-4">
                            <img src="{{ asset('placeholder/800/400') }}" class="card-img-top" alt="Article Featured Image">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="badge bg-primary">AI</span>
                                    <small class="text-muted">February 18, 2024</small>
                                </div>
                                <h2 class="card-title">Integrating AI Tools in Your Development Workflow</h2>
                                <p class="card-text">Artificial intelligence is transforming how developers work. Learn how to integrate AI tools into your development workflow to increase productivity and improve code quality.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('placeholder/40/40') }}" class="rounded-circle me-2" alt="Author">
                                        <span>Mike Coder</span>
                                    </div>
                                    <a href="#" class="btn btn-outline-primary">Read More</a>
                                </div>
                            </div>
                        </article>
                        
                        <nav aria-label="Blog pagination">
                            <ul class="pagination justify-content-center">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Search Widget -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">Search</h5>
                        </div>
                        <div class="card-body">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search for...">
                                <button class="btn btn-primary" type="button">Go!</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Categories Widget -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">Categories</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2">
                                <a href="#" class="btn btn-outline-primary btn-sm">Laravel (12)</a>
                                <a href="#" class="btn btn-outline-primary btn-sm">PHP (8)</a>
                                <a href="#" class="btn btn-outline-primary btn-sm">JavaScript (15)</a>
                                <a href="#" class="btn btn-outline-primary btn-sm">React (9)</a>
                                <a href="#" class="btn btn-outline-primary btn-sm">DevOps (7)</a>
                                <a href="#" class="btn btn-outline-primary btn-sm">AI (5)</a>
                                <a href="#" class="btn btn-outline-primary btn-sm">Security (4)</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Popular Posts Widget -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">Popular Posts</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="d-flex mb-3 pb-3 border-bottom">
                                    <img src="{{ asset('placeholder/60/60') }}" class="me-3" alt="Post Thumbnail">
                                    <div>
                                        <h6 class="mb-1"><a href="#" class="text-decoration-none">RESTful API Design Best Practices</a></h6>
                                        <small class="text-muted">2,540 views</small>
                                    </div>
                                </li>
                                <li class="d-flex mb-3 pb-3 border-bottom">
                                    <img src="{{ asset('placeholder/60/60') }}" class="me-3" alt="Post Thumbnail">
                                    <div>
                                        <h6 class="mb-1"><a href="#" class="text-decoration-none">Docker vs Kubernetes: When to Use What</a></h6>
                                        <small class="text-muted">1,980 views</small>
                                    </div>
                                </li>
                                <li class="d-flex">
                                    <img src="{{ asset('placeholder/60/60') }}" class="me-3" alt="Post Thumbnail">
                                    <div>
                                        <h6 class="mb-1"><a href="#" class="text-decoration-none">Testing in Laravel: A Complete Guide</a></h6>
                                        <small class="text-muted">1,750 views</small>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="mb-4">Subscribe to Our Newsletter</h2>
                    <p class="lead mb-5">Get the latest articles, tutorials, and updates delivered straight to your inbox.</p>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <form class="mb-3">
                                <div class="input-group">
                                    <input type="email" class="form-control" placeholder="Your email address">
                                    <button class="btn btn-primary" type="submit">Subscribe</button>
                                </div>
                            </form>
                            <small class="text-muted">We respect your privacy and will never share your information.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection