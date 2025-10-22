@extends('layouts.drivvo-form', [
    'pageTitle' => 'Biaya',
    'pageIcon' => 'fas fa-credit-card',
    'formAction' => route('expenses.store'),
    'formId' => 'expenseForm',
    'cancelRoute' => route('expenses.index'),
    'modalRoute' => route('expenses.create'),
    'vehicle' => $vehicle ?? null
])

@section('form-fields')
<!-- Tanggal -->
<div class="field-group">
    <label class="form-label">Tanggal</label>
    <input type="date" name="expense_date" class="form-control" value="{{ old('expense_date', date('Y-m-d')) }}" required>
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
        <option value="Parkir" {{ old('category') == 'Parkir' ? 'selected' : '' }}>Parkir</option>
        <option value="Tol" {{ old('category') == 'Tol' ? 'selected' : '' }}>Tol</option>
        <option value="Asuransi" {{ old('category') == 'Asuransi' ? 'selected' : '' }}>Asuransi</option>
        <option value="Pajak" {{ old('category') == 'Pajak' ? 'selected' : '' }}>Pajak</option>
        <option value="Denda" {{ old('category') == 'Denda' ? 'selected' : '' }}>Denda</option>
        <option value="Accessories" {{ old('category') == 'Accessories' ? 'selected' : '' }}>Accessories</option>
        <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
    </select>
</div>

<!-- Sub Kategori -->
<div class="field-group">
    <label class="form-label">Sub kategori</label>
    <input type="text" name="subcategory" class="form-control" value="{{ old('subcategory') }}" placeholder="Opsional">
</div>

<!-- Deskripsi -->
<div class="field-group">
    <label class="form-label">Deskripsi</label>
    <input type="text" name="description" class="form-control" value="{{ old('description') }}" placeholder="Deskripsi biaya" required>
</div>

<!-- Jumlah -->
<div class="field-group">
    <label class="form-label">Jumlah</label>
    <div class="input-group">
        <span class="input-group-text">Rp</span>
        <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount') }}" placeholder="0" required>
    </div>
</div>

<!-- Vendor/Tempat -->
<div class="field-group">
    <label class="form-label">Vendor/Tempat</label>
    <input type="text" name="vendor" class="form-control" value="{{ old('vendor') }}" placeholder="Nama vendor atau tempat">
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

<!-- Nomor Kwitansi -->
<div class="field-group">
    <label class="form-label">Nomor kwitansi</label>
    <input type="text" name="receipt_number" class="form-control" value="{{ old('receipt_number') }}" placeholder="Nomor kwitansi/struk">
</div>

<!-- Biaya Berulang -->
<div class="field-group">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="is_recurring" id="isRecurring" value="1" {{ old('is_recurring') ? 'checked' : '' }}>
        <label class="form-check-label" for="isRecurring">
            Biaya berulang
        </label>
    </div>
</div>

<!-- Periode Berulang -->
<div class="field-group" id="recurringPeriodGroup" style="display: {{ old('is_recurring') ? 'block' : 'none' }};">
    <label class="form-label">Periode</label>
    <select name="recurring_period" class="form-select">
        <option value="">Pilih periode</option>
        <option value="Harian" {{ old('recurring_period') == 'Harian' ? 'selected' : '' }}>Harian</option>
        <option value="Mingguan" {{ old('recurring_period') == 'Mingguan' ? 'selected' : '' }}>Mingguan</option>
        <option value="Bulanan" {{ old('recurring_period') == 'Bulanan' ? 'selected' : '' }}>Bulanan</option>
        <option value="3 Bulan" {{ old('recurring_period') == '3 Bulan' ? 'selected' : '' }}>3 Bulan</option>
        <option value="6 Bulan" {{ old('recurring_period') == '6 Bulan' ? 'selected' : '' }}>6 Bulan</option>
        <option value="Tahunan" {{ old('recurring_period') == 'Tahunan' ? 'selected' : '' }}>Tahunan</option>
    </select>
</div>

<!-- Catatan -->
<div class="field-group">
    <label class="form-label">Catatan</label>
    <textarea name="notes" class="form-control" rows="3" placeholder="Tambahkan catatan (opsional)">{{ old('notes') }}</textarea>
</div>
@endsection

@section('additional-scripts')
// Toggle recurring period field
document.getElementById('isRecurring').addEventListener('change', function() {
    const recurringPeriodGroup = document.getElementById('recurringPeriodGroup');
    if (this.checked) {
        recurringPeriodGroup.style.display = 'block';
    } else {
        recurringPeriodGroup.style.display = 'none';
    }
});
@endsection
