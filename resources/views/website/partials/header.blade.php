<!-- Enhanced Professional Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-lg border-bottom" id="mainNavbar">
    <div class="container">
        <!-- Brand Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <div class="brand-logo">
                <span class="brand-main text-primary-custom fw-bold">INVIDIA</span><span class="brand-accent text-accent-custom fw-bold">TECH</span>
                <div class="brand-tagline">Knowledge & Learning Platform</div>
            </div>
        </a>

        <!-- Mobile Menu Toggle -->
        <div class="d-flex align-items-center order-lg-3">
            <!-- Connect Button (visible on all screens) -->
            <a class="btn btn-primary-custom rounded-pill px-4 me-3" href="{{ route('contact') }}">
                <i class="fas fa-envelope me-2"></i>
                <span class="d-none d-sm-inline">Connect</span>
                <span class="d-inline d-sm-none">Connect</span>
            </a>
            
            <!-- Mobile Toggle Button -->
            <button class="navbar-toggler border-0 p-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <div class="mobile-menu-btn">
                    <span class="line line1"></span>
                    <span class="line line2"></span>
                    <span class="line line3"></span>
                </div>
            </button>
        </div>

        <!-- Navigation Menu -->
        <div class="collapse navbar-collapse order-lg-2" id="navbarNav">
            <!-- Main Navigation -->
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="fas fa-home nav-icon"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('articles') || request()->routeIs('article.show') ? 'active' : '' }}" href="{{ route('articles') }}">
                        <i class="fas fa-book-open nav-icon"></i>
                        <span>Articles</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tutorials') ? 'active' : '' }}" href="#">
                        <i class="fas fa-graduation-cap nav-icon"></i>
                        <span>Tutorials</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                        <i class="fas fa-user nav-icon"></i>
                        <span>About</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
                        <i class="fas fa-envelope nav-icon"></i>
                        <span>Contact</span>
                    </a>
                </li>
            </ul>

            <!-- Authentication Section -->
            <ul class="navbar-nav ms-auto d-lg-none">
                <li class="nav-divider"></li>
                @guest
                    <li class="nav-item" style="display: none;">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt nav-icon"></i>
                            <span>Login</span>
                        </a>
                    </li>
                    <li class="nav-item" style="display: none;">
                        <a class="nav-link" href="{{ route('register') }}">
                            <i class="fas fa-user-plus nav-icon"></i>
                            <span>Register</span>
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="fas fa-tachometer-alt nav-icon"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-bookmark nav-icon"></i>
                            <span>My Bookmarks</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <div class="nav-link user-info">
                            <div class="user-avatar bg-primary-custom text-white">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="user-name">{{ Auth::user()->name }}</span>
                        </div>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn border-0 text-start w-100">
                                <i class="fas fa-sign-out-alt nav-icon"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </li>
                @endguest
                
                <!-- Mobile Social Links -->
                <li class="nav-divider"></li>
                <li class="nav-item">
                    <div class="mobile-social-links">
                        <a href="https://www.facebook.com/Muhammad.Nawaz.Dev/" target="_blank" class="social-link" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://www.linkedin.com/in/muhammad-nawaz-43a354201/" target="_blank" class="social-link" title="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="https://github.com/nawazfdev" target="_blank" class="social-link" title="GitHub">
                            <i class="fab fa-github"></i>
                        </a>
                        <a href="https://invidiatech.com" target="_blank" class="social-link" title="Website">
                            <i class="fas fa-globe"></i>
                        </a>
                    </div>
                </li>
            </ul>

            <!-- Desktop Authentication (hidden on mobile) -->
            <ul class="navbar-nav d-none d-lg-flex">
                @guest
                    <li class="nav-item" style="display: none;">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item" style="display: none;">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle user-dropdown" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar bg-primary-custom text-white me-2">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span>{{ Str::limit(Auth::user()->name, 15) }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="navbarDropdown">
                            <li>
                                <div class="dropdown-header">
                                    <div class="user-info-dropdown">
                                        <div class="user-avatar bg-primary-custom text-white">
                                            {{ substr(Auth::user()->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ Auth::user()->name }}</div>
                                            <small class="text-muted">{{ Auth::user()->email }}</small>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-2 text-primary-custom"></i>Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-bookmark me-2 text-primary-custom"></i>My Bookmarks
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user-cog me-2 text-primary-custom"></i>Settings
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<!-- Enhanced Navbar Styles -->
<style>
/* Enhanced Navbar Styling */
#mainNavbar {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    backdrop-filter: blur(20px);
    background-color: rgba(255, 255, 255, 0.95) !important;
    border-bottom: 1px solid var(--border-light);
    z-index: 1050;
}

