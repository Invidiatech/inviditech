<!-- Enhanced Hero Section with Tech Skills -->
<section class="hero-section bg-white position-relative overflow-hidden">
    <!-- Background Elements -->
    <div class="hero-pattern"></div>
    <div class="hero-shapes">
        <div class="hero-shape hero-shape-1"></div>
        <div class="hero-shape hero-shape-2"></div>
        <div class="hero-shape hero-shape-3"></div>
    </div>
    
    <div class="container position-relative">
        <div class="row align-items-center min-vh-100" style="padding-top: 100px;">
            <!-- Content Column -->
            <div class="col-lg-6 col-xl-5 animate">
                <div class="hero-content">
                    <!-- Professional Badge -->
                    <div class="hero-badge mb-4">
                        <span class="badge bg-primary-gradient text-white px-4 py-2 rounded-pill fs-6">
                            <i class="fas fa-trophy me-2"></i>
                            Award-Winning IT Solutions Provider
                        </span>
                    </div>
                    
                    <!-- Main Heading -->
                    <h1 class="hero-title fw-bold mb-4">
                        Cutting-Edge Solutions for 
                        <span class="text-accent-custom position-relative">
                            Future Tech
                            <svg class="hero-underline" viewBox="0 0 300 12" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 6 Q 150 1 295 6" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"/>
                            </svg>
                        </span>
                    </h1>
                    
                    <!-- Description -->
                    <p class="hero-description lead mb-5">
                        <strong>InvidiaTech</strong> is your premier technology partner offering comprehensive IT solutions, 
                        in-depth technical articles, and cutting-edge software development expertise. As a trusted 
                        <strong>Laravel specialist</strong> and industry leader, we collaborate with global enterprises 
                        to deliver innovative, scalable solutions that drive digital transformation.
                    </p>
                    
                    <!-- Call to Action Buttons -->
                    <div class="hero-actions d-flex gap-3 mb-4">
                        <a href="{{ route('services') }}" class="btn btn-primary-custom btn-lg rounded-pill px-5">
                            <i class="fas fa-cogs me-2"></i>
                            Explore Services
                        </a>
                        <a href="{{ route('articles') }}" class="btn btn-outline-primary-custom btn-lg rounded-pill px-5">
                            <i class="fas fa-book-open me-2"></i>
                            Latest Tutorials
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Enhanced Visual Column with More Tech Skills -->
            <div class="col-lg-6 col-xl-7 animate animate-delay-1 text-center position-relative">
                <div class="hero-visual">
                    <!-- Main Illustration -->
                    <div class="hero-image-wrapper position-relative d-inline-block">
                        <img src="{{ asset('frontend/invidiatech-hero.svg') }}" 
                             alt="InvidiaTech - Professional IT Solutions" 
                             class="img-fluid hero-img">
                        
                        <!-- Enhanced Floating Tech Skills Elements -->
                        <!-- Top Row -->
                        <div class="floating-element floating-element-1">
                            <div class="tech-badge tech-badge-laravel">
                                <i class="fab fa-laravel"></i>
                                <span>Laravel</span>
                            </div>
                        </div>
                        
                        <div class="floating-element floating-element-2">
                            <div class="tech-badge tech-badge-react">
                                <i class="fab fa-react"></i>
                                <span>React</span>
                            </div>
                        </div>
                        
                        <!-- Middle Row -->
                        <div class="floating-element floating-element-3">
                            <div class="tech-badge tech-badge-php">
                                <i class="fab fa-php"></i>
                                <span>PHP</span>
                            </div>
                        </div>
                        
                        <div class="floating-element floating-element-4">
                            <div class="tech-badge tech-badge-js">
                                <i class="fab fa-js-square"></i>
                                <span>JavaScript</span>
                            </div>
                        </div>
                        
                        <!-- Additional Tech Skills -->
                        <div class="floating-element floating-element-5">
                            <div class="tech-badge tech-badge-aws">
                                <i class="fab fa-aws"></i>
                                <span>AWS</span>
                            </div>
                        </div>
                        
                        <div class="floating-element floating-element-6">
                            <div class="tech-badge tech-badge-vue">
                                <i class="fab fa-vue"></i>
                                <span>Vue.js</span>
                            </div>
                        </div>
                        
                        <div class="floating-element floating-element-7">
                            <div class="tech-badge tech-badge-docker">
                                <i class="fab fa-docker"></i>
                                <span>Docker</span>
                            </div>
                        </div>
                        
                        <div class="floating-element floating-element-8">
                            <div class="tech-badge tech-badge-mysql">
                                <i class="fas fa-database"></i>
                                <span>MySQL</span>
                            </div>
                        </div>
                        
                        <div class="floating-element floating-element-9">
                            <div class="tech-badge tech-badge-git">
                                <i class="fab fa-git-alt"></i>
                                <span>Git</span>
                            </div>
                        </div>
                        
                        <div class="floating-element floating-element-10">
                            <div class="tech-badge tech-badge-api">
                                <i class="fas fa-plug"></i>
                                <span>API</span>
                            </div>
                        </div>
                        
                        <!-- Background Decorations -->
                        <div class="hero-decoration hero-decoration-1"></div>
                        <div class="hero-decoration hero-decoration-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Styles for Tech Skills Animation -->
