@extends('website.layouts.app')
@section('title', 'Hire Us - InvidiaTech')
@section('meta_title', 'Hire InvidiaTech - Web Development Services')
@section('meta_description', 'Hire InvidiaTech for Laravel development, modern web apps, and scalable technical solutions.')
@section('meta_keywords', 'Hire Laravel Developer, Web Development Services, InvidiaTech')
@section('content')   
    <!-- Page Header -->
    <section class="page-header">
        <div class="page-header-pattern"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center animate">
                    <h1 class="fw-bold mb-4">Hire Us</h1>
                    <p class="lead">Expert tech solutions to bring your digital vision to life</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-5 services-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4 animate">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-laptop-code"></i>
                        </div>
                        <h4>Web Development</h4>
                        <p>Custom web applications with Laravel, Vue.js, or React</p>
                    </div>
                </div>
                <div class="col-md-4 animate">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-server"></i>
                        </div>
                        <h4>API Development</h4>
                        <p>Robust API solutions for seamless system integration</p>
                    </div>
                </div>
                <div class="col-md-4 animate">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h4>E-commerce</h4>
                        <p>Complete online store solutions with secure payment</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Technologies Section -->
    <section class="py-5 bg-light tech-section">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 text-center animate">
                    <h3 class="fw-bold">Technologies We Use</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-12 animate">
                    <div class="tech-grid">
                        <div class="tech-item">
                            <i class="fab fa-laravel"></i>
                            <span>Laravel</span>
                        </div>
                        <div class="tech-item">
                            <i class="fab fa-vuejs"></i>
                            <span>Vue.js</span>
                        </div>
                        <div class="tech-item">
                            <i class="fab fa-react"></i>
                            <span>React</span>
                        </div>
                        <div class="tech-item">
                            <i class="fab fa-node-js"></i>
                            <span>Node.js</span>
                        </div>
                        <div class="tech-item">
                            <i class="fab fa-php"></i>
                            <span>PHP</span>
                        </div>
                        <div class="tech-item">
                            <i class="fab fa-js"></i>
                            <span>JavaScript</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="py-5 testimonial-section">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 text-center animate">
                    <h3 class="fw-bold">Client Feedback</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 mx-auto animate">
                    <div class="testimonial-slider">
                        <div class="testimonial-track">
                            <div class="testimonial-slide active" id="testimonial-1">
                                <div class="testimonial-card">
                                    <div class="testimonial-rating mb-3">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <p class="testimonial-text">"InvidiaTech transformed our outdated learning platform into a modern, efficient system that our users love. Their expertise made all the difference."</p>
                                    <div class="testimonial-author">
                                        <img src="/api/placeholder/50/50" alt="Client" class="testimonial-avatar">
                                        <div>
                                            <h5>Sarah Johnson</h5>
                                            <p>EduTech Systems</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="testimonial-slide" id="testimonial-2">
                                <div class="testimonial-card">
                                    <div class="testimonial-rating mb-3">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <p class="testimonial-text">"Their API integration project exceeded our expectations. The attention to detail and security considerations made implementation seamless."</p>
                                    <div class="testimonial-author">
                                        <img src="/api/placeholder/50/50" alt="Client" class="testimonial-avatar">
                                        <div>
                                            <h5>Michael Roberts</h5>
                                            <p>FinTech Solutions</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="testimonial-dots">
                            <span class="testimonial-dot active" onclick="showTestimonial(1)"></span>
                            <span class="testimonial-dot" onclick="showTestimonial(2)"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Platforms & Contact Form -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-6 animate">
                    <h3 class="fw-bold mb-4">Start Your Project</h3>
                    <div class="contact-form">
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Your Name">
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" placeholder="Your Email">
                                </div>
                                <div class="col-md-6">
                                    <select class="form-select">
                                        <option selected disabled>Project Type</option>
                                        <option>Web Application</option>
                                        <option>API Development</option>
                                        <option>E-commerce</option>
                                        <option>Other</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-select">
                                        <option selected disabled>Budget Range</option>
                                        <option>$1,000 - $5,000</option>
                                        <option>$5,000 - $10,000</option>
                                        <option>$10,000+</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control" rows="3" placeholder="Project Details"></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary-custom w-100">Submit Project Request</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="col-lg-6 animate">
                    <div class="platform-section">
                        <h3 class="fw-bold mb-4">Or Hire Us On</h3>
                        <div class="platform-cards">
                            <a href="#" class="platform-card">
                                <div class="platform-icon">
                                    <i class="fab fa-fiverr"></i>
                                </div>
                                <div class="platform-info">
                                    <h4>Fiverr</h4>
                                    <p>Quick tasks & small projects</p>
                                    <span class="platform-cta">View Gigs <i class="fas fa-external-link-alt"></i></span>
                                </div>
                            </a>
                            
                            <a href="#" class="platform-card">
                                <div class="platform-icon">
                                    <i class="fab fa-upwork"></i>
                                </div>
                                <div class="platform-info">
                                    <h4>Upwork</h4>
                                    <p>Hourly & milestone projects</p>
                                    <span class="platform-cta">View Profile <i class="fas fa-external-link-alt"></i></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        // Testimonial Slider Functionality
        let currentSlide = 1;
        const totalSlides = 2;
        
        function showTestimonial(slideNumber) {
            // Hide all slides
            document.querySelectorAll('.testimonial-slide').forEach(slide => {
                slide.classList.remove('active');
            });
            
            // Deactivate all dots
            document.querySelectorAll('.testimonial-dot').forEach(dot => {
                dot.classList.remove('active');
            });
            
            // Show the selected slide
            document.getElementById(`testimonial-${slideNumber}`).classList.add('active');
            
            // Activate the corresponding dot
            document.querySelectorAll('.testimonial-dot')[slideNumber-1].classList.add('active');
            
            currentSlide = slideNumber;
        }
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Auto rotate testimonials every 5 seconds
            setInterval(function() {
                let nextSlide = currentSlide + 1;
                if (nextSlide > totalSlides) nextSlide = 1;
                showTestimonial(nextSlide);
            }, 5000);
        });
    </script>
    @endpush
@endsection