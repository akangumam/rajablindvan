@extends('layouts.drivvo')@extends('layouts.drivvo')@extends('layouts.drivvo')@extends('layouts.drivvo')@extends('layouts.drivvo')



@section('title', 'Data Perawatan')



@section('content')@section('title', 'Data Perawatan')

<style>

    .page-header {

        padding: 0 0 20px 0;

        margin-bottom: 0;@section('content')@section('title', 'Data Perawatan')

        border-bottom: 2px solid #f0f0f0;

    }<style>

    .page-title {

        font-size: 28px;    .maintenance-card {

        font-weight: 800;

        color: #1a1a1a;        border: none;

        margin: 0;

        letter-spacing: -0.5px;        border-radius: 12px;@section('content')@section('title', 'Data Perawatan')@section('title', 'Data Perawatan')

    }

    .page-subtitle {        box-shadow: 0 2px 8px rgba(0,0,0,0.06);

        font-size: 15px;

        color: #6c757d;        margin-bottom: 12px;<style>

        margin: 8px 0 0 0;

        font-weight: 400;        transition: all 0.2s ease;

    }

    .empty-state {    }    .maintenance-card {

        text-align: center;

        padding: 40px 20px;    .maintenance-card:hover {

        max-width: 650px;

        margin: 0 auto;        box-shadow: 0 4px 12px rgba(0,0,0,0.1);        border: none;

        min-height: calc(100vh - 200px);

        display: flex;        transform: translateX(4px);

        flex-direction: column;

        align-items: center;    }        border-radius: 12px;@section('content')@section('content')

        justify-content: center;

        position: relative;    .maintenance-icon {

        top: -40px;

    }        width: 48px;        box-shadow: 0 2px 8px rgba(0,0,0,0.06);

    .empty-title {

        font-size: 32px;        height: 48px;

        font-weight: 800;

        color: #1a1a1a;        border-radius: 12px;        margin-bottom: 12px;<style><div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

        margin-bottom: 20px;

        letter-spacing: -0.5px;        display: flex;

    }

    .empty-description {        align-items: center;        transition: all 0.2s ease;

        font-size: 17px;

        color: #6c757d;        justify-content: center;

        line-height: 1.7;

        margin-bottom: 40px;        font-size: 24px;    }    .maintenance-card {    <h1 class="h2">Data Perawatan & Service</h1>

        max-width: 500px;

    }        margin-right: 16px;

</style>

    }    .maintenance-card:hover {

<div class="page-header">

    <div>    .category-routine { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }

        <h1 class="page-title">Riwayat Perawatan & Service</h1>

        <p class="page-subtitle">Pantau jadwal perawatan kendaraan Anda</p>    .category-repair { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }        box-shadow: 0 4px 12px rgba(0,0,0,0.1);        border: none;    <div class="btn-toolbar mb-2 mb-md-0">

    </div>

</div>    .category-emergency { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }



@if($maintenances->count() > 0)        transform: translateX(4px);



<!-- Show data if available -->    .maintenance-amount {

<div class="alert alert-info">

    Data perawatan tersedia. Feature list belum diimplementasi.        font-size: 20px;    }        border-radius: 12px;        <a href="{{ route('maintenances.create') }}" class="btn btn-primary">

</div>

        font-weight: 700;

@else

<div class="empty-state">        color: #fd7e14;    .maintenance-icon {

    <div style="width: 160px; height: 160px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 80px; box-shadow: 0 12px 32px rgba(250, 112, 154, 0.3); margin: 0 auto 40px;">

        🔧    }

    </div>

    <h3 class="empty-title">Belum Ada Data Perawatan</h3>    .maintenance-date {        width: 48px;        box-shadow: 0 2px 8px rgba(0,0,0,0.06);            <i class="bi bi-plus-circle me-1"></i>

    <p class="empty-description">

        Mulai mencatat setiap perawatan dan service kendaraan        font-size: 13px;

        untuk menjaga performa dan kondisi kendaraan Anda.

    </p>        color: #6c757d;        height: 48px;

    <a href="{{ route('maintenances.create') }}" class="btn btn-warning btn-lg rounded-pill px-5 shadow">

        <i class="bi bi-plus-lg me-2"></i>Tambah Data Pertama    }

    </a>

</div>    .status-badge {        border-radius: 12px;        margin-bottom: 12px;            Tambah Data Service

@endif

@endsection        padding: 6px 12px;

        border-radius: 8px;        display: flex;

        font-size: 12px;

        font-weight: 600;        align-items: center;        transition: all 0.2s ease;        </a>

        color: white;

    }        justify-content: center;

    .status-completed { background: #28a745; }

    .status-scheduled { background: #007bff; }        font-size: 24px;    }    </div>

    .status-overdue { background: #dc3545; }

        margin-right: 16px;

    .stats-card {

        border-radius: 12px;    }    .maintenance-card:hover {</div>

        padding: 20px;

        margin-bottom: 24px;    .category-routine { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }

        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);

        color: white;    .category-repair { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }        box-shadow: 0 4px 12px rgba(0,0,0,0.1);

    }

    .page-header {    .category-emergency { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }

        padding: 0 0 28px 0;

        margin-bottom: 28px;        transform: translateX(4px);@if($maintenances->count() > 0)

        border-bottom: 2px solid #f0f0f0;

    }    .maintenance-amount {

    .page-title {

        font-size: 28px;        font-size: 20px;    }<div class="card">

        font-weight: 800;

        color: #1a1a1a;        font-weight: 700;

        margin: 0;

        letter-spacing: -0.5px;        color: #fd7e14;    .maintenance-icon {    <div class="card-body p-0">

    }

    .page-subtitle {    }

        font-size: 15px;

        color: #6c757d;    .maintenance-date {        width: 48px;        <div class="table-responsive">

        margin: 8px 0 0 0;

        font-weight: 400;        font-size: 13px;

    }

    .empty-state {        color: #6c757d;        height: 48px;            <table class="table table-hover mb-0">

        text-align: center;

        padding: 80px 20px;    }

        max-width: 650px;

        margin: 60px auto;    .status-badge {        border-radius: 12px;                <thead class="table-light">

        min-height: 60vh;

        display: flex;        padding: 6px 12px;

        flex-direction: column;

        align-items: center;        border-radius: 8px;        display: flex;                    <tr>

        justify-content: center;

    }        font-size: 12px;

    .empty-title {

        font-size: 32px;        font-weight: 600;        align-items: center;                        <th>Tanggal</th>

        font-weight: 800;

        color: #1a1a1a;        color: white;

        margin-bottom: 20px;

        letter-spacing: -0.5px;    }        justify-content: center;                        <th>Kendaraan</th>

    }

    .empty-description {    .status-completed { background: #28a745; }

        font-size: 17px;

        color: #6c757d;    .status-scheduled { background: #007bff; }        font-size: 24px;                        <th>Jenis Service</th>

        line-height: 1.7;

        margin-bottom: 40px;    .status-overdue { background: #dc3545; }

        max-width: 500px;

    }        margin-right: 16px;                        <th>Kategori</th>

</style>

    .stats-card {

<div class="page-header">

    <div>        border-radius: 12px;    }                        <th>Odometer</th>

        <h1 class="page-title">Riwayat Perawatan & Service</h1>

        <p class="page-subtitle">Pantau jadwal perawatan kendaraan Anda</p>        padding: 20px;

    </div>

</div>        margin-bottom: 24px;    .category-routine { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }                        <th>Biaya</th>



@if($maintenances->count() > 0)        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);



<!-- Summary Stats -->        color: white;    .category-repair { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }                        <th>Status</th>

<div class="stats-card">

    <div class="row">    }

        <div class="col-md-4 stat-item text-center">

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
