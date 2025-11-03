@extends('layouts.drivvo')

@section('title', '403 - Access Denied')

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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
        animation: pulse 2s infinite;
    }

    .error-icon i {
        font-size: 80px;
        color: white;
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    .error-code {
        font-size: 72px;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
    }

    .btn-primary-error:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        color: white;
    }

    .btn-secondary-error {
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
    }

    .btn-secondary-error:hover {
        background: #f8f9ff;
        color: #667eea;
    }

    .error-details {
        margin-top: 40px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 12px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .error-details h4 {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }

    .error-details ul {
        text-align: left;
        color: #666;
        font-size: 14px;
        line-height: 1.8;
    }
</style>

<div class="error-container">
    <div class="error-icon">
        <i class="fas fa-shield-alt"></i>
    </div>

    <div class="error-code">403</div>
    <h1 class="error-title">Access Denied</h1>
    
    <p class="error-message">
        Maaf, Anda tidak memiliki izin untuk mengakses halaman ini. 
        Halaman ini hanya dapat diakses oleh pengguna dengan role tertentu.
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

    <div class="error-details">
        <h4><i class="fas fa-info-circle"></i> Informasi Akses:</h4>
        <ul>
            <li>Anda login sebagai: <strong>{{ Auth::user()->name }}</strong></li>
            <li>Role Anda: <strong>{{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }}</strong></li>
            <li>Jika Anda merasa ini adalah kesalahan, hubungi administrator</li>
        </ul>
    </div>
</div>
@endsection
