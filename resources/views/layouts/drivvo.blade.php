<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="logout-url" content="{{ route('logout') }}">
    <meta name="login-url" content="{{ route('login') }}">

    <title>Radja Blind Van - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Mobile Responsive CSS -->
    <link rel="stylesheet" href="{{ asset('css/mobile-responsive.css') }}">

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/airbnb.css">

    <!-- Custom CSS -->
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .drivvo-sidebar {
            background-color: #2c3e50;
            width: 240px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            padding: 0;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            transition: width 0.3s ease;
        }

        .drivvo-sidebar.collapsed {
            width: 70px;
        }

        .drivvo-sidebar.collapsed .brand-text,
        .drivvo-sidebar.collapsed .nav-text,
        .drivvo-sidebar.collapsed .language-label,
        .drivvo-sidebar.collapsed .language-buttons {
            opacity: 0;
            visibility: hidden;
            width: 0;
            overflow: hidden;
        }

        .drivvo-sidebar.collapsed .app-brand-logo {
            max-width: 40px !important;
            max-height: 40px !important;
        }

        .drivvo-sidebar.collapsed .drivvo-nav-link {
            justify-content: center;
            padding: 12px;
        }

        .drivvo-sidebar.collapsed .drivvo-nav-link i {
            margin-right: 0;
        }

        .drivvo-sidebar.collapsed .language-switcher {
            padding: 10px;
        }

        /* Tooltip for collapsed sidebar */
        .drivvo-sidebar.collapsed .drivvo-nav-link::after {
            content: attr(title);
            position: absolute;
            left: 70px;
            background: #2c3e50;
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease;
            z-index: 1001;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .drivvo-sidebar.collapsed .drivvo-nav-link:hover::after {
            opacity: 1;
        }

        .drivvo-sidebar.collapsed .drivvo-brand {
            padding: 20px 10px;
            min-height: 80px;
        }

        .drivvo-brand {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100px;
            text-align: center;
            flex-shrink: 0;
        }

        .app-logo {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .app-logo:hover {
            transform: scale(1.02);
            opacity: 0.9;
        }

        .app-brand-logo {
            max-width: 200px !important;
            max-height: 70px !important;
            width: auto !important;
            height: auto !important;
            object-fit: contain;
            display: block;
            margin: 0 auto;
            filter: brightness(0) invert(1);
        }

        .brand-text {
            display: flex;
            align-items: center;
            color: white;
            font-weight: 600;
            font-size: 16px;
        }

        .brand-text .brand-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(45deg, #ff6b35, #f7931e);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
        }

        .drivvo-nav {
            padding: 20px 0;
            flex: 1;
            overflow-y: auto;
        }

        .drivvo-nav-item {
            margin: 0 20px 8px 20px;
        }

        .drivvo-nav-link {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s ease;
            font-weight: 500;
            white-space: nowrap;
            position: relative;
        }

        .drivvo-nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
        }

        .drivvo-nav-link.active {
            background-color: rgba(255,255,255,0.15);
            color: white;
        }

        .drivvo-nav-link i {
            width: 20px;
            margin-right: 12px;
            text-align: center;
            flex-shrink: 0;
        }

        .drivvo-nav-link .nav-text {
            transition: opacity 0.2s ease, width 0.2s ease;
            white-space: nowrap;
        }

        /* Language Switcher */
        .language-switcher {
            padding: 20px 15px;
            border-top: 1px solid rgba(255,255,255,0.1);
            flex-shrink: 0;
            background-color: #2c3e50;
        }

        .language-label {
            color: rgba(255,255,255,0.5);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }

        .language-buttons {
            display: flex;
            gap: 8px;
        }

        .lang-btn {
            flex: 1;
            padding: 8px 12px;
            border-radius: 6px;
            text-align: center;
            font-weight: 600;
            font-size: 13px;
            text-decoration: none;
            transition: all 0.3s ease;
            background: rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.7);
        }

        .lang-btn:hover {
            background: rgba(255,255,255,0.15);
            color: rgba(255,255,255,0.9);
        }

        .lang-btn.active {
            background: #3498db;
            color: white;
        }

        .main-content {
            margin-left: 240px;
            padding: 20px;
            min-height: 100vh;
            background-color: #f8f9fa;
            width: calc(100vw - 240px);
            overflow: visible;
            transition: margin-left 0.3s ease, width 0.3s ease;
        }

        .main-content.sidebar-collapsed {
            margin-left: 70px;
            width: calc(100vw - 70px);
        }

        /* Sidebar Toggle Button for Desktop */
        .sidebar-toggle-btn {
            position: fixed;
            top: 20px;
            left: 250px;
            z-index: 999;
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: left 0.3s ease;
        }

        .sidebar-toggle-btn:hover {
            background: #f8f9fa;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .sidebar-toggle-btn.collapsed {
            left: 80px;
        }

        .sidebar-toggle-btn i {
            color: #2c3e50;
            font-size: 16px;
            transition: transform 0.3s ease;
        }

        .sidebar-toggle-btn.collapsed i {
            transform: rotate(180deg);
        }

        /* Page Header Styles */
        .page-header {
            background: white;
            padding: 30px;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .page-title {
            font-size: 32px;
            font-weight: 700;
            color: #2c3e50;
            margin: 0 0 8px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-title i {
            font-size: 28px;
            color: #007bff;
        }

        .page-subtitle {
            font-size: 15px;
            color: #7f8c8d;
            margin: 0;
            font-weight: 400;
        }

        .content-header {
            background-color: white;
            padding: 20px 30px;
            border-bottom: 1px solid #e9ecef;
            margin-bottom: 0;
        }

        .content-body {
            padding: 0;
        }

        .nav-divider {
            height: 1px;
            background-color: rgba(255,255,255,0.1);
            margin: 20px 20px;
        }

        /* Vehicle Modal Styles */
        .vehicle-item {
            display: flex;
            align-items: center;
            padding: 16px 20px;
            text-decoration: none;
            color: inherit;
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.2s ease;
        }

        .vehicle-item:hover {
            background-color: rgba(0,123,255,0.05);
            color: inherit;
        }

        .vehicle-item:last-child {
            border-bottom: none;
        }

        .vehicle-logo {
            width: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 16px;
        }

        .vehicle-info {
            flex: 1;
        }

        .vehicle-name {
            font-weight: 500;
            color: #333;
            font-size: 15px;
            line-height: 1.2;
        }

        .vehicle-indicator {
            width: 32px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .vehicle-indicator i {
            font-size: 18px;
            color: #6c757d;
        }

        /* Brand Logo Styles */
        .brand-logo {
            width: 20px;
            height: 20px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 10px;
            color: white;
            flex-shrink: 0;
        }

        .toyota-logo {
            background: #e60012;
            color: white;
            border-radius: 50%;
        }

        .honda-logo {
            background: #cc0000;
            color: white;
            border-radius: 2px;
            font-weight: 900;
        }

        .daihatsu-logo {
            background: #0066cc;
            color: white;
            border-radius: 3px;
        }

        .mitsubishi-logo {
            background: #dc143c;
            color: white;
            border-radius: 2px;
        }

        .suzuki-logo {
            background: #004cff;
            color: white;
            border-radius: 2px;
            font-weight: 900;
        }

        .nissan-logo {
            background: #c3002f;
            color: white;
            border-radius: 50%;
        }

        .generic-logo {
            background: linear-gradient(135deg, #666666, #888888);
        }

        /* Brand Logo Image Styles */
        .brand-logo-img {
            width: 28px;
            height: 28px;
            object-fit: contain;
            flex-shrink: 0;
        }

        /* Scrollbar Styles */
        .drivvo-sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .drivvo-sidebar::-webkit-scrollbar-track {
            background: rgba(0,0,0,0.1);
        }

        .drivvo-sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.2);
            border-radius: 3px;
        }

        .drivvo-sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.3);
        }

        /* Mobile Menu Toggle Button */
        .mobile-menu-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1100;
            background: #2c3e50;
            border: none;
            border-radius: 8px;
            padding: 12px 16px;
            color: white;
            font-size: 20px;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .mobile-menu-close {
            display: none;
            position: absolute;
            top: 20px;
            right: 20px;
            background: transparent;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            z-index: 1001;
        }

        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            .sidebar-toggle-btn {
                display: none;
            }

            .mobile-menu-toggle {
                display: block;
            }

            .drivvo-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                width: 280px;
                z-index: 1050;
                height: 100vh;
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
                padding-bottom: 80px;
            }

            .drivvo-sidebar.active {
                transform: translateX(0);
            }

            .drivvo-nav {
                padding-bottom: 100px !important;
            }

            .drivvo-sidebar.collapsed {
                width: 280px;
            }

            .mobile-menu-close {
                display: block;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 15px;
                padding-top: 70px;
            }

            .main-content.sidebar-collapsed {
                margin-left: 0;
                width: 100%;
            }

            .page-header {
                padding: 20px 15px;
            }

            .page-title {
                font-size: 24px;
            }

            .page-title i {
                font-size: 22px;
            }

            .page-subtitle {
                font-size: 13px;
            }

            /* User Info Bar Mobile */
            .user-info-bar {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 12px !important;
                padding: 15px !important;
            }

            .user-info-bar .user-details {
                width: 100%;
            }

            .user-info-bar .role-badge {
                align-self: flex-start;
            }

            /* Modal adjustments */
            .modal-dialog {
                margin: 10px;
            }

            /* Sidebar overlay when open */
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.5);
                z-index: 1040;
            }

            .sidebar-overlay.active {
                display: block;
            }

            /* Table responsive */
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            /* Cards */
            .card {
                margin-bottom: 15px;
            }

            /* Buttons */
            .btn {
                font-size: 14px;
                padding: 8px 16px;
            }

            /* Forms */
            .form-control, .form-select {
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .drivvo-sidebar {
                width: 100%;
                max-width: 280px;
            }

            .main-content {
                padding: 10px;
                padding-top: 65px;
            }

            .page-header {
                padding: 15px 10px;
            }

            .page-title {
                font-size: 20px;
            }

            .page-title i {
                font-size: 18px;
            }

            .user-info-bar {
                padding: 12px !important;
            }

            .user-info-bar .user-avatar {
                width: 36px !important;
                height: 36px !important;
                font-size: 14px !important;
            }

            .user-info-bar .user-name {
                font-size: 14px !important;
            }

            .user-info-bar .user-email {
                font-size: 12px !important;
            }

            .role-badge {
                font-size: 12px !important;
                padding: 5px 12px !important;
            }
        }

        /* Add New Modal Card Hover Effects */
        .add-new-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
        }

        .add-new-card:active {
            transform: translateY(-1px);
        }
    </style>


    @stack('styles')
