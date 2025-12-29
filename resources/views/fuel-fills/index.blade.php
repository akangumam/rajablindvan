@extends('layouts.drivvo')

@section('title', 'Data Isi Bensin')

@section('content')
<style>
    .fuel-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        margin-bottom: 12px;
        transition: all 0.2s ease;
    }
    .fuel-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transform: translateX(4px);
    }
    .fuel-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-right: 16px;
    }
    .fuel-amount {
        font-size: 20px;
        font-weight: 700;
        color: #28a745;
    }
    .fuel-date {
        font-size: 13px;
        color: #6c757d;
    }
    .efficiency-badge {
        padding: 6px 12px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
    }
    .stats-card {
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
    }
    .page-header {
        padding: 0 0 20px 0;
        margin-bottom: 0;
        border-bottom: 2px solid #f0f0f0;
    }
    .page-title {
        font-size: 24px;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0;
    }
    .page-subtitle {
        font-size: 14px;
        color: #6c757d;
        margin: 4px 0 0 0;
    }
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        max-width: 700px;
        margin: 0 auto;
        min-height: calc(100vh - 200px);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
        top: -40px;
    }
    .empty-title {
        font-size: 32px;
        font-weight: 800;
        color: #1a1a1a;
        margin-bottom: 20px;
        letter-spacing: -0.5px;
    }
    .empty-description {
        font-size: 17px;
        color: #6c757d;
        line-height: 1.7;
        margin-bottom: 40px;
        max-width: 500px;
    }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">Riwayat Isi BBM</h1>
        <p class="page-subtitle">Monitor Consumption bahan bakar Vehicle you</p>
    </div>
        </a>
    </div>
</div>

@if($fuelFills->count() > 0)

<!-- Summary Stats -->
<div class="stats-card">
    <div class="row">
        <div class="col-md-3 stat-item text-center">
            <div class="stat-value" style="font-size: 28px; font-weight: 700;">{{ $fuelFills->count() }}</div>
            <div class="stat-label" style="font-size: 13px; opacity: 0.9;">Total Pengisian</div>
        </div>
        <div class="col-md-3 stat-item text-center border-start border-white border-opacity-25">
            <div class="stat-value" style="font-size: 28px; font-weight: 700;">{{ number_format($fuelFills->sum('liters'), 1) }} L</div>
            <div class="stat-label" style="font-size: 13px; opacity: 0.9;">Total Liters</div>
        </div>
        <div class="col-md-3 stat-item text-center border-start border-white border-opacity-25">
            <div class="stat-value" style="font-size: 28px; font-weight: 700;">Rp {{ number_format($fuelFills->sum('total_cost'), 0, ',', '.') }}</div>
            <div class="stat-label" style="font-size: 13px; opacity: 0.9;">Total Cost</div>
        </div>
        <div class="col-md-3 stat-item text-center border-start border-white border-opacity-25">
            <div class="stat-value" style="font-size: 28px; font-weight: 700;">
                {{ $fuelFills->whereNotNull('fuel_efficiency')->avg('fuel_efficiency') ? number_format($fuelFills->whereNotNull('fuel_efficiency')->avg('fuel_efficiency'), 1) : '-' }} km/L
            </div>
            <div class="stat-label" style="font-size: 13px; opacity: 0.9;">Average Consumption</div>
        </div>
    </div>
</div>

<!-- Fuel Fill List -->
<div class="row">
    @foreach($fuelFills as $fuel)
    <div class="col-12">
        <div class="fuel-card">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <!-- Icon -->
                    <div class="fuel-icon">⛽</div>

                    <!-- Main Info -->
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="mb-1">
                                    <span class="badge bg-success">{{ $fuel->vehicle->name }}</span>
                                    <span class="badge bg-secondary">{{ $fuel->vehicle->license_plate }}</span>
                                </h6>
                                <p class="mb-1 text-muted small">
                                    <i class="bi bi-speedometer2"></i> {{ number_format($fuel->odometer, 0, ',', '.') }} km
                                    <span class="mx-2">•</span>
                                    <i class="bi bi-droplet-fill"></i> {{ number_format($fuel->liters, 1) }} Liter
                                    <span class="mx-2">•</span>
                                    Rp {{ number_format($fuel->price_per_liter, 0, ',', '.') }}/L
                                </p>
                                @if($fuel->fuel_type)
                                    <small class="text-muted">{{ $fuel->fuel_type }}</small>
                                @endif
                            </div>
                            <div class="text-end">
                                <div class="fuel-amount">Rp {{ number_format($fuel->total_cost, 0, ',', '.') }}</div>
                                <div class="fuel-date">
                                    <i class="bi bi-calendar3"></i> {{ $fuel->fill_date->format($appDateFormat . ', H:i') }}
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                @if($fuel->fuel_efficiency)
                                    <span class="efficiency-badge">
                                        <i class="bi bi-speedometer"></i> {{ number_format($fuel->fuel_efficiency, 1) }} km/L
                                    </span>
                                @endif
                                @if($fuel->trip_distance)
                                    <span class="ms-2 badge bg-info">
                                        <i class="bi bi-geo-alt"></i> {{ number_format($fuel->trip_distance, 0, ',', '.') }} km
                                    </span>
                                @endif
                                @if(!$fuel->is_full_tank)
                                    <span class="ms-2 badge bg-warning text-dark">
                                        <i class="bi bi-droplet-half"></i> Tidak Full Tank
                                    </span>
                                @endif
                            </div>

                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary rounded-pill" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('fuel-fills.show', $fuel) }}">
                                            <i class="bi bi-eye me-2"></i>Lihat Detail
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('fuel-fills.edit', $fuel) }}">
                                            <i class="bi bi-pencil-square me-2"></i>Edit
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('fuel-fills.destroy', $fuel) }}" method="POST"
                                              onsubmit="return confirm('Yakin want to delete data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-trash me-2"></i>Delete
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
    {{ $fuelFills->links() }}
</div>

@else
<div class="empty-state">
    <div style="width: 160px; height: 160px; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 80px; box-shadow: 0 12px 32px rgba(67, 233, 123, 0.3); margin: 0 auto 40px;">
        ⛽
    </div>
    <h3 class="empty-title">No data yet Isi BBM</h3>
    <p class="empty-description">
        Start recording every pengisian bahan bakar untuk
        memantau Consumption dan efisiensi Vehicle you.
    </p>
    <a href="{{ route('fuel-fills.create') }}" class="btn btn-success btn-lg rounded-pill px-5 shadow">
        <i class="bi bi-plus-lg me-2"></i>Add Data Pertama
    </a>
</div>
@endif
@endsection



























