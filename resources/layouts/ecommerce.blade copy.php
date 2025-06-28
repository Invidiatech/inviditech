<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weight Loss Journey</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('front-end/assets/css/main.css?v=5.3') }}">
    <link rel="stylesheet" href="{{ asset('front-end/assets/css/root/bmi.css') }}">
    <link rel="stylesheet" href="{{ asset('front-end/assets/css/root/header.css') }}">
    <link rel="stylesheet" href="{{ asset('front-end/assets/css/root/product.css') }}">
    <link rel="stylesheet" href="{{ asset('front-end/assets/css/root/recent-article.css') }}">
    <link rel="stylesheet" href="{{ asset('front-end/assets/css/root/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('front-end/assets/css/root/form.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
<div class="wrapper">
    @if(request()->is('/')) 
        @include('partials.frontend.header')
        @include('partials.frontend.sticky_header')
    @else
        @include('partials.frontend.page-header')
    @endif
    @include('partials.frontend.mobile_header')
    <div class="page-wrapper">
        @yield('content')
    </div>

    @include('partials.frontend.script')
    @include('partials.frontend.footer')
</div>

</body>
</html>
