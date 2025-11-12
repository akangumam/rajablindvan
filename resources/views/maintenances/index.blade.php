@extends('layouts.drivvo')@extends('layouts.drivvo')@extends('layouts.drivvo')@extends('layouts.drivvo')@extends('layouts.drivvo')@extends('layouts.drivvo')@extends('layouts.drivvo')



@section('title', 'Service & Maintenance')



@section('content')@section('title', 'Service & Maintenance')

<style>

    .page-header {

        display: flex;

        justify-content: space-between;@section('content')@section('title', 'Data Perawatan')

        align-items: center;

        margin-bottom: 24px;<style>

        background: white;

        padding: 30px;    .page-header {

        border-radius: 8px;

        box-shadow: 0 1px 3px rgba(0,0,0,0.1);        display: flex;

    }

    .page-title {        justify-content: space-between;@section('content')@section('title', 'Data Perawatan')

        font-size: 32px;

        font-weight: 700;        align-items: center;

        color: #2c3e50;

        margin: 0 0 8px 0;        margin-bottom: 24px;<style>

        display: flex;

        align-items: center;        background: white;

        gap: 12px;

    }        padding: 30px;    .page-header {

    .page-title i {

        font-size: 28px;        border-radius: 8px;

        color: #fd7e14;

    }        box-shadow: 0 1px 3px rgba(0,0,0,0.1);        padding: 0 0 20px 0;

    .page-subtitle {

        font-size: 15px;    }

        color: #7f8c8d;

        margin: 0;    .page-title {        margin-bottom: 0;@section('content')@section('title', 'Data Perawatan')

        font-weight: 400;

    }        font-size: 32px;

    .btn-add-maintenance {

        background: white;        font-weight: 700;        border-bottom: 2px solid #f0f0f0;

        border: 2px solid #fd7e14;

        color: #fd7e14;        color: #2c3e50;

        padding: 10px 24px;

        border-radius: 8px;        margin: 0 0 8px 0;    }<style>

        font-weight: 600;

        text-transform: uppercase;        display: flex;

        font-size: 14px;

        letter-spacing: 0.5px;        align-items: center;    .page-title {

        transition: all 0.3s ease;

        text-decoration: none;        gap: 12px;

        display: inline-block;

    }    }        font-size: 28px;    .maintenance-card {

    .btn-add-maintenance:hover {

        background: #fd7e14;    .page-title i {

        color: white;

        transform: translateY(-1px);        font-size: 28px;        font-weight: 800;

        box-shadow: 0 4px 12px rgba(253, 126, 20, 0.3);

    }        color: #fd7e14;

    .maintenance-table-container {

        background: white;    }        color: #1a1a1a;        border: none;

        border-radius: 12px;

        overflow: hidden;    .page-subtitle {

        box-shadow: 0 1px 3px rgba(0,0,0,0.1);

    }        font-size: 15px;        margin: 0;

    .maintenance-table {

        width: 100%;        color: #7f8c8d;

        margin: 0;

    }        margin: 0;        letter-spacing: -0.5px;        border-radius: 12px;@section('content')@section('title', 'Data Perawatan')@section('title', 'Data Perawatan')

    .maintenance-table thead {

        background: #f8f9fa;        font-weight: 400;

        border-bottom: 2px solid #e9ecef;

    }    }    }

    .maintenance-table thead th {

        padding: 16px 20px;    .btn-add-maintenance {

        font-size: 13px;

        font-weight: 600;        background: white;    .page-subtitle {        box-shadow: 0 2px 8px rgba(0,0,0,0.06);

        color: #6c757d;

        text-transform: uppercase;        border: 2px solid #fd7e14;

        letter-spacing: 0.5px;

        border: none;        color: #fd7e14;        font-size: 15px;

    }

    .maintenance-table tbody td {        padding: 10px 24px;

        padding: 20px;

        vertical-align: middle;        border-radius: 8px;        color: #6c757d;        margin-bottom: 12px;<style>

        border-bottom: 1px solid #f0f0f0;

        font-size: 14px;        font-weight: 600;

        color: #495057;

    }        text-transform: uppercase;        margin: 8px 0 0 0;

    .maintenance-table tbody tr:hover {

        background: #f8f9fa;        font-size: 14px;

    }

    .vehicle-badge {        letter-spacing: 0.5px;        font-weight: 400;        transition: all 0.2s ease;

        display: inline-flex;

        align-items: center;        transition: all 0.3s ease;

        gap: 8px;

        padding: 6px 12px;    }    }

        background: #e3f2fd;

        border-radius: 6px;    .btn-add-maintenance:hover {

        font-weight: 500;

        color: #1976d2;        background: #fd7e14;    .empty-state {    }    .maintenance-card {

        font-size: 13px;

    }        color: white;

    .type-badge {

        padding: 6px 12px;        transform: translateY(-1px);        text-align: center;

        border-radius: 6px;

        font-weight: 500;        box-shadow: 0 4px 12px rgba(253, 126, 20, 0.3);

        font-size: 12px;

        text-transform: uppercase;    }        padding: 40px 20px;    .maintenance-card:hover {

    }

    .type-badge.service {    .maintenance-table-container {

        background: #fff3cd;

        color: #856404;        background: white;        max-width: 650px;

    }

    .type-badge.repair {        border-radius: 12px;

        background: #f8d7da;

        color: #721c24;        overflow: hidden;        margin: 0 auto;        box-shadow: 0 4px 12px rgba(0,0,0,0.1);        border: none;

    }

    .status-badge {        box-shadow: 0 1px 3px rgba(0,0,0,0.1);

        padding: 6px 12px;

        border-radius: 6px;    }        min-height: calc(100vh - 200px);

        font-weight: 500;

        font-size: 12px;    .maintenance-table {

    }

    .status-badge.completed {        width: 100%;        display: flex;        transform: translateX(4px);

        background: #d4edda;

        color: #155724;        margin: 0;

    }

    .status-badge.scheduled {    }        flex-direction: column;

        background: #cce5ff;

        color: #004085;    .maintenance-table thead {

    }

    .action-btns {        background: #f8f9fa;        align-items: center;    }        border-radius: 12px;@section('content')@section('content')

        display: flex;

        gap: 8px;        border-bottom: 2px solid #e9ecef;

    }

    .btn-action {    }        justify-content: center;

        padding: 8px 12px;

        border-radius: 6px;    .maintenance-table thead th {

        border: none;

        font-size: 13px;        padding: 16px 20px;        position: relative;    .maintenance-icon {

        cursor: pointer;

        transition: all 0.2s ease;        font-size: 13px;

        text-decoration: none;

        display: inline-block;        font-weight: 600;        top: -40px;

    }

    .btn-view {        color: #6c757d;

        background: #e3f2fd;

        color: #1976d2;        text-transform: uppercase;    }        width: 48px;        box-shadow: 0 2px 8px rgba(0,0,0,0.06);

    }

    .btn-view:hover {        letter-spacing: 0.5px;

        background: #1976d2;

        color: white;        border: none;    .empty-title {

    }

    .btn-edit {    }

        background: #fff3cd;

        color: #856404;    .maintenance-table tbody td {        font-size: 32px;        height: 48px;

    }

    .btn-edit:hover {        padding: 20px;

        background: #ffc107;

        color: white;        vertical-align: middle;        font-weight: 800;

    }

    .btn-delete {        border-bottom: 1px solid #f0f0f0;

        background: #f8d7da;

        color: #721c24;        font-size: 14px;        color: #1a1a1a;        border-radius: 12px;        margin-bottom: 12px;<style><div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    }

    .btn-delete:hover {        color: #495057;

        background: #dc3545;

        color: white;    }        margin-bottom: 20px;

    }

    .empty-state {    .maintenance-table tbody tr:hover {

        text-align: center;

        padding: 60px 20px;        background: #f8f9fa;        letter-spacing: -0.5px;        display: flex;

        max-width: 600px;

        margin: 40px auto;    }

    }

    .empty-icon {    .vehicle-badge {    }

        font-size: 64px;

        color: #dee2e6;        display: inline-flex;

        margin-bottom: 20px;

    }        align-items: center;    .empty-description {        align-items: center;        transition: all 0.2s ease;

    .empty-title {

        font-size: 28px;        gap: 8px;

        font-weight: 700;

        color: #2c3e50;        padding: 6px 12px;        font-size: 17px;

        margin-bottom: 12px;

    }        background: #e3f2fd;

    .empty-subtitle {

        font-size: 16px;        border-radius: 6px;        color: #6c757d;        justify-content: center;

        color: #6c757d;

        margin-bottom: 30px;        font-weight: 500;

    }

</style>        color: #1976d2;        line-height: 1.7;



<div class="container-fluid">        font-size: 13px;

    @if(session('success'))

    <div class="alert alert-success alert-dismissible fade show" role="alert">    }        margin-bottom: 40px;        font-size: 24px;    }    .maintenance-card {    <h1 class="h2">Data Perawatan & Service</h1>

        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>    .type-badge {

    </div>

    @endif        padding: 6px 12px;        max-width: 500px;



    <div class="page-header">        border-radius: 6px;

        <div>

            <h1 class="page-title">        font-weight: 500;    }        margin-right: 16px;

                <i class="fas fa-wrench"></i>

                Service & Maintenance        font-size: 12px;

            </h1>

            <p class="page-subtitle">Manage vehicle service and maintenance records</p>        text-transform: uppercase;</style>

        </div>

        <a href="{{ route('maintenances.create') }}" class="btn btn-add-maintenance">    }

            <i class="fas fa-plus me-2"></i>Add New Service

        </a>    .type-badge.service {    }    .maintenance-card:hover {

    </div>

        background: #fff3cd;

    @if($maintenances->count() > 0)

    <div class="maintenance-table-container">        color: #856404;<div class="page-header">

        <table class="maintenance-table">

            <thead>    }

                <tr>

                    <th>Date</th>    .type-badge.repair {    <div>    .category-routine { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }

                    <th>Vehicle</th>

                    <th>Type</th>        background: #f8d7da;

                    <th>Service Type</th>

                    <th>Odometer</th>        color: #721c24;        <h1 class="page-title">Riwayat Perawatan & Service</h1>

                    <th>Place</th>

                    <th>Cost</th>    }

                    <th>Status</th>

                    <th>Actions</th>    .status-badge {        <p class="page-subtitle">Pantau jadwal perawatan kendaraan Anda</p>    .category-repair { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }        box-shadow: 0 4px 12px rgba(0,0,0,0.1);        border: none;    <div class="btn-toolbar mb-2 mb-md-0">

                </tr>

            </thead>        padding: 6px 12px;

            <tbody>

                @foreach($maintenances as $maintenance)        border-radius: 6px;    </div>

                <tr>

                    <td>        font-weight: 500;

                        <div class="fw-bold">{{ $maintenance->maintenance_date->format('d M Y') }}</div>

                        <small class="text-muted">{{ $maintenance->maintenance_date->diffForHumans() }}</small>        font-size: 12px;</div>    .category-emergency { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }

                    </td>

                    <td>    }

                        <div class="vehicle-badge">

                            <i class="fas fa-car"></i>    .status-badge.completed {

                            {{ $maintenance->vehicle->name ?? 'N/A' }}

                        </div>        background: #d4edda;

                    </td>

                    <td>        color: #155724;@if($maintenances->count() > 0)        transform: translateX(4px);

                        @php

                            $category = strtolower($maintenance->category ?? 'service');    }

                        @endphp

                        <span class="type-badge {{ $category }}">    .status-badge.scheduled {

                            {{ $maintenance->type ?? 'Service' }}

                        </span>        background: #cce5ff;

                    </td>

                    <td>        color: #004085;<!-- Show data if available -->    .maintenance-amount {

                        <strong>{{ $maintenance->service_type ?? '-' }}</strong>

                    </td>    }

                    <td>

                        <span class="text-nowrap">{{ number_format($maintenance->odometer, 0, ',', '.') }} km</span>    .action-btns {<div class="alert alert-info">

                    </td>

                    <td>{{ $maintenance->place ?? $maintenance->workshop ?? '-' }}</td>        display: flex;

                    <td>

                        @php        gap: 8px;    Data perawatan tersedia. Feature list belum diimplementasi.        font-size: 20px;    }        border-radius: 12px;        <a href="{{ route('maintenances.create') }}" class="btn btn-primary">

                            $cost = $maintenance->total_cost ?? $maintenance->cost ?? 0;

                        @endphp    }

                        <strong class="text-danger">Rp {{ number_format($cost, 0, ',', '.') }}</strong>

                    </td>    .btn-action {</div>

                    <td>

                        @php        padding: 8px 12px;

                            $statusMap = [

                                'Completed' => ['text' => 'Completed', 'class' => 'completed'],        border-radius: 6px;        font-weight: 700;

                                'Scheduled' => ['text' => 'Scheduled', 'class' => 'scheduled'],

                                'Overdue' => ['text' => 'Overdue', 'class' => 'overdue']        border: none;

                            ];

                            $status = $statusMap[$maintenance->status] ?? ['text' => $maintenance->status, 'class' => 'completed'];        font-size: 13px;@else

                        @endphp

                        <span class="status-badge {{ $status['class'] }}">{{ $status['text'] }}</span>        cursor: pointer;

                    </td>

                    <td>        transition: all 0.2s ease;<div class="empty-state">        color: #fd7e14;    .maintenance-icon {

                        <div class="action-btns">

                            <a href="{{ route('maintenances.show', $maintenance) }}" class="btn-action btn-view" title="View">    }

                                <i class="fas fa-eye"></i>

                            </a>    .btn-view {    <div style="width: 160px; height: 160px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 80px; box-shadow: 0 12px 32px rgba(250, 112, 154, 0.3); margin: 0 auto 40px;">

                            <a href="{{ route('maintenances.edit', $maintenance) }}" class="btn-action btn-edit" title="Edit">

                                <i class="fas fa-edit"></i>        background: #e3f2fd;

                            </a>

                            @if(auth()->user()->canDeleteRecords())        color: #1976d2;        🔧    }

                            <form action="{{ route('maintenances.destroy', $maintenance) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this maintenance record?')">

                                @csrf    }

                                @method('DELETE')

                                <button type="submit" class="btn-action btn-delete" title="Delete">    .btn-view:hover {    </div>

                                    <i class="fas fa-trash"></i>

                                </button>        background: #1976d2;

                            </form>

                            @endif        color: white;    <h3 class="empty-title">Belum Ada Data Perawatan</h3>    .maintenance-date {        width: 48px;        box-shadow: 0 2px 8px rgba(0,0,0,0.06);            <i class="bi bi-plus-circle me-1"></i>

                        </div>

                    </td>    }

                </tr>

                @endforeach    .btn-edit {    <p class="empty-description">

            </tbody>

        </table>        background: #fff3cd;



        <div class="p-3">        color: #856404;        Mulai mencatat setiap perawatan dan service kendaraan        font-size: 13px;

            {{ $maintenances->links() }}

        </div>    }

    </div>

    @else    .btn-edit:hover {        untuk menjaga performa dan kondisi kendaraan Anda.

    <div class="maintenance-table-container">

        <div class="empty-state">        background: #ffc107;

            <div class="empty-icon">

                <i class="fas fa-wrench"></i>        color: white;    </p>        color: #6c757d;        height: 48px;

            </div>

            <h2 class="empty-title">No Service Records Yet</h2>    }

            <p class="empty-subtitle">Start tracking your vehicle maintenance by adding your first service record.</p>

            <a href="{{ route('maintenances.create') }}" class="btn btn-add-maintenance">    .btn-delete {    <a href="{{ route('maintenances.create') }}" class="btn btn-warning btn-lg rounded-pill px-5 shadow">

                <i class="fas fa-plus me-2"></i>Add First Service

            </a>        background: #f8d7da;

        </div>

    </div>        color: #721c24;        <i class="bi bi-plus-lg me-2"></i>Tambah Data Pertama    }

    @endif

</div>    }

@endsection

    .btn-delete:hover {    </a>

        background: #dc3545;

        color: white;</div>    .status-badge {        border-radius: 12px;        margin-bottom: 12px;            Tambah Data Service

    }

    .empty-state {@endif

        text-align: center;

        padding: 60px 20px;@endsection        padding: 6px 12px;

        max-width: 600px;

        margin: 40px auto;        border-radius: 8px;        display: flex;

    }

    .empty-icon {        font-size: 12px;

        font-size: 64px;

        color: #dee2e6;        font-weight: 600;        align-items: center;        transition: all 0.2s ease;        </a>

        margin-bottom: 20px;

    }        color: white;

    .empty-title {

        font-size: 28px;    }        justify-content: center;

        font-weight: 700;

        color: #2c3e50;    .status-completed { background: #28a745; }

        margin-bottom: 12px;

    }    .status-scheduled { background: #007bff; }        font-size: 24px;    }    </div>

    .empty-subtitle {

        font-size: 16px;    .status-overdue { background: #dc3545; }

        color: #6c757d;

        margin-bottom: 30px;        margin-right: 16px;

    }

    .pagination {    .stats-card {

        margin-top: 20px;

    }        border-radius: 12px;    }    .maintenance-card:hover {</div>

</style>

        padding: 20px;

<div class="container-fluid">

    <!-- Success Message -->        margin-bottom: 24px;    .category-routine { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }

    @if(session('success'))

    <div class="alert alert-success alert-dismissible fade show" role="alert">        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);

        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>        color: white;    .category-repair { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }        box-shadow: 0 4px 12px rgba(0,0,0,0.1);

    </div>

    @endif    }



    <!-- Page Header -->    .page-header {    .category-emergency { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }

    <div class="page-header">

        <div>        padding: 0 0 28px 0;

            <h1 class="page-title">

                <i class="fas fa-wrench"></i>        margin-bottom: 28px;        transform: translateX(4px);@if($maintenances->count() > 0)

                Service & Maintenance

            </h1>        border-bottom: 2px solid #f0f0f0;

            <p class="page-subtitle">Manage vehicle service and maintenance records</p>

        </div>    }    .maintenance-amount {

        <a href="{{ route('maintenances.create') }}" class="btn btn-add-maintenance">

            <i class="fas fa-plus me-2"></i>Add New Service    .page-title {

        </a>

    </div>        font-size: 28px;        font-size: 20px;    }<div class="card">



    @if($maintenances->count() > 0)        font-weight: 800;

    <!-- Maintenance Table -->

    <div class="maintenance-table-container">        color: #1a1a1a;        font-weight: 700;

        <table class="maintenance-table">

            <thead>        margin: 0;

                <tr>

                    <th>Date</th>        letter-spacing: -0.5px;        color: #fd7e14;    .maintenance-icon {    <div class="card-body p-0">

                    <th>Vehicle</th>

                    <th>Type</th>    }

                    <th>Service Type</th>

                    <th>Odometer</th>    .page-subtitle {    }

                    <th>Place</th>

                    <th>Cost</th>        font-size: 15px;

                    <th>Status</th>

                    <th>Actions</th>        color: #6c757d;    .maintenance-date {        width: 48px;        <div class="table-responsive">

                </tr>

            </thead>        margin: 8px 0 0 0;

            <tbody>

                @foreach($maintenances as $maintenance)        font-weight: 400;        font-size: 13px;

                <tr>

                    <td>    }

                        <div class="fw-bold">{{ $maintenance->maintenance_date->format('d M Y') }}</div>

                        <small class="text-muted">{{ $maintenance->maintenance_date->diffForHumans() }}</small>    .empty-state {        color: #6c757d;        height: 48px;            <table class="table table-hover mb-0">

                    </td>

                    <td>        text-align: center;

                        <div class="vehicle-badge">

                            <i class="fas fa-car"></i>        padding: 80px 20px;    }

                            {{ $maintenance->vehicle->name ?? 'N/A' }}

                        </div>        max-width: 650px;

                    </td>

                    <td>        margin: 60px auto;    .status-badge {        border-radius: 12px;                <thead class="table-light">

                        <span class="type-badge {{ strtolower($maintenance->category ?? 'service') }}">

                            {{ $maintenance->type ?? 'Service' }}        min-height: 60vh;

                        </span>

                    </td>        display: flex;        padding: 6px 12px;

                    <td>

                        <strong>{{ $maintenance->service_type ?? '-' }}</strong>        flex-direction: column;

                    </td>

                    <td>        align-items: center;        border-radius: 8px;        display: flex;                    <tr>

                        <span class="text-nowrap">{{ number_format($maintenance->odometer, 0, ',', '.') }} km</span>

                    </td>        justify-content: center;

                    <td>{{ $maintenance->place ?? $maintenance->workshop ?? '-' }}</td>

                    <td>    }        font-size: 12px;

                        <strong class="text-danger">Rp {{ number_format($maintenance->total_cost ?? $maintenance->cost ?? 0, 0, ',', '.') }}</strong>

                    </td>    .empty-title {

                    <td>

                        @php        font-size: 32px;        font-weight: 600;        align-items: center;                        <th>Tanggal</th>

                            $statusMap = [

                                'Completed' => ['text' => 'Completed', 'class' => 'completed'],        font-weight: 800;

                                'Scheduled' => ['text' => 'Scheduled', 'class' => 'scheduled'],

                                'Overdue' => ['text' => 'Overdue', 'class' => 'overdue']        color: #1a1a1a;        color: white;

                            ];

                            $status = $statusMap[$maintenance->status] ?? ['text' => $maintenance->status, 'class' => 'completed'];        margin-bottom: 20px;

                        @endphp

                        <span class="status-badge {{ $status['class'] }}">{{ $status['text'] }}</span>        letter-spacing: -0.5px;    }        justify-content: center;                        <th>Kendaraan</th>

                    </td>

                    <td>    }

                        <div class="action-btns">

                            <a href="{{ route('maintenances.show', $maintenance) }}" class="btn-action btn-view" title="View">    .empty-description {    .status-completed { background: #28a745; }

                                <i class="fas fa-eye"></i>

                            </a>        font-size: 17px;

                            <a href="{{ route('maintenances.edit', $maintenance) }}" class="btn-action btn-edit" title="Edit">

                                <i class="fas fa-edit"></i>        color: #6c757d;    .status-scheduled { background: #007bff; }        font-size: 24px;                        <th>Jenis Service</th>

                            </a>

                            @if(auth()->user()->canDeleteRecords())        line-height: 1.7;

                            <form action="{{ route('maintenances.destroy', $maintenance) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this maintenance record?')">

                                @csrf        margin-bottom: 40px;    .status-overdue { background: #dc3545; }

                                @method('DELETE')

                                <button type="submit" class="btn-action btn-delete" title="Delete">        max-width: 500px;

                                    <i class="fas fa-trash"></i>

                                </button>    }        margin-right: 16px;                        <th>Kategori</th>

                            </form>

                            @endif</style>

                        </div>

                    </td>    .stats-card {

                </tr>

                @endforeach<div class="page-header">

            </tbody>

        </table>    <div>        border-radius: 12px;    }                        <th>Odometer</th>



        <!-- Pagination -->        <h1 class="page-title">Riwayat Perawatan & Service</h1>

        <div class="p-3">

            {{ $maintenances->links() }}        <p class="page-subtitle">Pantau jadwal perawatan kendaraan Anda</p>        padding: 20px;

        </div>

    </div>    </div>

    @else

    <!-- Empty State --></div>        margin-bottom: 24px;    .category-routine { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }                        <th>Biaya</th>

    <div class="maintenance-table-container">

        <div class="empty-state">

            <div class="empty-icon">

                <i class="fas fa-wrench"></i>@if($maintenances->count() > 0)        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);

            </div>

            <h2 class="empty-title">No Service Records Yet</h2>

            <p class="empty-subtitle">Start tracking your vehicle maintenance by adding your first service record.</p>

            <a href="{{ route('maintenances.create') }}" class="btn btn-add-maintenance"><!-- Summary Stats -->        color: white;    .category-repair { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }                        <th>Status</th>

                <i class="fas fa-plus me-2"></i>Add First Service

            </a><div class="stats-card">

        </div>

    </div>    <div class="row">    }

    @endif

