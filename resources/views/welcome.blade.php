<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InvidiaTech - Professional Technical Solutions</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #044168;
            --secondary: #0069AA;
            --accent: #00A9FF;
            --text-primary: #2C3E50;
            --border-color: #E5E9EF;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: var(--text-primary);
            background: #F8FAFC;
        }

        .navbar {
            background: var(--primary);
            padding: 0;
        }

        .top-bar {
            background: #033152;
            padding: 4px 0;
            font-size: 14px;
        }

        .nav-link {
            padding: 1rem !important;
            color: #fff !important;
            font-weight: 500;
        }

        .nav-link:hover {
            background: var(--secondary);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            padding: 80px 0;
            color: white;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        /* Feature Cards */
        .feature-card {
            background: white;
            border-radius: 8px;
            padding: 2rem;
            height: 100%;
            transition: transform 0.3s ease;
            border: 1px solid var(--border-color);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: var(--accent);
            margin-bottom: 1.5rem;
        }

        /* Stats Section */
        .stats-section {
            background: white;
            padding: 60px 0;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        /* CTA Section */
        .cta-section {
            background: var(--secondary);
            color: white;
            padding: 60px 0;
        }

        /* Latest Resources */
        .resource-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .resource-card:hover {
            transform: translateY(-5px);
        }

        .resource-image {
            height: 200px;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }

        .testimonial-card {
            background: white;
            border-radius: 8px;
            padding: 2rem;
            margin: 1rem 0;
            border: 1px solid var(--border-color);
        }

        .client-image {
            width: 60px;
            height: 60px;
            border-radius: 30px;
            margin-right: 1rem;
        }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar text-white">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="me-3"><i class="fas fa-envelope me-2"></i>contact@invidiatech.com</span>
                    <span><i class="fas fa-phone me-2"></i>+1 (555) 123-4567</span>
                </div>
                <div>
                    <a href="#" class="text-white text-decoration-none me-3"><i class="fas fa-user me-1"></i>Login</a>
                    <a href="#" class="text-white text-decoration-none"><i class="fas fa-user-plus me-1"></i>Register</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand text-white fw-bold py-2" href="#">InvidiaTech</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="tutorials.html">Tutorials</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">References</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Enterprise</a></li>
                    <li class="nav-item"><a class="nav-link" href="blog.html">Blog</a></li>
                </ul>
            </div>
        </div>
    </nav>

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
                    <img src="{{ asset('assets/images/software-developer.jpg') }}" alt="Hero Image" class="img-fluid rounded">
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
                            <img src="/api/placeholder/60/60" alt="Client" class="client-image">
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
                            <img src="/api/placeholder/60/60" alt="Client" class="client-image">
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
<!-- Footer -->
    <footer class="bg-dark text-light py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Company Info -->
                <div class="col-lg-4">
                    <h5 class="text-white mb-4">InvidiaTech</h5>
                    <p class="text-light opacity-75 mb-4">Empowering developers and businesses with cutting-edge technical solutions and professional training services.</p>
                    <div class="social-links">
                        <a href="#" class="text-light me-3"><i class="fab fa-linkedin fa-lg"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-github fa-lg"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-youtube fa-lg"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-4">
                    <h6 class="text-white mb-4">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none opacity-75">About Us</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none opacity-75">Our Services</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none opacity-75">Careers</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none opacity-75">Contact Us</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none opacity-75">Blog</a></li>
                    </ul>
                </div>

                <!-- Resources -->
                <div class="col-lg-2 col-md-4">
                    <h6 class="text-white mb-4">Resources</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none opacity-75">Tutorials</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none opacity-75">Documentation</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none opacity-75">E-books</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none opacity-75">Webinars</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none opacity-75">Open Source</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div class="col-lg-2 col-md-4">
                    <h6 class="text-white mb-4">Support</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none opacity-75">Help Center</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none opacity-75">Community</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none opacity-75">FAQ</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none opacity-75">Terms of Service</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none opacity-75">Privacy Policy</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div class="col-lg-2">
                    <h6 class="text-white mb-4">Newsletter</h6>
                    <p class="text-light opacity-75 mb-3">Subscribe to our newsletter for updates and tutorials.</p>
                    <form>
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="Enter your email">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Subscribe</button>
                    </form>
                </div>
            </div>

            <!-- Bottom Footer -->
            <div class="border-top border-secondary mt-5 pt-4">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p class="text-light opacity-75 mb-md-0">&copy; 2024 InvidiaTech. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <a href="#" class="text-light text-decoration-none opacity-75 me-3">Terms</a>
                        <a href="#" class="text-light text-decoration-none opacity-75 me-3">Privacy</a>
                        <a href="#" class="text-light text-decoration-none opacity-75">Cookies</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>