@extends('website.layouts.app')
@section('title', 'Article - InvidiaTech')
@section('content')    
    <!-- Page Header -->
    <section class="page-header">
        <div class="page-header-pattern"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center animate">
                    <h1 class="fw-bold mb-4">Articles & Insights</h1>
                    <p class="lead mb-5">Explore our collection of in-depth articles, tutorials, and insights on Laravel, web development, and technology trends.</p>
                    <form action="{{ route('articles') }}" method="GET" class="search-box">
                        <input type="text" name="search" class="search-input" placeholder="Search articles..." value="{{ $search ?? '' }}">
                        <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Articles Section -->
    <section class="py-5 my-5">
        <div class="container">
            <div class="row">
                <!-- Articles Content -->
                <div class="col-lg-8">
                    <!-- Categories Filter -->
                    <div class="mb-4 animate">
                        <h6 class="mb-3">Filter by Category</h6>
                        <div class="d-flex flex-wrap">
                            <a href="{{ route('articles') }}" class="category-badge {{ !$categorySlug ? 'active' : '' }}">All</a>
                            @foreach($categories as $category)
                                <a href="{{ route('articles', ['category' => $category->slug]) }}" 
                                   class="category-badge {{ $categorySlug == $category->slug ? 'active' : '' }}">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    
                    @if($search)
                        <div class="alert alert-info">
                            Search results for: <strong>{{ $search }}</strong>
                            <a href="{{ route('articles') }}" class="float-end">Clear</a>
                        </div>
                    @endif
                    
                    <!-- Featured Article -->
                    @if($featuredArticle && !$search && !$categorySlug && !$tagSlug)
                        <div class="animate">
                            <div class="article-card mb-5">
                                <div class="row g-0">
                                    <div class="col-md-6">
                                        @if($featuredArticle->featured_image)
                                            <img src="{{ asset('storage/' . $featuredArticle->featured_image) }}" 
                                                 alt="{{ $featuredArticle->featured_image_alt ?? $featuredArticle->title }}" 
                                                 class="img-fluid h-100 w-100 object-fit-cover">
                                        @else
                                            <img src="/api/placeholder/600/400" alt="Featured Article" class="img-fluid h-100 w-100 object-fit-cover">
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-4">
                                            <div class="mb-2">
                                                @if($featuredArticle->category && is_object($featuredArticle->category))
                                                    <span class="article-tag tag-{{ strtolower($featuredArticle->category->slug ?? 'default') }}">{{ $featuredArticle->category->name }}</span>
                                                @endif
                                                @if($featuredArticle->tags)
                                                    @foreach($featuredArticle->tags as $tag)
                                                        <span class="article-tag tag-{{ strtolower($tag->slug ?? 'default') }}">{{ $tag->name }}</span>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <h3 class="mb-3">{{ $featuredArticle->title }}</h3>
                                            <p class="text-muted mb-3">{{ $featuredArticle->excerpt }}</p>
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <small class="text-muted"><i class="far fa-clock me-1"></i> {{ $featuredArticle->created_at->format('F d, Y') }}</small>
                                            </div>
                                            <a href="{{ route('article.show', $featuredArticle->slug) }}" class="btn btn-accent-custom rounded-pill px-4">Read More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Articles Grid -->
                    <div class="row">
                        @forelse($articles as $article)
                            <div class="col-md-6 mb-4 animate {{ $loop->index > 1 ? 'animate-delay-' . ($loop->index % 4) : '' }}">
                                <div class="article-card h-100">
                                    @if($article->featured_image)
                                        <img src="{{ asset('storage/' . $article->featured_image) }}" 
                                             alt="{{ $article->featured_image_alt ?? $article->title }}" 
                                             class="article-img">
                                    @else
                                        <img src="/api/placeholder/600/350" alt="{{ $article->title }}" class="article-img">
                                    @endif
                                    <div class="p-4">
                                        <div class="mb-2">
                                            @if($article->category && is_object($article->category))
                                                <a href="{{ route('articles', ['category' => $article->category->slug]) }}" 
                                                   class="article-tag tag-{{ strtolower($article->category->slug ?? 'default') }}">
                                                    {{ $article->category->name }}
                                                </a>
                                            @endif
                                            @if($article->tags)
                                                @foreach($article->tags->take(2) as $tag)
                                                    <a href="{{ route('articles', ['tag' => $tag->slug ?? '#']) }}" 
                                                       class="article-tag tag-{{ strtolower($tag->slug ?? 'default') }}">
                                                        {{ $tag->name }}
                                                    </a>
                                                @endforeach
                                            @endif
                                        </div>
                                        <h5 class="mb-3">{{ $article->title }}</h5>
                                        <p class="text-muted mb-3">{{ Str::limit($article->excerpt, 100) }}</p>
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <small class="text-muted"><i class="far fa-clock me-1"></i> {{ $article->created_at->format('F d, Y') }}</small>
                                            <small class="text-muted"><i class="far fa-eye me-1"></i> {{ number_format($article->views_count ?? 0) }}</small>
                                        </div>
                                        <a href="{{ route('article.show', $article->slug) }}" class="text-accent-custom fw-bold">Read more <i class="fas fa-arrow-right ms-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-info">
                                    No articles found. Please try a different search or category.
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($articles->hasPages())
                        <div class="d-flex justify-content-center mt-5">
                            {{ $articles->withQueryString()->links() }}
                        </div>
                    @endif
                   
                </div>
                
                <!-- Sidebar -->
                <div class="col-lg-4 sidebar">
                    <!-- Search Box -->
                    <div class="mb-4 animate">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="mb-3">Search</h5>
                                <form action="{{ route('articles') }}" method="GET" class="search-box">
                                    <input type="text" name="search" class="search-input" placeholder="Search articles..." value="{{ $search ?? '' }}">
                                    <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Subscribe Box -->
                    <div class="mb-4 animate animate-delay-1">
                        <div class="subscribe-box">
                            <h5 class="mb-3">Subscribe to Our Newsletter</h5>
                            <p class="mb-4">Get the latest articles and insights delivered directly to your inbox.</p>
                            <form action="" method="POST" class="input-group">
                                @csrf
                                <input type="email" name="email" class="form-control newsletter-input" placeholder="Your email address" required>
                                <button class="btn newsletter-btn text-white" type="submit">Subscribe</button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Categories -->
                    <div class="mb-4 animate animate-delay-2">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="mb-3">Categories</h5>
                                <ul class="list-group list-group-flush">
                                    @foreach($categories as $category)
                                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                            <a href="{{ route('articles', ['category' => $category->slug]) }}" 
                                               class="text-decoration-none text-primary-custom">
                                                {{ $category->name }}
                                            </a>
                                            <span class="badge bg-accent-custom rounded-pill">{{ $category->seo_blogs_count ?? $category->articles_count ?? 0 }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Trending Articles -->
                    <div class="mb-4 animate animate-delay-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="mb-3">Trending Articles</h5>
                                @foreach($trendingArticles as $trendingArticle)
                                    <div class="trending-article">
                                        @if($trendingArticle->featured_image)
                                            <img src="{{ asset('storage/' . $trendingArticle->featured_image) }}" 
                                                 alt="{{ $trendingArticle->featured_image_alt ?? $trendingArticle->title }}" 
                                                 class="trending-img">
                                        @else
                                            <img src="/api/placeholder/80/80" alt="{{ $trendingArticle->title }}" class="trending-img">
                                        @endif
                                        <div class="trending-content">
                                            <h6>
                                                <a href="{{ route('article.show', $trendingArticle->slug) }}" 
                                                   class="text-decoration-none text-primary-custom">
                                                    {{ $trendingArticle->title }}
                                                </a>
                                            </h6>
                                            <small class="text-muted">
                                                <i class="far fa-clock me-1"></i> {{ $trendingArticle->created_at->format('F d, Y') }}
                                            </small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tags Cloud -->
                    <div class="animate">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="mb-3">Popular Tags</h5>
                                <div class="d-flex flex-wrap">
                                    @foreach($popularTags as $tag)
                                        <a href="{{ route('articles', ['tag' => $tag->slug]) }}" 
                                           class="article-tag tag-{{ strtolower($tag->slug ?? 'default') }} m-1">
                                            {{ $tag->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
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
                    <h2 class="fw-bold mb-4">Want to Contribute?</h2>
                    <p class="lead mb-5">Share your knowledge with our community. We're looking for technical writers and experts to contribute articles.</p>
                    <a href="{{ route('contact') }}" class="btn btn-accent-custom btn-lg rounded-pill px-5">Get in Touch</a>
                </div>
            </div>
        </div>
    </section>
@endsection