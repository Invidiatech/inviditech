<!-- Hero Section -->
<section class="hero bg-white">
    <div class="hero-pattern"></div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 animate">
                <h1 class="fw-bold mb-4">Cutting-Edge Solutions for <span class="text-accent-custom">Future Tech</span></h1>
                <p class="lead mb-5">
                    Invidiatech is a technology hub offering in-depth articles, best practices, and advanced 
                    software development concepts with a primary focus on Laravel. As an Upwork agency, we 
                    collaborate with leading IT companies to deliver innovative solutions.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('services') }}" class="btn btn-primary-custom btn-lg rounded-pill px-4">Our Services</a>
                    <a href="{{ route('articles') }}" class="btn btn-outline-secondary rounded-pill px-4">Latest Articles</a>
                </div>
            </div>
            <div class="col-lg-6 animate animate-delay-1 text-center">
                <img src="{{ asset('frontend/assets/images/home/invidiatech-hero.svg') }}" 
                    alt="Technology Illustration" class="img-fluid hero-img">
            </div>
        </div>
    </div>
</section>