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
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            padding: 0;
        }

        .drivvo-brand {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100px;
            text-align: center;
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
            /* Ukuran Logo - Extra Large */
            max-width: 200px !important;
            max-height: 70px !important;
            width: auto !important;
            height: auto !important;
            object-fit: contain;
            display: block;
            margin: 0 auto;
            
            /* White Logo Filter */
            filter: brightness(0) invert(1);
        }
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

        .main-content {
            margin-left: 240px;
            padding: 20px;
            min-height: 100vh;
            background-color: #f8f9fa;
            width: calc(100vw - 240px);
            overflow: visible;
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
    </style>

    @stack('styles')
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="drivvo-sidebar">
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

                <!-- Tambah Baru Button -->
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
                    <a href="{{ route('reports.financial') }}" class="drivvo-nav-link">
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

                <div class="nav-divider"></div>

                <!-- Settings -->
                <div class="drivvo-nav-item">
                    <a href="{{ route('settings.index') }}" class="drivvo-nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i>
                        {{ __('common.settings') }}
                    </a>
                </div>

                <div class="nav-divider"></div>

                <!-- Language Switcher -->
                <div class="drivvo-nav-item">
                    <div style="padding: 0 16px;">
                        <div style="color: rgba(255,255,255,0.5); font-size: 12px; margin-bottom: 8px; text-transform: uppercase; font-weight: 600;">Bahasa / Language</div>
                        <div class="btn-group w-100" role="group">
                            <a href="{{ route('locale.switch', 'id') }}" 
                               class="btn btn-sm {{ app()->getLocale() == 'id' ? 'btn-light' : 'btn-outline-light' }}"
                               style="flex: 1; font-size: 13px; font-weight: 600;">
                                🇮🇩 ID
                            </a>
                            <a href="{{ route('locale.switch', 'en') }}" 
                               class="btn btn-sm {{ app()->getLocale() == 'en' ? 'btn-light' : 'btn-outline-light' }}"
                               style="flex: 1; font-size: 13px; font-weight: 600;">
                                🇬🇧 EN
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
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
                    <!-- Pengisian -->
                    <a href="{{ route('fuel-fills.create') }}" class="quick-add-item">
                        <div class="quick-add-icon fuel">
                            <i class="fas fa-gas-pump"></i>
                        </div>
                        <div class="quick-add-text">{{ __('quick_add.fuel_fill') }}</div>
                    </a>

                    <!-- Layanan -->
                    <a href="{{ route('maintenances.create') }}" class="quick-add-item">
                        <div class="quick-add-icon service">
                            <i class="fas fa-wrench"></i>
                        </div>
                        <div class="quick-add-text">{{ __('quick_add.maintenance') }}</div>
                    </a>

                    <!-- Biaya -->
                    <a href="{{ route('expenses.create') }}" class="quick-add-item">
                        <div class="quick-add-icon expense">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <div class="quick-add-text">{{ __('quick_add.expense') }}</div>
                    </a>

                    <!-- Pendapatan -->
                    <a href="{{ route('incomes.create') }}" class="quick-add-item">
                        <div class="quick-add-icon income">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="quick-add-text">{{ __('quick_add.income') }}</div>
                    </a>

                    <!-- Rute -->
                    <a href="{{ route('trips.create') }}" class="quick-add-item">
                        <div class="quick-add-icon route">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <div class="quick-add-text">{{ __('quick_add.trip') }}</div>
                    </a>

                    <!-- Daftar cek -->
                    <a href="{{ route('checklists.create') }}" class="quick-add-item">
                        <div class="quick-add-icon checklist">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <div class="quick-add-text">{{ __('quick_add.checklist') }}</div>
                    </a>

                    <!-- Pengingat -->
                    <a href="{{ route('reminders.create') }}" class="quick-add-item">
                        <div class="quick-add-icon reminder">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="quick-add-text">{{ __('quick_add.reminder') }}</div>
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
                    <h5 class="modal-title fw-semibold" id="vehicleModalLabel">Kendaraan</h5>
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
                            TAMBAH BARU
                        </button>
                        <button type="button" class="btn btn-outline-primary" onclick="window.location.href='{{ route('vehicles.index') }}'">
                            KELOLA KENDARAAN
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>