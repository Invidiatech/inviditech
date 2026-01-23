<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'InvidiaTech') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('frontend/images/logo/invidiatehch-favicon.png') }}?v=2" title="InvidiaTech Favicon">
    <link rel="shortcut icon" type="image/png" href="{{ asset('frontend/images/logo/invidiatehch-favicon.png') }}?v=2" title="InvidiaTech Favicon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('frontend/images/logo/invidiatehch-favicon.png') }}?v=2" title="InvidiaTech App Icon">
    <link rel="icon" sizes="32x32" type="image/png" href="{{ asset('frontend/images/logo/invidiatehch-favicon.png') }}?v=2" title="InvidiaTech Favicon 32x32">
    <link rel="icon" sizes="16x16" type="image/png" href="{{ asset('frontend/images/logo/invidiatehch-favicon.png') }}?v=2" title="InvidiaTech Favicon 16x16">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    @stack('styles')

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js" defer></script>
    <script src="{{ asset('frontend/js/dashboard.js') }}" defer></script>
    <link rel="stylesheet" href="{{ asset('frontend/css/dashboard.css') }}">
    @stack('scripts')
    
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="dashboard-sidebar">
            <div class="sidebar-header">
                <a href="{{ route('home') }}" class="sidebar-logo">
                    INVIDIA<span class="text-accent-custom">TECH</span>
                </a>
                <button class="btn-close-sidebar d-lg-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="sidebar-user">
                <div class="user-avatar">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4299e1&color=fff" alt="{{ Auth::user()->name }}">
                </div>
                <div class="user-info">
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-email">{{ Auth::user()->email }}</div>
                </div>
            </div>
            
            <nav class="sidebar-nav">
                <ul>
                    <li class="nav-section">
                        <span class="nav-section-title">Main</span>
                    </li>
                    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}" class="nav-link">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('dashboard.profile') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.profile') }}" class="nav-link">
                            <i class="fas fa-user"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                    
                    <li class="nav-section">
                        <span class="nav-section-title">Content</span>
                    </li>
                    <li class="nav-item {{ request()->routeIs('dashboard.bookmarks') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.bookmarks') }}" class="nav-link">
                            <i class="fas fa-bookmark"></i>
                            <span>Bookmarks</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('dashboard.comments') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.comments') }}" class="nav-link">
                            <i class="fas fa-comments"></i>
                            <span>Comments</span>
                        </a>
                    </li>
                    
                    <li class="nav-section">
                        <span class="nav-section-title">Settings</span>
                    </li>
                    <li class="nav-item {{ request()->routeIs('dashboard.settings') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.settings') }}" class="nav-link">
                            <i class="fas fa-cog"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                </ul>
            </nav>
            
            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="dashboard-main">
            <!-- Top Navigation -->
            <nav class="dashboard-topbar">
                <button class="toggle-sidebar d-lg-none">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="d-flex align-items-center">
                    <h1 class="page-title mb-0">@yield('page-title')</h1>
                </div>
                
                <div class="topbar-actions">
                    <a href="{{ route('articles') }}" class="btn-icon" title="Browse Articles">
                        <i class="fas fa-newspaper"></i>
                    </a>
                    <a href="{{ route('home') }}" class="btn-icon" title="Go to Website">
                        <i class="fas fa-globe"></i>
                    </a>
                    <div class="dropdown">
                        <button class="btn-avatar" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4299e1&color=fff" alt="{{ Auth::user()->name }}">
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('dashboard.profile') }}">Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('dashboard.settings') }}">Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            
            <!-- Content -->
            <div class="dashboard-content">
                @if(session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>