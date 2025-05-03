<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'InvidiaTech - Professional Technical Solutions')</title>
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
    <script src="{{ asset('frontend/js/article-interactions.js') }}"></script>
    <script src="{{ asset('frontend/js/article-js..js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">


</head>
<body>
    @include('website.partials.header')
    
    @yield('content')
    
    @include('website.partials.footer')
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
 <!-- Bootstrap JS and dependencies -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
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