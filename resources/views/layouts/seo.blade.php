<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="icon" type="image/png" href="{{ asset('assets/logo/invidia-fav-icon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/logo/invidia-fav-icon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/logo/invidia-fav-icon.png') }}">
    <link rel="icon" sizes="32x32" type="image/png" href="{{ asset('assets/logo/invidia-fav-icon.png') }}">
    <link rel="icon" sizes="16x16" type="image/png" href="{{ asset('assets/logo/invidia-fav-icon.png') }}">
    <!-- Plugins CSS -->
    <link href="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/Backend/product.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/header-colors.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/Backend/dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/Backend/table.css') }}" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

<!-- Pusher and Echo Configuration -->
<script>
    window.appConfig = {
        pusherKey: "{{ env('PUSHER_APP_KEY') }}",
        pusherCluster: "{{ env('PUSHER_APP_CLUSTER') }}",
        broadcaster: "pusher" // Make sure this is explicitly set to "pusher"
    };
</script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<!-- DataTables Buttons and Dependencies -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <title>My Weightloss Centre</title>
</head>

<body>
<div class="wrapper">
@include('partials.seo.sidebar')
@include('partials.seo.header')
	<div class="page-wrapper">
        @yield('seo-content')
    </div>
    @include('partials.seo.footer')
</body>
</html>
