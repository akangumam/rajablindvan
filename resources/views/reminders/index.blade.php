@extends('layouts.drivvo')
@section('title', 'Reminders')
@section('content')

<style>
    .reminders-container {
        padding: 24px 32px;
    }

    /* Search Form */
    .search-form {
        margin-bottom: 20px;
    }

    .search-input-wrapper {
        position: relative;
        max-width: 500px;
    }

    .search-input-wrapper input {
        width: 100%;
        padding: 12px 45px 12px 45px;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 14px;
        transition: all 0.3s;
        background: white;
    }

    .search-input-wrapper input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .search-input-wrapper .search-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
        font-size: 16px;
    }

    .search-input-wrapper .clear-search {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #999;
        cursor: pointer;
        font-size: 16px;
        padding: 0;
        display: none;
    }

    .search-input-wrapper input:not(:placeholder-shown) ~ .clear-search {
        display: block;
    }

    .search-input-wrapper .clear-search:hover {
        color: #667eea;
    }

    /* Vehicle Selector Dropdown */
    .vehicle-selector-header {
        background: white;
        padding: 16px 24px;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .vehicle-dropdown-btn {
        background: white;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        padding: 10px 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        font-size: 15px;
        font-weight: 600;
        color: #333;
        transition: all 0.2s;
    }

    .vehicle-dropdown-btn:hover {
        border-color: #667eea;
        background: #f8f9ff;
    }

    .vehicle-dropdown-btn i {
        color: #667eea;
        font-size: 18px;
    }

    /* Breadcrumb */
    .reminder-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #999;
        font-size: 14px;
        margin-bottom: 20px;
    }

    .reminder-breadcrumb a {
        color: #667eea;
        text-decoration: none;
    }

    .reminder-breadcrumb a:hover {
        text-decoration: underline;
    }

    /* Page Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .page-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 28px;
        font-weight: 700;
        color: #333;
        margin: 0;
    }

    .page-title i {
        color: #667eea;
    }

    .btn-add {
        background: transparent;
        border: 2px solid #667eea;
        color: #667eea;
        padding: 10px 24px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.2s;
    }

    .btn-add:hover {
        background: #667eea;
        color: white;
    }

    /* Empty State */
    .empty-state {
        background: white;
        border-radius: 12px;
        padding: 60px 20px;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .empty-state-icon {
        width: 200px;
        height: 200px;
        margin: 0 auto 24px;
        background: linear-gradient(135deg, #f5f7ff 0%, #e8ecff 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .empty-state-icon i.fa-calendar {
        font-size: 80px;
        color: #667eea;
        opacity: 0.4;
    }

    .empty-state-icon i.fa-bell {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 50px;
        color: #667eea;
    }

    .empty-state-text {
        font-size: 18px;
        color: #666;
        margin-bottom: 32px;
        font-weight: 500;
    }

    .btn-empty-action {
        background: #667eea;
        color: white;
        border: none;
        padding: 14px 32px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-empty-action:hover {
        background: #5568d3;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    /* Reminders List */
    .reminders-list {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .reminder-item {
        padding: 20px 24px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: background 0.2s;
    }

    .reminder-item:hover {
        background: #f8f9ff;
    }

    .reminder-item:last-child {
        border-bottom: none;
    }

    .reminder-info {
        flex: 1;
    }

    .reminder-title {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin-bottom: 4px;
    }

    .reminder-meta {
        font-size: 14px;
        color: #999;
    }

    .reminder-badge {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }

    .reminder-badge.pending {
        background: #fff3cd;
        color: #856404;
    }

    .reminder-badge.completed {
        background: #d4edda;
        color: #155724;
    }

    .reminder-actions {
        display: flex;
        gap: 8px;
        margin-left: 16px;
    }

    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 14px;
    }

    .btn-edit {
        background: #e3f2fd;
        color: #1976d2;
    }

    .btn-edit:hover {
        background: #1976d2;
        color: white;
    }

    .btn-delete {
        background: #ffebee;
        color: #c62828;
    }

    .btn-delete:hover {
        background: #c62828;
        color: white;
    }

    /* Custom Pagination */
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 24px;
        padding: 20px 24px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .pagination-info {
        font-size: 14px;
        color: #666;
    }

    .pagination-links {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .pagination-links a,
    .pagination-links span {
        min-width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .pagination-links a {
        background: white;
        border: 2px solid #e0e0e0;
        color: #666;
    }

    .pagination-links a:hover {
        border-color: #667eea;
        color: #667eea;
        background: #f8f9ff;
    }

    .pagination-links .active {
        background: #667eea;
        border: 2px solid #667eea;
        color: white;
    }

    .pagination-links .disabled {
        background: #f5f5f5;
        border: 2px solid #e0e0e0;
        color: #ccc;
        cursor: not-allowed;
    }
</style>

<div class="reminders-container">
    <!-- Vehicle Selector Header -->
    <div class="vehicle-selector-header">
        <button class="vehicle-dropdown-btn" type="button" data-bs-toggle="modal" data-bs-target="#vehicleReminderModal">
            <i class="fas fa-car"></i>
            <span id="selectedVehicleName">
                @if(isset($selectedVehicle))
                    {{ $selectedVehicle->name }}
                @else
                    Select Vehicle
                @endif
            </span>
            <i class="fas fa-chevron-down" style="margin-left: auto; font-size: 12px;"></i>
        </button>
    </div>

    <!-- Breadcrumb -->
    @if(isset($selectedVehicle))
        <div class="reminder-breadcrumb">
            <a href="{{ route('dashboard') }}">{{ $selectedVehicle->name }}</a>
            <i class="fas fa-chevron-right" style="font-size: 10px;"></i>
            <span>Reminders</span>
        </div>
    @endif

    <!-- Search Bar -->
    @if(isset($selectedVehicle))
        <form action="{{ route('reminders.index') }}" method="GET" class="search-form">
            <input type="hidden" name="vehicle" value="{{ $selectedVehicle->id }}">
            <div class="search-input-wrapper position-relative">
                <i class="fas fa-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #999; z-index: 1;"></i>
                <input type="text"
                       id="reminderSearch"
                       name="search"
                       placeholder="Search by title, category, or notes..."
                       value="{{ request('search') }}"
                       style="padding-left: 40px; padding-right: 40px;"
                       autocomplete="off"
                       autofocus>
                <button type="button"
                        id="clearSearch"
                        class="clear-search position-absolute"
                        onclick="clearSearchInput('reminderSearch')"
                        style="right: 12px; top: 50%; transform: translateY(-50%); padding: 0; width: 24px; height: 24px; border: none; background: transparent; display: {{ request('search') ? 'block' : 'none' }};">
                    <i class="fas fa-times text-muted"></i>
                </button>
            </div>
        </form>
    @endif

    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-bell"></i>
            Reminders
        </h1>
        @if(isset($selectedVehicle))
            <a href="{{ route('reminders.create', ['vehicle' => $selectedVehicle->id]) }}" class="btn-add">
                ADD NEW
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(!isset($selectedVehicle))
        <!-- Empty State: No Vehicle Selected -->
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-calendar"></i>
                <i class="fas fa-bell"></i>
            </div>
            <div class="empty-state-text">
                Select Vehicle to view reminders
            </div>
        </div>
    @elseif(isset($reminders) && $reminders->count() > 0)
        <!-- Reminders List -->
        <div class="reminders-list">
            @foreach($reminders as $reminder)
                <div class="reminder-item">
                    <div class="reminder-info">
                        <div class="reminder-title">{{ $reminder->title }}</div>
                        <div class="reminder-meta">
                            <i class="fas fa-tag me-1"></i>{{ $reminder->category }}
                            <span class="mx-2">•</span>
                            <i class="far fa-calendar me-1"></i>{{ $reminder->due_date->format($appDateFormat) }}
                            @if($reminder->estimated_cost)
                                <span class="mx-2">•</span>
                                <i class="fas fa-dollar-sign me-1"></i>Rp {{ number_format($reminder->estimated_cost, 0, ',', '.') }}
                            @endif
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        @if($reminder->is_completed)
                            <span class="reminder-badge completed">Completed</span>
                        @else
                            <span class="reminder-badge pending">Pending</span>
                        @endif

                        <div class="reminder-actions">
                            <a href="{{ route('reminders.edit', $reminder->id) }}" class="btn-action btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('reminders.destroy', $reminder->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this reminder?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Custom Pagination -->
        @if($reminders->hasPages())
            <div class="pagination-container">
                <div class="pagination-info">
                    Showing {{ $reminders->firstItem() }} to {{ $reminders->lastItem() }} of {{ $reminders->total() }} results
                </div>
                <div class="pagination-links">
                    @if ($reminders->onFirstPage())
                        <span class="disabled">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $reminders->appends(request()->query())->previousPageUrl() }}">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    @endif

                    @foreach ($reminders->getUrlRange(1, $reminders->lastPage()) as $page => $url)
                        @if ($page == $reminders->currentPage())
                            <span class="active">{{ $page }}</span>
                        @else
                            <a href="{{ $reminders->appends(request()->query())->url($page) }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($reminders->hasMorePages())
                        <a href="{{ $reminders->appends(request()->query())->nextPageUrl() }}">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @else
                        <span class="disabled">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    @endif
                </div>
            </div>
        @endif
    @else
        <!-- Empty State: No Reminders -->
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-calendar"></i>
                <i class="fas fa-bell"></i>
            </div>
            <div class="empty-state-text">
                you have no reminders
            </div>
            <a href="{{ route('reminders.create', ['vehicle' => $selectedVehicle->id]) }}" class="btn-empty-action">
                ADD NEW REMINDER
            </a>
        </div>
    @endif
</div>

<!-- Vehicle Selection Modal for Reminders -->
<div class="modal fade" id="vehicleReminderModal" tabindex="-1" aria-labelledby="vehicleReminderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 8px 24px rgba(0,0,0,0.15);">
            <div class="modal-header border-0 pb-2" style="padding: 20px 24px 10px 24px;">
                <h5 class="modal-title fw-semibold" id="vehicleReminderModalLabel" style="font-size: 18px; color: #333;">Select Vehicle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0" style="padding: 10px 24px 20px 24px;">
                <!-- Searchbar -->
                <div class="position-relative mb-3">
                    <i class="fas fa-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #999; z-index: 1;"></i>
                    <input type="text"
                           id="vehicleReminderSearch"
                           class="form-control"
                           placeholder="Cari Nama atau No Plat..."
                           style="padding-left: 40px; padding-right: 40px; border-radius: 10px;"
                           autofocus>
                    <button type="button"
                            id="clearVehicleReminderSearch"
                            class="btn btn-sm position-absolute"
                            style="right: 12px; top: 50%; transform: translateY(-50%); padding: 0; width: 24px; height: 24px; border: none; background: transparent; display: none;">
                        <i class="fas fa-times text-muted"></i>
                    </button>
                </div>

                <!-- Vehicle List -->
                <div id="vehicleReminderList" style="max-height: 400px; overflow-y: auto;">
                @foreach($vehicles ?? [] as $vehicle)
                    <a href="{{ route('reminders.index', ['vehicle' => $vehicle->id]) }}"
                       class="vehicle-modal-item {{ isset($selectedVehicle) && $selectedVehicle->id == $vehicle->id ? 'active' : '' }}"
                       style="display: flex; align-items: center; padding: 12px 16px; border-radius: 12px; text-decoration: none; transition: all 0.2s; margin-bottom: 8px; background: {{ isset($selectedVehicle) && $selectedVehicle->id == $vehicle->id ? '#f0f4ff' : 'transparent' }};"
                       onmouseover="if(!this.classList.contains('active')) this.style.background='#f8f9fa'"
                       onmouseout="if(!this.classList.contains('active')) this.style.background='transparent'">
                        <div style="width: 48px; height: 48px; background: white; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-right: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                            <img src="{{ $vehicle->getBrandLogoUrl() }}"
                                 alt="{{ $vehicle->brand }}"
                                 style="width: 32px; height: 32px; object-fit: contain;">
                        </div>
                        <div style="flex: 1;">
                            <div style="font-size: 15px; font-weight: 600; color: #333; margin-bottom: 2px;">
                                {{ $vehicle->name }}
                            </div>
                            <div style="font-size: 13px; color: #999;">
                                {{ $vehicle->license_plate }}
                            </div>
                        </div>
                        @if(isset($selectedVehicle) && $selectedVehicle->id == $vehicle->id)
                            <i class="fas fa-check-circle" style="color: #667eea; font-size: 20px;"></i>
                        @else
                            <i class="fas fa-chevron-right" style="color: #ddd; font-size: 14px;"></i>
                        @endif
                    </a>
                @endforeach
                </div>
            </div>
            <div class="modal-footer border-0 pt-0" style="padding: 10px 24px 20px 24px;">
                <div class="d-grid gap-2 w-100">
                    <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('vehicles.create') }}'"
                            style="background: #667eea; border: none; padding: 12px; font-weight: 600; border-radius: 10px;">
                        <i class="fas fa-plus me-2"></i>Add New Vehicles
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Live search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('reminderSearch');
    const reminderCards = document.querySelectorAll('.reminder-item'); // Updated selector to match reminder list items
    const clearBtn = document.getElementById('clearSearch');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();

            // Toggle clear button
            if (clearBtn) {
                clearBtn.style.display = searchTerm.length > 0 ? 'block' : 'none';
            }

            reminderCards.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }

    // Vehicle modal searchbar - auto-focus when modal opens
    const vehicleReminderModal = document.getElementById('vehicleReminderModal');
    if (vehicleReminderModal) {
        vehicleReminderModal.addEventListener('shown.bs.modal', function() {
            const searchInput = document.getElementById('vehicleReminderSearch');
            if (searchInput) {
                setTimeout(() => {
                    searchInput.focus();
                }, 100);
            }
        });
    }

    // Vehicle modal searchbar - live search
    const vehicleSearchInput = document.getElementById('vehicleReminderSearch');
    const clearVehicleBtn = document.getElementById('clearVehicleReminderSearch');
    const vehicleItems = document.querySelectorAll('.vehicle-modal-item');

    if (vehicleSearchInput) {
        vehicleSearchInput.addEventListener('input', function(e) {
            const searchText = e.target.value.toLowerCase();

            // Show/hide clear button
            if (clearVehicleBtn) {
                clearVehicleBtn.style.display = searchText ? 'block' : 'none';
            }

            // Filter vehicle items
            vehicleItems.forEach(item => {
                const vehicleName = item.querySelector('div[style*="font-size: 15px"]')?.textContent.toLowerCase() || '';
                const vehicleBrand = item.querySelector('div[style*="font-size: 13px"]')?.textContent.toLowerCase() || '';
                const matchText = vehicleName + ' ' + vehicleBrand;

                if (matchText.includes(searchText)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        // Clear button functionality
        if (clearVehicleBtn) {
            clearVehicleBtn.addEventListener('click', function() {
                vehicleSearchInput.value = '';
                this.style.display = 'none';

                // Show all items
                vehicleItems.forEach(item => {
                    item.style.display = 'flex';
                });

                vehicleSearchInput.focus();
            });
        }
    }
});

function clearSearchInput(inputId) {
    const input = document.getElementById(inputId);
    if (input) {
        input.value = '';
        input.form.submit();
    }
}
</script>
@endpush

@endsection




























