<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Drivvo - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Custom CSS -->
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            margin: 0.2rem 0;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .stats-card.fuel {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        
        .stats-card.maintenance {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        
        .stats-card.expenses {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }
        
        .stats-card.rental {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            color: #495057;
            background-color: #f8f9fa;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
        }
        
        .navbar-brand {
            font-weight: 600;
            color: #495057;
        }
        
        .content-wrapper {
            min-height: calc(100vh - 56px);
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-light">
    <!-- Top Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="bi bi-speedometer2 me-2"></i>
                RajaBlindVan Dashboard
            </a>
            
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-1"></i>
                        User
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 px-0 sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column px-3">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                               href="{{ route('dashboard') }}">
                                <i class="bi bi-speedometer2 me-2"></i>
                                Dashboard
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('vehicles.*') ? 'active' : '' }}" 
                               href="{{ route('vehicles.index') }}">
                                <i class="bi bi-car-front me-2"></i>
                                Kendaraan
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('fuel-fills.*') ? 'active' : '' }}" 
                               href="{{ route('fuel-fills.index') }}">
                                <i class="bi bi-fuel-pump me-2"></i>
                                Isi Bensin
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('maintenances.*') ? 'active' : '' }}" 
                               href="{{ route('maintenances.index') }}">
                                <i class="bi bi-tools me-2"></i>
                                Perawatan
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('expenses.*') ? 'active' : '' }}" 
                               href="{{ route('expenses.index') }}">
                                <i class="bi bi-wallet2 me-2"></i>
                                Pengeluaran
                            </a>
                        </li>
                        
                        <hr class="text-white-50 my-3">
                        
                        <li class="nav-item">
                            <div class="nav-link text-white-50 fw-bold small">
                                RENTAL
                            </div>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}" 
                               href="{{ route('customers.index') }}">
                                <i class="bi bi-people me-2"></i>
                                Customer
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('rentals.*') ? 'active' : '' }}" 
                               href="{{ route('rentals.index') }}">
                                <i class="bi bi-calendar-check me-2"></i>
                                Data Rental
                            </a>
                        </li>
                        
                        <hr class="text-white-50 my-3">
                        
                        <li class="nav-item">
                            <div class="nav-link text-white-50 fw-bold small">
                                LAPORAN
                            </div>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('reports.dashboard') ? 'active' : '' }}" 
                               href="{{ route('reports.dashboard') }}">
                                <i class="bi bi-speedometer2 me-2"></i>
                                Dashboard Laporan
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('reports.rentals') ? 'active' : '' }}" 
                               href="{{ route('reports.rentals') }}">
                                <i class="bi bi-calendar-check me-2"></i>
                                Laporan Rental
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('reports.vehicles') ? 'active' : '' }}" 
                               href="{{ route('reports.vehicles') }}">
                                <i class="bi bi-car-front me-2"></i>
                                Laporan Kendaraan
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('reports.financial') ? 'active' : '' }}" 
                               href="{{ route('reports.financial') }}">
                                <i class="bi bi-currency-dollar me-2"></i>
                                Laporan Keuangan
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('reports.customers') ? 'active' : '' }}" 
                               href="{{ route('reports.customers') }}">
                                <i class="bi bi-people me-2"></i>
                                Laporan Customer
                            </a>
                        </li>
                        
                        <hr class="text-white-50 my-3">
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}" 
                               href="{{ route('settings.index') }}">
                                <i class="bi bi-gear-fill me-2"></i>
                                Pengaturan
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 content-wrapper">
                <div class="py-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>