</div>        <div class="col-md-4 stat-item text-center">

@endsection

            <div style="font-size: 28px; font-weight: 700;">{{ $maintenances->count() }}</div>    .page-header {    .category-emergency { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }                        <th>Service Berikutnya</th>

            <div style="font-size: 13px; opacity: 0.9;">Total Service</div>

        </div>        padding: 24px 0;

        <div class="col-md-4 stat-item text-center border-start border-white border-opacity-25">

            <div style="font-size: 28px; font-weight: 700;">Rp {{ number_format($maintenances->sum('cost'), 0, ',', '.') }}</div>        margin-bottom: 24px;                        <th>Aksi</th>

            <div style="font-size: 13px; opacity: 0.9;">Total Biaya</div>

        </div>    }

        <div class="col-md-4 stat-item text-center border-start border-white border-opacity-25">

            <div style="font-size: 28px; font-weight: 700;">{{ $maintenances->where('status', 'Scheduled')->count() }}</div>    .page-title {    .maintenance-amount {                    </tr>

            <div style="font-size: 13px; opacity: 0.9;">Dijadwalkan</div>

        </div>        font-size: 24px;

    </div>

</div>        font-weight: 700;        font-size: 20px;                </thead>



<!-- Maintenance List -->        color: #1a1a1a;

<div class="row">

    @foreach($maintenances as $maintenance)        margin: 0;        font-weight: 700;                <tbody>

    <div class="col-12">

        <div class="maintenance-card">    }

            <div class="card-body p-3">

                <div class="d-flex align-items-center">    .page-subtitle {        color: #fd7e14;                    @foreach($maintenances as $maintenance)

                    <!-- Icon -->

                    <div class="maintenance-icon category-{{ strtolower($maintenance->category) }}">        font-size: 14px;

                        @if($maintenance->category === 'Routine')

                            🔧        color: #6c757d;    }                    <tr>

                        @elseif($maintenance->category === 'Repair')

                            ⚙️        margin: 4px 0 0 0;

                        @else

                            🚨    }    .maintenance-date {                        <td>

                        @endif

                    </div>    .empty-state {



                    <!-- Main Info -->        text-align: center;        font-size: 13px;                            <div class="fw-bold">{{ $maintenance->maintenance_date->format('d M Y') }}</div>

                    <div class="flex-grow-1">

                        <div class="d-flex justify-content-between align-items-start mb-2">        padding: 60px 20px;

                            <div>

                                <h6 class="mb-1">        max-width: 600px;        color: #6c757d;                            <small class="text-muted">{{ $maintenance->maintenance_date->diffForHumans() }}</small>

                                    <strong>{{ $maintenance->type }}</strong>

                                    @php        margin: 40px auto;

                                        $categoryColors = [

                                            'Routine' => 'info',    }    }                        </td>

                                            'Repair' => 'warning',

                                            'Emergency' => 'danger'    .empty-title {

                                        ];

                                        $statusMap = [        font-size: 28px;    .status-badge {                        <td>

                                            'Completed' => ['text' => 'Selesai', 'class' => 'completed'],

                                            'Scheduled' => ['text' => 'Dijadwalkan', 'class' => 'scheduled'],        font-weight: 700;

                                            'Overdue' => ['text' => 'Terlambat', 'class' => 'overdue']

                                        ];        color: #1a1a1a;        padding: 6px 12px;                            <div class="fw-bold">{{ $maintenance->vehicle->name }}</div>

                                    @endphp

                                    <span class="badge bg-{{ $categoryColors[$maintenance->category] ?? 'secondary' }}">        margin-bottom: 16px;

                                        {{ $maintenance->category }}

                                    </span>    }        border-radius: 8px;                            <small class="text-muted">{{ $maintenance->vehicle->license_plate }}</small>

                                    <span class="status-badge status-{{ $statusMap[$maintenance->status]['class'] ?? 'secondary' }}">

                                        {{ $statusMap[$maintenance->status]['text'] ?? $maintenance->status }}    .empty-description {

                                    </span>

                                </h6>        font-size: 16px;        font-size: 12px;                        </td>

                                <p class="mb-1 text-muted small">

                                    <span class="badge bg-success">{{ $maintenance->vehicle->name }}</span>        color: #6c757d;

                                    <span class="badge bg-secondary">{{ $maintenance->vehicle->license_plate }}</span>

                                    <span class="mx-2">•</span>        line-height: 1.6;        font-weight: 600;                        <td>{{ $maintenance->type }}</td>

                                    <i class="bi bi-speedometer2"></i> {{ number_format($maintenance->odometer, 0, ',', '.') }} km

                                </p>        margin-bottom: 32px;

                                @if($maintenance->description)

                                    <small class="text-muted">{{ Str::limit($maintenance->description, 100) }}</small>    }        color: white;                        <td>

                                @endif

                            </div></style>

                            <div class="text-end">

                                <div class="maintenance-amount">Rp {{ number_format($maintenance->cost, 0, ',', '.') }}</div>    }                            @php

                                <div class="maintenance-date">

                                    <i class="bi bi-calendar3"></i> {{ $maintenance->maintenance_date->format('d M Y') }}<div class="page-header">

                                </div>

                            </div>    <div class="d-flex justify-content-between align-items-center">    .status-completed { background: #28a745; }                                $categoryColors = [

                        </div>

        <div>

                        <div class="d-flex justify-content-between align-items-center">

                            <div>            <h1 class="page-title">Riwayat Perawatan & Service</h1>    .status-scheduled { background: #007bff; }                                    'Routine' => 'bg-info',

                                @if($maintenance->next_maintenance_date)

                                    <span class="badge bg-primary">            <p class="page-subtitle">Pantau jadwal perawatan kendaraan Anda</p>

                                        <i class="bi bi-clock-history"></i>

                                        Service Berikutnya: {{ $maintenance->next_maintenance_date->format('d M Y') }}        </div>    .status-overdue { background: #dc3545; }                                    'Repair' => 'bg-warning',

                                        @if($maintenance->next_maintenance_odometer)

                                            / {{ number_format($maintenance->next_maintenance_odometer, 0, ',', '.') }} km        <a href="{{ route('maintenances.create') }}" class="btn btn-warning rounded-pill px-4 shadow-sm">

                                        @endif

                                    </span>            <i class="bi bi-plus-lg me-2"></i>Tambah Service                                    'Emergency' => 'bg-danger'

                                @endif

                                @if($maintenance->workshop)        </a>

                                    <span class="ms-2 text-muted small">

                                        <i class="bi bi-shop"></i> {{ $maintenance->workshop }}    </div>    .stats-card {                                ];

                                    </span>

                                @endif</div>

                            </div>

        border-radius: 12px;                            @endphp

                            <div class="dropdown">

                                <button class="btn btn-sm btn-outline-secondary rounded-pill" type="button" data-bs-toggle="dropdown">@if($maintenances->count() > 0)

                                    <i class="bi bi-three-dots"></i>

                                </button>        padding: 20px;                            <span class="badge {{ $categoryColors[$maintenance->category] ?? 'bg-secondary' }}">

                                <ul class="dropdown-menu dropdown-menu-end shadow">

                                    <li><!-- Summary Stats -->

                                        <a class="dropdown-item" href="{{ route('maintenances.show', $maintenance) }}">

                                            <i class="bi bi-eye me-2"></i>Lihat Detail<div class="stats-card">        margin-bottom: 24px;                                {{ $maintenance->category }}

                                        </a>

                                    </li>    <div class="row">

                                    <li>

                                        <a class="dropdown-item" href="{{ route('maintenances.edit', $maintenance) }}">        <div class="col-md-4 stat-item text-center">        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);                            </span>

                                            <i class="bi bi-pencil-square me-2"></i>Edit

                                        </a>            <div style="font-size: 28px; font-weight: 700;">{{ $maintenances->count() }}</div>

                                    </li>

                                    <li><hr class="dropdown-divider"></li>            <div style="font-size: 13px; opacity: 0.9;">Total Service</div>        color: white;                        </td>

                                    <li>

                                        <form action="{{ route('maintenances.destroy', $maintenance) }}" method="POST"        </div>

                                              onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                                            @csrf        <div class="col-md-4 stat-item text-center border-start border-white border-opacity-25">    }                        <td>{{ number_format($maintenance->odometer, 0, ',', '.') }} km</td>

                                            @method('DELETE')

                                            <button type="submit" class="dropdown-item text-danger">            <div style="font-size: 28px; font-weight: 700;">Rp {{ number_format($maintenances->sum('cost'), 0, ',', '.') }}</div>

                                                <i class="bi bi-trash me-2"></i>Hapus

                                            </button>            <div style="font-size: 13px; opacity: 0.9;">Total Biaya</div></style>                        <td>

                                        </form>

                                    </li>        </div>

                                </ul>

                            </div>        <div class="col-md-4 stat-item text-center border-start border-white border-opacity-25">                            <div class="fw-bold">Rp {{ number_format($maintenance->cost, 0, ',', '.') }}</div>

                        </div>

                    </div>            <div style="font-size: 28px; font-weight: 700;">{{ $maintenances->where('status', 'Scheduled')->count() }}</div>

                </div>

            </div>            <div style="font-size: 13px; opacity: 0.9;">Dijadwalkan</div><div class="d-flex justify-content-between align-items-center mb-4">                        </td>

        </div>

    </div>        </div>

    @endforeach

</div>    </div>    <div>                        <td>



<!-- Pagination --></div>

<div class="d-flex justify-content-center mt-4">

    {{ $maintenances->links() }}        <h1 class="h3 mb-1">Riwayat Perawatan & Service</h1>                            @php

</div>

<!-- Maintenance List -->

@else

<div class="empty-state"><div class="row">        <p class="text-muted small mb-0">Pantau jadwal perawatan kendaraan Anda</p>                                $statusColors = [

    <div style="width: 160px; height: 160px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 80px; box-shadow: 0 12px 32px rgba(250, 112, 154, 0.3); margin: 0 auto 40px;">

        🔧    @foreach($maintenances as $maintenance)

    </div>

    <h3 class="empty-title">Belum Ada Data Perawatan</h3>    <div class="col-12">    </div>                                    'Completed' => 'bg-success',

    <p class="empty-description">

        Mulai mencatat setiap perawatan dan service kendaraan        <div class="maintenance-card">

        untuk menjaga performa dan kondisi kendaraan Anda.

    </p>            <div class="card-body p-3">    <a href="{{ route('maintenances.create') }}" class="btn btn-warning rounded-pill px-4">                                    'Scheduled' => 'bg-primary',

    <a href="{{ route('maintenances.create') }}" class="btn btn-warning btn-lg rounded-pill px-5 shadow">

        <i class="bi bi-plus-lg me-2"></i>Tambah Data Pertama                <div class="d-flex align-items-center">

    </a>

</div>                    <!-- Icon -->        <i class="bi bi-plus-lg me-2"></i>Tambah Service                                    'Overdue' => 'bg-danger'

@endif

@endsection                    <div class="maintenance-icon category-{{ strtolower($maintenance->category) }}">


                        @if($maintenance->category === 'Routine')    </a>                                ];

                            🔧

                        @elseif($maintenance->category === 'Repair')</div>                            @endphp

                            ⚙️

                        @else                            <span class="badge {{ $statusColors[$maintenance->status] ?? 'bg-secondary' }}">

                            🚨

                        @endif@if($maintenances->count() > 0)                                {{ $maintenance->status }}

                    </div>

                            </span>

                    <!-- Main Info -->

                    <div class="flex-grow-1"><!-- Summary Stats -->                        </td>

                        <div class="d-flex justify-content-between align-items-start mb-2">

                            <div><div class="stats-card">                        <td>

                                <h6 class="mb-1">

                                    <strong>{{ $maintenance->type }}</strong>    <div class="row">                            @if($maintenance->next_maintenance_date)

                                    @php

                                        $categoryColors = [        <div class="col-md-4 stat-item text-center">                                <div class="small">{{ $maintenance->next_maintenance_date->format('d M Y') }}</div>

                                            'Routine' => 'info',

                                            'Repair' => 'warning',            <div class="stat-value" style="font-size: 28px; font-weight: 700;">{{ $maintenances->count() }}</div>                                @if($maintenance->next_maintenance_odometer)

                                            'Emergency' => 'danger'

                                        ];            <div class="stat-label" style="font-size: 13px; opacity: 0.9;">Total Service</div>                                    <small class="text-muted">{{ number_format($maintenance->next_maintenance_odometer, 0, ',', '.') }} km</small>

                                        $statusMap = [

                                            'Completed' => ['text' => 'Selesai', 'class' => 'completed'],        </div>                                @endif

                                            'Scheduled' => ['text' => 'Dijadwalkan', 'class' => 'scheduled'],

                                            'Overdue' => ['text' => 'Terlambat', 'class' => 'overdue']        <div class="col-md-4 stat-item text-center border-start border-white border-opacity-25">                            @else

                                        ];

                                    @endphp            <div class="stat-value" style="font-size: 28px; font-weight: 700;">Rp {{ number_format($maintenances->sum('cost'), 0, ',', '.') }}</div>                                <span class="text-muted">-</span>

                                    <span class="badge bg-{{ $categoryColors[$maintenance->category] ?? 'secondary' }}">

                                        {{ $maintenance->category }}            <div class="stat-label" style="font-size: 13px; opacity: 0.9;">Total Biaya</div>                            @endif

                                    </span>

                                    <span class="status-badge status-{{ $statusMap[$maintenance->status]['class'] ?? 'secondary' }}">        </div>                        </td>

                                        {{ $statusMap[$maintenance->status]['text'] ?? $maintenance->status }}

                                    </span>        <div class="col-md-4 stat-item text-center border-start border-white border-opacity-25">                        <td>

                                </h6>

                                <p class="mb-1 text-muted small">            <div class="stat-value" style="font-size: 28px; font-weight: 700;">{{ $maintenances->where('status', 'Scheduled')->count() }}</div>                            <div class="btn-group btn-group-sm">

                                    <span class="badge bg-success">{{ $maintenance->vehicle->name }}</span>

                                    <span class="badge bg-secondary">{{ $maintenance->vehicle->license_plate }}</span>            <div class="stat-label" style="font-size: 13px; opacity: 0.9;">Dijadwalkan</div>                                <button class="btn btn-outline-primary" type="button" data-bs-toggle="dropdown">

                                    <span class="mx-2">•</span>

                                    <i class="bi bi-speedometer2"></i> {{ number_format($maintenance->odometer, 0, ',', '.') }} km        </div>                                    <i class="bi bi-three-dots-vertical"></i>

                                </p>

                                @if($maintenance->description)    </div>                                </button>

                                    <small class="text-muted">{{ Str::limit($maintenance->description, 100) }}</small>

                                @endif</div>                                <ul class="dropdown-menu">

                            </div>

                            <div class="text-end">                                    <li>

                                <div class="maintenance-amount">Rp {{ number_format($maintenance->cost, 0, ',', '.') }}</div>

                                <div class="maintenance-date"><!-- Maintenance List -->                                        <a class="dropdown-item" href="{{ route('maintenances.show', $maintenance) }}">

                                    <i class="bi bi-calendar3"></i> {{ $maintenance->maintenance_date->format('d M Y') }}

                                </div><div class="row">                                            <i class="bi bi-eye me-2"></i>Detail

                            </div>

                        </div>    @foreach($maintenances as $maintenance)                                        </a>



                        <div class="d-flex justify-content-between align-items-center">    <div class="col-12">                                    </li>

                            <div>

                                @if($maintenance->next_maintenance_date)        <div class="maintenance-card">                                    <li>

                                    <span class="badge bg-primary">

                                        <i class="bi bi-clock-history"></i>            <div class="card-body p-3">                                        <a class="dropdown-item" href="{{ route('maintenances.edit', $maintenance) }}">

                                        Service Berikutnya: {{ $maintenance->next_maintenance_date->format('d M Y') }}

                                        @if($maintenance->next_maintenance_odometer)                <div class="d-flex align-items-center">                                            <i class="bi bi-pencil me-2"></i>Edit

                                            / {{ number_format($maintenance->next_maintenance_odometer, 0, ',', '.') }} km

                                        @endif                    <!-- Icon -->                                        </a>

                                    </span>

                                @endif                    <div class="maintenance-icon category-{{ strtolower($maintenance->category) }}">                                    </li>

                                @if($maintenance->workshop)

                                    <span class="ms-2 text-muted small">                        @if($maintenance->category === 'Routine')                                    <li><hr class="dropdown-divider"></li>

                                        <i class="bi bi-shop"></i> {{ $maintenance->workshop }}

                                    </span>                            🔧                                    <li>

                                @endif

                            </div>                        @elseif($maintenance->category === 'Repair')                                        <form action="{{ route('maintenances.destroy', $maintenance) }}" method="POST"



                            <div class="dropdown">                            ⚙️                                              onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                                <button class="btn btn-sm btn-outline-secondary rounded-pill" type="button" data-bs-toggle="dropdown">

                                    <i class="bi bi-three-dots"></i>                        @else                                            @csrf

                                </button>

                                <ul class="dropdown-menu dropdown-menu-end shadow">                            🚨                                            @method('DELETE')

                                    <li>

                                        <a class="dropdown-item" href="{{ route('maintenances.show', $maintenance) }}">                        @endif                                            <button type="submit" class="dropdown-item text-danger">

                                            <i class="bi bi-eye me-2"></i>Lihat Detail

                                        </a>                    </div>                                                <i class="bi bi-trash me-2"></i>Hapus

                                    </li>

                                    <li>                                            </button>

                                        <a class="dropdown-item" href="{{ route('maintenances.edit', $maintenance) }}">

                                            <i class="bi bi-pencil-square me-2"></i>Edit                    <!-- Main Info -->                                        </form>

                                        </a>

                                    </li>                    <div class="flex-grow-1">                                    </li>

                                    <li><hr class="dropdown-divider"></li>

                                    <li>                        <div class="d-flex justify-content-between align-items-start mb-2">                                </ul>

                                        <form action="{{ route('maintenances.destroy', $maintenance) }}" method="POST"

                                              onsubmit="return confirm('Yakin ingin menghapus data ini?')">                            <div>                            </div>

                                            @csrf

                                            @method('DELETE')                                <h6 class="mb-1">                        </td>

                                            <button type="submit" class="dropdown-item text-danger">

                                                <i class="bi bi-trash me-2"></i>Hapus                                    <strong>{{ $maintenance->type }}</strong>                    </tr>

                                            </button>

                                        </form>                                    @php                    @endforeach

                                    </li>

                                </ul>                                        $categoryColors = [                </tbody>

                            </div>

                        </div>                                            'Routine' => 'info',            </table>

                    </div>

                </div>                                            'Repair' => 'warning',        </div>

            </div>

        </div>                                            'Emergency' => 'danger'    </div>

    </div>

    @endforeach                                        ];</div>

</div>

                                        $statusMap = [

<!-- Pagination -->

<div class="d-flex justify-content-center mt-4">                                            'Completed' => ['text' => 'Selesai', 'class' => 'completed'],<!-- Pagination -->

    {{ $maintenances->links() }}

</div>                                            'Scheduled' => ['text' => 'Dijadwalkan', 'class' => 'scheduled'],<div class="d-flex justify-content-center mt-4">



@else                                            'Overdue' => ['text' => 'Terlambat', 'class' => 'overdue']    {{ $maintenances->links() }}

<div class="empty-state">

    <div class="mx-auto mb-4" style="width: 140px; height: 140px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 70px; box-shadow: 0 8px 24px rgba(250, 112, 154, 0.3);">                                        ];</div>

        🔧

    </div>                                    @endphp

    <h3 class="empty-title">Belum Ada Data Perawatan</h3>

    <p class="empty-description">                                    <span class="badge bg-{{ $categoryColors[$maintenance->category] ?? 'secondary' }}">@else

        Mulai mencatat setiap perawatan dan service kendaraan<br>

        untuk menjaga performa dan kondisi kendaraan Anda.                                        {{ $maintenance->category }}<div class="text-center py-5">

    </p>

    <a href="{{ route('maintenances.create') }}" class="btn btn-warning btn-lg rounded-pill px-5 shadow">                                    </span>    <i class="bi bi-tools display-1 text-muted"></i>

        <i class="bi bi-plus-lg me-2"></i>Tambah Data Pertama

    </a>                                    <span class="status-badge status-{{ $statusMap[$maintenance->status]['class'] ?? 'secondary' }}">    <h3 class="mt-3">Belum Ada Data Perawatan</h3>

</div>

@endif                                        {{ $statusMap[$maintenance->status]['text'] ?? $maintenance->status }}    <p class="text-muted">Mulai dengan menambahkan data service pertama Anda.</p>

@endsection

                                    </span>    <a href="{{ route('maintenances.create') }}" class="btn btn-primary">

                                </h6>        <i class="bi bi-plus-circle me-1"></i>

                                <p class="mb-1 text-muted small">        Tambah Data Pertama

                                    <span class="badge bg-success">{{ $maintenance->vehicle->name }}</span>    </a>

                                    <span class="badge bg-secondary">{{ $maintenance->vehicle->license_plate }}</span></div>

                                    <span class="mx-2">•</span>@endif

                                    <i class="bi bi-speedometer2"></i> {{ number_format($maintenance->odometer, 0, ',', '.') }} km@endsection

                                </p>
                                @if($maintenance->description)
                                    <small class="text-muted">{{ Str::limit($maintenance->description, 100) }}</small>
                                @endif
                            </div>
                            <div class="text-end">
                                <div class="maintenance-amount">Rp {{ number_format($maintenance->cost, 0, ',', '.') }}</div>
                                <div class="maintenance-date">
                                    <i class="bi bi-calendar3"></i> {{ $maintenance->maintenance_date->format('d M Y') }}
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                @if($maintenance->next_maintenance_date)
                                    <span class="badge bg-primary">
                                        <i class="bi bi-clock-history"></i>
                                        Service Berikutnya: {{ $maintenance->next_maintenance_date->format('d M Y') }}
                                        @if($maintenance->next_maintenance_odometer)
                                            / {{ number_format($maintenance->next_maintenance_odometer, 0, ',', '.') }} km
                                        @endif
                                    </span>
                                @endif
                                @if($maintenance->workshop)
                                    <span class="ms-2 text-muted small">
                                        <i class="bi bi-shop"></i> {{ $maintenance->workshop }}
                                    </span>
                                @endif
                            </div>

                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary rounded-pill" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('maintenances.show', $maintenance) }}">
                                            <i class="bi bi-eye me-2"></i>Lihat Detail
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('maintenances.edit', $maintenance) }}">
                                            <i class="bi bi-pencil-square me-2"></i>Edit
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('maintenances.destroy', $maintenance) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-trash me-2"></i>Hapus
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
    {{ $maintenances->links() }}
</div>

@else
<div class="text-center py-5">
    <div class="empty-icon mx-auto mb-4" style="width: 120px; height: 120px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 60px;">
        🔧
    </div>
    <h3 class="mb-3">Belum Ada Data Perawatan</h3>
    <p class="text-muted mb-4">Mulai mencatat setiap perawatan dan service kendaraan<br>untuk menjaga performa dan kondisi kendaraan Anda.</p>
    <a href="{{ route('maintenances.create') }}" class="btn btn-warning btn-lg rounded-pill px-5">
        <i class="bi bi-plus-lg me-2"></i>Tambah Data Pertama
    </a>
</div>
@endif
@endsection