<style>
/* Enhanced Hero Visual Styles */
.hero-visual {
    position: relative;
    z-index: 2;
    padding: 3rem 2rem;
}

.hero-image-wrapper {
    position: relative;
    display: inline-block;
    max-width: 100%;
    margin: 0 auto;
}

.hero-img {
    max-width: 100%;
    width: 100%;
    height: auto;
    filter: drop-shadow(0 20px 40px rgba(4, 65, 104, 0.1));
    animation: heroFloat 6s ease-in-out infinite;
}

/* Hero Actions - Keep buttons on same line */
.hero-actions {
    align-items: center;
}

.hero-actions .btn {
    flex-shrink: 0;
    white-space: nowrap;
}

@keyframes heroFloat {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
}

/* Enhanced Floating Elements with Better Positioning */
.floating-element {
    position: absolute;
    z-index: 3;
    pointer-events: none;
}

/* Top Layer - Primary Skills */
.floating-element-1 {
    top: -8%;
    right: -25%;
    animation: floatElement1 5s ease-in-out infinite;
}

.floating-element-2 {
    top: 8%;
    left: -30%;
    animation: floatElement2 4.5s ease-in-out infinite;
}

/* Middle Layer - Core Skills */
.floating-element-3 {
    top: 35%;
    right: -35%;
    animation: floatElement3 5.5s ease-in-out infinite;
}

.floating-element-4 {
    top: 25%;
    left: -25%;
    animation: floatElement4 4s ease-in-out infinite;
}

/* Additional Skills Layer */
.floating-element-5 {
    bottom: 35%;
    right: -20%;
    animation: floatElement5 6s ease-in-out infinite;
}

.floating-element-6 {
    bottom: 45%;
    left: -35%;
    animation: floatElement6 4.2s ease-in-out infinite;
}

.floating-element-7 {
    bottom: 8%;
    right: -30%;
    animation: floatElement7 5.8s ease-in-out infinite;
}

.floating-element-8 {
    bottom: -5%;
    left: -20%;
    animation: floatElement8 4.8s ease-in-out infinite;
}

.floating-element-9 {
    top: 65%;
    right: -15%;
    animation: floatElement9 5.2s ease-in-out infinite;
}

.floating-element-10 {
    top: 55%;
    left: -15%;
    animation: floatElement10 4.6s ease-in-out infinite;
}

/* Different Animation Patterns for Each Element */
@keyframes floatElement1 {
    0%, 100% { transform: translateY(0) translateX(0) rotate(0deg); }
    25% { transform: translateY(-20px) translateX(10px) rotate(90deg); }
    50% { transform: translateY(-10px) translateX(-5px) rotate(180deg); }
    75% { transform: translateY(-30px) translateX(15px) rotate(270deg); }
}

