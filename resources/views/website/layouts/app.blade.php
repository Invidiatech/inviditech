<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Dynamic Title -->
    <title>
        @if(isset($article))
            {{ $article->meta_title ?: $article->title }} - InvidiaTech
        @elseif(View::hasSection('meta_title'))
            @yield('meta_title') - InvidiaTech
        @elseif(View::hasSection('title'))
            @yield('title') - InvidiaTech
        @else
            @yield('title', 'InvidiaTech - Professional Technical Solutions')
        @endif
    </title>
    
    <!-- Meta Description -->
    <meta name="description" content="@if(isset($article)){{ $article->meta_description ?: ($article->excerpt ?: Str::limit(strip_tags($article->content), 160)) }}@elseif(View::hasSection('meta_description'))@yield('meta_description')@else{{ 'Professional technical solutions and development services' }}@endif">
    
    <!-- Author and Publisher -->
    @if(isset($article))
    <meta name="author" content="InvidiaTech">
    <meta name="publisher" content="InvidiaTech">
    @endif
    
    <!-- Meta Keywords -->
    @if(isset($article) && $article->focus_keyword)
        <meta name="keywords" content="{{ $article->focus_keyword }}, Laravel, PHP, Web Development, Technical Solutions">
    @elseif(View::hasSection('meta_keywords'))
        <meta name="keywords" content="@yield('meta_keywords')">
    @else
        <meta name="keywords" content="Web Development, Laravel, PHP, Technical Solutions, Software Development">
    @endif
    
    <!-- Canonical URL -->
    @if(isset($article) && $article->canonical_url)
        <link rel="canonical" href="{{ $article->canonical_url }}">
    @else
        <link rel="canonical" href="{{ url()->current() }}">
    @endif
    
    <!-- Robots Meta -->
    @if(isset($article))
        <meta name="robots" content="{{ $article->is_indexed ? 'index,follow' : 'noindex,nofollow' }}">
    @else
        <meta name="robots" content="index,follow">
    @endif
    
    <!-- Open Graph Tags -->
    <meta property="og:title" content="@if(isset($article)){{ $article->og_title ?: ($article->meta_title ?: $article->title) }}@elseif(View::hasSection('meta_title'))@yield('meta_title')@elseif(View::hasSection('title'))@yield('title')@else{{ 'InvidiaTech - Professional Technical Solutions' }}@endif">
    <meta property="og:description" content="@if(isset($article)){{ $article->og_description ?: ($article->meta_description ?: ($article->excerpt ?: Str::limit(strip_tags($article->content), 160))) }}@elseif(View::hasSection('meta_description'))@yield('meta_description')@else{{ 'Professional technical solutions and development services' }}@endif">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="@if(isset($article))article@else website @endif">
    @if(isset($article) && $article->featured_image)
        <meta property="og:image" content="{{ asset('storage/' . $article->featured_image) }}">
    @elseif(isset($article) && $article->og_image)
        <meta property="og:image" content="{{ asset('storage/' . $article->og_image) }}">
    @else
        <meta property="og:image" content="{{ asset('assets/website/images/og-default.jpg') }}">
    @endif
    <meta property="og:site_name" content="InvidiaTech">
    
    <!-- Twitter Card Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@if(isset($article)){{ $article->twitter_title ?: ($article->meta_title ?: $article->title) }}@elseif(View::hasSection('meta_title'))@yield('meta_title')@elseif(View::hasSection('title'))@yield('title')@else{{ 'InvidiaTech - Professional Technical Solutions' }}@endif">
    <meta name="twitter:description" content="@if(isset($article)){{ $article->twitter_description ?: ($article->meta_description ?: ($article->excerpt ?: Str::limit(strip_tags($article->content), 160))) }}@elseif(View::hasSection('meta_description'))@yield('meta_description')@else{{ 'Professional technical solutions and development services' }}@endif">
    @if(isset($article) && $article->featured_image)
        <meta name="twitter:image" content="{{ asset('storage/' . $article->featured_image) }}">
    @elseif(isset($article) && $article->twitter_image)
        <meta name="twitter:image" content="{{ asset('storage/' . $article->twitter_image) }}">
    @else
        <meta name="twitter:image" content="{{ asset('assets/website/images/twitter-default.jpg') }}">
    @endif
    
    <!-- Article specific meta tags -->
    @if(isset($article))
    <meta property="article:published_time" content="{{ $article->publish_date ? $article->publish_date->toISOString() : $article->created_at->toISOString() }}">
    <meta property="article:modified_time" content="{{ $article->updated_at->toISOString() }}">
    <meta property="article:author" content="InvidiaTech">
    <meta property="article:section" content="{{ (is_object($article->category) ? $article->category->name : 'Technology') }}">
    @if($article->reading_time)
    <meta name="twitter:label1" content="Reading time">
    <meta name="twitter:data1" content="{{ $article->reading_time }} min read">
    @endif
     @if($article->tags->count())
    @foreach($article->tags as $tag)
    <meta property="article:tag" content="{{ $tag->name }}">
    @endforeach
    @endif
    @endif
    
    <!-- Schema.org JSON-LD -->
    @if(isset($article))
        @if($article->schema_markup)
        <script type="application/ld+json">
        {!! $article->schema_markup !!}
        </script>
        @else
        <script type="application/ld+json">
        {!! App\Helpers\SeoHelper::generateArticleSchema($article) !!}
        </script>
        @endif
    @else
        <!-- Website Schema -->
        <script type="application/ld+json">
        {!! App\Helpers\SeoHelper::generateWebsiteSchema() !!}
        </script>
    @endif

    @if(View::hasSection('schema_markup'))
        <script type="application/ld+json">
        @yield('schema_markup')
        </script>
    @endif
    
    <!-- Additional structured data for breadcrumbs -->
    @if(isset($article))
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [{
            "@type": "ListItem",
            "position": 1,
            "name": "Home",
            "item": "{{ url('/') }}"
        },{
            "@type": "ListItem",
            "position": 2,
            "name": "Blog",
            "item": "{{ route('articles') }}"
        },{
            "@type": "ListItem",
            "position": 3,
            "name": "{{ $article->title }}",
            "item": "{{ url()->current() }}"
        }]
    }
    </script>
    @endif
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('frontend/images/logo/invidiatehch-favicon.png') }}?v=2" title="InvidiaTech Favicon">
    <link rel="shortcut icon" type="image/png" href="{{ asset('frontend/images/logo/invidiatehch-favicon.png') }}?v=2" title="InvidiaTech Favicon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('frontend/images/logo/invidiatehch-favicon.png') }}?v=2" title="InvidiaTech App Icon">
    <link rel="icon" sizes="32x32" type="image/png" href="{{ asset('frontend/images/logo/invidiatehch-favicon.png') }}?v=2" title="InvidiaTech Favicon 32x32">
    <link rel="icon" sizes="16x16" type="image/png" href="{{ asset('frontend/images/logo/invidiatehch-favicon.png') }}?v=2" title="InvidiaTech Favicon 16x16">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    
    <!-- CSS Files -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('assets/website/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/website/css/services.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/website/css/article.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/website/css/hire-us.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/website/css/about-us.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/website/css/contact-us.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/website/css/article-detial.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Additional SEO Meta Tags -->
    <meta name="theme-color" content="#3b82f6">
    <meta name="msapplication-TileColor" content="#3b82f6">
    <meta name="msapplication-TileImage" content="{{ asset('frontend/images/logo/invidiatehch-favicon.png') }}?v=2">
    <meta name="application-name" content="InvidiaTech">
    <meta name="apple-mobile-web-app-title" content="InvidiaTech">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    
    <!-- Preconnect to external domains for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    
    <!-- DNS prefetch for better performance -->
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
    
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-P6QBNWXJ');</script>
    <!-- End Google Tag Manager -->
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P6QBNWXJ"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    
    @include('website.partials.header')
    
    @yield('content')
    
    @include('website.partials.footer')
    
    <!-- JavaScript Files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/js/article-interactions.js') }}"></script>
    <script src="{{ asset('frontend/js/article-js..js') }}"></script>
    
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('shadow');
                navbar.style.padding = '0.5rem 0';
            } else {
                navbar.classList.remove('shadow');
            }
        });
        
        // Animate elements on scroll
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };
        
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);
        
        document.querySelectorAll('.animate').forEach(item => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            item.style.transition = 'all 0.6s ease-out';
            observer.observe(item);
        });
    </script>
</body>
</html>