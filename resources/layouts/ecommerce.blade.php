<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
          @include('frontend.pages.component.seo-meta')
   <meta name="google-site-verification" content="nrKB4IF_xlFQCTdrXaaMfPmqdmOfksWKo3jF4-9S0tg" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Serif:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
 <link rel="icon" href="{{ asset('assets/images/avatars/apple-touch-icon.png') }}" type="image/png">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('front-end/assets/css/root/main.css') }}">
<link rel="stylesheet" href="{{ asset('front-end/assets/css/root/footer.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
<script src="{{ asset('front-end/assets/js/common/common.js') }}"></script>
<script src="https://cdn.superpayments.com/js/payment.js"></script>
<!-- Add this to your layout file (typically resources/views/layouts/app.blade.php) -->
<!-- Make sure this is in the <head> section -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-KXW3XCXP');</script>
    <!-- End Google Tag Manager -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-MHSEJ3J7PZ"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-MHSEJ3J7PZ');
    </script>
{{-- meta --}}
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '554816487680273');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=554816487680273&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
 <script type="text/javascript">
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "ru5uodx62e");
</script>

</head>
<body>
         <!-- Google Tag Manager (noscript) -->
         <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KXW3XCXP"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
            <!-- End Google Tag Manager (noscript) -->
<div class="wrapper">
@if(request()->is('/'))
        @include('partials.frontend.header')
     @else
        @include('partials.frontend.page-header')
    @endif
      <div class="page-wrapper">
        @yield('content')
    </div>

    @include('partials.frontend.script')
    @include('partials.frontend.footer')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    // For main nav
    let toggler = document.querySelector("#custom-open-btn");
    let navbarCollapse = document.querySelector("#navbarNav");
    if (toggler && navbarCollapse) {
        toggler.addEventListener("click", function() {
            navbarCollapse.classList.toggle("show");
        });
    }

    // For scrolled nav
    let togglerScrolled = document.querySelector("#custom-open-btn-scrolled");
    let navbarCollapseScrolled = document.querySelector("#navbarNavScrolled");
    if (togglerScrolled && navbarCollapseScrolled) {
        togglerScrolled.addEventListener("click", function() {
            navbarCollapseScrolled.classList.toggle("show");
        });
    }
});

</script>
</body>
</html>