#mainNavbar.scrolled {
    background-color: rgba(255, 255, 255, 0.98) !important;
    box-shadow: 0 8px 32px rgba(4, 65, 104, 0.1) !important;
}

/* Brand Logo Enhancements */
.navbar-brand {
    text-decoration: none;
    transition: transform 0.3s ease;
}

.navbar-brand:hover {
    transform: scale(1.05);
}

.brand-logo {
    display: flex;
    flex-direction: column;
    line-height: 1;
}

.brand-main,
.brand-accent {
    font-size: 1.5rem;
    font-weight: 700;
    letter-spacing: -0.5px;
}

.brand-tagline {
    font-size: 0.6rem;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: -2px;
    font-weight: 400;
}

/* Enhanced Navigation Links */
.nav-link {
    font-weight: 500;
    color: var(--text-primary) !important;
    padding: 0.75rem 1rem !important;
    margin: 0 0.25rem;
    border-radius: 12px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.nav-link::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    background: var(--accent-gradient);
    bottom: -5px;
    left: 50%;
    transform: translateX(-50%);
    transition: width 0.3s ease;
    border-radius: 1px;
}

.nav-link:hover::after,
.nav-link.active::after {
    width: 60%;
}

.nav-icon {
    font-size: 0.9rem;
    opacity: 0.7;
    transition: opacity 0.3s ease;
}

.nav-link:hover {
    color: var(--accent) !important;
    background-color: rgba(0, 169, 255, 0.08);
    transform: translateY(-1px);
}

.nav-link:hover .nav-icon {
    opacity: 1;
}

.nav-link.active {
    color: var(--accent) !important;
    background: linear-gradient(135deg, rgba(0, 169, 255, 0.1) 0%, rgba(4, 65, 104, 0.05) 100%);
    font-weight: 600;
}

.nav-link.active .nav-icon {
    opacity: 1;
    color: var(--accent);
}

/* Custom Mobile Menu Button */
.mobile-menu-btn {
    width: 30px;
    height: 30px;
    position: relative;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 6px;
    padding: 5px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.mobile-menu-btn:hover {
    background-color: rgba(0, 169, 255, 0.1);
}

.line {
    width: 20px;
    height: 2px;
    background-color: var(--primary);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border-radius: 1px;
}

/* Mobile menu animation */
.navbar-toggler[aria-expanded="true"] .line1 {
    transform: translateY(8px) rotate(45deg);
}

.navbar-toggler[aria-expanded="true"] .line2 {
    opacity: 0;
    transform: translateX(-10px);
}

.navbar-toggler[aria-expanded="true"] .line3 {
    transform: translateY(-8px) rotate(-45deg);
}

/* User Avatar */
.user-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.9rem;
    box-shadow: 0 2px 8px rgba(4, 65, 104, 0.2);
}

.user-dropdown {
    align-items: center;
    padding: 0.5rem 1rem !important;
    border-radius: 25px;
    background-color: rgba(4, 65, 104, 0.05);
    border: 1px solid var(--border-light);
}

.user-dropdown:hover {
    background-color: rgba(4, 65, 104, 0.1);
    border-color: var(--accent);
}

/* Enhanced Dropdown */
.dropdown-menu {
    border: none;
    border-radius: 15px;
    box-shadow: 0 10px 40px rgba(4, 65, 104, 0.15);
    padding: 0.5rem 0;
    margin-top: 0.5rem;
    min-width: 280px;
    backdrop-filter: blur(20px);
    background-color: rgba(255, 255, 255, 0.95);
}

.dropdown-header {
    padding: 1rem 1.5rem 0.5rem;
    border: none;
}

