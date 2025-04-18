 
@extends('website.layouts.app')
@section('title', 'Services - InvidiaTech')
@section('content')
     <!-- Page Header -->
     <section class="page-header">
        <div class="page-header-pattern"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center animate">
                    <h1 class="fw-bold mb-4">Our Services</h1>
                    <p class="lead">We provide cutting-edge technology solutions with a focus on Laravel development, delivering high-quality, scalable applications that drive business growth.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Services -->
    <section class="py-5 my-5">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto animate">
                    <h6 class="text-uppercase text-accent-custom fw-bold">What We Offer</h6>
                    <h2 class="fw-bold">Comprehensive Development Services</h2>
                    <p class="lead">Tailored solutions to meet your business needs with cutting-edge technologies</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4 animate">
                    <div class="service-card text-center p-4">
                        <div class="service-icon">
                            <i class="fab fa-laravel fa-2x"></i>
                        </div>
                        <h4 class="mb-3">Laravel Development</h4>
                        <p>Expert Laravel development services with modern best practices, delivering robust, scalable web applications that drive your business forward.</p>
                        <ul class="list-unstyled text-start mt-4">
                            <li class="mb-2"><i class="fas fa-check text-accent-custom me-2"></i> Custom Laravel Applications</li>
                            <li class="mb-2"><i class="fas fa-check text-accent-custom me-2"></i> Laravel API Development</li>
                            <li class="mb-2"><i class="fas fa-check text-accent-custom me-2"></i> Laravel Maintenance & Support</li>
                            <li class="mb-2"><i class="fas fa-check text-accent-custom me-2"></i> Laravel Performance Optimization</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 animate animate-delay-1">
                    <div class="service-card text-center p-4">
                        <div class="service-icon">
                            <i class="fas fa-server fa-2x"></i>
                        </div>
                        <h4 class="mb-3">Full Stack Development</h4>
                        <p>Comprehensive full stack development combining robust backend systems with intuitive frontend experiences for a complete digital solution.</p>
                        <ul class="list-unstyled text-start mt-4">
                            <li class="mb-2"><i class="fas fa-check text-accent-custom me-2"></i> Backend Architecture Design</li>
                            <li class="mb-2"><i class="fas fa-check text-accent-custom me-2"></i> Frontend Implementation</li>
                            <li class="mb-2"><i class="fas fa-check text-accent-custom me-2"></i> Database Design & Optimization</li>
                            <li class="mb-2"><i class="fas fa-check text-accent-custom me-2"></i> API Integration & Development</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 animate animate-delay-2">
                    <div class="service-card text-center p-4">
                        <div class="service-icon">
                            <i class="fas fa-code fa-2x"></i>
                        </div>
                        <h4 class="mb-3">Custom Web Applications</h4>
                        <p>Tailor-made web applications designed to solve specific business challenges, streamline operations, and enhance customer experiences.</p>
                        <ul class="list-unstyled text-start mt-4">
                            <li class="mb-2"><i class="fas fa-check text-accent-custom me-2"></i> Requirements Analysis</li>
                            <li class="mb-2"><i class="fas fa-check text-accent-custom me-2"></i> UX/UI Design</li>
                            <li class="mb-2"><i class="fas fa-check text-accent-custom me-2"></i> Agile Development Process</li>
                            <li class="mb-2"><i class="fas fa-check text-accent-custom me-2"></i> Ongoing Maintenance & Support</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 animate animate-delay-3">
                    <div class="service-card text-center p-4">
                        <div class="service-icon">
                            <i class="fas fa-mobile-alt fa-2x"></i>
                        </div>
                        <h4 class="mb-3">Responsive Web Design</h4>
                        <p>Mobile-first design approach ensuring your applications work flawlessly across all devices, providing an optimal user experience everywhere.</p>
                        <ul class="list-unstyled text-start mt-4">
                            <li class="mb-2"><i class="fas fa-check text-accent-custom me-2"></i> Mobile-First Approach</li>
                            <li class="mb-2"><i class="fas fa-check text-accent-custom me-2"></i> Cross-Browser Compatibility</li>
                            <li class="mb-2"><i class="fas fa-check text-accent-custom me-2"></i> Progressive Web Apps</li>
                            <li class="mb-2"><i class="fas fa-check text-accent-custom me-2"></i> Responsive Frameworks</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 animate">
                    <div class="service-card text-center p-4">
                        <div class="service-icon">
                            <i class="fas fa-database fa-2x"></i>
                        </div>
                        <h4 class="mb-3">Database Management</h4>
                        <p>Efficient database design, implementation, and optimization services to ensure your applications run smoothly and securely at any scale.</p>
                        <ul class="list-unstyled text-start mt-4">
                            <li class="mb-2"><i class="fas fa-check text-accent-custom me-2"></i> Database Architecture</li>
                            <li class="mb-2"><i class="fas fa-check text-accent-custom me-2"></i> Performance Optimization</li>
                            <li class="mb-2"><i class="fas fa-check text-accent-custom me-2"></i> Data Migration</li>
                            <li class="mb-2"><i class="fas fa-check text-accent-custom me-2"></i> Security Implementation</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 animate animate-delay-1">
                    <div class="service-card text-center p-4">
                        <div class="service-icon">
                            <i class="fas fa-cloud fa-2x"></i>
                        </div>
                        <h4 class="mb-3">DevOps & Deployment</h4>
                        <p>Streamlined development operations with continuous integration and deployment, ensuring reliable, scalable applications in production.</p>
                        <ul class="list-unstyled text-start mt-4">
                            <li class="mb-2"><i class="fas fa-check text-accent-custom me-2"></i> CI/CD Pipeline Setup</li>
                            <li class="mb-2"><i class="fas fa-check text-accent-custom me-2"></i> Server Configuration</li>
                            <li class="mb-2"><i class="fas fa-check text-accent-custom me-2"></i> Docker Containerization</li>
                            <li class="mb-2"><i class="fas fa-check text-accent-custom me-2"></i> Cloud Infrastructure Management</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Process Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto animate">
                    <h6 class="text-uppercase text-accent-custom fw-bold">How We Work</h6>
                    <h2 class="fw-bold">Our Development Process</h2>
                    <p class="lead">A structured approach to delivering high-quality solutions</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="process-step animate">
                        <div class="process-number">1</div>
                        <div class="process-icon"><i class="fas fa-comments"></i></div>
                        <div class="process-connector"></div>
                        <h4>Discovery & Requirements</h4>
                        <p>We begin by understanding your business goals, challenges, and requirements. Through detailed discussions and analysis, we create a comprehensive blueprint for your project.</p>
                    </div>
                    <div class="process-step animate animate-delay-1">
                        <div class="process-number">2</div>
                        <div class="process-icon"><i class="fas fa-pencil-alt"></i></div>
                        <div class="process-connector"></div>
                        <h4>Planning & Design</h4>
                        <p>Based on the requirements, we create a detailed project plan, architecture diagrams, and UI/UX designs to visualize the final product before development begins.</p>
                    </div>
                    <div class="process-step animate animate-delay-2">
                        <div class="process-number">3</div>
                        <div class="process-icon"><i class="fas fa-code"></i></div>
                        <div class="process-connector"></div>
                        <h4>Development</h4>
                        <p>Our expert developers work on implementing the solution using modern technologies and best practices, with a focus on clean, maintainable code and security.</p>
                    </div>
                    <div class="process-step animate animate-delay-3">
                        <div class="process-number">4</div>
                        <div class="process-icon"><i class="fas fa-vial"></i></div>
                        <div class="process-connector"></div>
                        <h4>Testing & Quality Assurance</h4>
                        <p>We conduct thorough testing, including functional, performance, and security tests to ensure the solution meets the highest quality standards and works flawlessly.</p>
                    </div>
                    <div class="process-step last-step animate">
                        <div class="process-number">5</div>
                        <div class="process-icon"><i class="fas fa-rocket"></i></div>
                        <div class="process-connector"></div>
                        <h4>Deployment & Support</h4>
                        <p>Once approved, we deploy the solution to production and provide ongoing support and maintenance to ensure it continues to perform optimally and evolves as your business grows.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Technologies Section -->
    <section class="py-5 my-5">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto animate">
                    <h6 class="text-uppercase text-accent-custom fw-bold">Tools & Technologies</h6>
                    <h2 class="fw-bold">Our Technology Stack</h2>
                    <p class="lead">We use cutting-edge technologies to deliver robust, scalable solutions</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="row text-center">
                        <div class="col-md-3 col-6 mb-4 animate">
                            <div class="technology-icon mb-3">
                                <i class="fab fa-laravel fa-3x text-accent-custom"></i>
                            </div>
                            <h5>Laravel</h5>
                        </div>
                        <div class="col-md-3 col-6 mb-4 animate animate-delay-1">
                            <div class="technology-icon mb-3">
                                <i class="fab fa-vuejs fa-3x text-accent-custom"></i>
                            </div>
                            <h5>Vue.js</h5>
                        </div>
                        <div class="col-md-3 col-6 mb-4 animate animate-delay-2">
                            <div class="technology-icon mb-3">
                                <i class="fab fa-react fa-3x text-accent-custom"></i>
                            </div>
                            <h5>React</h5>
                        </div>
                        <div class="col-md-3 col-6 mb-4 animate animate-delay-3">
                            <div class="technology-icon mb-3">
                                <i class="fab fa-node-js fa-3x text-accent-custom"></i>
                            </div>
                            <h5>Node.js</h5>
                        </div>
                        <div class="col-md-3 col-6 mb-4 animate">
                            <div class="technology-icon mb-3">
                                <i class="fab fa-aws fa-3x text-accent-custom"></i>
                            </div>
                            <h5>AWS</h5>
                        </div>
                        <div class="col-md-3 col-6 mb-4 animate animate-delay-1">
                            <div class="technology-icon mb-3">
                                <i class="fab fa-docker fa-3x text-accent-custom"></i>
                            </div>
                            <h5>Docker</h5>
                        </div>
                        <div class="col-md-3 col-6 mb-4 animate animate-delay-2">
                            <div class="technology-icon mb-3">
                                <i class="fas fa-database fa-3x text-accent-custom"></i>
                            </div>
                            <h5>MySQL</h5>
                        </div>
                        <div class="col-md-3 col-6 mb-4 animate animate-delay-3">
                            <div class="technology-icon mb-3">
                                <i class="fab fa-bootstrap fa-3x text-accent-custom"></i>
                            </div>
                            <h5>Bootstrap</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto animate">
                    <h6 class="text-uppercase text-accent-custom fw-bold">Client Feedback</h6>
                    <h2 class="fw-bold">What Our Clients Say</h2>
                    <p class="lead">Hear from businesses who have experienced our services</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 animate">
                    <div class="testimonial-card">
                        <div class="d-flex align-items-center mb-4">
                            <img src="/api/placeholder/80/80" alt="Client" class="client-img">
                            <div class="ms-3">
                                <h5 class="mb-1">Jane Smith</h5>
                                <p class="mb-0 text-muted">CEO, TechStart Inc.</p>
                            </div>
                        </div>
                        <p class="mb-0">"Invidiatech helped us transform our outdated system into a modern, efficient platform. Their Laravel expertise and commitment to quality were evident throughout the project."</p>
                        <div class="mt-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 animate animate-delay-1">
                    <div class="testimonial-card">
                        <div class="d-flex align-items-center mb-4">
                            <img src="/api/placeholder/80/80" alt="Client" class="client-img">
                            <div class="ms-3">
                                <h5 class="mb-1">Michael Johnson</h5>
                                <p class="mb-0 text-muted">CTO, GlobalTech Solutions</p>
                            </div>
                        </div>
                        <p class="mb-0">"We've worked with several development teams before, but Invidiatech's approach to full-stack development is exceptional. Their attention to detail and code quality has significantly improved our platform's performance."</p>
                        <div class="mt-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 animate animate-delay-2">
                    <div class="testimonial-card">
                        <div class="d-flex align-items-center mb-4">
                            <img src="/api/placeholder/80/80" alt="Client" class="client-img">
                            <div class="ms-3">
                                <h5 class="mb-1">Sarah Williams</h5>
                                <p class="mb-0 text-muted">Product Manager, InnovateX</p>
                            </div>
                        </div>
                        <p class="mb-0">"The team at Invidiatech delivered our project ahead of schedule and exceeded our expectations. Their Laravel expertise and proactive communication made the development process smooth and efficient."</p>
                        <div class="mt-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-5 my-5">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto animate">
                    <h6 class="text-uppercase text-accent-custom fw-bold">Common Questions</h6>
                    <h2 class="fw-bold">Frequently Asked Questions</h2>
                    <p class="lead">Find answers to common questions about our services</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 mx-auto animate">
                    <div class="faq-item">
                        <div class="faq-header" onclick="toggleFaq(this)">
                            <h5>What is your development process?</h5>
                        </div>
                        <div class="faq-body">
                            <p>Our development process follows an agile methodology that includes discovery, planning, development, testing, and deployment phases. We maintain transparent communication throughout the project, with regular updates and demonstrations to ensure the final product meets your expectations.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-header" onclick="toggleFaq(this)">
                            <h5>How do you handle project timelines and deadlines?</h5>
                        </div>
                        <div class="faq-body">
                            <p>We create detailed project plans with realistic timelines based on the project scope and complexity. Our agile approach allows us to adapt to changes while staying on track. We provide regular progress updates and communicate proactively if any adjustments to the timeline are needed.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-header" onclick="toggleFaq(this)">
                            <h5>What makes your Laravel development services unique?</h5>
                        </div>
                        <div class="faq-body">
                            <p>Our Laravel development expertise goes beyond basic implementation. We focus on building scalable, maintainable applications using the latest Laravel best practices, design patterns, and performance optimization techniques. Our developers regularly contribute to the Laravel community and stay updated with the latest framework updates and features.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-header" onclick="toggleFaq(this)">
                            <h5>Do you provide ongoing support after project completion?</h5>
                        </div>
                        <div class="faq-body">
                            <p>Yes, we offer various support and maintenance packages to ensure your application continues to run smoothly after launch. These include regular updates, security patches, performance monitoring, and feature enhancements. We can tailor a support plan to meet your specific needs and budget.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-header" onclick="toggleFaq(this)">
                            <h5>Can you work with our existing team?</h5>
                        </div>
                        <div class="faq-body">
                            <p>Absolutely! We're experienced in collaborating with in-house teams, providing specialized expertise where needed. We can integrate seamlessly with your existing workflows, tools, and processes to deliver value without disruption. Many clients find this hybrid approach allows them to leverage our expertise while maintaining internal control.</p>
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
                    <h2 class="fw-bold mb-4">Ready to Transform Your Digital Presence?</h2>
                    <p class="lead mb-5">Let's discuss your project requirements and create a custom solution that drives results</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="hire-us.html" class="btn btn-accent-custom btn-lg rounded-pill px-5">Hire Us Now</a>
                        <a href="contact.html" class="btn btn-outline-light btn-lg rounded-pill px-5">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection