<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
 
    <!-- App title -->
    <title>{{ $generaleSetting?->title ?? config('app.name', 'Laravel') }}</title>

    <!-- Meta -->
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <!-- Font-Awesome--Min-Css-Link -->
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">

    <!-- sweetalert css-->
    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.min.css') }}">

    <!-- Bootstrap--Min-Css-Link -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">

    <!-- quill css -->
    <link rel="stylesheet" href="{{ asset('assets/css/quill.snow.css') }}">

    <!-- Custom--Css-Link -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!--Responsive--Css-Link -->
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

    <!-- Toastr Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="{{ asset('assets/css/jquery.timepicker.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}" type="text/css">

    @stack('css')

    <style>
        .has-passport.fixed-header .app-header {
            top: 55px;
        }

        .has-passport.fixed-sidebar .app-main .app-main-outer {
            padding-top: 50px;
        }

        .has-passport.fixed-sidebar .app-sidebar {
            top: 80px;
            height: 100svh;
        }
    </style>
</head>

<body>
    <div class="app-container body-tabs-shadow fixed-sidebar fixed-header" id="appContent">
    <div class="app-header">
    <div class="app-header-logo"></div>
    <div class="app-header-mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header-menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="app-header-content">
        <!-- Header-left-Section -->
        <div class="app-header-left">
            <div class="header-pane">
                <div>
                    <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>

            <!-- Header-Text-Section -->
            <div class="header-text">
                <h4 class="mb-0 header-title">
                    Dashboard
                </h4>
                <p class="mb-0 header-subtitle">
                    Welcome to Your Dashboard
                </p>
            </div>
        </div>
        <!-- End-Header-Left-section -->

        <!-- Header-Right-Section -->
        <div class="app-header-right">
            <!-- search bar -->
            <div class="searchingBox">
                <div class="d-flex position-relative">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search Menu" autocomplete="off">
                    <span class="searchIcon"><i class="fa fa-search"></i></span>
                </div>
                <ul class="search-list" style="display: none"></ul>
            </div>
            <div class="badgeButtonBox me-1 me-md-3">
                <div id="searchBtn" class="notificationIcon">
                    <button type="button" class="emailBadge">
                        <img src="{{ asset('assets/icons-admin/search.svg') }}" alt="search" loading="lazy" />
                    </button>
                </div>
            </div>

            <!-- Theme dark and light -->
            <div class="badgeButtonBox me-1 me-md-3">
                <div class="notificationIcon" onclick="switchTheme()">
                    <button type="button" class="emailBadge">
                        <img class="lightModeIcon" src="{{ asset('assets/icons-admin/moon.svg') }}" alt="bell" loading="lazy" />
                        <img class="darkModeIcon" src="{{ asset('assets/icons-admin/sun.svg') }}" alt="bell" loading="lazy" />
                    </button>
                </div>
            </div>

            <!-- Notification Section -->
            <div class="badgeButtonBox me-1 me-md-3">
                <div class="notificationIcon">
                    <button type="button" class="emailBadge dropdown-toggle position-relative" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('assets/icons/bell-on.svg') }}" alt="bell" loading="lazy" />
                        <span class="position-absolute notificationCount" id="totalNotify">3</span>
                    </button>
                    <div class="dropdown-menu p-0 emailNotificationSection">
                        <div class="dropdown-item emailNotification">
                            <div class="emailHeader">
                                <h6 class="massTitle">
                                    Notifications
                                </h6>
                                <a href="#" class="text-dark">
                                    Marks all as read
                                </a>
                            </div>
                            <div class="message-section" id="notifications">
                                <a href="#" class="item d-flex gap-2 align-items-center">
                                    <div class="iconBox pdfIcon">
                                        <i class="bi bi-bell"></i>
                                    </div>
                                    <div class="notification w-100 unread">
                                        <div class="userName">
                                            <p class="massTitle">New Order Received</p>
                                            <span class="time">2 hours ago</span>
                                        </div>
                                        <div>
                                            <p class="description">You have received a new order #12345</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="item d-flex gap-2 align-items-center">
                                    <div class="iconBox cardIcon">
                                        <i class="bi bi-envelope"></i>
                                    </div>
                                    <div class="notification w-100">
                                        <div class="userName">
                                            <p class="massTitle">Message from Customer</p>
                                            <span class="time">Yesterday</span>
                                        </div>
                                        <div>
                                            <p class="description">John Doe sent you a message regarding order #12340</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="item d-flex gap-2 align-items-center">
                                    <div class="iconBox pdfIcon">
                                        <i class="bi bi-check-circle"></i>
                                    </div>
                                    <div class="notification w-100">
                                        <div class="userName">
                                            <p class="massTitle">Payment Successful</p>
                                            <span class="time">3 days ago</span>
                                        </div>
                                        <div>
                                            <p class="description">Payment for order #12339 was successful</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="emailFooter">
                                <a href="#" class="massPera text-dark">
                                    View All Notifications
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Language Dropdown -->
            <div class="user-profile-box dropdown mx-3">
                <div class="nav-profile-box dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="lang">
                        <img src="{{ asset('assets/icons-admin/Language.svg') }}" alt="icon" loading="lazy" />
                        <span>English</span>
                        <i class="fa-solid fa-angle-down dropIcon"></i>
                    </div>
                </div>

                <div class="dropdown-menu profile-item">
                    <a href="#" class="dropdown-item language-active">
                        <i class="fa fa-language mr-3"></i>
                        English
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="fa fa-language mr-3"></i>
                        Spanish
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="fa fa-language mr-3"></i>
                        French
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="fa fa-language mr-3"></i>
                        German
                    </a>
                </div>
            </div>

            <!-- User Profile Dropdown -->
            <div class="user-profile-box user-profile dropdown">
                <div class="nav-profile-box dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="profile-info">
                        <span class="name">John Doe</span>
                        <span class="role">Administrator</span>
                    </div>
                    <div class="profile-image">
                        <img class="profilePic" src="{{ asset('assets/icons/user.svg') }}" alt="profile" loading="lazy" />
                    </div>
                </div>

                <div class="dropdown-menu profile-item">
                    <a href="#" class="dropdown-item">
                        <img src="{{ asset('assets/icons-admin/user-circle.svg') }}" alt="user" loading="lazy" />
                        Profile
                    </a>
                    <a href="#" class="dropdown-item">
                        <img src="{{ asset('assets/icons-admin/settings.svg') }}" alt="setting" loading="lazy" />
                        Settings
                    </a>
                    <a href="#" class="dropdown-item">
                        <img src="{{ asset('assets/icons-admin/role-permission.svg') }}" alt="key" loading="lazy"/>
                        Change Password
                    </a>
                    <button class="dropdown-item cursor-pointer logout text-danger">
                        <img src="{{ asset('assets/icons-admin/log-out.svg') }}" alt="key" loading="lazy"/>
                        Logout
                    </button>
                </div>
            </div>
        </div>
        <!-- End-Header-Right-Section -->
    </div>