@keyframes floatElement2 {
    0%, 100% { transform: translateY(0) translateX(0) rotate(0deg); }
    33% { transform: translateY(-15px) translateX(-10px) rotate(120deg); }
    66% { transform: translateY(-25px) translateX(5px) rotate(240deg); }
}

@keyframes floatElement3 {
    0%, 100% { transform: translateY(0) translateX(0) scale(1); }
    50% { transform: translateY(-18px) translateX(8px) scale(1.1); }
}

@keyframes floatElement4 {
    0%, 100% { transform: translateY(0) translateX(0) rotate(0deg); }
    40% { transform: translateY(-22px) translateX(-8px) rotate(144deg); }
    80% { transform: translateY(-12px) translateX(12px) rotate(288deg); }
}

@keyframes floatElement5 {
    0%, 100% { transform: translateY(0) translateX(0) rotate(0deg) scale(1); }
    30% { transform: translateY(-16px) translateX(6px) rotate(108deg) scale(1.05); }
    60% { transform: translateY(-28px) translateX(-4px) rotate(216deg) scale(0.95); }
}

@keyframes floatElement6 {
    0%, 100% { transform: translateY(0) translateX(0) rotate(0deg); }
    25% { transform: translateY(-14px) translateX(-12px) rotate(90deg); }
    75% { transform: translateY(-26px) translateX(8px) rotate(270deg); }
}

@keyframes floatElement7 {
    0%, 100% { transform: translateY(0) translateX(0) scale(1) rotate(0deg); }
    45% { transform: translateY(-20px) translateX(10px) scale(1.08) rotate(162deg); }
}

@keyframes floatElement8 {
    0%, 100% { transform: translateY(0) translateX(0) rotate(0deg); }
    35% { transform: translateY(-17px) translateX(-6px) rotate(126deg); }
    70% { transform: translateY(-13px) translateX(14px) rotate(252deg); }
}

@keyframes floatElement9 {
    0%, 100% { transform: translateY(0) translateX(0) rotate(0deg); }
    50% { transform: translateY(-24px) translateX(-10px) rotate(180deg); }
}

@keyframes floatElement10 {
    0%, 100% { transform: translateY(0) translateX(0) scale(1); }
    40% { transform: translateY(-19px) translateX(7px) scale(1.06); }
    80% { transform: translateY(-11px) translateX(-9px) scale(0.98); }
}

/* Enhanced Tech Badge Styles with Individual Colors */
.tech-badge {
    background: var(--background-white);
    border: 3px solid var(--border-light);
    border-radius: 30px;
    padding: 0.8rem 1.4rem;
    display: flex;
    align-items: center;
    gap: 0.7rem;
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--text-primary);
    box-shadow: 0 12px 35px rgba(4, 65, 104, 0.2);
    backdrop-filter: blur(15px);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    white-space: nowrap;
    pointer-events: auto;
    min-width: 120px;
    justify-content: center;
}

.tech-badge:hover {
    transform: scale(1.15) translateY(-5px);
    box-shadow: 0 20px 50px rgba(4, 65, 104, 0.35);
}

/* Individual Tech Badge Colors */
.tech-badge-laravel {
    border-color: #ff2d20;
    background: linear-gradient(135deg, rgba(255, 45, 32, 0.1) 0%, rgba(255, 255, 255, 0.9) 100%);
}

.tech-badge-laravel:hover {
    border-color: #ff2d20;
    background: linear-gradient(135deg, rgba(255, 45, 32, 0.2) 0%, rgba(255, 255, 255, 0.95) 100%);
    color: #ff2d20;
}

.tech-badge-react {
    border-color: #61dafb;
    background: linear-gradient(135deg, rgba(97, 218, 251, 0.1) 0%, rgba(255, 255, 255, 0.9) 100%);
}

.tech-badge-react:hover {
    border-color: #61dafb;
    background: linear-gradient(135deg, rgba(97, 218, 251, 0.2) 0%, rgba(255, 255, 255, 0.95) 100%);
    color: #61dafb;
}

