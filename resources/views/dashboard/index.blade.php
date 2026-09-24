{{--
    ============================================================
    CATATAN: File ini adalah dashboard LAMA yang tidak digunakan.
    Dashboard aktif saat ini adalah: dashboard/main.blade.php
    Route dashboard (/) menggunakan DashboardController@index
    yang me-render 'dashboard.main'.

    File ini TIDAK dihapus untuk keperluan referensi,
    namun TIDAK digunakan dalam produksi.
    ============================================================
--}}
@extends('layouts.drivvo')

@section('title', 'Dashboard (Lama - Tidak Digunakan)')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 60vh;">
    <div class="text-center p-5">
        <i class="fas fa-archive text-muted" style="font-size: 64px; margin-bottom: 20px;"></i>
        <h3 class="text-muted mb-3">Halaman Ini Tidak Aktif</h3>
        <p class="text-muted mb-4">Dashboard aktif telah dipindahkan. Silakan kembali ke dashboard utama.</p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary">
            <i class="fas fa-tachometer-alt me-2"></i>
            Ke Dashboard Utama
        </a>
    </div>
</div>
@endsection