</div>

        <div class="app-main">
            @include('layouts.admin.sidebar')
            <div class="app-main-outer">
                <div class="app-main-inner">
                    <div class="container-fluid">
                        @yield('content')  <!-- Dynamic Content -->
                    </div>
                </div>
            </div>
        </div>
    </div>

  
    <script src="{{ asset('assets/scripts/jquery-3.6.3.min.js') }}"></script>
<!-- Bootstrap-Min-Bundil-Link -->
<script src="{{ asset('assets/scripts/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('assets/scripts/script.js') }}"></script>
<!-- Main-Script-Js-Link -->
<script src="{{ asset('assets/scripts/main.js') }}"></script>

<!-- Full-Screen-Js-Link -->
<script src="{{ asset('assets/scripts/full-screen.js') }}"></script>

<!--select2 -->
<script src="{{ asset('assets/scripts/select2.min.js') }}"></script>

<!-- sweetalert js-->
<script src="{{ asset('assets/scripts/sweetalert2.min.js') }}"></script>

<!-- quill  editor-->
<script src="{{ asset('assets/scripts/quill.js') }}"></script>

<script src="{{ asset('assets/scripts/jQuery.print.min.js') }}"></script>

<script src="{{ asset('assets/scripts/toastr.min.js') }}"></script>

