@extends('layouts.app')
@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1>Master Modern Technology</h1>
                    <p class="lead mb-4">Comprehensive tutorials, professional services, and expert guidance for your technical journey.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="btn btn-light btn-lg">Get Started</a>
                        <a href="#" class="btn btn-outline-light btn-lg">Our Services</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('images/hero.jpg') }}" alt="Hero Image" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2>Why Choose InvidiaTech</h2>
                <p class="lead text-muted">Empowering developers and businesses with cutting-edge technical solutions</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-laptop-code"></i>
                        </div>
                        <h3>Expert-Led Tutorials</h3>
                        <p>Learn from industry experts with our comprehensive, practical tutorials covering the latest technologies.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <h3>Professional Services</h3>
                        <p>Custom development, consulting, and enterprise solutions tailored to your business needs.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h3>Corporate Training</h3>
                        <p>Upskill your team with customized training programs delivered by experienced professionals.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Tutorials</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">50K+</div>
                        <div class="stat-label">Students</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">100+</div>
                        <div class="stat-label">Enterprise Clients</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">15+</div>
                        <div class="stat-label">Technologies</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Resources -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Latest Resources</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="resource-card">
                        <div class="resource-image">
                            <i class="fab fa-python"></i>
                        </div>
                        <div class="p-4">
                            <h4>Python Masterclass</h4>
                            <p class="text-muted">Comprehensive Python programming from basics to advanced concepts.</p>
                            <a href="#" class="btn btn-outline-primary">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="resource-card">
                        <div class="resource-image">
                            <i class="fab fa-react"></i>
                        </div>
                        <div class="p-4">
                            <h4>React Development</h4>
                            <p class="text-muted">Modern web development with React and related technologies.</p>
                            <a href="#" class="btn btn-outline-primary">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="resource-card">
                        <div class="resource-image">
                            <i class="fab fa-aws"></i>
                        </div>
                        <div class="p-4">
                            <h4>AWS Cloud Solutions</h4>
                            <p class="text-muted">Cloud architecture and deployment with Amazon Web Services.</p>
                            <a href="#" class="btn btn-outline-primary">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">What Our Clients Say</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="testimonial-card">
                        <div class="d-flex mb-4">
                            <img src="{{ asset('images/client1.jpg') }}" alt="Client" class="client-image">
                            <div>
                                <h5 class="mb-1">Sarah Johnson</h5>
                                <p class="text-muted mb-0">CTO, TechCorp</p>
                            </div>
                        </div>
                        <p class="mb-0">"InvidiaTech's corporate training program has significantly improved our team's technical capabilities. Their expert-led sessions were practical and highly engaging."</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="testimonial-card">
                        <div class="d-flex mb-4">
                            <img src="{{ asset('images/client2.jpg') }}" alt="Client" class="client-image">
                            <div>
                                <h5 class="mb-1">Michael Chen</h5>
                                <p class="text-muted mb-0">Lead Developer, StartupX</p>
                            </div>
                        </div>
                        <p class="mb-0">"The quality of tutorials and technical content is outstanding. It's our go-to resource for keeping up with the latest technologies and best practices."</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container text-center">
            <h2 class="mb-4">Ready to Start Your Journey?</h2>
            <p class="lead mb-4">Join thousands of developers and companies who trust InvidiaTech for their technical growth.</p>
            <a href="#" class="btn btn-light btn-lg">Get Started Today</a>
        </div>
    </section>
@endsection