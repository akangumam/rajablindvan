@extends('layouts.drivvo')

@section('title', 'Edit Pendapatan')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-edit"></i>
                    Edit Pendapatan
                </h1>
                <p class="page-subtitle mb-0">Perbarui informasi pendapatan kendaraan</p>
            </div>
            <a href="{{ route('incomes.show', $income) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card">
        <div class="card-body p-4">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Terdapat kesalahan:</h6>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('incomes.update', $income) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Vehicle Information -->
                <div class="form-section mb-4">
                    <h5 class="section-title">
                        <i class="fas fa-car text-primary me-2"></i>
                        Informasi Kendaraan
                    </h5>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kendaraan <span class="text-danger">*</span></label>
                        <select name="vehicle_id" class="form-select" required>
                            @foreach($vehicles as $veh)
                                <option value="{{ $veh->id }}" {{ old('vehicle_id', $income->vehicle_id) == $veh->id ? 'selected' : '' }}>
                                    {{ $veh->name }} - {{ $veh->license_plate }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Income Details -->
                <div class="form-section mb-4">
                    <h5 class="section-title">
                        <i class="fas fa-clipboard-list text-primary me-2"></i>
                        Detail Pendapatan
                    </h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                            <input type="date"
                                   name="income_date"
                                   class="form-control"
                                   value="{{ old('income_date', $income->income_date ? $income->income_date->format('Y-m-d') : '') }}"
                                   required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Waktu</label>
                            <input type="time"
                                   name="income_time"
                                   class="form-control"
                                   value="{{ old('income_time', $income->income_time ? substr((string) $income->income_time, 0, 5) : '') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Odometer (km)</label>
                            <div class="input-group">
                                <input type="number"
                                       name="odometer"
                                       class="form-control"
                                       min="0"
                                       value="{{ old('odometer', $income->odometer) }}">
                                <span class="input-group-text">KM</span>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Jenis Pendapatan <span class="text-danger">*</span></label>
                            <select name="type" class="form-select" required>
                                <option value="">Pilih Jenis Pendapatan</option>
                                @php $currentType = old('type', $income->type); @endphp
                                @if($currentType && !$incomeTypes->contains('name', $currentType))
                                    <option value="{{ $currentType }}" selected>{{ $currentType }}</option>
                                @endif
                                @foreach($incomeTypes as $it)
                                    <option value="{{ $it->name }}" {{ $currentType == $it->name ? 'selected' : '' }}>
                                        {{ $it->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nilai Pendapatan (Rp) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number"
                                       step="any"
                                       name="amount"
                                       class="form-control"
                                       min="0"
                                       value="{{ old('amount', (float) $income->amount) }}"
                                       required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Pengguna / Penanggung Jawab</label>
                            <select name="user_id" class="form-select">
                                <option value="">Pilih Pengguna</option>
                                @foreach($users as $u)
                                    <option value="{{ $u->id }}" {{ old('user_id', $income->user_id) == $u->id ? 'selected' : '' }}>
                                        {{ $u->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Catatan</label>
                            <textarea name="notes" class="form-control" rows="3" placeholder="Catatan tambahan...">{{ old('notes', $income->notes ?? $income->description) }}</textarea>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Lampiran File (Opsional)</label>
                            <input type="file" name="attachment" class="form-control" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                            @if($income->attachment)
                                <small class="text-muted d-block mt-1">
                                    Lampiran saat ini: <a href="{{ asset('storage/' . $income->attachment) }}" target="_blank">Lihat File</a>
                                </small>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 justify-content-end pt-3 border-top">
                    <a href="{{ route('incomes.show', $income) }}" class="btn btn-secondary px-4">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-success px-4 fw-semibold">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
