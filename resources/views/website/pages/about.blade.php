@extends('website.layouts.app')
@section('title', 'About Us - InvidiaTech')
@section('content')   
    <!-- Page Header -->
    <section class="page-header">
        <div class="page-header-pattern"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center animate">
                    <h1 class="fw-bold mb-4">About Invidiatech</h1>
                    <p class="lead">A professional development studio delivering cutting-edge technology solutions with a personalized approach.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 animate">
                    <div class="about-img">
                    <img src="{{ asset('assets/profile/Muhammad Nawaz.jpg') }}"  alt="Muhammad Nawaz" class="img-fluid rounded">
                    </div>
                </div>
                <div class="col-lg-7 animate">
                    <div class="founder-badge mb-3">
                        <span>Founder & Lead Developer</span>
                    </div>
                    <h2 class="fw-bold mb-3">Muhammad Nawaz</h2>
                    <h6 class="text-accent-custom fw-bold mb-4">Full Stack Web Developer</h6>
                    <p>Welcome to Invidiatech, a freelance-based development studio founded in 2020. I'm Muhammad Nawaz, a passionate Full Stack Web Developer specializing in PHP, Laravel, WordPress, Shopify, HTML, CSS, Bootstrap, and JavaScript.</p>
                    <p>With a focus on delivering quality solutions, I transform business challenges into efficient digital experiences. From concept to deployment, every project receives my dedicated personal attention, ensuring exceptional results and complete client satisfaction.</p>
                    <div class="professional-links mt-4 mb-4">
                        <a href="https://www.linkedin.com/in/muhammad-nawaz-43a354201/" target="_blank" class="social-link">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-github"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('services') }}" class="btn btn-primary-custom px-4 me-3">My Services</a>
                        <a href="{{ route('contact') }}"  class="btn btn-outline-secondary px-4">Contact Me</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Expertise Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row text-center mb-4">
                <div class="col-lg-8 mx-auto animate">
                    <h2 class="fw-bold">My Expertise</h2>
                    <p>Specialized skills to deliver exceptional digital solutions</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4 animate">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fab fa-laravel"></i>
                        </div>
                        <h4>PHP & Laravel</h4>
                        <p>Custom web applications with robust backend solutions built on Laravel and PHP.</p>
                    </div>
                </div>
                <div class="col-md-4 animate">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fab fa-wordpress"></i>
                        </div>
                        <h4>WordPress & Shopify</h4>
                        <p>Professional websites and e-commerce solutions with customized functionality.</p>
                    </div>
                </div>
                <div class="col-md-4 animate">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-code"></i>
                        </div>
                        <h4>Frontend Development</h4>
                        <p>Responsive, user-friendly interfaces using HTML, CSS, Bootstrap & JavaScript.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6 text-center mb-4 animate">
                    <div class="stats-counter">100+</div>
                    <div class="stats-text">Projects Completed</div>
                </div>
                <div class="col-md-3 col-6 text-center mb-4 animate">
                    <div class="stats-counter">50+</div>
                    <div class="stats-text">Happy Clients</div>
                </div>
                <div class="col-md-3 col-6 text-center mb-4 animate">
                    <div class="stats-counter">5+</div>
                    <div class="stats-text">Years Experience</div>
                </div>
                <div class="col-md-3 col-6 text-center mb-4 animate">
                    <div class="stats-counter">10+</div>
                    <div class="stats-text">Technologies</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Approach Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 animate">
                    <h2 class="fw-bold mb-4">My Approach</h2>
                    <div class="approach-item">
                        <div class="approach-number">01</div>
                        <h5>Personal Attention</h5>
                        <p>Every project receives my direct attention from start to finish, ensuring quality and clear communication.</p>
                    </div>
                    <div class="approach-item">
                        <div class="approach-number">02</div>
                        <h5>Business-Focused Solutions</h5>
                        <p>I focus on creating solutions that address your specific business needs and drive tangible results.</p>
                    </div>
                    <div class="approach-item">
                        <div class="approach-number">03</div>
                        <h5>Quality & Timeliness</h5>
                        <p>Delivering high-quality work within agreed timeframes is my commitment to every client.</p>
                    </div>
                </div>
                <div class="col-lg-6 animate">
                    <div class="approach-img">
                        <img src="/api/placeholder/500/400" alt="My Approach" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Freelance Platforms -->
    <section class="py-5 d-none">
        <div class="container">
            <div class="row text-center mb-4">
                <div class="col-lg-8 mx-auto animate">
                    <h2 class="fw-bold">Find Me On</h2>
                    <p>You can also hire me through these popular freelance platforms</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="row g-4">
                        <div class="col-md-6 animate">
                            <a href="#" class="platform-card">
                                <div class="platform-icon">
                                    <i class="fab fa-upwork"></i>
                                </div>
                                <div class="platform-info">
                                    <h4>Upwork</h4>
                                    <p>Top-rated developer with consistent 5-star reviews</p>
                                    <span class="platform-cta">View Profile <i class="fas fa-external-link-alt"></i></span>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 animate">
                            <a href="#" class="platform-card">
                                <div class="platform-icon">
                                    <i class="fab fa-fw fa-fiverr"></i>
                                </div>
                                <div class="platform-info">
                                    <h4>Fiverr</h4>
                                    <p>offering premium development services</p>
                                    <span class="platform-cta">View Gigs <i class="fas fa-external-link-alt"></i></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary-custom">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8 text-white animate">
                    <h2 class="fw-bold mb-4">Ready to Start Your Project?</h2>
                    <p class="lead mb-4">Let's discuss how I can help bring your ideas to life with the perfect solution</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="hire-us.html" class="btn btn-accent-custom px-4">Hire Me Now</a>
                        <a href="contact.html" class="btn btn-outline-light px-4">Contact Me</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection