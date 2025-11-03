<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
        }

        .drivvo-add-btn {
            background-color: #3498db;
            color: white;
            border-radius: 50px;
            padding: 12px 20px;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        .drivvo-add-btn:hover {
            background-color: #2980b9;
            color: white;
            transform: translateY(-1px);
        }

        .drivvo-add-btn i {
            margin-right: 8px;
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

        /* Modal Styles */
        .quick-add-modal .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .quick-add-item {
            display: flex;
            align-items: center;
            padding: 16px 20px;
            text-decoration: none;
            color: #333;
            transition: background-color 0.2s ease;
            border-radius: 8px;
            margin: 4px 0;
        }

        .quick-add-item:hover {
            background-color: #f8f9fa;
            color: #333;
        }

        .quick-add-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 16px;
            color: white;
            font-size: 16px;
        }

        .quick-add-icon.fuel { background-color: #ff9500; }
        .quick-add-icon.service { background-color: #8b5a3c; }
        .quick-add-icon.expense { background-color: #ff3b30; }
        .quick-add-icon.income { background-color: #34c759; }
        .quick-add-icon.route { background-color: #5e5ce6; }
        .quick-add-icon.checklist { background-color: #007aff; }
        .quick-add-icon.reminder { background-color: #af52de; }

        .quick-add-text {
            font-weight: 500;
            font-size: 16px;
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
            .mobile-menu-toggle {
                display: block;
            }

            .drivvo-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                width: 280px;
                z-index: 1050;
            }

            .drivvo-sidebar.active {
                transform: translateX(0);
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
    </style>

    @stack('styles')
</head>

<body>
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
                        {{ __('common.dashboard') }}
                    </a>
                </div>

                <!-- History -->
                <div class="drivvo-nav-item">
                    <a href="{{ route('history.index') }}" class="drivvo-nav-link {{ request()->routeIs('history.*') ? 'active' : '' }}">
                        <i class="fas fa-history"></i>
                        History
                    </a>
                </div>

                <!-- ADD NEW Button -->
                <div class="drivvo-nav-item">
                    <button type="button" class="drivvo-add-btn" data-bs-toggle="modal" data-bs-target="#quickAddModal">
                        <i class="fas fa-plus"></i>
                        {{ __('common.add_new') }}
                    </button>
                </div>

                <!-- Other Menu Items -->
                <div class="drivvo-nav-item">
                    <a href="{{ route('reminders.index') }}" class="drivvo-nav-link {{ request()->routeIs('reminders.*') ? 'active' : '' }}">
                        <i class="fas fa-bell"></i>
                        {{ __('common.reminders') }}
                    </a>
                </div>

                <div class="drivvo-nav-item">
                    <a href="{{ route('reports.index') }}" class="drivvo-nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i>
                        {{ __('common.reports') }}
                    </a>
                </div>

                <div class="nav-divider"></div>

                <!-- Vehicles & Users -->
                <div class="drivvo-nav-item">
                    <a href="{{ route('vehicles.index') }}" class="drivvo-nav-link {{ request()->routeIs('vehicles.*') ? 'active' : '' }}">
                        <i class="fas fa-car"></i>
                        {{ __('common.vehicles') }}
                    </a>
                </div>

                <div class="drivvo-nav-item">
                    <a href="{{ route('customers.index') }}" class="drivvo-nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        {{ __('common.customers') }}
                    </a>
                </div>

                <!-- Order List -->
                <div class="drivvo-nav-item">
                    <a href="{{ route('orders.index') }}" class="drivvo-nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                        <i class="fas fa-clipboard-list"></i>
                        Order List
                    </a>
                </div>

                <!-- Users (Only for Administrator) -->
                @auth
                @if(Auth::user()->canManageUsers())
                <div class="drivvo-nav-item">
                    <a href="{{ route('users.index') }}" class="drivvo-nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="fas fa-user"></i>
                        Users
                    </a>
                </div>
                @endif
                @endauth

                <div class="nav-divider"></div>

                <!-- Settings -->
                <div class="drivvo-nav-item">
                    <a href="{{ route('settings.index') }}" class="drivvo-nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i>
                        Settings
                    </a>
                </div>

                <!-- Logout -->
                <div class="drivvo-nav-item">
                    <button type="button" class="drivvo-nav-link" onclick="showLogoutModal()" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; color: inherit; padding: 12px 20px;">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
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
                <div>
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

    <!-- Quick Add Modal -->
    <div class="modal fade quick-add-modal" id="quickAddModal" tabindex="-1" aria-labelledby="quickAddModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 380px;">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <!-- Income -->
                    <a href="{{ route('incomes.create') }}" class="quick-add-item">
                        <div class="quick-add-icon income">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="quick-add-text">Income</div>
                    </a>

                    <!-- Service (Maintenance) -->
                    <a href="{{ route('maintenances.create') }}" class="quick-add-item">
                        <div class="quick-add-icon service">
                            <i class="fas fa-wrench"></i>
                        </div>
                        <div class="quick-add-text">Service</div>
                    </a>

                    <!-- Expense -->
                    <a href="{{ route('expenses.create') }}" class="quick-add-item">
                        <div class="quick-add-icon expense">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <div class="quick-add-text">Expense</div>
                    </a>
                </div>
            </div>
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
                        <button type="button" class="btn btn-outline-primary" onclick="window.location.href='{{ route('vehicles.index') }}'">
                            {{ __('vehicle.manage_vehicles') }}
                        </button>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Logout Modal Script -->
    <script>
        function showLogoutModal() {
            const logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
            logoutModal.show();
        }

        function confirmLogout() {
            document.getElementById('logoutForm').submit();
        }

        // Mobile Menu Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const mobileMenuClose = document.getElementById('mobileMenuClose');
            const sidebar = document.querySelector('.drivvo-sidebar');
            const overlay = document.getElementById('sidebarOverlay');

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
            const sidebarLinks = sidebar.querySelectorAll('.drivvo-nav-link, .quick-add-item');
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
                    }
                }, 250);
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>



























