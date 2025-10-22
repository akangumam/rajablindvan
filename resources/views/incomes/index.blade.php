@extends('layouts.drivvo')

@section('title', 'Pendapatan')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: between;
        align-items: center;
        margin-bottom: 24px;
    }
    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #333;
        margin: 0;
    }
    .btn-add {
        background: white;
        border: 2px solid #3498db;
        color: #3498db;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 14px;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }
    .btn-add:hover {
        background: #3498db;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
    }
</style>

<div class="page-header">
    <h1 class="page-title">Pendapatan</h1>
    <a href="{{ route('incomes.create') }}" class="btn-add">
        TAMBAH BARU
    </a>
</div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($incomes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kendaraan</th>
                                <th>Kategori</th>
                                <th>Sumber</th>
                                <th>Deskripsi</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($incomes as $income)
                                <tr>
                                    <td>{{ $income->income_date->format('d/m/Y') }}</td>
                                    <td>{{ $income->vehicle->name }}</td>
                                    <td>{{ $income->category }}</td>
                                    <td>{{ $income->source ?? '-' }}</td>
                                    <td>{{ $income->description }}</td>
                                    <td>Rp {{ number_format($income->amount, 0, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route('incomes.edit', $income) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $incomes->links() }}
            @else
                <p class="text-center text-muted py-5">Belum ada data pendapatan</p>
            @endif
        </div>
    </div>
</div>
@endsection
