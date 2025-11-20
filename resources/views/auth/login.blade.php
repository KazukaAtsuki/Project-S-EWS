<!DOCTYPE html>
<html lang="en" class="light-style" dir="ltr" data-theme="theme-default">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - CEMS Early Warning System</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" />

    <style>
        :root {
            --samu-yellow: #E5B93D;
            --samu-blue: #2E6FA8;
            --samu-cyan: #42C8DD;
        }

        body {
            background: linear-gradient(135deg, var(--samu-blue) 0%, var(--samu-cyan) 100%);
            min-height: 100vh;
            font-family: 'Public Sans', sans-serif;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
        }

        .login-left {
            background: linear-gradient(135deg, var(--samu-blue) 0%, var(--samu-cyan) 100%);
            padding: 60px 40px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .logo-circle {
            width: 120px;
            height: 120px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .logo-circle img {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }

        .login-right {
            padding: 60px 50px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--samu-blue) 0%, var(--samu-cyan) 100%);
            border: none;
            padding: 12px;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(66, 200, 221, 0.4);
        }

        .form-control {
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            padding: 12px 15px;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--samu-cyan);
            box-shadow: 0 0 0 0.2rem rgba(66, 200, 221, 0.25);
        }

        .input-group-text {
            border-radius: 0 10px 10px 0;
            border: 2px solid #e0e0e0;
            border-left: none;
            background: white;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: var(--samu-cyan);
            border-color: var(--samu-cyan);
        }

        .alert {
            border-radius: 10px;
            border: none;
        }

        .decoration-dots {
            position: absolute;
            width: 100px;
            height: 100px;
            opacity: 0.1;
        }

        .dots-top-right {
            top: 20px;
            right: 20px;
        }

        .dots-bottom-left {
            bottom: 20px;
            left: 20px;
        }

        @media (max-width: 768px) {
            .login-left {
                display: none;
            }

            .login-right {
                padding: 40px 30px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <div class="row g-0">
                <!-- Left Side - Branding -->
                <div class="col-lg-5 login-left position-relative">
                    <!-- Decorative Dots -->
                    <div class="decoration-dots dots-top-right">
                        <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="10" cy="10" r="3" fill="white"/>
                            <circle cx="30" cy="10" r="3" fill="white"/>
                            <circle cx="50" cy="10" r="3" fill="white"/>
                            <circle cx="70" cy="10" r="3" fill="white"/>
                            <circle cx="10" cy="30" r="3" fill="white"/>
                            <circle cx="30" cy="30" r="3" fill="white"/>
                            <circle cx="50" cy="30" r="3" fill="white"/>
                            <circle cx="70" cy="30" r="3" fill="white"/>
                        </svg>
                    </div>

                    <div class="logo-circle">
                        <img src="{{ asset('assets/img/logo-samu.png') }}" alt="SAMU Logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                        <i class='bx bx-shield-quarter' style="font-size: 60px; color: var(--samu-blue); display: none;"></i>
                    </div>

                    <h2 class="fw-bold mb-3">CEMS</h2>
                    <h5 class="mb-4">Early Warning System</h5>
                    <p class="mb-0" style="opacity: 0.9;">Monitoring and managing environmental compliance in real-time</p>

                    <!-- Decorative Dots -->
                    <div class="decoration-dots dots-bottom-left">
                        <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="30" cy="70" r="3" fill="white"/>
                            <circle cx="50" cy="70" r="3" fill="white"/>
                            <circle cx="70" cy="70" r="3" fill="white"/>
                            <circle cx="90" cy="70" r="3" fill="white"/>
                            <circle cx="30" cy="90" r="3" fill="white"/>
                            <circle cx="50" cy="90" r="3" fill="white"/>
                            <circle cx="70" cy="90" r="3" fill="white"/>
                            <circle cx="90" cy="90" r="3" fill="white"/>
                        </svg>
                    </div>
                </div>

                <!-- Right Side - Login Form -->
                <div class="col-lg-7 login-right">
                    <div class="mb-4">
                        <h3 class="fw-bold mb-2">Welcome back! 👋</h3>
                        <p class="text-muted">Please sign in to your account and start the adventure</p>
                    </div>

                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center">
                            <i class='bx bx-error-circle me-2' style="font-size: 20px;"></i>
                            <div class="flex-grow-1">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0 bg-white" style="border-radius: 10px 0 0 10px; border: 2px solid #e0e0e0; border-right: none;">
                                    <i class='bx bx-envelope' style="color: var(--samu-cyan);"></i>
                                </span>
                                <input type="email"
                                       class="form-control border-start-0 @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       placeholder="Enter your email"
                                       value="{{ old('email') }}"
                                       style="border-left: none;"
                                       autofocus
                                       required>
                            </div>
                            @error('email')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0 bg-white" style="border-radius: 10px 0 0 10px; border: 2px solid #e0e0e0; border-right: none;">
                                    <i class='bx bx-lock-alt' style="color: var(--samu-cyan);"></i>
                                </span>
                                <input type="password"
                                       id="password"
                                       class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror"
                                       name="password"
                                       placeholder="Enter your password"
                                       style="border-left: none; border-right: none;"
                                       required />
                                <span class="input-group-text bg-white" onclick="togglePassword()" style="cursor: pointer;">
                                    <i class='bx bx-hide' id="toggleIcon"></i>
                                </span>
                            </div>
                            @error('password')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember" />
                                <label class="form-check-label" for="remember">
                                    Remember me for 30 days
                                </label>
                            </div>
                        </div>

                        <div class="d-grid mb-4">
                            <button class="btn btn-primary btn-lg" type="submit">
                                <i class='bx bx-log-in me-2'></i>Sign In
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="text-muted mb-0">
                                Need help?
                                <a href="#" class="fw-semibold text-decoration-none" style="color: var(--samu-cyan);">
                                    Contact Administrator
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Core JS -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>

    <!-- Show/Hide Password -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bx-hide');
                toggleIcon.classList.add('bx-show');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bx-show');
                toggleIcon.classList.add('bx-hide');
            }
        }
    </script>
</body>
</html>