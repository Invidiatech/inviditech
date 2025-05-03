<!-- Navbar with Authentication Options -->
<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
    <div class="container">
        <a class="navbar-brand text-primary-custom" href="{{ route('home') }}">
            INVIDIA<span class="text-accent-custom">TECH</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
    <!-- Centered Nav Menu -->
    <ul class="navbar-nav mx-auto">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('services') ? 'active' : '' }}" href="{{ route('services') }}">Services</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('articles') || request()->routeIs('article.show') ? 'active' : '' }}" href="{{ route('articles') }}">Tutorial</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
        </li>
    </ul>

    <!-- Right Side - Auth Links -->
    <ul class="navbar-nav">
        @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">Register</a>
            </li>
        @else
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="{{ route('dashboard') }}" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li><a class="dropdown-item" href="#">My Bookmarks</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">Logout</button>
                        </form>
                    </li>
                </ul>
            </li>
        @endguest
        <li class="nav-item ms-lg-3">
            <a class="btn btn-accent-custom rounded-pill px-4" href="https://www.fiverr.com/sellers/muhammadnawa564/">Hire Us</a>
        </li>
    </ul>
</div>

    </div>
</nav>