<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Raja Fleet | Vehicle Management System</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/logos/brands/Raja-Fleet-Transparan.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/logos/brands/Raja-Fleet-Transparan.png') }}">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 & Font Awesome 6 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- DotLottie Player -->
    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>

    <style>
        :root {
            --brand-primary: #0B4DB7;
            --brand-primary-hover: #083D93;
            --brand-secondary: #00A3FF;
            --brand-accent: #38BDF8;
            --navy-dark: #071933;
            --navy-surface: #0C2340;
            --text-main: #0F172A;
            --text-muted: #64748B;
            --text-light: #94A3B8;
            --border-color: #E2E8F0;
            --bg-light: #F8FAFC;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        html, body {
            min-height: 100%;
        }

        body {
            min-height: 100vh;
            background-color: var(--navy-dark);
            color: var(--text-main);
            overflow-x: hidden;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        /* Ambient Glowing Background Mesh */
        .ambient-glow {
            position: fixed;
            border-radius: 50%;
            filter: blur(140px);
            opacity: 0.22;
            pointer-events: none;
            z-index: 0;
        }
        .glow-1 {
            width: 550px;
            height: 550px;
            background: #00A3FF;
            top: -120px;
            left: -120px;
        }
        .glow-2 {
            width: 650px;
            height: 650px;
            background: #0B4DB7;
            bottom: -150px;
            right: -100px;
        }

        /* Main Wrapper */
        .auth-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            margin: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
        }

        .auth-card {
            width: 100%;
            max-width: 1100px;
            background: #FFFFFF;
            border-radius: 26px;
            box-shadow: 0 30px 80px -20px rgba(0, 15, 45, 0.6), 0 0 0 1px rgba(255, 255, 255, 0.08);
            display: flex;
            overflow: hidden;
            animation: fadeInScale 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.97) translateY(16px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        /* ================= Left Form Section ================= */
        .auth-form-side {
            flex: 1.1;
            padding: 42px 46px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: #FFFFFF;
            position: relative;
        }

        .brand-top-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .brand-logo-wrap {
            display: inline-flex;
            align-items: center;
            text-decoration: none;
        }

        .brand-logo-img {
            height: 44px;
            width: auto;
            object-fit: contain;
            transition: transform 0.25s ease;
        }

        .brand-logo-img:hover {
            transform: scale(1.03);
        }

        .portal-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 5px 12px;
            background: rgba(11, 77, 183, 0.07);
            border: 1px solid rgba(11, 77, 183, 0.15);
            border-radius: 50px;
            font-size: 11.5px;
            font-weight: 600;
            color: var(--brand-primary);
            letter-spacing: 0.2px;
        }

        .pulse-indicator {
            width: 7px;
            height: 7px;
            background: #10B981;
            border-radius: 50%;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            animation: pulseGreen 2s infinite;
        }

        @keyframes pulseGreen {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .auth-heading-block {
            margin-bottom: 22px;
        }

        .auth-title {
            font-size: 26px;
            font-weight: 800;
            color: #0F172A;
            letter-spacing: -0.6px;
            margin-bottom: 6px;
            line-height: 1.25;
        }

        .auth-subtitle {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.5;
            margin-bottom: 0;
        }

        /* Form Controls */
        .form-floating-custom {
            margin-bottom: 18px;
        }

        .form-label-custom {
            display: block;
            font-size: 13.5px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        .input-group-custom {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon-left {
            position: absolute;
            left: 18px;
            color: #94A3B8;
            font-size: 15px;
            transition: color 0.2s ease;
            pointer-events: none;
            z-index: 2;
        }

        .input-custom {
            width: 100%;
            height: 52px;
            padding: 12px 18px 12px 48px;
            background: #F8FAFC;
            border: 1.5px solid #E2E8F0;
            border-radius: 14px;
            font-size: 14.5px;
            font-weight: 500;
            color: #1E293B;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .input-custom::placeholder {
            color: #94A3B8;
            font-weight: 400;
        }

        .input-custom:hover {
            border-color: #CBD5E1;
            background: #FFFFFF;
        }

        .input-custom:focus {
            outline: none;
            background: #FFFFFF;
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 4px rgba(11, 77, 183, 0.12);
        }

        .input-group-custom:focus-within .input-icon-left {
            color: var(--brand-primary);
        }

        .input-custom.is-invalid {
            border-color: #EF4444 !important;
            background-color: #FEF2F2 !important;
        }

        .input-custom.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.12) !important;
        }

        .invalid-message {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #DC2626;
            font-size: 12.5px;
            font-weight: 500;
            margin-top: 6px;
        }

        /* Password Toggle Button */
        .password-toggle-btn {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #94A3B8;
            font-size: 16px;
            padding: 8px;
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
        }

        .password-toggle-btn:hover {
            color: var(--brand-primary);
            background: rgba(11, 77, 183, 0.08);
        }

        /* Checkbox & Options */
        .auth-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            font-size: 13.5px;
        }

        .custom-checkbox {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            user-select: none;
            color: #475569;
            font-weight: 500;
            margin-bottom: 0;
        }

        .custom-checkbox input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            width: 19px;
            height: 19px;
            border: 2px solid #CBD5E1;
            border-radius: 6px;
            background: #FFFFFF;
            cursor: pointer;
            display: grid;
            place-content: center;
            transition: all 0.2s ease;
        }

        .custom-checkbox input[type="checkbox"]::before {
            content: "\f00c";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            font-size: 11px;
            color: #FFFFFF;
            transform: scale(0);
            transition: transform 0.15s ease-in-out;
        }

        .custom-checkbox input[type="checkbox"]:checked {
            background: var(--brand-primary);
            border-color: var(--brand-primary);
        }

        .custom-checkbox input[type="checkbox"]:checked::before {
            transform: scale(1);
        }

        .custom-checkbox:hover input[type="checkbox"] {
            border-color: var(--brand-primary);
        }

        /* Submit Button */
        .btn-submit-login {
            width: 100%;
            height: 52px;
            background: linear-gradient(135deg, #0B4DB7 0%, #1D68E2 50%, #00A3FF 100%);
            background-size: 200% auto;
            border: none;
            border-radius: 14px;
            color: #FFFFFF;
            font-size: 15.5px;
            font-weight: 700;
            letter-spacing: 0.2px;
            cursor: pointer;
            box-shadow: 0 10px 25px -5px rgba(11, 77, 183, 0.4), 0 4px 6px -2px rgba(11, 77, 183, 0.2);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-submit-login:hover {
            background-position: right center;
            transform: translateY(-2px);
            box-shadow: 0 16px 32px -6px rgba(11, 77, 183, 0.5);
        }

        .btn-submit-login:active {
            transform: translateY(0);
            box-shadow: 0 6px 16px -2px rgba(11, 77, 183, 0.4);
        }

        .btn-submit-login i {
            font-size: 15px;
            transition: transform 0.25s ease;
        }

        .btn-submit-login:hover i {
            transform: translateX(4px);
        }

        /* Alerts */
        .alert-custom {
            padding: 14px 18px;
            border-radius: 12px;
            font-size: 13.5px;
            margin-bottom: 22px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            line-height: 1.45;
            animation: shakeAlert 0.4s ease;
        }

        @keyframes shakeAlert {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-4px); }
            40%, 80% { transform: translateX(4px); }
        }

        .alert-custom.alert-danger-custom {
            background: #FEF2F2;
            border: 1px solid #FECACA;
            color: #991B1B;
        }

        .alert-custom.alert-success-custom {
            background: #ECFDF5;
            border: 1px solid #A7F3D0;
            color: #065F46;
        }

        .alert-custom i {
            font-size: 16px;
            margin-top: 2px;
            flex-shrink: 0;
        }

        /* Footer inside Form Side - Clean Minimalist */
        .auth-form-footer {
            margin-top: 32px;
            padding-top: 18px;
            border-top: 1px solid #F1F5F9;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 12.5px;
            color: #94A3B8;
        }

        .auth-form-footer a {
            color: var(--brand-primary);
            text-decoration: none;
            font-weight: 600;
        }

        /* ================= Right Showcase Section ================= */
        .auth-showcase-side {
            flex: 1.2;
            background: linear-gradient(145deg, #071933 0%, #0D2B52 50%, #092040 100%);
            padding: 42px 42px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: #FFFFFF;
            position: relative;
            overflow: hidden;
        }

        /* Subtle Pattern Grid */
        .showcase-grid-bg {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(rgba(0, 163, 255, 0.12) 1px, transparent 1px),
                linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 32px 32px, 64px 64px;
            opacity: 0.7;
            pointer-events: none;
        }

        /* Glowing Orbs inside showcase */
        .showcase-orb-1 {
            position: absolute;
            width: 320px;
            height: 320px;
            background: radial-gradient(circle, rgba(0, 163, 255, 0.35) 0%, rgba(0, 163, 255, 0) 70%);
            top: -60px;
            right: -60px;
            border-radius: 50%;
            pointer-events: none;
        }

        .showcase-orb-2 {
            position: absolute;
            width: 380px;
            height: 380px;
            background: radial-gradient(circle, rgba(11, 77, 183, 0.4) 0%, rgba(11, 77, 183, 0) 70%);
            bottom: -80px;
            left: -80px;
            border-radius: 50%;
            pointer-events: none;
        }

        .showcase-content {
            position: relative;
            z-index: 2;
        }

        .showcase-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            padding: 5px 12px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.1px;
            color: #38BDF8;
            margin-bottom: 16px;
        }

        .showcase-heading {
            font-size: 28px;
            font-weight: 800;
            line-height: 1.25;
            letter-spacing: -0.7px;
            color: #FFFFFF;
            margin-bottom: 12px;
        }

        .showcase-heading span {
            background: linear-gradient(135deg, #38BDF8 0%, #FFFFFF 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .showcase-desc {
            font-size: 13.5px;
            color: #94A3B8;
            line-height: 1.55;
            margin-bottom: 24px;
            max-width: 460px;
        }

        /* Glass Cards Container */
        .glass-cards-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 22px;
        }

        .glass-feature-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.09);
            border-radius: 14px;
            padding: 13px 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            transition: all 0.3s ease;
        }

        .glass-feature-card:hover {
            background: rgba(255, 255, 255, 0.09);
            border-color: rgba(56, 189, 248, 0.3);
            transform: translateX(4px);
        }

        .feature-icon-box {
            width: 40px;
            height: 40px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .icon-blue-glow {
            background: linear-gradient(135deg, rgba(11, 77, 183, 0.8), rgba(0, 163, 255, 0.8));
            color: #FFFFFF;
            box-shadow: 0 4px 15px rgba(0, 163, 255, 0.3);
        }

        .icon-cyan-glow {
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.8), rgba(56, 189, 248, 0.8));
            color: #FFFFFF;
            box-shadow: 0 4px 15px rgba(56, 189, 248, 0.3);
        }

        .icon-emerald-glow {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.8), rgba(52, 211, 153, 0.8));
            color: #FFFFFF;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .feature-text-title {
            font-size: 14.5px;
            font-weight: 700;
            color: #F8FAFC;
            margin-bottom: 2px;
        }

        .feature-text-sub {
            font-size: 12px;
            color: #94A3B8;
            margin-bottom: 0;
            line-height: 1.4;
        }

        /* Showcase Bottom Stats Bar */
        .showcase-footer {
            position: relative;
            z-index: 2;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
        }

        .stat-number {
            font-size: 19px;
            font-weight: 800;
            color: #FFFFFF;
            letter-spacing: -0.3px;
        }

        .stat-label {
            font-size: 11px;
            color: #94A3B8;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-divider {
            width: 1px;
            height: 26px;
            background: rgba(255, 255, 255, 0.12);
        }

        /* ================= Responsive Breakpoints ================= */
        @media (max-width: 991.98px) {
            .auth-wrapper {
                padding: 32px 16px;
                align-items: flex-start;
            }

            .auth-card {
                flex-direction: column;
                max-width: 480px;
                margin: 20px auto;
                min-height: auto;
                border-radius: 22px;
            }

            .auth-form-side {
                padding: 40px 32px;
            }

            .auth-showcase-side {
                display: none; /* Clean focus on mobile */
            }

            .brand-top-row {
                margin-bottom: 24px;
            }

            .auth-title {
                font-size: 24px;
            }
        }

        @media (max-width: 480px) {
            .auth-wrapper {
                padding: 20px 12px;
            }

            .auth-form-side {
                padding: 32px 20px;
            }

            .brand-logo-img {
                height: 40px;
            }

            .auth-title {
                font-size: 22px;
            }

            .auth-options {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
        }

        /* ================= Loading Screen Styles ================= */
        .loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(145deg, #071933 0%, #0D2B52 60%, #092040 100%);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .loading-screen.active {
            display: flex;
        }

        .loading-content {
            text-align: center;
            color: white;
            width: 100%;
            max-width: 540px;
            padding: 40px 24px;
            animation: fadeInScale 0.4s ease;
        }

        .lottie-container {
            width: 100%;
            max-width: 380px;
            height: 240px;
            margin: 0 auto 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        dotlottie-player {
            width: 100%;
            height: 100%;
        }

        .progress-container {
            width: 100%;
            height: 6px;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 10px;
            overflow: hidden;
            margin: 20px 0;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #00A3FF, #38BDF8, #FFFFFF, #00A3FF);
            background-size: 200% 100%;
            border-radius: 10px;
            animation: progressGradient 1.4s linear infinite;
            width: 100%;
        }

        @keyframes progressGradient {
            0% { background-position: 0% 50%; }
            100% { background-position: 200% 50%; }
        }

        .loading-text {
            font-size: 20px;
            font-weight: 700;
            margin-top: 16px;
            color: #FFFFFF;
            letter-spacing: -0.3px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .loading-text i {
            color: #38BDF8;
        }

        .loading-subtext {
            font-size: 13.5px;
            color: #94A3B8;
            margin-top: 6px;
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

    <!-- Ambient Glowing Orbs Background -->
    <div class="ambient-glow glow-1"></div>
    <div class="ambient-glow glow-2"></div>

    <!-- Loading Screen (Displayed on login submit) -->
    <div class="loading-screen" id="loadingScreen" aria-live="polite">
        <div class="loading-content">
            <div class="lottie-container">
                <dotlottie-player
                    src="{{ asset('assets/images/car_loading_page.lottie') }}"
                    background="transparent"
                    speed="1.4"
                    loop
                    autoplay>
                </dotlottie-player>
            </div>

            <div class="progress-container">
                <div class="progress-bar"></div>
            </div>

            <div class="loading-text">
                <i class="fas fa-van-shuttle"></i> Memuat Dashboard Fleet<span class="loading-dots"></span>
            </div>
            <div class="loading-subtext">Menyiapkan konfigurasi & sistem analitik armada Anda...</div>
        </div>
    </div>

    <!-- Main Auth Container -->
    <div class="auth-wrapper">
        <div class="auth-card">
            
            <!-- Left Side: Login Form -->
            <div class="auth-form-side">
                <div>
                    <!-- Brand Top Row: Logo & Status Badge -->
                    <div class="brand-top-row">
                        <a href="{{ url('/') }}" class="brand-logo-wrap" title="Raja Fleet">
                            <img src="{{ asset('assets/logos/brands/Raja-Fleet-Transparan.png') }}"
                                 alt="Raja Fleet"
                                 class="brand-logo-img">
                        </a>
                        <div class="portal-badge">
                            <span class="pulse-indicator"></span>
                            <span>Fleet Operations v2.4</span>
                        </div>
                    </div>

                    <!-- Welcome Heading -->
                    <div class="auth-heading-block">
                        <h1 class="auth-title">Selamat Datang Kembali</h1>
                        <p class="auth-subtitle">Masuk untuk mengakses monitoring operasional armada, efisiensi BBM, dan jadwal pemeliharaan.</p>
                    </div>

                    <!-- Flash Message Success -->
                    @if(session('success'))
                    <div class="alert-custom alert-success-custom">
                        <i class="fas fa-circle-check"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                    @endif

                    <!-- Error Alert -->
                    @if($errors->any())
                    <div class="alert-custom alert-danger-custom">
                        <i class="fas fa-circle-exclamation"></i>
                        <div>
                            @if($errors->has('email'))
                                {{ $errors->first('email') }}
                            @else
                                {{ $errors->first() }}
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Login Form -->
                    <form action="{{ route('login.post') }}" method="POST" id="loginForm" autocomplete="on">
                        @csrf

                        <!-- Email Input -->
                        <div class="form-floating-custom">
                            <label for="email" class="form-label-custom">Alamat Email</label>
                            <div class="input-group-custom">
                                <i class="fas fa-envelope input-icon-left"></i>
                                <input type="email"
                                       class="input-custom @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       placeholder="admin@rajablindvan.com"
                                       required
                                       autofocus
                                       autocomplete="email">
                            </div>
                            @error('email')
                                <div class="invalid-message">
                                    <i class="fas fa-circle-xmark"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="form-floating-custom">
                            <label for="password" class="form-label-custom">Kata Sandi</label>
                            <div class="input-group-custom">
                                <i class="fas fa-lock input-icon-left"></i>
                                <input type="password"
                                       class="input-custom @error('password') is-invalid @enderror"
                                       id="password"
                                       name="password"
                                       placeholder="••••••••••••"
                                       required
                                       autocomplete="current-password">
                                <button type="button" 
                                        class="password-toggle-btn" 
                                        id="togglePasswordBtn" 
                                        onclick="togglePasswordVisibility()" 
                                        aria-label="Tampilkan atau sembunyikan kata sandi">
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-message">
                                    <i class="fas fa-circle-xmark"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Options Row: Remember Me -->
                        <div class="auth-options">
                            <label class="custom-checkbox" for="remember">
                                <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span>Ingat saya di perangkat ini</span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-submit-login" id="submitBtn">
                            <span>Masuk ke Dashboard</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </form>
                </div>

                <!-- Footer - Minimalist Copyright Only -->
                <div class="auth-form-footer">
                    <span>© {{ date('Y') }} Raja Fleet. Hak Cipta Dilindungi.</span>
                </div>
            </div>

            <!-- Right Side: Executive Fleet Showcase -->
            <div class="auth-showcase-side">
                <div class="showcase-grid-bg"></div>
                <div class="showcase-orb-1"></div>
                <div class="showcase-orb-2"></div>

                <div class="showcase-content">
                    <div class="showcase-tag">
                        <i class="fas fa-satellite-dish"></i>
                        <span>Smart Fleet Management</span>
                    </div>

                    <h2 class="showcase-heading">
                        Kontrol Penuh Armada <span>Blind Van</span> Anda Dalam Satu Platform.
                    </h2>
                    
                    <p class="showcase-desc">
                        Akses sistem pemantauan real-time untuk efisiensi bahan bakar, manajemen jadwal servis berkala, dan rekam jejak performa kendaraan secara presisi.
                    </p>

                    <!-- Glassmorphism Highlight Cards -->
                    <div class="glass-cards-list">
                        <!-- Card 1 -->
                        <div class="glass-feature-card">
                            <div class="feature-icon-box icon-blue-glow">
                                <i class="fas fa-van-shuttle"></i>
                            </div>
                            <div>
                                <div class="feature-text-title">Monitoring & Telemetri Real-Time</div>
                                <div class="feature-text-sub">Pantau odometer, konsumsi BBM per kilometer, dan status unit aktif.</div>
                            </div>
                        </div>

                        <!-- Card 2 -->
                        <div class="glass-feature-card">
                            <div class="feature-icon-box icon-cyan-glow">
                                <i class="fas fa-wrench"></i>
                            </div>
                            <div>
                                <div class="feature-text-title">Pengingat Servis & Pemeliharaan Preventif</div>
                                <div class="feature-text-sub">Notifikasi otomatis pergantian oli, ban, dan uji kelayakan armada.</div>
                            </div>
                        </div>

                        <!-- Card 3 -->
                        <div class="glass-feature-card">
                            <div class="feature-icon-box icon-emerald-glow">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div>
                                <div class="feature-text-title">Analisis Biaya & Efisiensi Operasional</div>
                                <div class="feature-text-sub">Laporan komprehensif pengeluaran operasional per kendaraan dan rute.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Showcase Metrics Footer -->
                <div class="showcase-footer">
                    <div class="stat-item">
                        <div class="stat-number">99.8%</div>
                        <div class="stat-label">Kesiapan Armada</div>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat-item">
                        <div class="stat-number">24 / 7</div>
                        <div class="stat-label">Monitoring Aktif</div>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat-item">
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Data Terenkripsi</div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Password Visibility Toggle
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Handle Form Submission and Loading Screen
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('loginForm');
            const loadingScreen = document.getElementById('loadingScreen');
            const submitBtn = document.getElementById('submitBtn');

            // Clear previous session indicators
            localStorage.removeItem('shouldBeLoggedIn');
            localStorage.removeItem('closingTabs');
            sessionStorage.clear();

            if (loginForm) {
                loginForm.addEventListener('submit', function(e) {
                    // Check HTML5 validity
                    if (!loginForm.checkValidity()) {
                        return;
                    }

                    // Disable button to prevent double-click
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = `<span>Menghubungkan...</span> <i class="fas fa-spinner fa-spin"></i>`;
                    }

                    // Mark login state
                    localStorage.setItem('shouldBeLoggedIn', 'true');

                    // Show modern loading screen
                    if (loadingScreen) {
                        loadingScreen.classList.add('active');
                    }
                });
            }
        });
    </script>
</body>
</html>
