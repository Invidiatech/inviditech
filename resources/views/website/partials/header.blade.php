<!-- Enhanced Professional Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow-lg" id="mainNavbar">
    <div class="container">
        <!-- Brand Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <div class="d-flex align-items-center">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-700 rounded-lg d-flex align-items-center justify-content-center me-3">
                    <span class="text-white fw-bold fs-5">A</span>
                </div>
                <div class="d-flex flex-column">
                    <span class="text-white small fw-medium">CODE WITH</span>
                    <span class="text-white fs-5 fw-bold">AHMED</span>
                </div>
            </div>
        </a>

        <!-- Right side buttons -->
        <div class="d-flex align-items-center order-lg-3">
            <!-- Theme Toggle -->
            <button id="themeToggle" class="btn btn-outline-light btn-sm me-3" onclick="toggleTheme()">
                <i id="themeIcon" class="fas fa-sun"></i>
            </button>
            
            <!-- User Profile -->
            <button class="btn btn-secondary btn-sm rounded-circle me-3">
                <i class="fas fa-user"></i>
            </button>
            
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
                        <span>Home</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('articles') || request()->routeIs('article.show') ? 'active' : '' }}" href="{{ route('articles') }}">
                        <span>Blog</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                        <span>About</span>
                    </a>
                </li>
            </ul>
        </div>

        </div>
    </div>
</nav>

<!-- Enhanced Navbar Styles -->
<style>
/* Enhanced Navbar Styling */
#mainNavbar {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    backdrop-filter: blur(20px);
    background-color: #1f2937 !important;
    border-bottom: 1px solid #374151;
    z-index: 1050;
}

#mainNavbar.scrolled {
    background-color: rgba(31, 41, 55, 0.98) !important;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3) !important;
}

/* Brand Logo Enhancements */
.navbar-brand {
    text-decoration: none;
    transition: transform 0.3s ease;
}

.navbar-brand:hover {
    transform: scale(1.05);
}

/* Enhanced Navigation Links */
.nav-link {
    font-weight: 500;
    color: #d1d5db !important;
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
    background: linear-gradient(135deg, #8b5cf6, #a855f7);
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

.nav-link:hover {
    color: #ffffff !important;
    background-color: rgba(139, 92, 246, 0.1);
    transform: translateY(-1px);
}

.nav-link.active {
    color: #ffffff !important;
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.1) 0%, rgba(168, 85, 247, 0.05) 100%);
    font-weight: 600;
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
    background-color: rgba(139, 92, 246, 0.1);
}

.line {
    width: 20px;
    height: 2px;
    background-color: #d1d5db;
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

/* Theme Toggle Button */
#themeToggle {
    border: 1px solid #6b7280;
    color: #d1d5db;
    transition: all 0.3s ease;
}

#themeToggle:hover {
    background-color: #374151;
    border-color: #8b5cf6;
    color: #ffffff;
}

/* Mobile Navigation Enhancements */
@media (max-width: 991.98px) {
    .navbar-collapse {
        background-color: rgba(31, 41, 55, 0.98);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        margin-top: 1rem;
        padding: 1.5rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        border: 1px solid #374151;
        animation: slideDown 0.3s ease-out;
    }

    .nav-link {
        padding: 1rem 1.5rem !important;
        margin: 0.25rem 0;
        border-radius: 15px;
        font-size: 1rem;
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

/* Focus states for accessibility */
.nav-link:focus,
#themeToggle:focus {
    outline: 2px solid #8b5cf6;
    outline-offset: 2px;
}
</style>

<script>
// Theme Toggle Functionality
function toggleTheme() {
    const body = document.body;
    const navbar = document.getElementById('mainNavbar');
    const themeIcon = document.getElementById('themeIcon');
    const themeToggle = document.getElementById('themeToggle');
    
    if (body.classList.contains('light-theme')) {
        // Switch to dark theme
        body.classList.remove('light-theme');
        body.classList.add('dark-theme');
        navbar.classList.remove('bg-white');
        navbar.classList.add('bg-dark');
        themeIcon.className = 'fas fa-moon';
        themeToggle.classList.remove('btn-outline-dark');
        themeToggle.classList.add('btn-outline-light');
        localStorage.setItem('theme', 'dark');
    } else {
        // Switch to light theme
        body.classList.remove('dark-theme');
        body.classList.add('light-theme');
        navbar.classList.remove('bg-dark');
        navbar.classList.add('bg-white');
        themeIcon.className = 'fas fa-sun';
        themeToggle.classList.remove('btn-outline-light');
        themeToggle.classList.add('btn-outline-dark');
        localStorage.setItem('theme', 'light');
    }
}

// Initialize theme on page load
document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    // Apply saved theme or system preference
    if (savedTheme === 'light' || (!savedTheme && !prefersDark)) {
        document.body.classList.add('light-theme');
        document.getElementById('mainNavbar').classList.add('bg-white');
        document.getElementById('themeIcon').className = 'fas fa-sun';
        document.getElementById('themeToggle').classList.add('btn-outline-dark');
    } else {
        document.body.classList.add('dark-theme');
        document.getElementById('mainNavbar').classList.add('bg-dark');
        document.getElementById('themeIcon').className = 'fas fa-moon';
        document.getElementById('themeToggle').classList.add('btn-outline-light');
    }
    
    const navbar = document.getElementById('mainNavbar');
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');

    // Navbar scroll effect
    function handleScroll() {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
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
});
</script>