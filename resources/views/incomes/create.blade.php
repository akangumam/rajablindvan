@extends('layouts.drivvo-form', [
    'pageTitle' => 'Pendapatan',
    'pageIcon' => 'fas fa-money-bill-wave',
    'formAction' => route('incomes.store'),
    'formId' => 'incomeForm',
    'cancelRoute' => route('incomes.index'),
    'modalRoute' => route('incomes.create'),
    'vehicle' => $vehicle ?? null
])

@section('form-fields')
<!-- Tanggal -->
<div class="field-group">
    <label class="form-label">Tanggal</label>
    <input type="date" name="income_date" class="form-control" value="{{ old('income_date', date('Y-m-d')) }}" required>
</div>

<!-- Odometer -->
<div class="field-group">
    <label class="form-label">Odometer</label>
    <div class="input-group">
        <input type="number" step="0.01" name="odometer" class="form-control" value="{{ old('odometer') }}" placeholder="0">
        <span class="input-group-text">km</span>
    </div>
</div>

<!-- Kategori -->
<div class="field-group">
    <label class="form-label">Kategori</label>
    <select name="category" class="form-select" required>
        <option value="">Pilih kategori</option>
        <option value="Rental" {{ old('category') == 'Rental' ? 'selected' : '' }}>Rental</option>
        <option value="Service" {{ old('category') == 'Service' ? 'selected' : '' }}>Service</option>
        <option value="Transport" {{ old('category') == 'Transport' ? 'selected' : '' }}>Transport</option>
        <option value="Delivery" {{ old('category') == 'Delivery' ? 'selected' : '' }}>Delivery</option>
        <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
    </select>
</div>

<!-- Sumber/Customer -->
<div class="field-group">
    <label class="form-label">Sumber/Customer</label>
    <input type="text" name="source" class="form-control" value="{{ old('source') }}" placeholder="Nama customer atau sumber pendapatan">
</div>

<!-- Deskripsi -->
<div class="field-group">
    <label class="form-label">Deskripsi</label>
    <input type="text" name="description" class="form-control" value="{{ old('description') }}" placeholder="Deskripsi pendapatan" required>
</div>

<!-- Jumlah -->
<div class="field-group">
    <label class="form-label">Jumlah</label>
    <div class="input-group">
        <span class="input-group-text">Rp</span>
        <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount') }}" placeholder="0" required>
    </div>
</div>

<!-- Metode Pembayaran -->
<div class="field-group">
    <label class="form-label">Metode pembayaran</label>
    <select name="payment_method" class="form-select">
        <option value="">Pilih metode</option>
        <option value="Tunai" {{ old('payment_method') == 'Tunai' ? 'selected' : '' }}>Tunai</option>
        <option value="Transfer" {{ old('payment_method') == 'Transfer' ? 'selected' : '' }}>Transfer</option>
        <option value="Kartu Kredit" {{ old('payment_method') == 'Kartu Kredit' ? 'selected' : '' }}>Kartu Kredit</option>
        <option value="E-Wallet" {{ old('payment_method') == 'E-Wallet' ? 'selected' : '' }}>E-Wallet</option>
    </select>
</div>

<!-- Nomor Invoice -->
<div class="field-group">
    <label class="form-label">Nomor invoice</label>
    <input type="text" name="invoice_number" class="form-control" value="{{ old('invoice_number') }}" placeholder="Nomor invoice">
</div>

<!-- Catatan -->
<div class="field-group">
    <label class="form-label">Catatan</label>
    <textarea name="notes" class="form-control" rows="3" placeholder="Tambahkan catatan (opsional)">{{ old('notes') }}</textarea>
</div>
@endsection
