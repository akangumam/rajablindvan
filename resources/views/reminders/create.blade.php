@extends('layouts.drivvo-form', [
    'pageTitle' => 'Tambah Pengingat',
    'pageIcon' => 'fa-bell',
    'pageSubtitle' => 'Buat pengingat untuk perawatan atau biaya kendaraan',
    'formAction' => route('reminders.store'),
    'formId' => 'reminderForm',
    'cancelRoute' => isset($vehicle) ? route('reminders.index', ['vehicle' => $vehicle->id]) : route('reminders.index'),
])

@section('form-fields')
@if(isset($vehicle))
    <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
@endif

<div class="field-group">
    <label class="form-label">Judul pengingat</label>
    <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="Contoh: Ganti Oli Mesin" required>
</div>

<div class="field-group">
    <label class="form-label">Kategori</label>
    <select name="category" class="form-select" required>
        <option value="">Pilih kategori</option>
        <option value="Service">Service</option>
        <option value="Ganti Oli">Ganti Oli</option>
        <option value="Pajak">Pajak</option>
        <option value="Asuransi">Asuransi</option>
    </select>
</div>

<div class="field-group">
    <label class="form-label">Tanggal jatuh tempo</label>
    <input type="date" name="due_date" class="form-control" value="{{ old('due_date') }}" required>
</div>

<div class="field-group">
    <label class="form-label">Catatan</label>
    <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
</div>
@endsection

@section('additional-scripts')
console.log('Form ready');
@endsection
