@extends('website.layouts.app')
@section('title', 'Contact Us - InvidiaTech')
@section('content')   
    <!-- Page Header -->
    <section class="page-header">
        <div class="page-header-pattern"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center animate">
                    <h1 class="fw-bold mb-4">Contact Us</h1>
                    <p class="lead">Get in touch with our team to discuss your project requirements or to learn more about our services.</p>
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
                        <h5>Our Location</h5>
                        <p class="mb-0">Blue Area<br>Islamabad<br>Pakistan</p>
                    </div>
                </div>
                <div class="col-md-4 animate animate-delay-1">
                    <div class="contact-info-card text-center p-4 h-100">
                        <div class="contact-icon">
                            <i class="fas fa-envelope fa-lg"></i>
                        </div>
                        <h5>Email Us</h5>
                        <p class="mb-2">General Inquiries:<br><a href="mailto:sardarnawaz122@gmail.com" class="text-accent-custom">sardarnawaz122@gmail.com</a></p>
                        <p class="mb-0">Support:<br><a href="mailto:support@invidiatech.com" class="text-accent-custom">support@invidiatech.com</a></p>
                    </div>
                </div>
                <div class="col-md-4 animate animate-delay-2">
                    <div class="contact-info-card text-center p-4 h-100">
                        <div class="contact-icon">
                            <i class="fas fa-phone-alt fa-lg"></i>
                        </div>
                        <h5>Call Us</h5>
                        <p class="mb-2">Main Office:<br><a href="tel:+03435281821" class="text-accent-custom">0343-5281821</a></p>
                        <p class="mb-0">WhatsApp:<br><a href="tel:+03145184047" class="text-accent-custom">03145184047</a></p>
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
                    <h2 class="fw-bold mb-4">Send Us a Message</h2>
                    <p class="mb-4">Fill out the form below and we'll get back to you as soon as possible. We're here to answer any questions you might have about our services, projects, or how we can help your business.</p>
                    <div class="contact-form p-4">
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Your Name</label>
                                    <input type="text" class="form-control custom-input" id="name" placeholder="Muhammad Nawaz">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Your Email</label>
                                    <input type="email" class="form-control custom-input" id="email" placeholder="nawaz@gmail.com">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control custom-input" id="subject" placeholder="Project Inquiry">
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control custom-input" id="message" rows="5" placeholder="Tell us about your project or inquiry..."></textarea>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="privacy">
                                <label class="form-check-label" for="privacy">I agree to the <a href="#" class="text-accent-custom">Privacy Policy</a></label>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary-custom py-2">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 animate animate-delay-1">
                    <div class="map-container mt-lg-0 mt-5">
                        <!-- Embedded Google Map of Islamabad Blue Area -->
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3318.1605847075694!2d73.08182017579657!3d33.72637217282968!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38dfbfd1da2e8d35%3A0x24ca3a4051fe961d!2sBlue%20Area%2C%20Islamabad%2C%20Islamabad%20Capital%20Territory%2C%20Pakistan!5e0!3m2!1sen!2s!4v1713795652988!5m2!1sen!2s" 
                        width="600" height="400" style="border:0; width: 100%; height: 400px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Connect with Us -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto animate">
                    <h6 class="text-uppercase text-accent-custom fw-bold">Stay Connected</h6>
                    <h2 class="fw-bold">Connect With Us</h2>
                    <p class="lead">Follow us on social media to stay updated with our latest news, articles, and projects</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8 animate">
                    <div class="d-flex justify-content-center flex-wrap gap-4">
                        <a href="#" class="btn btn-light p-3 rounded-circle shadow-sm" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                            <i class="fab fa-twitter fa-2x text-accent-custom"></i>
                        </a>
                        <a href="#" class="btn btn-light p-3 rounded-circle shadow-sm" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                            <i class="fab fa-facebook-f fa-2x text-accent-custom"></i>
                        </a>
                        <a href="#" class="btn btn-light p-3 rounded-circle shadow-sm" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                            <i class="fab fa-linkedin-in fa-2x text-accent-custom"></i>
                        </a>
                        <a href="#" class="btn btn-light p-3 rounded-circle shadow-sm" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                            <i class="fab fa-instagram fa-2x text-accent-custom"></i>
                        </a>
                        <a href="#" class="btn btn-light p-3 rounded-circle shadow-sm" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                            <i class="fab fa-github fa-2x text-accent-custom"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-5 d-none my-5">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto animate">
                    <h6 class="text-uppercase text-accent-custom fw-bold">Common Questions</h6>
                    <h2 class="fw-bold">Frequently Asked Questions</h2>
                    <p class="lead">Find answers to common questions about contacting us</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 mx-auto animate">
                    <div class="faq-item">
                        <div class="faq-header" onclick="toggleFaq(this)">
                            <h5>What information should I include in my inquiry?</h5>
                        </div>
                        <div class="faq-body">
                            <p>To help us respond more effectively, please include details about your project or inquiry such as project scope, timeline, budget range, and any specific requirements or challenges. The more information you provide, the better we can understand your needs and provide a tailored response.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-header" onclick="toggleFaq(this)">
                            <h5>How quickly can I expect a response?</h5>
                        </div>
                        <div class="faq-body">
                            <p>We aim to respond to all inquiries within 24 business hours. For complex project requests, we may need additional time to prepare a comprehensive response. Rest assured, we prioritize timely communication and will keep you updated throughout the process.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-header" onclick="toggleFaq(this)">
                            <h5>Can I schedule a consultation call?</h5>
                        </div>
                        <div class="faq-body">
                            <p>Absolutely! We offer free initial consultation calls to discuss your project in detail. After receiving your inquiry, we'll suggest available time slots for a call with our experts. This helps us better understand your requirements and allows you to ask questions directly.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-header" onclick="toggleFaq(this)">
                            <h5>Do you work with international clients?</h5>
                        </div>
                        <div class="faq-body">
                            <p>Yes, we work with clients worldwide. Our team is experienced in collaborating remotely across different time zones. We use various communication tools to ensure smooth project coordination regardless of geographical location.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-header" onclick="toggleFaq(this)">
                            <h5>How can I request a quote for my project?</h5>
                        </div>
                        <div class="faq-body">
                            <p>You can request a quote by filling out our contact form with details about your project, or by directly emailing us at sardarnawaz122@gmail.com. For more comprehensive projects, we recommend scheduling a consultation call to discuss your requirements in detail before providing a formal quote.</p>
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
                    <p class="lead mb-5">Skip the form and get in touch with us directly to discuss your project requirements</p>
                    <a href="hire-us.html" class="btn btn-accent-custom btn-lg rounded-pill px-5">Hire Us Now</a>
                </div>
            </div>
        </div>
    </section>

@endsection