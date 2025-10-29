@extends('layouts.drivvo')

@section('title', 'Settings - Reminders')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar Menu -->
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-gear-fill text-primary me-2"></i>
                        Settings
                    </h5>
                </div>
                <div class="list-group list-group-flush">
                    <!-- Settings Sub-menu -->
                    <a href="{{ route('settings.units') }}" class="list-group-item list-group-item-action ps-4">
                        <i class="bi bi-speedometer2 text-muted me-2"></i>
                        Units
                    </a>
                    <a href="{{ route('settings.reminders') }}" class="list-group-item list-group-item-action ps-4 active">
                        <i class="bi bi-bell text-primary me-2"></i>
                        Reminders
                    </a>
                    <a href="{{ route('settings.format') }}" class="list-group-item list-group-item-action ps-4">
                        <i class="bi bi-calendar3 text-muted me-2"></i>
                        Format
                    </a>
                    
                    <!-- Divider -->
                    <div class="list-group-item bg-light py-1"></div>
                    
                    <a href="{{ route('settings.account') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-person-circle text-muted me-2"></i>
                        My Account
                    </a>
                    <a href="{{ route('settings.index') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-file-earmark-text text-muted me-2"></i>
                        Files and Storage
                    </a>
                    <a href="{{ route('settings.fuel-types') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-fuel-pump text-muted me-2"></i>
                        Fuel Types
                    </a>
                    <a href="{{ route('settings.fuel-stations') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-shop text-muted me-2"></i>
                        Gas Stations
                    </a>
                    <a href="{{ route('settings.locations') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-geo-alt text-muted me-2"></i>
                        Locations
                    </a>
                    <a href="{{ route('settings.service-types') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-wrench text-muted me-2"></i>
                        Service Types
                    </a>
                    <a href="{{ route('settings.expense-types') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-wallet2 text-muted me-2"></i>
                        Expense Types
                    </a>
                    <a href="{{ route('settings.income-types') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-cash-stack text-muted me-2"></i>
                        Income Types
                    </a>
                    <a href="{{ route('settings.reasons') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-briefcase text-muted me-2"></i>
                        Reasons
                    </a>
                    <a href="{{ route('settings.payment-methods') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-credit-card text-muted me-2"></i>
                        Payment Methods
                    </a>
                    <a href="{{ route('settings.forms') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-file-earmark text-muted me-2"></i>
                        Forms
                    </a>
                    <a href="{{ route('settings.contacts') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-envelope text-muted me-2"></i>
                        Menghubungi
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Reminders</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="#">
                        @csrf
                        
                        <!-- Kilometer Amount -->
                        <div class="mb-4">
                            <label for="kmReminder" class="form-label fw-bold">Kilometer Amount</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="kmReminder" name="km_reminder" value="500" placeholder="500">
                                <span class="input-group-text">Km</span>
                            </div>
                            <a href="#" class="text-primary text-decoration-none small mt-1 d-inline-block">
                                <i class="bi bi-link-45deg"></i> Show Reminders for Next 500 Km / Miles.
                            </a>
                        </div>

                        <hr>

                        <!-- Number of days -->
                        <div class="mb-4">
                            <label for="daysReminder" class="form-label fw-bold">Number of days</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="daysReminder" name="days_reminder" value="30" placeholder="30">
                                <span class="input-group-text">Days</span>
                            </div>
                            <a href="#" class="text-primary text-decoration-none small mt-1 d-inline-block">
                                <i class="bi bi-link-45deg"></i> Show Reminders for Next 30 Days
                            </a>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.list-group-item-action:hover {
    background-color: #f8f9fa;
}
.list-group-item-action.active {
    background-color: #e7f3ff;
    border-left: 3px solid #0d6efd;
    color: #0d6efd;
}
</style>
@endsection






























