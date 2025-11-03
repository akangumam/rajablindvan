@extends('layouts.drivvo')

@section('title', '500 - Server Error')

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
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 40px rgba(250, 112, 154, 0.3);
        animation: shake 0.5s infinite;
    }

    .error-icon i {
        font-size: 80px;
        color: white;
    }

    @keyframes shake {
        0%, 100% {
            transform: rotate(0deg);
        }
        25% {
            transform: rotate(-5deg);
        }
        75% {
            transform: rotate(5deg);
        }
    }

    .error-code {
        font-size: 72px;
        font-weight: 700;
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
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
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: white;
        border: none;
    }

    .btn-primary-error:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(250, 112, 154, 0.3);
        color: white;
    }

    .btn-secondary-error {
        background: white;
        color: #fa709a;
        border: 2px solid #fa709a;
    }

    .btn-secondary-error:hover {
        background: #fff5f8;
        color: #fa709a;
    }

    .error-info {
        margin-top: 40px;
        padding: 25px;
        background: #fff3cd;
        border-radius: 12px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        border-left: 4px solid #ffc107;
    }

    .error-info h4 {
        font-size: 16px;
        font-weight: 600;
        color: #856404;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .error-info p {
        color: #856404;
        font-size: 14px;
        line-height: 1.6;
        margin: 0;
    }
</style>

<div class="error-container">
    <div class="error-icon">
        <i class="fas fa-exclamation-triangle"></i>
    </div>

    <div class="error-code">500</div>
    <h1 class="error-title">Internal Server Error</h1>
    
    <p class="error-message">
        Oops! Terjadi kesalahan di server kami. 
        Tim kami telah diberitahu dan sedang memperbaiki masalah ini.
    </p>

    <div class="error-actions">
        <a href="{{ route('dashboard') }}" class="btn-error btn-primary-error">
            <i class="fas fa-home"></i>
            Back to Dashboard
        </a>
        <a href="javascript:location.reload()" class="btn-error btn-secondary-error">
            <i class="fas fa-redo"></i>
            Refresh Page
        </a>
    </div>

    <div class="error-info">
        <h4>
            <i class="fas fa-info-circle"></i>
            Apa yang terjadi?
        </h4>
        <p>
            Server mengalami masalah saat memproses permintaan Anda. 
            Silakan coba lagi dalam beberapa saat. Jika masalah berlanjut, 
            hubungi administrator sistem.
        </p>
    </div>
</div>
@endsection
