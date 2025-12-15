<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Raja Blind Van</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }

        .login-header .logo {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 40px;
            color: #667eea;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .login-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .login-header p {
            font-size: 14px;
            opacity: 0.9;
            margin: 0;
        }

        .login-body {
            padding: 40px 30px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-label i {
            color: #667eea;
            font-size: 16px;
        }

        .form-control {
            padding: 12px 16px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1);
        }

        .invalid-feedback {
            display: block;
            margin-top: 8px;
            font-size: 13px;
            color: #dc3545;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .form-check-label {
            font-size: 14px;
            color: #666;
            cursor: pointer;
            user-select: none;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .alert {
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 20px;
            border: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .login-footer {
            padding: 20px 30px;
            background: #f8f9fa;
            text-align: center;
            font-size: 13px;
            color: #666;
        }

        .password-toggle {
            position: relative;
        }

        .password-toggle-btn {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #999;
            cursor: pointer;
            padding: 0;
            font-size: 16px;
        }

        .password-toggle-btn:hover {
            color: #667eea;
        }

        /* Loading Screen Styles */
        .loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            overflow: hidden;
        }

        .loading-screen.active {
            display: flex;
        }

        .loading-content {
            text-align: center;
            color: white;
            width: 100%;
            max-width: 500px;
            padding: 20px;
        }

        /* Road Scene Container */
        .road-scene {
            width: 100%;
            height: 200px;
            position: relative;
            margin-bottom: 30px;
            perspective: 200px;
        }

        /* Sky with moving clouds */
        .sky {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 60%;
            background: linear-gradient(to bottom, #1a1a2e 0%, #2d3561 100%);
            overflow: hidden;
        }

        .stars {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .star {
            position: absolute;
            width: 3px;
            height: 3px;
            background: white;
            border-radius: 50%;
            animation: twinkle 2s infinite;
        }

        .star:nth-child(1) { top: 10%; left: 20%; animation-delay: 0s; }
        .star:nth-child(2) { top: 25%; left: 45%; animation-delay: 0.3s; }
        .star:nth-child(3) { top: 15%; left: 70%; animation-delay: 0.6s; }
        .star:nth-child(4) { top: 30%; left: 85%; animation-delay: 0.9s; }
        .star:nth-child(5) { top: 8%; left: 55%; animation-delay: 1.2s; }
        .star:nth-child(6) { top: 35%; left: 30%; animation-delay: 0.4s; }
        .star:nth-child(7) { top: 20%; left: 10%; animation-delay: 0.7s; }

        @keyframes twinkle {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.3; transform: scale(0.5); }
        }

        /* Moon */
        .moon {
            position: absolute;
            top: 15px;
            right: 40px;
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
            border-radius: 50%;
            box-shadow: 0 0 30px rgba(255, 255, 200, 0.5);
        }

        /* Road */
        .road {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 50%;
            background: linear-gradient(to bottom, #2c3e50 0%, #1a252f 100%);
            border-top: 4px solid #f1c40f;
        }

        /* Road markings */
        .road-markings {
            position: absolute;
            bottom: 20%;
            left: 0;
            width: 200%;
            height: 8px;
            display: flex;
            animation: roadMove 0.8s linear infinite;
        }

        .marking {
            width: 60px;
            height: 100%;
            background: white;
            margin-right: 40px;
            border-radius: 2px;
        }

        @keyframes roadMove {
            0% { transform: translateX(0); }
            100% { transform: translateX(-100px); }
        }

        /* Van Container */
        .van-container {
            position: absolute;
            bottom: 35px;
            left: 50%;
            transform: translateX(-50%);
            animation: vanBounce 0.3s ease-in-out infinite;
        }

        @keyframes vanBounce {
            0%, 100% { transform: translateX(-50%) translateY(0); }
            50% { transform: translateX(-50%) translateY(-4px); }
        }

        /* Van SVG Style */
        .van-svg {
            width: 140px;
            height: 80px;
            filter: drop-shadow(0 10px 20px rgba(0,0,0,0.4));
        }

        /* Wheels */
        .wheel {
            animation: wheelSpin 0.3s linear infinite;
            transform-origin: center;
        }

        @keyframes wheelSpin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Headlights glow */
        .headlight-glow {
            position: absolute;
            right: -30px;
            bottom: 25px;
            width: 80px;
            height: 30px;
            background: linear-gradient(to right, rgba(255,255,150,0.6), transparent);
            filter: blur(10px);
            animation: headlightFlicker 0.5s ease-in-out infinite;
        }

        @keyframes headlightFlicker {
            0%, 100% { opacity: 0.8; }
            50% { opacity: 1; }
        }

        /* Exhaust smoke */
        .smoke-container {
            position: absolute;
            left: -20px;
            bottom: 15px;
        }

        .smoke {
            position: absolute;
            width: 15px;
            height: 15px;
            background: rgba(200, 200, 200, 0.6);
            border-radius: 50%;
            animation: smokeRise 1s ease-out infinite;
        }

        .smoke:nth-child(1) { animation-delay: 0s; }
        .smoke:nth-child(2) { animation-delay: 0.2s; left: 5px; }
        .smoke:nth-child(3) { animation-delay: 0.4s; left: -5px; }

        @keyframes smokeRise {
            0% {
                opacity: 0.8;
                transform: translateY(0) translateX(0) scale(0.5);
            }
            50% {
                opacity: 0.4;
            }
            100% {
                opacity: 0;
                transform: translateY(-40px) translateX(-30px) scale(1.5);
            }
        }

        /* Speed lines */
        .speed-lines {
            position: absolute;
            left: 0;
            bottom: 50px;
            width: 100%;
            height: 40px;
            overflow: hidden;
        }

        .speed-line {
            position: absolute;
            height: 2px;
            background: linear-gradient(to left, rgba(255,255,255,0.5), transparent);
            animation: speedLine 0.5s linear infinite;
        }

        .speed-line:nth-child(1) { top: 10px; width: 40px; animation-delay: 0s; }
        .speed-line:nth-child(2) { top: 20px; width: 60px; animation-delay: 0.15s; }
        .speed-line:nth-child(3) { top: 30px; width: 35px; animation-delay: 0.3s; }

        @keyframes speedLine {
            0% { left: 40%; opacity: 1; }
            100% { left: -20%; opacity: 0; }
        }

        /* Progress bar */
        .progress-container {
            width: 100%;
            height: 6px;
            background: rgba(255,255,255,0.2);
            border-radius: 3px;
            overflow: hidden;
            margin-top: 30px;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #667eea, #764ba2, #667eea);
            background-size: 200% 100%;
            border-radius: 3px;
            animation: progressMove 2s ease-in-out infinite, progressGradient 1s linear infinite;
            width: 0%;
        }

        @keyframes progressMove {
            0% { width: 0%; }
            50% { width: 70%; }
            100% { width: 100%; }
        }

        @keyframes progressGradient {
            0% { background-position: 0% 50%; }
            100% { background-position: 200% 50%; }
        }

        .loading-text {
            font-size: 22px;
            font-weight: 600;
            margin-top: 25px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        .loading-subtext {
            font-size: 14px;
            opacity: 0.7;
            margin-top: 8px;
        }

        .loading-dots {
            display: inline-block;
        }

        .loading-dots::after {
            content: '';
            animation: dots 1.5s steps(4, end) infinite;
        }

        @keyframes dots {
            0%, 20% { content: ''; }
            40% { content: '.'; }
            60% { content: '..'; }
            80%, 100% { content: '...'; }
        }
    </style>
</head>
<body>
    <!-- Loading Screen -->
    <div class="loading-screen" id="loadingScreen">
        <div class="loading-content">
            <!-- Road Scene with Van Animation -->
            <div class="road-scene">
                <!-- Sky with stars -->
                <div class="sky">
                    <div class="stars">
                        <div class="star"></div>
                        <div class="star"></div>
                        <div class="star"></div>
                        <div class="star"></div>
                        <div class="star"></div>
                        <div class="star"></div>
                        <div class="star"></div>
                    </div>
                    <div class="moon"></div>
                </div>

                <!-- Road with markings -->
                <div class="road">
                    <div class="road-markings">
                        <div class="marking"></div>
                        <div class="marking"></div>
                        <div class="marking"></div>
                        <div class="marking"></div>
                        <div class="marking"></div>
                        <div class="marking"></div>
                        <div class="marking"></div>
                        <div class="marking"></div>
                        <div class="marking"></div>
                        <div class="marking"></div>
                    </div>
                </div>

                <!-- Speed Lines -->
                <div class="speed-lines">
                    <div class="speed-line"></div>
                    <div class="speed-line"></div>
                    <div class="speed-line"></div>
                </div>

                <!-- Van -->
                <div class="van-container">
                    <!-- Headlight glow -->
                    <div class="headlight-glow"></div>

                    <!-- Exhaust smoke -->
                    <div class="smoke-container">
                        <div class="smoke"></div>
                        <div class="smoke"></div>
                        <div class="smoke"></div>
                    </div>

                    <!-- Van SVG -->
                    <svg class="van-svg" viewBox="0 0 140 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Van Body -->
                        <rect x="10" y="25" width="95" height="40" rx="5" fill="#3498db"/>
                        <rect x="10" y="25" width="95" height="40" rx="5" fill="url(#vanGradient)"/>

                        <!-- Cabin -->
                        <path d="M105 35 L105 65 L130 65 L130 45 L115 35 Z" fill="#2980b9"/>
                        <path d="M107 37 L107 50 L125 50 L125 45 L115 37 Z" fill="#87CEEB" opacity="0.8"/>

                        <!-- Windows -->
                        <rect x="15" y="30" width="20" height="15" rx="2" fill="#87CEEB" opacity="0.8"/>
                        <rect x="40" y="30" width="20" height="15" rx="2" fill="#87CEEB" opacity="0.8"/>
                        <rect x="65" y="30" width="20" height="15" rx="2" fill="#87CEEB" opacity="0.8"/>

                        <!-- Stripe -->
                        <rect x="10" y="50" width="95" height="5" fill="#e74c3c"/>

                        <!-- Headlights -->
                        <circle cx="128" cy="55" r="4" fill="#f1c40f"/>
                        <circle cx="128" cy="55" r="6" fill="#f1c40f" opacity="0.3"/>

                        <!-- Tail lights -->
                        <rect x="10" y="52" width="4" height="8" rx="1" fill="#e74c3c"/>

                        <!-- Wheels -->
                        <g class="wheel">
                            <circle cx="35" cy="65" r="12" fill="#2c3e50"/>
                            <circle cx="35" cy="65" r="8" fill="#7f8c8d"/>
                            <circle cx="35" cy="65" r="3" fill="#2c3e50"/>
                            <rect x="33" y="57" width="4" height="16" fill="#95a5a6" opacity="0.5"/>
                            <rect x="27" y="63" width="16" height="4" fill="#95a5a6" opacity="0.5"/>
                        </g>
                        <g class="wheel">
                            <circle cx="95" cy="65" r="12" fill="#2c3e50"/>
                            <circle cx="95" cy="65" r="8" fill="#7f8c8d"/>
                            <circle cx="95" cy="65" r="3" fill="#2c3e50"/>
                            <rect x="93" y="57" width="4" height="16" fill="#95a5a6" opacity="0.5"/>
                            <rect x="87" y="63" width="16" height="4" fill="#95a5a6" opacity="0.5"/>
                        </g>

                        <!-- Logo on van -->
                        <text x="50" y="48" font-size="8" fill="white" font-weight="bold">RAJA</text>

                        <!-- Gradient definition -->
                        <defs>
                            <linearGradient id="vanGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" stop-color="#3498db"/>
                                <stop offset="100%" stop-color="#2980b9"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="progress-container">
                <div class="progress-bar"></div>
            </div>

            <!-- Loading Text -->
            <div class="loading-text">
                <i class="fas fa-van-shuttle"></i> Loading Dashboard<span class="loading-dots"></span>
            </div>
            <div class="loading-subtext">Preparing your fleet management system</div>
        </div>
    </div>

    <div class="login-container">
        <div class="login-header">
            <div class="logo">
                <i class="fas fa-van-shuttle"></i>
            </div>
            <h1>Raja Blind Van</h1>
            <p>Vehicle Dashboard Management System</p>
        </div>

        <div class="login-body">
            @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                @if($errors->has('email'))
                    {{ $errors->first('email') }}
                @else
                    {{ $errors->first() }}
                @endif
            </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" id="loginForm">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope"></i>
                        Email Address
                    </label>
                    <input type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="Enter your email"
                           required
                           autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock"></i>
                        Password
                    </label>
                    <div class="password-toggle">
                        <input type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               id="password"
                               name="password"
                               placeholder="Enter your password"
                               required>
                        <button type="button" class="password-toggle-btn" onclick="togglePassword()">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">
                        Remember me
                    </label>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i>
                    Login
                </button>
            </form>
        </div>

        <div class="login-footer">
            © {{ date('Y') }} Raja Blind Van. All rights reserved.
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Show loading screen on form submit
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.querySelector('form');
            const loadingScreen = document.getElementById('loadingScreen');

            // Clear any previous session data
            localStorage.removeItem('shouldBeLoggedIn');
            localStorage.removeItem('closingTabs');
            sessionStorage.clear();

            loginForm.addEventListener('submit', function(e) {
                // Mark that user should be logged in
                localStorage.setItem('shouldBeLoggedIn', 'true');

                // Show loading screen
                loadingScreen.classList.add('active');
            });
        });
    </script>
</body>
</html>
