@extends('layouts.drivvo')

@section('title', 'Reset Password - ' . $user->name)

@section('content')
<style>
.reset-password-card {
    max-width: 600px;
    margin: 40px auto;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    overflow: hidden;
}

.reset-password-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px;
    text-align: center;
}

.reset-password-header h1 {
    margin: 0;
    font-size: 24px;
    font-weight: 600;
}

.reset-password-header p {
    margin: 10px 0 0 0;
    opacity: 0.9;
    font-size: 14px;
}

.reset-password-body {
    padding: 40px;
}

.user-info-box {
    background: #f8f9fa;
    border-left: 4px solid #667eea;
    padding: 20px;
    margin-bottom: 30px;
    border-radius: 4px;
}

.user-info-box h3 {
    margin: 0 0 10px 0;
    font-size: 16px;
    color: #333;
}

.user-info-box p {
    margin: 5px 0;
    color: #666;
    font-size: 14px;
}

.form-group {
    margin-bottom: 25px;
}

.form-label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #333;
    font-size: 14px;
}

.form-control {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 15px;
    transition: all 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-text {
    display: block;
    margin-top: 6px;
    font-size: 12px;
    color: #6c757d;
}

.btn-group {
    display: flex;
    gap: 10px;
    margin-top: 30px;
}

.btn-custom {
    flex: 1;
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
}

.alert {
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.alert-warning {
    background: #fff3cd;
    border: 1px solid #ffc107;
    color: #856404;
}

.alert-danger {
    background: #f8d7da;
    border: 1px solid #dc3545;
    color: #721c24;
}
</style>

<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-key"></i>
        Reset User Password
    </h1>
    <p class="page-subtitle">Set a new password for user account</p>
</div>

<div class="reset-password-card">
    <div class="reset-password-header">
        <h1><i class="fas fa-shield-alt"></i> Reset Password</h1>
        <p>Admin Feature - Set New Password for User</p>
    </div>

    <div class="reset-password-body">
        <!-- User Info -->
        <div class="user-info-box">
            <h3><i class="fas fa-user"></i> User Information</h3>
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Role:</strong> 
                @if($user->role === 'super_admin')
                    Administrator
                @elseif($user->role === 'manager')
                    Sales
                @elseif($user->role === 'operator')
                    Operation
                @else
                    {{ ucfirst($user->role ?? $user->user_type ?? 'User') }}
                @endif
            </p>
        </div>

        <!-- Warning -->
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <strong>Important:</strong> The user will be able to login immediately with the new password. 
                Make sure to inform them about the password change.
            </div>
        </div>

        @if($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-times-circle"></i>
            <div>
                <strong>Error:</strong>
                <ul style="margin: 5px 0 0 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <!-- Reset Password Form -->
        <form method="POST" action="{{ route('users.reset-password', $user) }}">
            @csrf

            <div class="form-group">
                <label class="form-label" for="new_password">
                    <i class="fas fa-lock"></i> New Password
                </label>
                <input type="password" 
                       class="form-control" 
                       id="new_password" 
                       name="new_password" 
                       required 
                       minlength="8"
                       placeholder="Enter new password (min. 8 characters)">
                <small class="form-text">Password must be at least 8 characters long</small>
            </div>

            <div class="form-group">
                <label class="form-label" for="new_password_confirmation">
                    <i class="fas fa-lock"></i> Confirm New Password
                </label>
                <input type="password" 
                       class="form-control" 
                       id="new_password_confirmation" 
                       name="new_password_confirmation" 
                       required
                       minlength="8"
                       placeholder="Re-enter new password">
                <small class="form-text">Both passwords must match</small>
            </div>

            <div class="btn-group">
                <a href="{{ route('users.show', $user) }}" class="btn-custom btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="btn-custom btn-primary">
                    <i class="fas fa-check"></i> Reset Password
                </button>
            </div>
        </form>

        <!-- Note for future email feature -->
        <div style="margin-top: 30px; padding: 15px; background: #e7f3ff; border-radius: 8px; font-size: 13px; color: #004085;">
            <i class="fas fa-info-circle"></i>
            <strong>Note:</strong> Email notification to user will be available when email service is configured on production server.
        </div>
    </div>
</div>
@endsection