<script src="{{ asset('assets/scripts/jquery.timepicker.min.js') }}"></script>
<script src="{{ asset('assets/scripts/jquery-ui.js') }}"></script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var themeColor = "{{ $generaleSetting?->primary_color ?? '#EE456B' }}";
            var themeHoverColor = "{{ $generaleSetting?->secondary_color ?? '#FEE5E8' }}";
            document.documentElement.style.setProperty('--theme-color', themeColor);
            document.documentElement.style.setProperty('--theme-hover-bg', themeHoverColor);

            // manage menu active svg color
            var svgImages = document.querySelectorAll(".menu.active .menu-icon");
            changeSvgImageColor(svgImages, themeColor);

            var selectedSvgImage;
            var svgColor;
            if (document.querySelectorAll(".btn-outline-primary img")) {
                selectedSvgImage = document.querySelectorAll(".btn-outline-primary img");
                svgColor = themeColor;
                changeSvgImageColor(selectedSvgImage, svgColor);
            }

            if (document.querySelectorAll(".btn-primary img")) {
                selectedSvgImage = document.querySelectorAll(".btn-primary img");
                svgColor = "#ffffff";
                changeSvgImageColor(selectedSvgImage, svgColor);
            }

            if (document.querySelectorAll(".btn-outline-info img")) {
                selectedSvgImage = document.querySelectorAll(".btn-outline-info img");
                svgColor = "#0ea5e9";
                changeSvgImageColor(selectedSvgImage, svgColor);
            }

            if (document.querySelectorAll(".btn-outline-warning img")) {
                selectedSvgImage = document.querySelectorAll(".btn-outline-warning img");
                svgColor = "#f97316";
                changeSvgImageColor(selectedSvgImage, svgColor);
            }

            if (document.querySelectorAll(".btn-danger img")) {
                selectedSvgImage = document.querySelectorAll(".btn-danger img");
                svgColor = "#ffffff";
                changeSvgImageColor(selectedSvgImage, svgColor);
            }

            if (document.querySelectorAll(".btn-outline-danger img")) {
                selectedSvgImage = document.querySelectorAll(".btn-outline-danger img");
                svgColor = "#ef4444";
                changeSvgImageColor(selectedSvgImage, svgColor);
            }

            if (document.querySelectorAll(".btn-outline-success img")) {
                selectedSvgImage = document.querySelectorAll(".btn-outline-success img");
                svgColor = "#059669";
                changeSvgImageColor(selectedSvgImage, svgColor);
            }

            if(document.querySelectorAll(".svg-bg img")){
                selectedSvgImage = document.querySelectorAll(".svg-bg img");
                svgColor = themeColor;
                changeSvgImageColor(selectedSvgImage, svgColor);
            }
        });

        function changeSvgImageColor(svgImages, svgColor, defaultColor = "#25314C") {
            svgImages.forEach(function(svgImage) {
                var svgPath = svgImage.getAttribute("src");
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var svgContent = xhr.responseText;

                        const strokeRegex = new RegExp(`stroke="${defaultColor}"`, 'g');
                        const fillRegex = new RegExp(`fill="${defaultColor}"`, 'g');

                        svgContent = svgContent.replace(strokeRegex, `stroke="${svgColor}"`);
                        svgContent = svgContent.replace(fillRegex, `fill="${svgColor}"`);

                        svgImage.src ="data:image/svg+xml;charset=utf-8," + encodeURIComponent(svgContent);
                    }
                };
                xhr.open("GET", svgPath, true);
                xhr.send();
            });
        }

        // Fetch Admin Notifications
        const fetchAdminNotifications = () => {
            $.ajax({
                type: 'GET',
                url: "",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'json',
                success: function(response) {
                    $('#totalNotify').text(response.data.total)
                    $('#notifications').empty()
                    $.each(response.data.notifications, function(key, value) {
                        var id = value.id;
                        var link = "";
                        link = link.replace(':id', id);
                        $('#notifications').append(
                            `<a href="${link}" class="item d-flex gap-2 align-items-center">
                            <div class="iconBox ${value.type == 'danger' ? 'cardIcon' : 'pdfIcon'}">
                                <i class="bi ${value.icon}"></i>
                            </div>
                            <div class="notification w-100 ${!value.is_read ? 'unread' : ''}">
                                <div class="userName">
                                    <p class="massTitle">${value.title} </p>
                                    <span class="time">${value.time}</span>
                                </div>
                                <div>
                                    <p class="description">${value.content}</p>
                                </div>
                            </div>
                        </a>`
                        );
                    })
                },
                error: function(e) {
                    $('#notifications').empty()
                    if (e.status == 401 || e.status == 403) {
                        $('#totalNotify').text(0)
                        $("#notifications").html("emply");
                    } else {
                        $("#notifications").html(e.responseText);
                    }
                }
            });
        }

        // fetch shop notifications
        const fetchShopNotifications = () => {
            $.ajax({
                type: 'GET',
                url: "",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'json',
                success: function(response) {
                    $('#totalNotify').text(response.data.total)
                    $('#notifications').empty()
                    $.each(response.data.notifications, function(key, value) {
                        var id = value.id;
                        var link = "";
                        link = link.replace(':id', id);
                        $('#notifications').append(
                            `<a href="${link}" class="item d-flex gap-2 align-items-center">
                            <div class="iconBox ${value.type == 'danger' ? 'cardIcon' : 'pdfIcon'}">
                                <i class="bi ${value.icon}"></i>
                            </div>
                            <div class="notification w-100 ${!value.is_read ? 'unread' : ''}">
                                <div class="userName">
                                    <p class="massTitle">${value.title} </p>
                                    <span class="time">${value.time}</span>
                                </div>
                                <div>
                                    <p class="description">${value.content}</p>
                                </div>
                            </div>
                        </a>`
                        );
                    })
                },
                error: function(e) {
                    $('#notifications').empty()
                    if (e.status == 401 || e.status == 403) {
                        $('#totalNotify').text(0)
                        $("#notifications").html("empty");
                    } else {
                        $("#notifications").html(e.responseText);
                    }
                }
            });
        }
    </script>

    <!-- Pusher Scripts -->
    <script>
        var pusher = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
            cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
        });

        var channel = pusher.subscribe('notification-channel');
    </script>

    <!-- Show Notifications Using Pusher JS -->

   

    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
    </script>

    @stack('scripts')

    @if (session('success'))
        <script>
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            })
        </script>
    @endif

    @if (session('error'))
        <script>
            Toast.fire({
                icon: 'error',
                title: "{{ session('error') }}"
            })
        </script>
    @endif

    @if (session('demoMode'))
        <script>
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "{{ session('demoMode') }}",
            });
        </script>
    @endif

    @if (session('alertError'))
        <script>
            Swal.fire({
                icon: "error",
                title: "Oops...",
                html: `{{ session('alertError')['message'] }} <br><br> {{ isset(session('alertError')['message2']) ? session('alertError')['message2'] : '' }}`,
            });
        </script>
    @endif

    <Script>
        document.addEventListener("DOMContentLoaded", function() {
            var root = document.documentElement;

            // Get the value of --theme-color
            var themeColor = getComputedStyle(root).getPropertyValue("--theme-color");

            $(".deleteConfirm").on("click", function(e) {
                e.preventDefault();
                const url = $(this).attr("href");
                Swal.fire({
                    title: "{{ __('Are you sure?') }}",
                    text: '{{ __('You will not be able to revert this!') }}',
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: themeColor,
                    cancelButtonColor: "#d33",
                    confirmButtonText: "{{ __('Yes, delete it!') }}",
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });

            $(".logout").on("click", function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "{{ __('Are you sure?') }}",
                    text: "{{ __('Are you sure you want to log out?') }}",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: themeColor,
                    cancelButtonColor: "#d33",
                    confirmButtonText: "{{ __('Yes, Logout!') }}",
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("logoutForm").submit();
                    }
                });
            });

            // form submit loader
            $('form').on('submit', function() {
                var submitButton = $(this).find('button[type="submit"]');

                submitButton.prop('disabled', true);
                submitButton.removeClass('px-5');

                submitButton.html(`<div class="d-flex align-items-center gap-1">
                    <div class="spinner-border spinner-border-sm" role="status"></div>
                    <span>Loading...</span>
                </div>`)
            });
        });
    </Script>

</body>

</html>