.user-info-dropdown {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.dropdown-item {
    padding: 0.75rem 1.5rem;
    color: var(--text-primary);
    font-weight: 500;
    transition: all 0.3s ease;
    border-radius: 8px;
    margin: 0 0.5rem;
}

.dropdown-item:hover {
    background-color: rgba(0, 169, 255, 0.08);
    color: var(--accent);
    transform: translateX(5px);
}

.dropdown-item i {
    width: 20px;
}

/* Mobile Navigation Enhancements */
@media (max-width: 991.98px) {
    .navbar-collapse {
        background-color: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        margin-top: 1rem;
        padding: 1.5rem;
        box-shadow: 0 10px 40px rgba(4, 65, 104, 0.15);
        border: 1px solid var(--border-light);
        animation: slideDown 0.3s ease-out;
    }

    .nav-link {
        padding: 1rem 1.5rem !important;
        margin: 0.25rem 0;
        border-radius: 15px;
        font-size: 1rem;
    }

    .nav-icon {
        font-size: 1.1rem;
        width: 24px;
        text-align: center;
    }

    .nav-divider {
        height: 1px;
        background: var(--border-color);
        margin: 1rem 0;
        border-radius: 1px;
    }

    .user-info {
        padding: 1rem 1.5rem !important;
        background-color: rgba(4, 65, 104, 0.05);
        border-radius: 15px;
        margin: 0.25rem 0;
        gap: 1rem;
    }

    .user-name {
        font-weight: 600;
        color: var(--text-primary);
    }

    .mobile-social-links {
        display: flex;
        justify-content: center;
        gap: 1rem;
        padding: 1rem 0;
    }

    .social-link {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--primary-gradient);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(4, 65, 104, 0.3);
    }

    .social-link:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(4, 65, 104, 0.4);
        color: white;
    }

    /* Hide brand tagline on small mobile */
    @media (max-width: 576px) {
        .brand-tagline {
            display: none;
        }
        
        .brand-main,
        .brand-accent {
            font-size: 1.3rem;
        }
    }
}

/* Slide down animation for mobile menu */
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Navbar scroll effect */
.navbar-scrolled {
    background-color: rgba(255, 255, 255, 0.98) !important;
    box-shadow: 0 8px 32px rgba(4, 65, 104, 0.15) !important;
}

/* Focus states for accessibility */
.nav-link:focus,
.dropdown-item:focus,
.mobile-menu-btn:focus {
    outline: 2px solid var(--accent);
    outline-offset: 2px;
}

/* High contrast mode adjustments */
@media (prefers-contrast: high) {
    .nav-link {
        border: 1px solid transparent;
    }
    
    .nav-link:hover,
    .nav-link.active {
        border-color: var(--accent);
    }
    
    .mobile-menu-btn {
        border: 1px solid var(--border-color);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.getElementById('mainNavbar');
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');

    // Navbar scroll effect
    function handleScroll() {
        if (window.scrollY > 50) {
            navbar.classList.add('navbar-scrolled');
        } else {
            navbar.classList.remove('navbar-scrolled');
        }
    }

    // Initial check
    handleScroll();
    
    // Add scroll event listener
    window.addEventListener('scroll', handleScroll, { passive: true });

    // Mobile menu toggle functionality
    navbarToggler.addEventListener('click', function() {
        const isExpanded = this.getAttribute('aria-expanded') === 'true';
        this.setAttribute('aria-expanded', !isExpanded);
        
        // Toggle body scroll when mobile menu is open
        if (!isExpanded) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    });

    // Close mobile menu when clicking a navigation link
    document.querySelectorAll('.navbar-nav .nav-link:not(.dropdown-toggle)').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 992 && navbarCollapse.classList.contains('show')) {
                navbarToggler.click(); // Trigger the toggle to close menu
                document.body.style.overflow = ''; // Restore body scroll
            }
        });
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        const isClickInsideNav = navbar.contains(event.target);
        const isNavOpen = navbarCollapse.classList.contains('show');
        
        if (!isClickInsideNav && isNavOpen && window.innerWidth < 992) {
            navbarToggler.click(); // Use the toggle button to close
            document.body.style.overflow = ''; // Restore body scroll
        }
    });

    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 992) {
            document.body.style.overflow = ''; // Restore body scroll on desktop
            navbarToggler.setAttribute('aria-expanded', 'false');
        }
    });

    // Enhanced hover effects for desktop
    if (window.innerWidth >= 992) {
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-1px)';
            });
            
            link.addEventListener('mouseleave', function() {
                if (!this.classList.contains('active')) {
                    this.style.transform = 'translateY(0)';
                }
            });
        });
    }

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const offsetTop = target.offsetTop - navbar.offsetHeight - 20;
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });
});
</script>