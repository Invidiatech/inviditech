@extends('website.layouts.app')
@section('title', 'About - InvidiaTech Knowledge Platform')
@section('content')   
    <!-- Page Header -->
    <section class="page-header" style="background: linear-gradient(135deg, #0441688c, #00A9FF8c), url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMjAiIGN5PSIyMCIgcj0iMiIgZmlsbD0iIzAwQTlGRiIgZmlsbC1vcGFjaXR5PSIwLjEiLz4KPC9zdmc+'); padding: 120px 0 80px; position: relative; color: white; overflow: hidden;">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center animate">
                    <h1 class="fw-bold mb-4" style="color: white !important;">About InvidiaTech</h1>
                    <p class="lead" style="color: rgba(255,255,255,0.9) !important;">A knowledge-sharing platform dedicated to empowering developers through practical insights and real-world experience.</p>
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
                        <img src="{{ asset('assets/profile/Muhammad Nawaz.jpg') }}" alt="Muhammad Nawaz" class="img-fluid rounded shadow">
                    </div>
                </div>
                <div class="col-lg-7 animate">
                    <div class="founder-badge mb-3">
                        <span>Founder & Knowledge Curator</span>
                    </div>
                    <h2 class="fw-bold mb-3">Muhammad Nawaz</h2>
                    <h6 class="text-accent-custom fw-bold mb-4">Full Stack Developer & Tech Educator</h6>
                    <p>Welcome to InvidiaTech, a knowledge-sharing platform I founded in 2024. I'm Muhammad Nawaz, a passionate Full Stack Developer specializing in PHP, Laravel, JavaScript, React, Vue.js, Livewire, and modern web technologies.</p>
                    <p>Through this platform, I share practical development insights, tutorials, and real-world solutions I've learned throughout my journey. My goal is to help fellow developers grow their skills and tackle complex challenges with confidence.</p>
                    <div class="professional-links mt-4 mb-4">
                        <a href="https://www.linkedin.com/in/muhammad-nawaz-43a354201/" target="_blank" class="social-link">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="https://github.com/nawazfdev" target="_blank" class="social-link">
                            <i class="fab fa-github"></i>
                        </a>
                        <a href="https://www.facebook.com/Muhammad.Nawaz.Dev/" target="_blank" class="social-link">
                            <i class="fab fa-facebook"></i>
                        </a>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('articles') }}" class="btn btn-primary-custom px-4 me-3">Explore Articles</a>
                        <a href="{{ route('contact') }}" class="btn btn-outline-secondary px-4">Connect With Me</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Knowledge Areas Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row text-center mb-4">
                <div class="col-lg-8 mx-auto animate">
                    <h2 class="fw-bold">Knowledge Areas</h2>
                    <p>Technologies and concepts I share insights about through practical experience</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4 animate">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fab fa-laravel"></i>
                        </div>
                        <h4>PHP & Laravel</h4>
                        <p>Advanced Laravel techniques, performance optimization, and modern PHP development practices.</p>
                    </div>
                </div>
                <div class="col-md-4 animate">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-code"></i>
                        </div>
                        <h4>Frontend Development</h4>
                        <p>JavaScript frameworks, responsive design patterns, and modern CSS techniques.</p>
                    </div>
                </div>
                <div class="col-md-4 animate">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-database"></i>
                        </div>
                        <h4>Database & Architecture</h4>
                        <p>Database optimization, system architecture, and scalable application design.</p>
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
                    <div class="stats-text">Articles & Tutorials</div>
                </div>
                <div class="col-md-3 col-6 text-center mb-4 animate">
                    <div class="stats-counter">5K+</div>
                    <div class="stats-text">Developers Helped</div>
                </div>
                <div class="col-md-3 col-6 text-center mb-4 animate">
                    <div class="stats-counter">5+</div>
                    <div class="stats-text">Years Experience</div>
                </div>
                <div class="col-md-3 col-6 text-center mb-4 animate">
                    <div class="stats-counter">15+</div>
                    <div class="stats-text">Technologies Covered</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 animate">
                    <h2 class="fw-bold mb-4">My Mission</h2>
                    <div class="approach-item">
                        <div class="approach-number">01</div>
                        <h5>Share Real Experience</h5>
                        <p>Every article and tutorial is based on hands-on experience and real-world problem-solving.</p>
                    </div>
                    <div class="approach-item">
                        <div class="approach-number">02</div>
                        <h5>Practical Learning</h5>
                        <p>Focus on actionable insights that developers can immediately apply in their projects.</p>
                    </div>
                    <div class="approach-item">
                        <div class="approach-number">03</div>
                        <h5>Community Growth</h5>
                        <p>Building a community where developers learn, share, and grow together through collaboration.</p>
                    </div>
                </div>
                <div class="col-lg-6 animate">
                    <div class="approach-img">
                        <div class="knowledge-visual-card bg-white p-4 rounded shadow">
                            <div class="text-center mb-4">
                                <i class="fas fa-lightbulb fa-4x text-primary-custom mb-3"></i>
                                <h4 class="text-primary-custom">Sharing Knowledge</h4>
                                <p class="text-muted">Empowering developers through practical insights and continuous learning</p>
                            </div>
                            <div class="progress-items">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Laravel Expertise</span>
                                    <span>95%</span>
                                </div>
                                <div class="progress mb-3" style="height: 8px;">
                                    <div class="progress-bar bg-primary-custom" style="width: 95%"></div>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>JavaScript</span>
                                    <span>90%</span>
                                </div>
                                <div class="progress mb-3" style="height: 8px;">
                                    <div class="progress-bar bg-accent-custom" style="width: 90%"></div>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Teaching & Sharing</span>
                                    <span>100%</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-success" style="width: 100%"></div>
                                </div>
                            </div>
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
                    <h2 class="fw-bold mb-4">Ready to Learn and Grow?</h2>
                    <p class="lead mb-4">Join the InvidiaTech community and explore comprehensive tutorials, insights, and practical development knowledge</p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="{{ route('articles') }}" class="btn btn-accent-custom px-4">Explore Articles</a>
                        <a href="{{ route('contact') }}" class="btn btn-outline-light px-4">Connect With Me</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .page-header {
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
        }
        
        .animate {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }
        
        .animate.animate-in {
            opacity: 1;
            transform: translateY(0);
        }
        
        .founder-badge {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 600;
        }
        
        .about-img img {
            border-radius: 15px;
            transition: transform 0.3s ease;
        }
        
        .about-img img:hover {
            transform: scale(1.05);
        }
        
        .social-link {
            display: inline-flex;
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            border-radius: 50%;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            margin-right: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 169, 255, 0.3);
        }
        
        .social-link:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 169, 255, 0.4);
            color: white;
        }
        
        .service-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }
        
        .service-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 1.8rem;
        }
        
        .stats-counter {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary);
            line-height: 1;
        }
        
        .stats-text {
            color: var(--text-muted);
            font-weight: 500;
            margin-top: 0.5rem;
        }
        
        .approach-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 2rem;
        }
        
        .approach-number {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin-right: 1.5rem;
            flex-shrink: 0;
        }
        
        .approach-item h5 {
            color: var(--primary);
            margin-bottom: 0.5rem;
        }
        
        .knowledge-visual-card {
            margin: 2rem 0;
        }
        
        .progress {
            border-radius: 10px;
            background-color: #f8f9fa;
        }
        
        .progress-bar {
            border-radius: 10px;
        }
        
        @media (max-width: 768px) {
            .page-header {
                padding: 100px 0 60px;
            }
            
            .stats-counter {
                font-size: 2.5rem;
            }
            
            .approach-item {
                margin-bottom: 1.5rem;
            }
            
            .approach-number {
                width: 40px;
                height: 40px;
                margin-right: 1rem;
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
                        entry.target.classList.add('animate-in');
                    }
                });
            }, observerOptions);

            // Observe all animatable elements
            document.querySelectorAll('.animate').forEach(el => {
                observer.observe(el);
            });

            // Counter animation
            function animateCounter(element, target) {
                let current = 0;
                const increment = target / 100;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    
                    let displayValue = Math.floor(current);
                    if (target >= 1000) {
                        displayValue = Math.floor(current / 1000) + 'K';
                    }
                    if (element.textContent.includes('+')) {
                        element.textContent = displayValue + '+';
                    } else {
                        element.textContent = displayValue;
                    }
                }, 20);
            }

            // Trigger counter animation when stats section comes into view
            const statsCounters = document.querySelectorAll('.stats-counter');
            const statsObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const text = entry.target.textContent;
                        let target = parseInt(text);
                        if (text.includes('K')) {
                            target = parseInt(text) * 1000;
                        }
                        animateCounter(entry.target, target);
                        statsObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });
            
            statsCounters.forEach(counter => {
                statsObserver.observe(counter);
            });
        });
    </script>
@endsection