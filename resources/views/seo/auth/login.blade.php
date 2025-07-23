<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
    <!-- Auth CSS -->
    <link href="{{ asset('assets/css/auth/login.css') }}" rel="stylesheet">
    <style>
        :root {
            --primary-color: #044168;
        }
        .left-panel {
            background-color: var(--primary-color);
        }
        .login-btn {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .login-btn:hover {
            background-color: #033454;
            border-color: #033454;
        }
        .forgot-link {
            color: var(--primary-color);
        }
        .forgot-link:hover {
            color: #033454;
        }
        .alert-info-custom {
            background-color: rgba(4, 65, 104, 0.1);
            border-color: var(--primary-color);
            color: var(--primary-color);
        }
    </style>
    <title>InvidiaTech Login</title>
</head>

<body>
    <div class="login-container">
        <!-- Left panel - Branding -->
        <div class="left-panel">
            <div class="left-content">
                <img src="{{ asset('assets/logo/lnvidiatech.png') }}" alt="InvidiaTech Logo" class="brand-logo">
                <h1>Welcome to InvidiaTech!</h1>
                <p>Log in to access your dashboard and manage your patients. We're committed to providing you with the best tools for patient care.</p>
            </div>
        </div>

        <!-- Right panel - Login form -->
        <div class="right-panel">
            <div class="login-header">
                <h2>InvidiaTech Login</h2>
                <p>Please enter your credentials to continue</p>
            </div>

            @if (session('status'))
                <div class="alert-custom alert-info-custom">
                    <div class="d-flex align-items-center">
                        <i class='bx bx-info-circle me-2'></i>
                        <div>{{ session('status') }}</div>
                    </div>
                </div>
            @endif

            <form class="login-form" method="POST" action="{{ route('seo.login') }}">
                @csrf
                <div class="form-group">
                    <i class='bx bx-envelope form-icon'></i>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                           id="email" name="email" value="{{ old('email') }}"
                           placeholder="Email Address" required autofocus autocomplete="username">
                    @error('email')
                        <span class="error-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <i class='bx bx-lock-alt form-icon'></i>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                           id="password" name="password" placeholder="Password" required autocomplete="current-password">
                    <span class="password-toggle" id="togglePassword">
                        <i class='bx bx-hide'></i>
                    </span>
                    @error('password')
                        <span class="error-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="login-options">
                    <div class="form-check d-none">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember"
                               {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            Remember me
                        </label>
                    </div>

                    @if (Route::has('seo.password.request'))
                        <a href="{{ route('seo.password.request') }}" class="forgot-link">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="login-btn">
                    <i class='bx bx-log-in-circle me-2'></i>Sign In
                </button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <!--Password show & hide js -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Toggle icon
                if (type === 'password') {
                    togglePassword.innerHTML = '<i class="bx bx-hide"></i>';
                } else {
                    togglePassword.innerHTML = '<i class="bx bx-show"></i>';
                }
            });
        });
    </script>
    <!--app JS-->
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>