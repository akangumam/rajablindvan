@extends('layouts.drivvo')

@section('title', '404 - Page Not Found')

@section('content')
<style>
    .error-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 70vh;
        text-align: center;
        padding: 40px 20px;
    }

    .error-icon {
        width: 200px;
        height: 200px;
        margin-bottom: 30px;
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 40px rgba(240, 147, 251, 0.3);
        animation: float 3s ease-in-out infinite;
    }

    .error-icon i {
        font-size: 80px;
        color: white;
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-20px);
        }
    }

    .error-code {
        font-size: 72px;
        font-weight: 700;
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 20px;
    }

    .error-title {
        font-size: 32px;
        font-weight: 600;
        color: #333;
        margin-bottom: 15px;
    }

    .error-message {
        font-size: 16px;
        color: #666;
        max-width: 500px;
        margin: 0 auto 40px;
        line-height: 1.6;
    }

    .error-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-error {
        padding: 14px 32px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        font-size: 15px;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .btn-primary-error {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        border: none;
    }

    .btn-primary-error:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(240, 147, 251, 0.3);
        color: white;
    }

    .btn-secondary-error {
        background: white;
        color: #f5576c;
        border: 2px solid #f5576c;
    }

    .btn-secondary-error:hover {
        background: #fff5f7;
        color: #f5576c;
    }

    .search-suggestion {
        margin-top: 40px;
        padding: 25px;
        background: white;
        border-radius: 12px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .search-suggestion h4 {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin-bottom: 15px;
    }

    .quick-links {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 10px;
        margin-top: 15px;
    }

    .quick-link {
        padding: 12px 16px;
        background: #f8f9fa;
        border-radius: 8px;
        text-decoration: none;
        color: #666;
        font-size: 14px;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .quick-link:hover {
        background: #667eea;
        color: white;
        transform: translateY(-2px);
    }

    .quick-link i {
        font-size: 16px;
    }
</style>

<div class="error-container">
    <div class="error-icon">
        <i class="fas fa-compass"></i>
    </div>

    <div class="error-code">404</div>
    <h1 class="error-title">Page Not Found</h1>
    
    <p class="error-message">
        Oops! Halaman yang Anda cari tidak ditemukan. 
        Halaman mungkin telah dipindahkan atau URL yang Anda masukkan salah.
    </p>

    <div class="error-actions">
        <a href="{{ route('dashboard') }}" class="btn-error btn-primary-error">
            <i class="fas fa-home"></i>
            Back to Dashboard
        </a>
        <a href="javascript:history.back()" class="btn-error btn-secondary-error">
            <i class="fas fa-arrow-left"></i>
            Go Back
        </a>
    </div>

    <div class="search-suggestion">
        <h4><i class="fas fa-link"></i> Quick Links:</h4>
        <div class="quick-links">
            <a href="{{ route('dashboard') }}" class="quick-link">
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </a>
            <a href="{{ route('vehicles.index') }}" class="quick-link">
                <i class="fas fa-car"></i>
                Vehicles
            </a>
            <a href="{{ route('customers.index') }}" class="quick-link">
                <i class="fas fa-users"></i>
                Customers
            </a>
            <a href="{{ route('orders.index') }}" class="quick-link">
                <i class="fas fa-shopping-cart"></i>
                Orders
            </a>
            <a href="{{ route('reminders.index') }}" class="quick-link">
                <i class="fas fa-bell"></i>
                Reminders
            </a>
            <a href="{{ route('reports.index') }}" class="quick-link">
                <i class="fas fa-chart-bar"></i>
                Reports
            </a>
        </div>
    </div>
</div>
@endsection
