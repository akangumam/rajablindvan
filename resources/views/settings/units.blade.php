@extends('layouts.drivvo')

@section('title', 'Settings - Units')

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
                    <a href="{{ route('settings.units') }}" class="list-group-item list-group-item-action ps-4 active">
                        <i class="bi bi-speedometer2 text-primary me-2"></i>
                        Units
                    </a>
                    <a href="{{ route('settings.reminders') }}" class="list-group-item list-group-item-action ps-4">
                        <i class="bi bi-bell text-muted me-2"></i>
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
                    <h5 class="mb-0">Units</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="#">
                        @csrf
                        
                        <!-- Distance Unit -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Distance Unit (km / Miles)</label>
                            <p class="text-muted small">You must edit your vehicle to change these settings.</p>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="distance_unit" id="distanceKm" value="km" checked>
                                <label class="form-check-label" for="distanceKm">
                                    Kilometer (km)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="distance_unit" id="distanceMiles" value="miles">
                                <label class="form-check-label" for="distanceMiles">
                                    Miles
                                </label>
                            </div>
                        </div>

                        <hr>

                        <!-- Liquid Fuel -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Liquid Fuel</label>
                            <select class="form-select" name="liquid_fuel_unit">
                                <option value="liter" selected>Liter (L)</option>
                                <option value="gallon">Gallon (gal)</option>
                            </select>
                            <a href="#" class="text-primary text-decoration-none small mt-1 d-inline-block">
                                <i class="bi bi-link-45deg"></i> Liter (L)
                            </a>
                        </div>

                        <hr>

                        <!-- Gas Fuel -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Gas Fuel</label>
                            <select class="form-select" name="gas_fuel_unit">
                                <option value="m3" selected>Meter kubik (M³)</option>
                                <option value="kg">Kilogram (kg)</option>
                                <option value="liter">Liter (L)</option>
                            </select>
                            <a href="#" class="text-primary text-decoration-none small mt-1 d-inline-block">
                                <i class="bi bi-link-45deg"></i> M³
                            </a>
                        </div>

                        <hr>

                        <!-- Fuel Efficiency -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Fuel Efficiency</label>
                            <select class="form-select" name="fuel_efficiency_unit">
                                <option value="km_per_liter" selected>Km/Liter</option>
                                <option value="liter_per_100km">Liter/100km</option>
                                <option value="mpg">Miles per gallon (MPG)</option>
                            </select>
                            <a href="#" class="text-primary text-decoration-none small mt-1 d-inline-block">
                                <i class="bi bi-link-45deg"></i> Km/Liter
                            </a>
                        </div>

                        <hr>

                        <!-- Show Average -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Show average in last fuel fill</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="showAverage" name="show_average" checked>
                                <label class="form-check-label" for="showAverage">
                                    Activekan
                                </label>
                            </div>
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






