.tech-badge-php {
    border-color: #777bb4;
    background: linear-gradient(135deg, rgba(119, 123, 180, 0.1) 0%, rgba(255, 255, 255, 0.9) 100%);
}

.tech-badge-php:hover {
    border-color: #777bb4;
    background: linear-gradient(135deg, rgba(119, 123, 180, 0.2) 0%, rgba(255, 255, 255, 0.95) 100%);
    color: #777bb4;
}

.tech-badge-js {
    border-color: #f7df1e;
    background: linear-gradient(135deg, rgba(247, 223, 30, 0.1) 0%, rgba(255, 255, 255, 0.9) 100%);
}

.tech-badge-js:hover {
    border-color: #f7df1e;
    background: linear-gradient(135deg, rgba(247, 223, 30, 0.2) 0%, rgba(255, 255, 255, 0.95) 100%);
    color: #e6a800;
}

.tech-badge-aws {
    border-color: #ff9900;
    background: linear-gradient(135deg, rgba(255, 153, 0, 0.1) 0%, rgba(255, 255, 255, 0.9) 100%);
}

.tech-badge-aws:hover {
    border-color: #ff9900;
    background: linear-gradient(135deg, rgba(255, 153, 0, 0.2) 0%, rgba(255, 255, 255, 0.95) 100%);
    color: #ff9900;
}

.tech-badge-vue {
    border-color: #4fc08d;
    background: linear-gradient(135deg, rgba(79, 192, 141, 0.1) 0%, rgba(255, 255, 255, 0.9) 100%);
}

.tech-badge-vue:hover {
    border-color: #4fc08d;
    background: linear-gradient(135deg, rgba(79, 192, 141, 0.2) 0%, rgba(255, 255, 255, 0.95) 100%);
    color: #4fc08d;
}

.tech-badge-docker {
    border-color: #2496ed;
    background: linear-gradient(135deg, rgba(36, 150, 237, 0.1) 0%, rgba(255, 255, 255, 0.9) 100%);
}

.tech-badge-docker:hover {
    border-color: #2496ed;
    background: linear-gradient(135deg, rgba(36, 150, 237, 0.2) 0%, rgba(255, 255, 255, 0.95) 100%);
    color: #2496ed;
}

.tech-badge-mysql {
    border-color: #4479a1;
    background: linear-gradient(135deg, rgba(68, 121, 161, 0.1) 0%, rgba(255, 255, 255, 0.9) 100%);
}

.tech-badge-mysql:hover {
    border-color: #4479a1;
    background: linear-gradient(135deg, rgba(68, 121, 161, 0.2) 0%, rgba(255, 255, 255, 0.95) 100%);
    color: #4479a1;
}

.tech-badge-git {
    border-color: #f05032;
    background: linear-gradient(135deg, rgba(240, 80, 50, 0.1) 0%, rgba(255, 255, 255, 0.9) 100%);
}

.tech-badge-git:hover {
    border-color: #f05032;
    background: linear-gradient(135deg, rgba(240, 80, 50, 0.2) 0%, rgba(255, 255, 255, 0.95) 100%);
    color: #f05032;
}

.tech-badge-api {
    border-color: var(--accent);
    background: linear-gradient(135deg, rgba(0, 169, 255, 0.1) 0%, rgba(255, 255, 255, 0.9) 100%);
}

.tech-badge-api:hover {
    border-color: var(--accent);
    background: linear-gradient(135deg, rgba(0, 169, 255, 0.2) 0%, rgba(255, 255, 255, 0.95) 100%);
    color: var(--accent);
}

/* Icon Styling */
.tech-badge i {
    font-size: 1.2rem;
    transition: all 0.3s ease;
}

.tech-badge:hover i {
    transform: scale(1.2) rotate(10deg);
}

/* Enhanced Hero Decorations */
.hero-decoration {
    position: absolute;
    border-radius: 50%;
    background: var(--primary-gradient);
    opacity: 0.04;
    z-index: 1;
}

