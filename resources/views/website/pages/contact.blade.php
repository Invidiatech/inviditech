@extends('website.layouts.app')
@section('title', 'Connect With Me - InvidiaTech Knowledge Platform')
@section('content')   
    <!-- Page Header -->
    <section class="page-header" style="background: linear-gradient(135deg, #0441688c, #00A9FF8c), url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMjAiIGN5PSIyMCIgcj0iMiIgZmlsbD0iIzAwQTlGRiIgZmlsbC1vcGFjaXR5PSIwLjEiLz4KPC9zdmc+'); padding: 120px 0 80px; position: relative; color: white; overflow: hidden;">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center animate">
                    <h1 class="fw-bold mb-4" style="color: white !important;">Connect With Me</h1>
                    <p class="lead" style="color: rgba(255,255,255,0.9) !important;">Let's discuss technology, share ideas, or explore collaboration opportunities in the world of web development.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Information -->
    <section class="py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 animate">
                    <div class="contact-info-card text-center p-4 h-100">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt fa-lg"></i>
                        </div>
                        <h5>My Location</h5>
                        <p class="mb-0">Rawalpindi<br>Punjab<br>Pakistan</p>
                    </div>
                </div>
                <div class="col-md-4 animate animate-delay-1">
                    <div class="contact-info-card text-center p-4 h-100">
                        <div class="contact-icon">
                            <i class="fas fa-envelope fa-lg"></i>
                        </div>
                        <h5>Email Me</h5>
                        <p class="mb-2">General Inquiries:<br><a href="mailto:sardarnawaz122@gmail.com" class="text-accent-custom">sardarnawaz122@gmail.com</a></p>
                        <p class="mb-0">Knowledge Sharing:<br><a href="mailto:hello@invidiatech.com" class="text-accent-custom">hello@invidiatech.com</a></p>
                    </div>
                </div>
                <div class="col-md-4 animate animate-delay-2">
                    <div class="contact-info-card text-center p-4 h-100">
                        <div class="contact-icon">
                            <i class="fas fa-phone-alt fa-lg"></i>
                        </div>
                        <h5>Call Me</h5>
                        <p class="mb-2">Phone:<br><a href="tel:+923435281821" class="text-accent-custom">+92 343-5281821</a></p>
                        <p class="mb-0">WhatsApp:<br><a href="https://wa.me/923145184047" target="_blank" class="text-accent-custom">+92 314-5184047</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 animate">
                    <h2 class="fw-bold mb-4">Send Me a Message</h2>
                    <p class="mb-4">Whether you have questions about web development, want to discuss a potential collaboration, or simply want to connect with a fellow developer, I'd love to hear from you.</p>
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="contact-form p-4">
                        <form action="{{ route('contact.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Your Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control custom-input @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" placeholder="Muhammad Nawaz" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Your Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control custom-input @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" placeholder="nawaz@gmail.com" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                              <select class="form-control custom-input @error('subject') is-invalid @enderror" id="subject" name="subject" required>
    <option value="">Choose a topic...</option>
    <option value="General Inquiry" {{ old('subject') == 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
    <option value="Technical Question" {{ old('subject') == 'Technical Question' ? 'selected' : '' }}>Technical Question</option>
    <option value="Collaboration" {{ old('subject') == 'Collaboration' ? 'selected' : '' }}>Collaboration Opportunity</option>
    <option value="Feedback" {{ old('subject') == 'Feedback' ? 'selected' : '' }}>Feedback on Articles</option>
    <option value="Guest Post" {{ old('subject') == 'Guest Post' ? 'selected' : '' }}>Guest Post Proposal</option>
    <option value="Project Discussion" {{ old('subject') == 'Project Discussion' ? 'selected' : '' }}>To Discuss Project or Idea to Implement</option>
    <option value="Other" {{ old('subject') == 'Other' ? 'selected' : '' }}>Other</option>
</select>

                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                                <textarea class="form-control custom-input @error('message') is-invalid @enderror" 
                                          id="message" name="message" rows="5" 
                                          placeholder="Share your thoughts, questions, or ideas..." required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input @error('privacy') is-invalid @enderror" 
                                       id="privacy" name="privacy" {{ old('privacy') ? 'checked' : '' }} required>
                                <label class="form-check-label" for="privacy">
                                    I agree to the <a href="#" class="text-accent-custom">Privacy Policy</a> and consent to being contacted <span class="text-danger">*</span>
                                </label>
                                @error('privacy')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary-custom py-2">
                                    <i class="fas fa-paper-plane me-2"></i>Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 animate animate-delay-1">
                    <div class="contact-visual mt-lg-0 mt-5">
                        <div class="knowledge-contact-card bg-white p-4 rounded shadow">
                            <div class="text-center mb-4">
                                <i class="fas fa-comments fa-4x text-primary-custom mb-3"></i>
                                <h4 class="text-primary-custom">Let's Connect</h4>
                                <p class="text-muted">I'm always excited to connect with fellow developers and learners</p>
                            </div>
                            
                            <div class="contact-topics">
                                <h6 class="fw-bold mb-3">What we can discuss:</h6>
                                <div class="topic-item d-flex align-items-center mb-2">
                                    <i class="fas fa-code text-primary-custom me-3"></i>
                                    <span>Web Development Techniques</span>
                                </div>
                                <div class="topic-item d-flex align-items-center mb-2">
                                    <i class="fas fa-lightbulb text-accent-custom me-3"></i>
                                    <span>Project Ideas & Solutions</span>
                                </div>
                                <div class="topic-item d-flex align-items-center mb-2">
                                    <i class="fas fa-users text-success me-3"></i>
                                    <span>Collaboration Opportunities</span>
                                </div>
                                <div class="topic-item d-flex align-items-center mb-2">
                                    <i class="fas fa-graduation-cap text-warning me-3"></i>
                                    <span>Learning & Knowledge Sharing</span>
                                </div>
                            </div>
                            
                            <div class="response-time mt-4 p-3 bg-light rounded">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-clock text-primary-custom me-2"></i>
                                    <div>
                                        <strong>Response Time</strong>
                                        <p class="mb-0 text-muted small">I typically respond within 24 hours</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Connect with Me -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto animate">
                    <h6 class="text-uppercase text-accent-custom fw-bold">Stay Connected</h6>
                    <h2 class="fw-bold">Follow My Journey</h2>
                    <p class="lead">Connect with me on social platforms where I share development insights, tutorials, and tech updates</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8 animate">
                    <div class="d-flex justify-content-center flex-wrap gap-4">
                        <a href="https://github.com/nawazfdev" target="_blank" class="btn btn-light p-3 rounded-circle shadow-sm social-btn" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                            <i class="fab fa-github fa-2x text-accent-custom"></i>
                        </a>
                        <a href="https://www.linkedin.com/in/muhammad-nawaz-43a354201/" target="_blank" class="btn btn-light p-3 rounded-circle shadow-sm social-btn" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                            <i class="fab fa-linkedin-in fa-2x text-accent-custom"></i>
                        </a>
                        <a href="https://www.facebook.com/Muhammad.Nawaz.Dev/" target="_blank" class="btn btn-light p-3 rounded-circle shadow-sm social-btn" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                            <i class="fab fa-facebook-f fa-2x text-accent-custom"></i>
                        </a>
                        <a href="mailto:sardarnawaz122@gmail.com" class="btn btn-light p-3 rounded-circle shadow-sm social-btn" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-envelope fa-2x text-accent-custom"></i>
                        </a>
                        <a href="https://wa.me/923145184047" target="_blank" class="btn btn-light p-3 rounded-circle shadow-sm social-btn" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                            <i class="fab fa-whatsapp fa-2x text-accent-custom"></i>
                        </a>
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
                    <h2 class="fw-bold mb-4">Ready to Start Learning Together?</h2>
                    <p class="lead mb-5">Explore my articles, tutorials, and insights to accelerate your web development journey</p>
                    <a href="{{ route('articles') }}" class="btn btn-accent-custom btn-lg rounded-pill px-5">
                        <i class="fas fa-book-open me-2"></i>Explore Knowledge Base
                    </a>
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
        
        .animate-delay-1 {
            transition-delay: 0.2s;
        }
        
        .animate-delay-2 {
            transition-delay: 0.4s;
        }
        
        .contact-info-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid #f0f0f0;
        }
        
        .contact-info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }
        
        .contact-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
        }
        
        .contact-form {
            background: #f8f9fa;
            border-radius: 15px;
            border: 1px solid #e9ecef;
        }
        
        .custom-input {
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        
        .custom-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 0.2rem rgba(0, 169, 255, 0.25);
        }
        
        .knowledge-contact-card {
            margin: 2rem 0;
        }
        
        .topic-item {
            padding: 0.5rem 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .topic-item:last-child {
            border-bottom: none;
        }
        
        .response-time {
            border-left: 4px solid var(--primary);
        }
        
        .social-btn {
            transition: all 0.3s ease;
        }
        
        .social-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
        }
        
        @media (max-width: 768px) {
            .page-header {
                padding: 100px 0 60px;
            }
            
            .contact-info-card {
                margin-bottom: 1.5rem;
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

            // Auto-hide alerts after 5 seconds
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    alert.remove();
                });
            }, 5000);

            // Form validation enhancement
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    document.querySelector('.contact-form').scrollIntoView({ 
                        behavior: 'smooth' 
                    });
                }
            });

            // Real-time validation
            document.querySelectorAll('.custom-input').forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.hasAttribute('required') && !this.value.trim()) {
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-invalid');
                    }
                });
            });
        });
    </script>
@endsection