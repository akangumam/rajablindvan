@extends('layouts.drivvo')

@section('title', 'User Details')

@section('content')
<style>
    .user-details-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    .card-header-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .card-header-title {
        font-size: 24px;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .card-body-custom {
        padding: 32px;
    }
    .detail-row {
        display: flex;
        padding: 16px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .detail-row:last-child {
        border-bottom: none;
    }
    .detail-label {
        font-weight: 600;
        color: #6c757d;
        width: 250px;
        flex-shrink: 0;
    }
    .detail-value {
        color: #333;
        flex: 1;
    }
    .badge-role {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.3px;
    }
    .badge-admin {
        background: #e3f2fd;
        color: #1976d2;
    }
    .badge-manager {
        background: #fff3e0;
        color: #f57c00;
    }
    .badge-driver {
        background: #f3e5f5;
        color: #7b1fa2;
    }
    .badge-status {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.3px;
    }
    .badge-active {
        background: #d4edda;
        color: #155724;
    }
    .badge-inactive {
        background: #f8d7da;
        color: #721c24;
    }
    .action-buttons {
        display: flex;
        gap: 12px;
    }
    .btn-custom {
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-back {
        background: #6c757d;
        color: white;
        border: none;
    }
    .btn-back:hover {
        background: #5a6268;
        color: white;
    }
    .btn-edit-custom {
        background: #3498db;
        color: white;
        border: none;
    }
    .btn-edit-custom:hover {
        background: #2980b9;
        color: white;
    }
</style>

<div class="user-details-card">
    <div class="card-header-custom">
        <h1 class="card-header-title">
            <i class="fas fa-user-circle"></i>
            User Details
        </h1>
        <div class="action-buttons">
            <a href="{{ route('users.index') }}" class="btn-custom btn-back">
                <i class="fas fa-arrow-left"></i>
                Back to List
            </a>
            <a href="{{ route('users.edit', $user) }}" class="btn-custom btn-edit-custom">
                <i class="fas fa-edit"></i>
                Edit User
            </a>
        </div>
    </div>

    <div class="card-body-custom">
        <div class="detail-row">
            <div class="detail-label">First Name</div>
            <div class="detail-value">{{ $user->first_name ?? $user->name }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Last Name</div>
            <div class="detail-value">{{ $user->last_name ?? '-' }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Email Address</div>
            <div class="detail-value">
                <a href="mailto:{{ $user->email }}" style="color: #3498db; text-decoration: none;">
                    <i class="fas fa-envelope me-2"></i>{{ $user->email }}
                </a>
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Title/Position</div>
            <div class="detail-value">{{ $user->title ?? '-' }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">User Type/Authorization</div>
            <div class="detail-value">
                @if($user->user_type == 'admin')
                    <span class="badge-role badge-admin">
                        <i class="fas fa-user-shield me-2"></i>Administrator
                    </span>
                @elseif($user->user_type == 'manager')
                    <span class="badge-role badge-manager">
                        <i class="fas fa-user-tie me-2"></i>Sales
                    </span>
                @elseif($user->user_type == 'driver')
                    <span class="badge-role badge-driver">
                        <i class="fas fa-user-cog me-2"></i>Operation
                    </span>
                @else
                    <span class="badge-role" style="background: #f5f5f5; color: #666;">User</span>
                @endif
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">User Status</div>
            <div class="detail-value">
                @if(($user->status ?? 'active') == 'active')
                    <span class="badge-status badge-active">
                        <i class="fas fa-check-circle me-2"></i>Active
                    </span>
                @else
                    <span class="badge-status badge-inactive">
                        <i class="fas fa-times-circle me-2"></i>Inactive
                    </span>
                @endif
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Account Created</div>
            <div class="detail-value">
                <i class="fas fa-calendar me-2"></i>
                {{ $user->created_at->format('d M Y, H:i') }}
                <span class="text-muted">({{ $user->created_at->diffForHumans() }})</span>
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Last Updated</div>
            <div class="detail-value">
                <i class="fas fa-clock me-2"></i>
                {{ $user->updated_at->format('d M Y, H:i') }}
                <span class="text-muted">({{ $user->updated_at->diffForHumans() }})</span>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    <i class="fas fa-check-circle me-2"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@endsection
