@extends('layouts.drivvo')
@section('title', 'Checklist')
@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4><i class="fas fa-tasks me-2"></i>List Checklist</h4>
        <a href="{{ route('checklists.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Checklist
        </a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-body">
            @if($checklists->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Vehicle</th>
                                <th>Type</th>
                                <th>Diperiksa Oleh</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($checklists as $checklist)
                                <tr>
                                    <td>{{ $checklist->check_date->format('d/m/Y') }}</td>
                                    <td>{{ $checklist->vehicle->name }}</td>
                                    <td>{{ $checklist->checklist_type }}</td>
                                    <td>{{ $checklist->checked_by ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $checklists->links() }}
            @else
                <p class="text-center text-muted py-5">No data yet checklist</p>
            @endif
        </div>
    </div>
</div>
@endsection




