</head>

<body @auth data-user-authenticated="true" @endauth>
    <!-- Desktop Sidebar Toggle Button -->
    <button class="sidebar-toggle-btn" id="sidebarToggleBtn">
        <i class="fas fa-chevron-left"></i>
    </button>

    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" id="mobileMenuToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="drivvo-sidebar">
            <!-- Mobile Close Button -->
            <button class="mobile-menu-close" id="mobileMenuClose">
                <i class="fas fa-times"></i>
            </button>

            <!-- Brand -->
            <div class="drivvo-brand">
                <a href="{{ route('dashboard') }}" class="app-logo" style="text-decoration: none; color: inherit; cursor: pointer;">
                    <img src="{{ asset('assets/logos/brands/Radja-Blind-Van-Logo.png') }}"
                         alt="Radja Blind Van"
                         class="app-brand-logo"
                         style="filter: brightness(0) invert(1);">
                </a>
            </div>

            <!-- Navigation -->
            <nav class="drivvo-nav">
                <!-- Dashboard -->
                <div class="drivvo-nav-item">
                    <a href="{{ route('dashboard') }}" class="drivvo-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span class="nav-text">{{ __('common.dashboard') }}</span>
                    </a>
                </div>

                <!-- History -->
                <div class="drivvo-nav-item">
                    <a href="{{ route('history.index') }}" class="drivvo-nav-link {{ request()->routeIs('history.*') ? 'active' : '' }}">
                        <i class="fas fa-history"></i>
                        <span class="nav-text">{{ __('common.history') }}</span>
                    </a>
                </div>

                <!-- Tambah Baru -->
                <div class="drivvo-nav-item">
                    <button type="button" class="drivvo-nav-link" onclick="showAddNewModal()" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; padding: 12px 20px;">
                        <i class="fas fa-plus-circle"></i>
                        <span class="nav-text">Tambah Baru</span>
                    </button>
                </div>

                <!-- Other Menu Items -->
                <div class="drivvo-nav-item">
                    <a href="{{ route('reminders.index') }}" class="drivvo-nav-link {{ request()->routeIs('reminders.*') ? 'active' : '' }}">
                        <i class="fas fa-bell"></i>
                        <span class="nav-text">{{ __('common.reminders') }}</span>
                    </a>
                </div>

                <div class="drivvo-nav-item">
                    <a href="{{ route('reports.index') }}" class="drivvo-nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i>
                        <span class="nav-text">{{ __('common.reports') }}</span>
                    </a>
                </div>

                <div class="nav-divider"></div>

                <!-- Vehicles & Users -->
                <div class="drivvo-nav-item">
                    <a href="{{ route('vehicles.index') }}" class="drivvo-nav-link {{ request()->routeIs('vehicles.*') ? 'active' : '' }}">
                        <i class="fas fa-car"></i>
                        <span class="nav-text">{{ __('common.vehicles') }}</span>
                    </a>
                </div>

                <div class="drivvo-nav-item">
                    <a href="{{ route('customers.index') }}" class="drivvo-nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span class="nav-text">{{ __('common.customers') }}</span>
                    </a>
                </div>

                <!-- Order List -->
                <div class="drivvo-nav-item">
                    <a href="{{ route('orders.index') }}" class="drivvo-nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                        <i class="fas fa-clipboard-list"></i>
                        <span class="nav-text">{{ __('common.order_list') }}</span>
                    </a>
                </div>



                <!-- Users (Only for Administrator) -->
                @auth
                @if(Auth::user()->canManageUsers())
                <div class="drivvo-nav-item">
                    <a href="{{ route('users.index') }}" class="drivvo-nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="fas fa-user"></i>
                        <span class="nav-text">{{ __('common.users') }}</span>
                    </a>
                </div>
                @endif
                @endauth

                <div class="nav-divider"></div>

                <!-- Settings -->
                <div class="drivvo-nav-item">
                    <a href="{{ route('settings.index') }}" class="drivvo-nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i>
                        <span class="nav-text">{{ __('common.settings') }}</span>
                    </a>
                </div>

                <!-- Logout -->
                <div class="drivvo-nav-item">
                    <button type="button" class="drivvo-nav-link" onclick="showLogoutModal()" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; color: red; padding: 12px 20px;">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="nav-text">{{ __('common.logout') }}</span>
                    </button>

                    <!-- Hidden logout form -->
                    <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- User Info Bar -->
            @auth
            <div class="user-info-bar" style="background: white; padding: 12px 24px; margin-bottom: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center;">
                <div class="user-details" style="display: flex; align-items: center; gap: 12px;">
                    <div class="user-avatar" style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 16px;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="user-name" style="font-weight: 600; color: #2c3e50; font-size: 15px;">{{ Auth::user()->name }}</div>
                        <div class="user-email" style="font-size: 13px; color: #7f8c8d;">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 15px;">
                    <!-- Location Selector (Only for Super Admin) -->
                    @if(Auth::user()->isSuperAdmin())
                    <div class="location-selector" style="display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-map-marker-alt" style="color: #e74c3c;"></i>
                        <select id="locationFilter" class="form-select form-select-sm" style="min-width: 150px; border-radius: 6px; border: 1px solid #ddd; padding: 6px 12px;" onchange="changeLocation(this.value)">
                            @php
                                $locations = \App\Models\Location::active()->get();
                                $selectedLocationId = session('selected_location_id');
                                // Check if location_id in URL parameter (takes priority)
                                if (request()->has('location_id')) {
                                    $selectedLocationId = request()->get('location_id');
                                }
                            @endphp
                            <option value="" {{ empty($selectedLocationId) ? 'selected' : '' }}>Semua Lokasi</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ $selectedLocationId == $location->id ? 'selected' : '' }}>
                                    {{ $location->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @else
                    <!-- Show current location for staff -->
                    @if(Auth::user()->location)
                    <div class="location-badge" style="padding: 6px 14px; border-radius: 6px; background: #ecf0f1; color: #2c3e50; font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-map-marker-alt" style="color: #e74c3c;"></i>
                        {{ Auth::user()->location->name }}
                    </div>
                    @endif
                    @endif

                    @php
                        $roleColors = [
                            'super_admin' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                            'admin' => 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
                            'manager' => 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
                            'operator' => 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
                        ];
                        $roleNames = [
                            'super_admin' => 'Administrator',
                            'manager' => 'Sales',
                            'operator' => 'Operation',
                        ];
                        $userRole = Auth::user()->role ?? 'operator';
                    @endphp
                    <span class="role-badge" style="padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 600; color: white; background: {{ $roleColors[$userRole] ?? '#999' }}; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                        <i class="fas fa-crown"></i> {{ $roleNames[$userRole] ?? 'User' }}
                    </span>
                </div>
            </div>
            @endauth


            @yield('content')
        </div>
    </div>

    <!-- Vehicle Selection Modal -->
    <div class="modal fade" id="vehicleModal" tabindex="-1" aria-labelledby="vehicleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
            <div class="modal-content">
                <div class="modal-header border-0 pb-2">
                    <h5 class="modal-title fw-semibold" id="vehicleModalLabel">{{ __('common.vehicles') }}</h5>
                    <div class="d-flex align-items-center">
                        <button type="button" class="btn btn-link p-0 me-3" style="text-decoration: none;">
                            <i class="fas fa-search text-primary"></i>
                        </button>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body pt-0">
                    @if(isset($allVehicles))
                        @foreach($allVehicles as $vehicle)
                            <a href="{{ route('dashboard', ['vehicle_id' => $vehicle->id]) }}" class="vehicle-item" onclick="window.location.href=this.href; return false;">
                                <div class="vehicle-logo">
                                    <img src="{{ $vehicle->getBrandLogoUrl() }}"
                                         alt="{{ $vehicle->brand }}"
                                         class="brand-logo-img">
                                </div>
                                <div class="vehicle-info">
                                    <div class="vehicle-name">{{ $vehicle->brand }} {{ $vehicle->model }}</div>
                                </div>
                                <div class="vehicle-indicator">
                                    <i class="fas fa-truck text-muted"></i>
                                </div>
                            </a>
                        @endforeach
                    @endif
                </div>
                <div class="modal-footer border-0 pt-0">
                    <div class="d-grid gap-2 w-100">
                        <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('vehicles.create') }}'">
                            {{ __('vehicle.add_vehicle_new') }}
                        </button>
                        @php
                            $currentVehicleId = request()->get('vehicle_id') ?? session('selected_vehicle_id');
                            if (!$currentVehicleId && isset($allVehicles) && $allVehicles->count() > 0) {
                                $currentVehicleId = $allVehicles->first()->id;
                            }
                        @endphp
                        @if($currentVehicleId)
                            <button type="button" class="btn btn-outline-primary" onclick="window.location.href='{{ route('vehicles.show', $currentVehicleId) }}'">
                                {{ __('vehicle.manage_vehicles') }}
                            </button>
                        @else
                            <button type="button" class="btn btn-outline-primary" onclick="window.location.href='{{ route('vehicles.index') }}'">
                                {{ __('vehicle.manage_vehicles') }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;">
                    <h5 class="modal-title" id="logoutModalLabel">
                        <i class="fas fa-exclamation-triangle"></i>
                        Konfirmasi Logout
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 30px; text-align: center;">
                    <div style="font-size: 60px; color: #667eea; margin-bottom: 20px;">
                        <i class="fas fa-sign-out-alt"></i>
                    </div>
                    <h5 style="margin-bottom: 15px; color: #333;">Apakah Anda yakin ingin keluar?</h5>
                    <p style="color: #666; margin-bottom: 0;">Anda akan keluar dari sistem dan perlu login kembali untuk mengakses dashboard.</p>
                </div>
                <div class="modal-footer" style="border: none; padding: 0 30px 30px; justify-content: center; gap: 10px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="min-width: 120px; padding: 10px 20px;">
                        <i class="fas fa-times"></i>
                        Batal
                    </button>
                    <button type="button" class="btn btn-danger" onclick="confirmLogout()" style="min-width: 120px; padding: 10px 20px;">
                        <i class="fas fa-sign-out-alt"></i>
                        Ya, Logout
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add New Modal -->
    <div class="modal fade" id="addNewModal" tabindex="-1" aria-labelledby="addNewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border: none; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.15);">
                <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 16px 16px 0 0; padding: 20px 24px;">
                    <h5 class="modal-title" id="addNewModalLabel">
                        <i class="fas fa-plus-circle me-2"></i>
                        Tambah Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 30px 24px;">
                    <p class="text-muted mb-4" style="font-size: 14px;">Pilih jenis data yang ingin Anda tambahkan:</p>

                    <div class="row g-3">
                        <!-- Income Card -->
                        <div class="col-12">
                            <a href="{{ route('incomes.create') }}" class="add-new-card" style="display: flex; align-items: center; padding: 16px 20px; background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%); border: 2px solid #667eea30; border-radius: 12px; text-decoration: none; transition: all 0.3s ease; position: relative; overflow: hidden;">
                                <div class="add-new-icon" style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 16px; flex-shrink: 0;">
                                    <i class="fas fa-money-bill-wave" style="font-size: 22px; color: white;"></i>
                                </div>
                                <div class="add-new-content" style="flex: 1;">
                                    <h6 class="mb-1" style="color: #2c3e50; font-weight: 600; font-size: 16px;">Pendapatan</h6>
                                    <p class="mb-0" style="color: #7f8c8d; font-size: 13px;">Tambahkan pendapatan baru</p>
                                </div>
                                <div class="add-new-arrow" style="color: #667eea; font-size: 18px;">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>
                        </div>

                        <!-- Service Card -->
                        <div class="col-12">
                            <a href="{{ route('maintenances.create') }}" class="add-new-card" style="display: flex; align-items: center; padding: 16px 20px; background: linear-gradient(135deg, #4facfe15 0%, #00f2fe15 100%); border: 2px solid #4facfe30; border-radius: 12px; text-decoration: none; transition: all 0.3s ease; position: relative; overflow: hidden;">
                                <div class="add-new-icon" style="width: 50px; height: 50px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 16px; flex-shrink: 0;">
                                    <i class="fas fa-wrench" style="font-size: 22px; color: white;"></i>
                                </div>
                                <div class="add-new-content" style="flex: 1;">
                                    <h6 class="mb-1" style="color: #2c3e50; font-weight: 600; font-size: 16px;">Servis</h6>
                                    <p class="mb-0" style="color: #7f8c8d; font-size: 13px;">Tambahkan layanan maintenance</p>
                                </div>
                                <div class="add-new-arrow" style="color: #4facfe; font-size: 18px;">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>
                        </div>

                        <!-- Expense Card -->
                        <div class="col-12">
                            <a href="{{ route('expenses.create') }}" class="add-new-card" style="display: flex; align-items: center; padding: 16px 20px; background: linear-gradient(135deg, #fa709a15 0%, #fee14015 100%); border: 2px solid #fa709a30; border-radius: 12px; text-decoration: none; transition: all 0.3s ease; position: relative; overflow: hidden;">
                                <div class="add-new-icon" style="width: 50px; height: 50px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 16px; flex-shrink: 0;">
                                    <i class="fas fa-receipt" style="font-size: 22px; color: white;"></i>
                                </div>
                                <div class="add-new-content" style="flex: 1;">
                                    <h6 class="mb-1" style="color: #2c3e50; font-weight: 600; font-size: 16px;">Pengeluaran</h6>
                                    <p class="mb-0" style="color: #7f8c8d; font-size: 13px;">Tambahkan pengeluaran baru</p>
                                </div>
                                <div class="add-new-arrow" style="color: #fa709a; font-size: 18px;">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get format from server-shared variable (if available) or default
            const dateFormat = "{{ $appDateFormat ?? 'Y-m-d' }}";

            // Convert PHP date format to Flatpickr format if necessary
            // Most PHP tokens d, m, Y, F, M, l, D are supported by Flatpickr directly.

            flatpickr("input[type='date']", {
                altInput: true,
                altFormat: dateFormat,
                dateFormat: "Y-m-d",
                allowInput: true, // Allow manual typing
                theme: "airbnb"
            });

            // Also support dedicated class
            flatpickr(".datepicker", {
                altInput: true,
                altFormat: dateFormat,
                dateFormat: "Y-m-d",
                allowInput: true,
                theme: "airbnb"
            });
        });
    </script>


    <!-- Location Filter Script -->
    <script>
        function changeLocation(locationId) {
            // Show loading indicator
            const select = document.getElementById('locationFilter');
            if (select) {
                select.disabled = true;
                select.style.opacity = '0.6';
            }

            // Build URL with location parameter
            const currentUrl = new URL(window.location.href);

            // Update location parameter
            currentUrl.searchParams.set('location_id', locationId);

            // Redirect to update page
            window.location.href = currentUrl.toString();
        }

        // Preserve location filter on page load
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const locationId = urlParams.get('location_id');
            const select = document.getElementById('locationFilter');

            if (select) {
                // Set selected value based on URL parameter
                if (locationId) {
                    select.value = locationId;
                } else {
                    select.value = ''; // Semua Lokasi
                }
            }
        });
    </script>

    <!-- Logout Modal Script -->
    <script>
        function showLogoutModal() {
            const logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
            logoutModal.show();
        }

        function confirmLogout() {
            // Clear localStorage flags to prevent re-login
            localStorage.setItem('shouldBeLoggedIn', 'false');
            sessionStorage.clear();

            // Submit logout form
            document.getElementById('logoutForm').submit();
        }

        function showAddNewModal() {
            const addNewModal = new bootstrap.Modal(document.getElementById('addNewModal'));
            addNewModal.show();
        }

        // Sidebar Toggle and Mobile Menu
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const mobileMenuClose = document.getElementById('mobileMenuClose');
            const sidebar = document.querySelector('.drivvo-sidebar');
            const mainContent = document.querySelector('.main-content');
            const overlay = document.getElementById('sidebarOverlay');

            // Load sidebar state from localStorage (for desktop)
            const sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (sidebarCollapsed && window.innerWidth > 768) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('sidebar-collapsed');
                sidebarToggleBtn.classList.add('collapsed');
            }

            // Desktop Sidebar Toggle
            if (sidebarToggleBtn) {
                sidebarToggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('sidebar-collapsed');
                    sidebarToggleBtn.classList.toggle('collapsed');

                    // Save state to localStorage
                    const isCollapsed = sidebar.classList.contains('collapsed');
                    localStorage.setItem('sidebarCollapsed', isCollapsed);
                });
            }

            // Mobile Menu Functions
            function openSidebar() {
                sidebar.classList.add('active');
                overlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            }

            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener('click', openSidebar);
            }

            if (mobileMenuClose) {
                mobileMenuClose.addEventListener('click', closeSidebar);
            }

            if (overlay) {
                overlay.addEventListener('click', closeSidebar);
            }

            // Close sidebar when clicking a link on mobile
            const sidebarLinks = sidebar.querySelectorAll('.drivvo-nav-link');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        closeSidebar();
                    }
                });
            });

            // Handle window resize
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    if (window.innerWidth > 768) {
                        closeSidebar();
                        // Restore collapsed state on desktop
                        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                        if (isCollapsed) {
                            sidebar.classList.add('collapsed');
                            mainContent.classList.add('sidebar-collapsed');
                            sidebarToggleBtn.classList.add('collapsed');
                        }
                    } else {
                        // Remove collapsed state on mobile
                        sidebar.classList.remove('collapsed');
                        mainContent.classList.remove('sidebar-collapsed');
                    }
                }, 250);
            });

            // Tooltip for collapsed sidebar (optional enhancement)
            if (window.innerWidth > 768) {
                const navLinks = sidebar.querySelectorAll('.drivvo-nav-link');
                navLinks.forEach(link => {
                    const text = link.querySelector('.nav-text');
                    if (text) {
                        link.setAttribute('title', text.textContent.trim());
                    }
                });
            }
        });
    </script>

    <!-- Global Search Dropdown Helper -->
    <script>
        // Global function to clear search input
        window.clearSearch = function(inputId, buttonId) {
            const input = document.getElementById(inputId);
            const button = document.getElementById(buttonId);
            if (input) {
                input.value = '';
                input.focus();
                input.dispatchEvent(new Event('input'));
            }
            if (button) {
                button.style.display = 'none';
            }
        };

        // Auto-focus search input when dropdown opens
        document.addEventListener('DOMContentLoaded', function() {
            // Handle all Bootstrap dropdowns
            document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(function(dropdown) {
                dropdown.addEventListener('shown.bs.dropdown', function() {
                    const dropdownMenu = this.nextElementSibling;
                    if (dropdownMenu) {
                        const searchInput = dropdownMenu.querySelector('input[type="text"], input[type="search"]');
                        if (searchInput) {
                            setTimeout(() => {
                                searchInput.focus();
                            }, 100);
                        }
                    }
                });
            });

            // Handle modal search inputs
            document.querySelectorAll('.modal').forEach(function(modal) {
                modal.addEventListener('shown.bs.modal', function() {
                    const searchInput = this.querySelector('input[id$="SearchInput"], input[id="searchInput"]');
                    if (searchInput) {
                        setTimeout(() => {
                            searchInput.focus();
                        }, 300);
                    }
                });
            });

            // Add clear button functionality to all search inputs
            document.querySelectorAll('input[id$="SearchInput"], input[id="searchInput"]').forEach(function(input) {
                const clearBtn = document.getElementById('clear' + input.id.charAt(0).toUpperCase() + input.id.slice(1).replace('Input', ''));
                if (clearBtn) {
                    input.addEventListener('input', function() {
                        clearBtn.style.display = this.value ? 'block' : 'none';
                    });
                }
            });
        });
    </script>

    @stack('scripts')

    <!-- Auto Logout Configuration -->
    @auth
    <script src="{{ asset('js/auto-logout.js') }}?v=2.3.0"></script>
    @endauth

    @include('layouts.currency-script')
</body>
</html>



























