@extends('layouts.drivvo')

@section('title', 'Data Service & Perawatan')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="h4 mb-1 fw-bold">
                            <i class="fas fa-wrench text-primary me-2"></i>
                            Data Service & Perawatan
                        </h2>
                        <p class="text-muted mb-0">Kelola riwayat service dan perawatan kendaraan</p>
                    </div>
                    <a href="{{ route('maintenances.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Service
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Kendaraan</th>
                                    <th>Jenis Service</th>
                                    <th>Odometer</th>
                                    <th>Biaya</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($maintenances as $key => $maintenance)
                                <tr>
                                    <td>{{ $maintenances->firstItem() + $key }}</td>
                                    <td>{{ $maintenance->maintenance_date ? $maintenance->maintenance_date->format('d/m/Y') : '-' }}</td>
                                    <td>
                                        <strong>{{ $maintenance->vehicle->name ?? '-' }}</strong><br>
                                        <small class="text-muted">{{ $maintenance->vehicle->license_plate ?? '-' }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $maintenance->type ?? '-' }}</span>
                                    </td>
                                    <td>{{ number_format($maintenance->odometer ?? 0) }} KM</td>
                                    <td>Rp {{ number_format($maintenance->cost ?? 0, 0, ',', '.') }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('maintenances.show', $maintenance->id) }}" class="btn btn-info" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('maintenances.edit', $maintenance->id) }}" class="btn btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if(Auth::user()->canManageUsers())
                                            <form action="{{ route('maintenances.destroy', $maintenance->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                        <p class="mb-0">Belum ada data service</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($maintenances->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $maintenances->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
