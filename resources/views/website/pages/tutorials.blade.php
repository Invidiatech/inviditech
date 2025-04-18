@extends('website.layouts.app')
@section('content')
<style>
        :root {
            --primary: #044168;
            --secondary: #0069AA;
            --accent: #00A9FF;
            --text-primary: #2C3E50;
            --border-color: #E5E9EF;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
            line-height: 1.6;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .tutorials-header {
            background-color: var(--primary);
            color: white;
            padding: 40px 0;
            position: relative;
            overflow: hidden;
        }
        
        .tutorials-header::before {
            content: '';
            position: absolute;
            right: -100px;
            top: -100px;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
        }
        
        .tutorials-header::after {
            content: '';
            position: absolute;
            bottom: -50px;
            left: 0;
            right: 0;
            height: 100px;
            background-color: white;
            transform: skewY(-3deg);
            z-index: 1;
        }
        
        .tutorials-header-content {
            position: relative;
            z-index: 2;
        }
        
        .breadcrumb {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0 0 20px 0;
            color: #044168;
        }
        
        .breadcrumb-item {
            display: flex;
            align-items: center;
            color:#044168;
        }
        
        .breadcrumb-item:not(:last-child)::after {
            content: '';
            margin: 0 0px;
            color: #044168;
        }
        
        .breadcrumb a {
            color: #044168;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .breadcrumb a:hover {
            color: #044168;
        }
        
        .page-title {
            font-size: 2.5rem;
            margin: 0;
            color: white;
        }
        
        .page-subtitle {
            color: rgba(255, 255, 255, 0.8);
            margin: 10px 0 0 0;
            font-size: 1.1rem;
            max-width: 600px;
        }
        
        .main-container {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 30px;
            position: relative;
            z-index: 2;
            margin-top: 30px;
        }
        
        .sidebar {
            position: sticky;
            top: 20px;
        }
        
        .sidebar-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            margin-bottom: 25px;
        }
        
        .sidebar-header {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            padding: 15px 20px;
            position: relative;
        }
        
        .sidebar-header h5 {
            margin: 0;
            font-size: 1.1rem;
        }
        
        .tech-list {
            list-style: none;
            padding: 15px;
            margin: 0;
        }
        
        .tech-list li {
            margin-bottom: 8px;
        }
        
        .tech-list a {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--text-primary);
            padding: 10px 15px;
            border-radius: 6px;
            transition: all 0.3s;
        }
        
        .tech-list a:hover {
            background-color: rgba(0, 105, 170, 0.1);
            color: var(--secondary);
        }
        
        .tech-list a.active {
            background-color: var(--secondary);
            color: white;
        }
        
        .tech-list a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }
        
        .service-box {
            padding: 20px;
        }
        
        .service-box h5 {
            color: var(--primary);
            margin-top: 0;
            position: relative;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        
        .service-box h5::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background-color: var(--accent);
            border-radius: 1.5px;
        }
        
        .service-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .service-item:last-child {
            margin-bottom: 0;
        }
        
        .service-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: rgba(0, 169, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--accent);
        }
        
        .service-text {
            font-weight: 500;
        }
        
        .main-content {
            min-width: 0;
        }
        
        .section-title {
            color: var(--primary);
            margin-top: 0;
            margin-bottom: 25px;
            font-size: 1.6rem;
            position: relative;
            padding-bottom: 10px;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background-color: var(--accent);
            border-radius: 2px;
        }
        
        .popular-tutorials {
            margin-bottom: 50px;
        }
        
        .tutorial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }
        
        .tutorial-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        
        .tutorial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .tutorial-header {
            padding: 20px;
            display: flex;
            align-items: flex-start;
            gap: 15px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .tech-icon {
            width: 50px;
            height: 50px;
            background-color: rgba(0, 105, 170, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--secondary);
            font-size: 1.5rem;
            flex-shrink: 0;
        }
        
        .tutorial-title {
            margin: 0;
            font-size: 1.1rem;
            line-height: 1.4;
            color: var(--primary);
        }
        
        .tutorial-body {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .tutorial-excerpt {
            color: var(--text-primary);
            margin: 0 0 15px 0;
            flex-grow: 1;
        }
        
        .tutorial-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            font-size: 0.85rem;
            color: #6c757d;
            margin-bottom: 15px;
        }
        
        .tutorial-meta span {
            display: flex;
            align-items: center;
        }
        
        .tutorial-meta i {
            margin-right: 5px;
        }
        
        .tutorial-link {
            display: inline-block;
            background-color: var(--primary);
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: background-color 0.3s;
            text-align: center;
        }
        
        .tutorial-link:hover {
            background-color: var(--secondary);
        }
        
        .latest-tutorials {
            margin-bottom: 50px;
        }
        
        .latest-list {
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        
        .latest-item {
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            transition: background-color 0.3s;
        }
        
        .latest-item:last-child {
            border-bottom: none;
        }
        
        .latest-item:hover {
            background-color: rgba(0, 105, 170, 0.05);
        }
        
        .latest-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .latest-title {
            margin: 0;
            font-size: 1.1rem;
            color: var(--primary);
        }
        
        .latest-date {
            font-size: 0.85rem;
            color: #6c757d;
        }
        
        .latest-excerpt {
            margin: 0;
            color: var(--text-primary);
        }
        
        .view-all {
            display: inline-block;
            background-color: white;
            color: var(--primary);
            border: 2px solid var(--primary);
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s;
            text-align: center;
            margin-top: 30px;
        }
        
        .view-all:hover {
            background-color: var(--primary);
            color: white;
        }
        
        .view-all i {
            margin-right: 5px;
        }
        
        .alert {
            padding: 20px;
            border-radius: 8px;
            background-color: rgba(0, 169, 255, 0.1);
            color: var(--secondary);
            margin-bottom: 25px;
        }
        
        .filters {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            padding: 15px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .filter-label {
            font-weight: 600;
            color: var(--primary);
        }
        
        .filter-options {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .filter-option {
            padding: 6px 15px;
            border-radius: 30px;
            background-color: #f8f9fa;
            color: var(--text-primary);
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.9rem;
        }
        
        .filter-option:hover {
            background-color: var(--border-color);
        }
        
        .filter-option.active {
            background-color: var(--primary);
            color: white;
        }
        
        @media (max-width: 991px) {
            .main-container {
                grid-template-columns: 1fr;
            }
            
            .sidebar {
                display: none;
            }
            
            .mobile-filters {
                display: block;
                margin-bottom: 25px;
            }
            
            .page-title {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 767px) {
            .tutorial-grid {
                grid-template-columns: 1fr;
            }
            
            .filters {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .filter-options {
                width: 100%;
            }
        }
    </style>
    <!-- Header Section -->
    <header class="tutorials-header">
        <div class="container">
            <div class="tutorials-header-content">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item" style="color:#044168 !important;">Laravel Tutorials</li>
                    </ol>
                </nav>
                <h1 class="page-title">Laravel Tutorials</h1>
                <p class="page-subtitle">Comprehensive guides to help you master Laravel framework from basics to advanced concepts.</p>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="main-container">
            <!-- Sidebar -->
            <aside class="sidebar">
                <div class="sidebar-card">
                    <div class="sidebar-header">
                        <h5>Laravel Topics</h5>
                    </div>
                    <ul class="tech-list">
                        @forelse($categories as $category)
                            <li>
                                <a href="{{ route('website.tutorials', ['topic' => $category->slug]) }}" 
                                   class="{{ $activeTopic === $category->slug ? 'active' : '' }}">
                                    @if($category->slug === 'laravel-basics')
                                        <i class="fab fa-laravel"></i>
                                    @elseif($category->slug === 'eloquent-orm')
                                        <i class="fas fa-database"></i>
                                    @elseif($category->slug === 'laravel-apis')
                                        <i class="fas fa-globe"></i>
                                    @elseif($category->slug === 'authentication')
                                        <i class="fas fa-lock"></i>
                                    @elseif($category->slug === 'middleware')
                                        <i class="fas fa-tools"></i>
                                    @elseif($category->slug === 'blade-templates')
                                        <i class="fas fa-file-alt"></i>
                                    @elseif($category->slug === 'laravel-packages')
                                        <i class="fas fa-boxes"></i>
                                    @elseif($category->slug === 'deployment')
                                        <i class="fas fa-server"></i>
                                    @else
                                        <i class="fab fa-laravel"></i>
                                    @endif
                                    {{ $category->name }}
                                </a>
                            </li>
                        @empty
                            <li><a href="#"><i class="fab fa-laravel"></i>No categories found</a></li>
                        @endforelse
                    </ul>
                </div>
                
                <div class="sidebar-card">
                {{-- <div class="sidebar-header">
                        <h5>Laravel Services</h5>
                    </div>
                  <div class="service-box">
                        @foreach($services as $service)
                            <div class="service-item">
                                <div class="service-icon">
                                    <i class="{{ $service['icon'] }}"></i>
                                </div>
                                <div class="service-text">{{ $service['name'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="sidebar-card">
                    <div class="sidebar-header">
                        <h5>Join Our Newsletter</h5>
                    </div>
                    <div class="service-box">
                        <p style="margin-top: 0; margin-bottom: 15px; color: var(--text-primary);">
                            Get the latest Laravel tips, tutorials, and updates directly to your inbox.
                        </p>
                        <form>
                            <div style="margin-bottom: 15px;">
                                <input type="email" placeholder="Your email address" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid var(--border-color); font-size: 0.9rem;">
                            </div>
                            <button type="submit" style="width: 100%; padding: 10px; background-color: var(--primary); color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 500; font-size: 0.9rem;">Subscribe</button>
                        </form>
                    </div>
                    --}}
                </div>
            </aside>

          <!-- Main Content -->
<main class="main-content">
    <!-- Filters (Mobile only) -->
    <div class="filters d-lg-none mobile-filters">
        <span class="filter-label">Topic:</span>
        <div class="filter-options">
            <span class="filter-option active">All</span>
            <span class="filter-option">Basics</span>
            <span class="filter-option">Eloquent</span>
            <span class="filter-option">APIs</span>
            <span class="filter-option">Authentication</span>
        </div>
    </div>

    <!-- Popular Tutorials -->
    <section class="popular-tutorials">
        <h2 class="section-title">
            @if($activeCategory)
                Popular {{ $activeCategory->name }} Tutorials
            @else
                Popular Laravel Tutorials
            @endif
        </h2>
        <div class="tutorial-grid">
            @forelse($popularTutorials as $tutorial)
                <div class="tutorial-card">
                    <div class="tutorial-header">
                        <div class="tech-icon">
                            @switch($tutorial->category->slug)
                                @case('eloquent-orm')<i class="fas fa-database"></i>@break
                                @case('laravel-apis')<i class="fas fa-globe"></i>@break
                                @case('authentication')<i class="fas fa-lock"></i>@break
                                @case('middleware')<i class="fas fa-tools"></i>@break
                                @case('blade-templates')<i class="fas fa-file-alt"></i>@break
                                @case('laravel-packages')<i class="fas fa-boxes"></i>@break
                                @case('deployment')<i class="fas fa-server"></i>@break
                                @default<i class="fab fa-laravel"></i>
                            @endswitch
                        </div>
                        <h3 class="tutorial-title">{{ $tutorial->title }}</h3>
                    </div>
                    <div class="tutorial-body">
                        <p class="tutorial-excerpt">{{ $tutorial->excerpt }}</p>
                        <div class="tutorial-meta">
                            <span><i class="fas fa-clock"></i> {{ $tutorial->reading_time }} min read</span>
                            <span><i class="fas fa-calendar"></i> {{ $tutorial->published_at->format('M d, Y') }}</span>
                        </div>
                        <a href="{{ route('website.blog.post', $tutorial->slug) }}" class="tutorial-link">Read Tutorial</a>
                    </div>
                </div>
            @empty
                <div class="alert alert-info w-100">
                    <p>No popular tutorials found. Check back soon for new content!</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Latest Tutorials -->
    <section class="latest-tutorials">
        <h2 class="section-title">
            @if($activeCategory)
                Latest {{ $activeCategory->name }} Tutorials
            @else
                Latest Laravel Tutorials
            @endif
        </h2>
        <div class="latest-list">
            @forelse($latestTutorials as $tutorial)
                <a href="{{ route('website.blog.post', $tutorial->slug) }}" class="latest-item">
                    <div class="latest-header">
                        <h3 class="latest-title">{{ $tutorial->title }}</h3>
                        <span class="latest-date">{{ $tutorial->published_at->diffForHumans() }}</span>
                    </div>
                    <p class="latest-excerpt">{{ $tutorial->excerpt }}</p>
                </a>
            @empty
                <div class="latest-item text-center">
                    <p>No tutorials found. Check back soon for new content!</p>
                </div>
            @endforelse
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ route('website.tutorials') }}" class="view-all">
                <i class="fas fa-th-list"></i> View All Tutorials
            </a>
        </div>
    </section>
</main>
        </div>
    </div>
    @endsection
    <script>
        // Reading Progress Bar
        window.addEventListener('scroll', function() {
            const totalHeight = document.body.scrollHeight - window.innerHeight;
            const progress = (window.scrollY / totalHeight) * 100;
            document.getElementById('readingProgressBar').style.width = progress + '%';
        });
    </script>
 