.hero-decoration-1 {
    width: 250px;
    height: 250px;
    top: -80px;
    right: -80px;
    animation: rotate 25s linear infinite;
}

.hero-decoration-2 {
    width: 180px;
    height: 180px;
    bottom: -60px;
    left: -60px;
    animation: rotate 30s linear infinite reverse;
}

@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Responsive Design for Enhanced Skills */
@media (max-width: 1399.98px) {
    .floating-element-1 { right: -20%; }
    .floating-element-2 { left: -25%; }
    .floating-element-3 { right: -30%; }
    .floating-element-4 { left: -20%; }
    .floating-element-5 { right: -15%; }
    .floating-element-6 { left: -30%; }
    .floating-element-7 { right: -25%; }
    .floating-element-8 { left: -15%; }
    .floating-element-9 { right: -10%; }
    .floating-element-10 { left: -10%; }
}

@media (max-width: 1199.98px) {
    .floating-element {
        display: none;
    }
    
    .hero-visual {
        padding: 2rem 1rem;
    }
    
    .tech-badge {
        padding: 0.6rem 1rem;
        font-size: 0.85rem;
        min-width: 100px;
    }
}

@media (max-width: 991.98px) {
    .hero-visual {
        margin-top: 3rem;
        padding: 1rem;
    }
}

@media (max-width: 767.98px) {
    .hero-visual {
        padding: 0.5rem;
    }
    
    .hero-actions {
        flex-direction: column;
        align-items: stretch;
    }
    
    .hero-actions .btn {
        width: 100%;
        max-width: 280px;
        margin: 0 auto;
    }
}

/* Animation delay for staggered effect */
.floating-element:nth-child(1) { animation-delay: 0s; }
.floating-element:nth-child(2) { animation-delay: 0.5s; }
.floating-element:nth-child(3) { animation-delay: 1s; }
.floating-element:nth-child(4) { animation-delay: 1.5s; }
.floating-element:nth-child(5) { animation-delay: 2s; }
.floating-element:nth-child(6) { animation-delay: 2.5s; }
.floating-element:nth-child(7) { animation-delay: 3s; }
.floating-element:nth-child(8) { animation-delay: 3.5s; }
.floating-element:nth-child(9) { animation-delay: 4s; }
.floating-element:nth-child(10) { animation-delay: 4.5s; }

/* Reduce motion for accessibility */
@media (prefers-reduced-motion: reduce) {
    .floating-element {
        animation: none;
    }
    
    .tech-badge:hover {
        transform: scale(1.05);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced interaction for tech badges
    document.querySelectorAll('.tech-badge').forEach((badge, index) => {
        // Add entrance animation delay
        badge.style.animationDelay = `${index * 0.2}s`;
        
        // Enhanced hover interactions
        badge.addEventListener('mouseenter', function() {
            // Pause the floating animation on hover
            this.parentElement.style.animationPlayState = 'paused';
            
            // Add a subtle glow effect
            this.style.boxShadow = '0 20px 50px rgba(4, 65, 104, 0.4), 0 0 30px rgba(0, 169, 255, 0.3)';
        });
        
        badge.addEventListener('mouseleave', function() {
            // Resume the floating animation
            this.parentElement.style.animationPlayState = 'running';
            
            // Reset shadow
            this.style.boxShadow = '';
        });
        
        // Add click interaction for demonstration
        badge.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Create a ripple effect
            const ripple = document.createElement('div');
            ripple.style.cssText = `
                position: absolute;
                border-radius: 50%;
                background: rgba(0, 169, 255, 0.6);
                transform: scale(0);
                animation: ripple 0.6s linear;
                left: ${e.offsetX - 10}px;
                top: ${e.offsetY - 10}px;
                width: 20px;
                height: 20px;
                pointer-events: none;
            `;
            
            this.style.position = 'relative';
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
    
    // Add CSS for ripple animation
    if (!document.getElementById('ripple-style')) {
        const style = document.createElement('style');
        style.id = 'ripple-style';
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    }
});
</script>