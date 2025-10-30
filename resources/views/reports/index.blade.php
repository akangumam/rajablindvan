@extends('layouts.drivvo')

@section('title', 'Reports')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .page-title {
        font-size: 32px;
        font-weight: 700;
        color: #2c3e50;
        margin: 0 0 8px 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .page-title i {
        font-size: 28px;
        color: #007bff;
    }
    .page-subtitle {
        font-size: 15px;
        color: #7f8c8d;
        margin: 0;
        font-weight: 400;
    }
    
    /* Filter Section - Stand-alone */
    .filter-section {
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        margin-bottom: 24px;
        overflow: hidden;
    }
    .filter-header {
        background: #007bff;
        color: white;
        padding: 16px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
    }
    .filter-header h5 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .filter-body {
        padding: 24px;
    }
    .filter-body.collapsed {
        display: none;
    }
    .filter-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }
    .filter-group label {
        font-weight: 600;
        color: #555;
        margin-bottom: 8px;
        display: block;
        font-size: 14px;
    }
    .form-select, .form-control {
        border: 1px solid #ddd;
        border-radius: 6px;
        padding: 8px 12px;
    }
    .form-select[multiple] {
        padding: 8px;
        cursor: pointer;
    }
    .form-select[multiple] option {
        padding: 8px 12px;
        border-radius: 4px;
        margin-bottom: 2px;
        cursor: pointer;
    }
    .form-select[multiple] option:hover {
        background-color: #e3f2fd;
    }
    .form-select[multiple] option:checked {
        background-color: #007bff;
        color: white;
    }
    #selectedVehiclesDisplay {
        background: #f8f9fa;
        padding: 12px;
        border-radius: 6px;
        border: 1px solid #dee2e6;
    }
    #selectedVehiclesList {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .selected-vehicle-tag {
        background: #007bff;
        color: white;
        padding: 4px 12px;
        border-radius: 16px;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .selected-vehicle-tag .remove-tag {
        cursor: pointer;
        font-weight: bold;
        opacity: 0.8;
    }
    .selected-vehicle-tag .remove-tag:hover {
        opacity: 1;
    }
    
    /* Toggle Switch */
    .toggle-section {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    }
    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 24px;
    }
    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    input:checked + .toggle-slider {
        background-color: #28a745;
    }
    input:checked + .toggle-slider:before {
        transform: translateX(26px);
    }
    .toggle-label {
        font-weight: 600;
        color: #333;
        font-size: 15px;
    }
    .toggle-status {
        font-size: 13px;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 4px;
    }
    .toggle-status.on {
        background: #d4edda;
        color: #155724;
    }
    .toggle-status.off {
        background: #f8d7da;
        color: #721c24;
    }
    .type-selection {
        margin-top: 8px;
        display: none;
    }
    .type-selection.show {
        display: block;
    }
    
    /* Alert */
    .alert-info-custom {
        background: #e3f2fd;
        border-left: 4px solid #2196f3;
        padding: 12px 16px;
        margin: 16px 0;
        border-radius: 4px;
        font-size: 14px;
        color: #1976d2;
    }
    
    /* Action Buttons */
    .filter-actions {
        display: flex;
        gap: 12px;
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }
    .btn-apply {
        background: #28a745;
        border: none;
        color: white;
        padding: 10px 30px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        transition: all 0.3s ease;
    }
    .btn-apply:hover {
        background: #218838;
        transform: translateY(-1px);
    }
    .btn-clear {
        background: #ffc107;
        border: none;
        color: #212529;
        padding: 10px 30px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
    }
    .btn-cancel {
        background: white;
        border: 2px solid #6c757d;
        color: #6c757d;
        padding: 10px 30px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
    }
    
    /* Report Display - Separate section with tabs */
    .report-display {
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        margin-top: 24px;
        /* Temporary: Show for testing, will be hidden by default */
        /* display: none; */
    }
    .report-display.show {
        display: block;
    }
    .nav-tabs {
        border-bottom: 2px solid #e9ecef;
        padding: 0 20px;
        background: #f8f9fa;
    }
    .nav-tabs .nav-link {
        border: none;
        color: #6c757d;
        font-weight: 600;
        padding: 16px 32px;
        margin-right: 8px;
        font-size: 15px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: transparent;
    }
    .nav-tabs .nav-link:hover {
        color: #007bff;
        border: none;
    }
    .nav-tabs .nav-link.active {
        color: #007bff;
        border: none;
        border-bottom: 3px solid #007bff;
        background: white;
    }
    .tab-content {
        background: white;
    }
    .tab-content-inner {
        padding: 30px;
    }
    
    /* Summary Cards */
    .summary-section {
        margin-bottom: 30px;
    }
    .summary-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 24px;
    }
    .summary-card {
        padding: 20px;
        border-radius: 8px;
        border: 2px solid #e9ecef;
    }
    .summary-card h6 {
        color: #6c757d;
        font-size: 13px;
        margin-bottom: 8px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .summary-card .amount {
        font-size: 28px;
        font-weight: 700;
        margin: 0;
    }
    .summary-card.income {
        border-color: #28a745;
        background: #f8fff9;
    }
    .summary-card.income .amount { color: #28a745; }
    .summary-card.cost {
        border-color: #dc3545;
        background: #fff8f8;
    }
    .summary-card.cost .amount { color: #dc3545; }
    .summary-card.balance {
        border-color: #007bff;
        background: #f8fbff;
    }
    .summary-card.balance .amount { color: #007bff; }
    
    /* Cost Split */
    .cost-split {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    .cost-card {
        padding: 16px;
        border-radius: 6px;
        border: 1px solid #e9ecef;
    }
    .cost-card h6 {
        color: #6c757d;
        font-size: 12px;
        margin-bottom: 6px;
        font-weight: 600;
        text-transform: uppercase;
    }
    .cost-card .amount {
        font-size: 22px;
        font-weight: 700;
    }
    .cost-card.service .amount { color: #17a2b8; }
    .cost-card.expense .amount { color: #fd7e14; }
    
    /* Vehicle Table */
    .vehicle-table-container {
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e9ecef;
    }
    .vehicle-table {
        width: 100%;
        margin: 0;
    }
    .vehicle-table thead {
        background: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
    }
    .vehicle-table thead th {
        padding: 14px 16px;
        font-size: 13px;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
    }
    .vehicle-table tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
    }
    .vehicle-table tbody tr:last-child td {
        border-bottom: none;
    }
    .vehicle-table tfoot {
        background: #f8f9fa;
        border-top: 2px solid #e9ecef;
    }
    .vehicle-table tfoot td {
        padding: 14px 16px;
        font-weight: 700;
        font-size: 15px;
    }
    
    /* Detail Tab - Accordion */
    .accordion-item {
        border: 1px solid #e9ecef;
        border-radius: 6px;
        margin-bottom: 12px;
    }
    .accordion-header .accordion-button {
        background: #f8f9fa;
        color: #333;
        font-weight: 600;
        font-size: 15px;
        padding: 14px 20px;
    }
    .accordion-header .accordion-button:not(.collapsed) {
        background: #007bff;
        color: white;
    }
    .accordion-body {
        padding: 20px;
    }
    
    /* Download Button */
    .download-btn {
        background: #28a745;
        border: none;
        color: white;
        padding: 8px 20px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 14px;
        float: right;
        margin-bottom: 16px;
    }
    .download-btn:hover {
        background: #218838;
    }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">
            <i class="bi bi-graph-up"></i>
            Reports
        </h1>
        <p class="page-subtitle">Generate comprehensive reports with custom filters</p>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- SECTION 1: FILTER (Stand-alone, no tab) -->
<div class="filter-section">
    <div class="filter-header" id="toggleFilter">
        <h5><i class="bi bi-funnel"></i> Filter</h5>
        <i class="bi bi-chevron-up" id="filterIcon"></i>
    </div>
    <div class="filter-body" id="filterBody">
        <!-- Vehicle Filter -->
        <div class="filter-group">
            <label>Vehicle</label>
            <select class="form-select" id="vehicleFilter">
                <option value="all">ALL</option>
                <option value="active">ACTIVE</option>
                <option value="inactive">INACTIVE</option>
                <option value="custom">CUSTOM</option>
            </select>
            <div id="customVehicleSelection" style="display: none; margin-top: 10px;">
                <div id="vehicleSelectBox">
                    <select class="form-select" id="vehicleIds" multiple size="8" style="height: auto; min-height: 150px;">
                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}">{{ $vehicle->name }} - {{ $vehicle->license_plate }}</option>
                        @endforeach
                    </select>
                    <small class="text-muted d-block mt-1">
                        <i class="bi bi-info-circle"></i> Hold Ctrl/Cmd to select multiple vehicles
                    </small>
                    <button type="button" class="btn btn-sm btn-primary mt-2" id="confirmVehicleSelection">
                        <i class="bi bi-check"></i> Confirm Selection
                    </button>
                </div>
                <div id="selectedVehiclesDisplay" class="mt-2" style="display: none;">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <strong>Selected Vehicles (<span id="selectedCount">0</span>)</strong>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="changeVehicleSelection">
                            <i class="bi bi-pencil"></i> Change
                        </button>
                    </div>
                    <div id="selectedVehiclesList"></div>
                </div>
            </div>
        </div>

        <!-- Period Filter -->
        <div class="filter-group">
            <label>Period</label>
            <select class="form-select" id="periodFilter">
                <option value="last_month">Last Month</option>
                <option value="last_3_months">Last 3 Months</option>
                <option value="last_6_months">Last 6 Months</option>
                <option value="last_year">Last Year</option>
                <option value="custom">Custom Date Range</option>
            </select>
            <div id="customPeriodSelection" style="display: none; margin-top: 10px;">
                <div class="row">
                    <div class="col-md-6">
                        <label>Start Date</label>
                        <input type="date" class="form-control" id="startDate">
                    </div>
                    <div class="col-md-6">
                        <label>End Date</label>
                        <input type="date" id="endDate" class="form-control">
                    </div>
                </div>
            </div>
        </div>

        <!-- Income Toggle -->
        <div class="filter-group">
            <div class="toggle-section">
                <label class="toggle-switch">
                    <input type="checkbox" id="incomeToggle" checked>
                    <span class="toggle-slider"></span>
                </label>
                <span class="toggle-label">Income</span>
                <span class="toggle-status on" id="incomeStatus">ON</span>
            </div>
            <div class="type-selection show" id="incomeTypeSelection">
                <select class="form-select" id="incomeType">
                    <option value="all">ALL</option>
                    <option value="custom">CUSTOM</option>
                </select>
            </div>
        </div>

        <!-- Service Toggle -->
        <div class="filter-group">
            <div class="toggle-section">
                <label class="toggle-switch">
                    <input type="checkbox" id="serviceToggle" checked>
                    <span class="toggle-slider"></span>
                </label>
                <span class="toggle-label">Service</span>
                <span class="toggle-status on" id="serviceStatus">ON</span>
            </div>
            <div class="type-selection show" id="serviceTypeSelection">
                <select class="form-select" id="serviceType">
                    <option value="all">ALL</option>
                    <option value="custom">CUSTOM</option>
                </select>
            </div>
        </div>

        <!-- Expense Toggle -->
        <div class="filter-group">
            <div class="toggle-section">
                <label class="toggle-switch">
                    <input type="checkbox" id="expenseToggle" checked>
                    <span class="toggle-slider"></span>
                </label>
                <span class="toggle-label">Expense</span>
                <span class="toggle-status on" id="expenseStatus">ON</span>
            </div>
            <div class="type-selection show" id="expenseTypeSelection">
                <select class="form-select" id="expenseType">
                    <option value="all">ALL</option>
                    <option value="custom">CUSTOM</option>
                </select>
            </div>
        </div>

        <!-- Alert -->
        <div class="alert-info-custom">
            <i class="bi bi-info-circle"></i>
            <strong>Note:</strong> Untuk Item yg di OFF berarti tidak akan dimunculkan dalam report/0
        </div>

        <!-- Action Buttons -->
        <div class="filter-actions">
            <button type="button" class="btn-apply" id="applyFilter">
                <i class="bi bi-check-circle"></i> APPLY FILTER
            </button>
            <button type="button" class="btn-clear" id="clearFilter">
                <i class="bi bi-arrow-clockwise"></i> CLEAR FILTER
            </button>
            <button type="button" class="btn-cancel" id="cancelFilter">
                <i class="bi bi-x-circle"></i> CANCEL (Minimize and Clear Filter)
            </button>
        </div>
    </div>
</div>

<!-- SECTION 2: REPORT DISPLAY (with 2 tabs: GENERAL & DETAIL) -->
<div class="report-display" id="reportDisplay">
    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#generalTab" type="button" role="tab">
                GENERAL TAB
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="detail-tab" data-bs-toggle="tab" data-bs-target="#detailTab" type="button" role="tab">
                DETAIL TAB
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <!-- GENERAL TAB -->
        <div class="tab-pane fade show active" id="generalTab" role="tabpanel">
            <div class="tab-content-inner">
            <button type="button" class="download-btn" id="downloadGeneral">
                <i class="bi bi-download"></i> Download
            </button>
            <div class="clearfix"></div>

            <!-- ITEM TO SHOW -->
            <div class="summary-section">
                <div class="summary-cards">
                    <div class="summary-card income">
                        <h6>Income</h6>
                        <p class="amount" id="totalIncome">Rp 0</p>
                    </div>
                    <div class="summary-card cost">
                        <h6>Cost</h6>
                        <p class="amount" id="totalCost">Rp 0</p>
                    </div>
                    <div class="summary-card balance">
                        <h6>Balance (Income - Cost)</h6>
                        <p class="amount" id="totalBalance">Rp 0</p>
                    </div>
                </div>
            </div>

            <!-- COST SPLIT (Sub Section) -->
            <div class="summary-section">
                <div class="cost-split">
                    <div class="cost-card service">
                        <h6>Service</h6>
                        <p class="amount" id="serviceCost">Rp 0</p>
                    </div>
                    <div class="cost-card expense">
                        <h6>Expense</h6>
                        <p class="amount" id="expenseCost">Rp 0</p>
                    </div>
                </div>
            </div>

            <!-- VEHICLE (Sub Section) - Report by Vehicle (4.3) -->
            <div class="summary-section">
                
                <div class="vehicle-table-container">
                    <table class="vehicle-table">
                        <thead>
                            <tr>
                                <th>Vehicle Name</th>
                                <th>Income</th>
                                <th>Service</th>
                                <th>Expense</th>
                                <th>Cost</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody id="vehicleTableBody">
                            <tr>
                                <td colspan="6" class="text-center text-muted">No data available. Please apply filter.</td>
                            </tr>
                        </tbody>
                        <tfoot id="vehicleTableFooter" style="display: none;">
                            <tr class="fw-bold">
                                <td>TOTAL</td>
                                <td id="footerIncome">Rp 0</td>
                                <td id="footerService">Rp 0</td>
                                <td id="footerExpense">Rp 0</td>
                                <td id="footerCost">Rp 0</td>
                                <td id="footerBalance">Rp 0</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            </div>
        </div>

        <!-- DETAIL TAB -->
        <div class="tab-pane fade" id="detailTab" role="tabpanel">
            <div class="tab-content-inner">
            <button type="button" class="download-btn" id="downloadDetail">
                <i class="bi bi-download"></i> Download
            </button>
            <div class="clearfix"></div>

            <!-- Detail Tab Header -->
            <div class="detail-header mb-4">
                <h5 class="mb-2">Sub Section (Income, Expense, Service)</h5>
                <p class="text-muted mb-0">Semua detail yang tercatat</p>
            </div>

            <div class="accordion" id="detailAccordion">
                <!-- Income Details -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#incomeDetails">
                            <i class="bi bi-cash-stack me-2"></i> Income Details
                        </button>
                    </h2>
                    <div id="incomeDetails" class="accordion-collapse collapse show" data-bs-parent="#detailAccordion">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Vehicle</th>
                                            <th>Customer</th>
                                            <th>Type</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody id="incomeDetailsBody">
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">No income data</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service Details -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#serviceDetails">
                            <i class="bi bi-tools me-2"></i> Service Details
                        </button>
                    </h2>
                    <div id="serviceDetails" class="accordion-collapse collapse" data-bs-parent="#detailAccordion">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Vehicle</th>
                                            <th>Type</th>
                                            <th>Description</th>
                                            <th>Cost</th>
                                        </tr>
                                    </thead>
                                    <tbody id="serviceDetailsBody">
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">No service data</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Expense Details -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#expenseDetails">
                            <i class="bi bi-receipt me-2"></i> Expense Details
                        </button>
                    </h2>
                    <div id="expenseDetails" class="accordion-collapse collapse" data-bs-parent="#detailAccordion">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Vehicle</th>
                                            <th>Category</th>
                                            <th>Description</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody id="expenseDetailsBody">
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">No expense data</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle filter section collapse/expand
    document.getElementById('toggleFilter').addEventListener('click', function() {
        const filterBody = document.getElementById('filterBody');
        const filterIcon = document.getElementById('filterIcon');
        
        filterBody.classList.toggle('collapsed');
        if (filterBody.classList.contains('collapsed')) {
            filterIcon.classList.remove('bi-chevron-up');
            filterIcon.classList.add('bi-chevron-down');
        } else {
            filterIcon.classList.remove('bi-chevron-down');
            filterIcon.classList.add('bi-chevron-up');
        }
    });

    // Vehicle filter - show/hide custom selection
    document.getElementById('vehicleFilter').addEventListener('change', function() {
        const customSelection = document.getElementById('customVehicleSelection');
        const selectBox = document.getElementById('vehicleSelectBox');
        const displayBox = document.getElementById('selectedVehiclesDisplay');
        
        if (this.value === 'custom') {
            customSelection.style.display = 'block';
            selectBox.style.display = 'block';
            displayBox.style.display = 'none';
        } else {
            customSelection.style.display = 'none';
            // Reset selection when switching away from custom
            document.getElementById('vehicleIds').selectedIndex = -1;
            updateSelectedVehiclesDisplay();
        }
    });

    // Confirm vehicle selection - hide select box and show tags
    document.getElementById('confirmVehicleSelection').addEventListener('click', function() {
        const selectedOptions = Array.from(document.getElementById('vehicleIds').selectedOptions);
        
        if (selectedOptions.length > 0) {
            document.getElementById('vehicleSelectBox').style.display = 'none';
            updateSelectedVehiclesDisplay();
            document.getElementById('selectedVehiclesDisplay').style.display = 'block';
        } else {
            alert('Please select at least one vehicle');
        }
    });

    // Change vehicle selection - show select box again
    document.getElementById('changeVehicleSelection').addEventListener('click', function() {
        document.getElementById('vehicleSelectBox').style.display = 'block';
        document.getElementById('selectedVehiclesDisplay').style.display = 'none';
    });

    // Handle vehicle selection in multiselect (for live preview - optional)
    document.getElementById('vehicleIds').addEventListener('change', function() {
        // Just update internal state, display will show after confirm
    });

    function updateSelectedVehiclesDisplay() {
        const select = document.getElementById('vehicleIds');
        const selectedOptions = Array.from(select.selectedOptions);
        const countSpan = document.getElementById('selectedCount');
        const listDiv = document.getElementById('selectedVehiclesList');
        
        if (selectedOptions.length > 0) {
            countSpan.textContent = selectedOptions.length;
            
            listDiv.innerHTML = selectedOptions.map(option => `
                <span class="selected-vehicle-tag">
                    ${option.text}
                    <span class="remove-tag" onclick="removeVehicleSelection('${option.value}')">&times;</span>
                </span>
            `).join('');
        } else {
            listDiv.innerHTML = '<span class="text-muted">No vehicles selected</span>';
        }
    }

    // Function to remove individual vehicle selection
    window.removeVehicleSelection = function(vehicleId) {
        const select = document.getElementById('vehicleIds');
        const option = select.querySelector(`option[value="${vehicleId}"]`);
        if (option) {
            option.selected = false;
            updateSelectedVehiclesDisplay();
            
            // If no vehicles left, show select box again
            if (select.selectedOptions.length === 0) {
                document.getElementById('vehicleSelectBox').style.display = 'block';
                document.getElementById('selectedVehiclesDisplay').style.display = 'none';
            }
        }
    };


    // Period filter - show/hide custom date range
    document.getElementById('periodFilter').addEventListener('change', function() {
        const customSelection = document.getElementById('customPeriodSelection');
        customSelection.style.display = this.value === 'custom' ? 'block' : 'none';
    });

    // Toggle switches
    function setupToggle(toggleId, statusId, typeSelectionId) {
        const toggle = document.getElementById(toggleId);
        const status = document.getElementById(statusId);
        const typeSelection = document.getElementById(typeSelectionId);
        
        toggle.addEventListener('change', function() {
            if (this.checked) {
                status.textContent = 'ON';
                status.classList.remove('off');
                status.classList.add('on');
                typeSelection.classList.add('show');
            } else {
                status.textContent = 'OFF';
                status.classList.remove('on');
                status.classList.add('off');
                typeSelection.classList.remove('show');
            }
        });
    }

    setupToggle('incomeToggle', 'incomeStatus', 'incomeTypeSelection');
    setupToggle('serviceToggle', 'serviceStatus', 'serviceTypeSelection');
    setupToggle('expenseToggle', 'expenseStatus', 'expenseTypeSelection');

    // Format currency
    function formatRupiah(amount) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
    }

    // Apply Filter - show report and switch to general tab
    document.getElementById('applyFilter').addEventListener('click', function() {
        const formData = {
            vehicle_filter: document.getElementById('vehicleFilter').value,
            vehicle_ids: Array.from(document.getElementById('vehicleIds').selectedOptions).map(opt => opt.value),
            period: document.getElementById('periodFilter').value,
            start_date: document.getElementById('startDate').value,
            end_date: document.getElementById('endDate').value,
            income_toggle: document.getElementById('incomeToggle').checked,
            income_type: document.getElementById('incomeType').value,
            service_toggle: document.getElementById('serviceToggle').checked,
            service_type: document.getElementById('serviceType').value,
            expense_toggle: document.getElementById('expenseToggle').checked,
            expense_type: document.getElementById('expenseType').value
        };

        // Show report display section
        const reportDisplay = document.getElementById('reportDisplay');
        reportDisplay.classList.add('show');
        
        // Activate General Tab
        const generalTab = new bootstrap.Tab(document.getElementById('general-tab'));
        generalTab.show();

        // Fetch report data
        fetch('{{ route("reports.generate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            // Update summary cards
            document.getElementById('totalIncome').textContent = formatRupiah(data.totalIncome);
            document.getElementById('totalCost').textContent = formatRupiah(data.totalCost);
            document.getElementById('totalBalance').textContent = formatRupiah(data.totalBalance);
            document.getElementById('serviceCost').textContent = formatRupiah(data.serviceCost);
            document.getElementById('expenseCost').textContent = formatRupiah(data.expenseCost);

            // Update vehicle table
            const tbody = document.getElementById('vehicleTableBody');
            const tfoot = document.getElementById('vehicleTableFooter');
            
            if (data.vehicles && data.vehicles.length > 0) {
                tbody.innerHTML = data.vehicles.map(v => `
                    <tr>
                        <td>${v.name}</td>
                        <td>${formatRupiah(v.income)}</td>
                        <td>${formatRupiah(v.service)}</td>
                        <td>${formatRupiah(v.expense)}</td>
                        <td>${formatRupiah(v.cost)}</td>
                        <td>${formatRupiah(v.balance)}</td>
                    </tr>
                `).join('');
                
                // Update footer
                document.getElementById('footerIncome').textContent = formatRupiah(data.totalIncome);
                document.getElementById('footerService').textContent = formatRupiah(data.serviceCost);
                document.getElementById('footerExpense').textContent = formatRupiah(data.expenseCost);
                document.getElementById('footerCost').textContent = formatRupiah(data.totalCost);
                document.getElementById('footerBalance').textContent = formatRupiah(data.totalBalance);
                tfoot.style.display = '';
            } else {
                tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">No data found</td></tr>';
                tfoot.style.display = 'none';
            }

            // Update income details
            const incomeBody = document.getElementById('incomeDetailsBody');
            if (data.incomeDetails && data.incomeDetails.length > 0) {
                incomeBody.innerHTML = data.incomeDetails.map(item => `
                    <tr>
                        <td>${item.date}</td>
                        <td>${item.vehicle}</td>
                        <td>${item.customer}</td>
                        <td>${item.type}</td>
                        <td>${formatRupiah(item.amount)}</td>
                    </tr>
                `).join('');
            } else {
                incomeBody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">No income data</td></tr>';
            }

            // Update service details
            const serviceBody = document.getElementById('serviceDetailsBody');
            if (data.serviceDetails && data.serviceDetails.length > 0) {
                serviceBody.innerHTML = data.serviceDetails.map(item => `
                    <tr>
                        <td>${item.date}</td>
                        <td>${item.vehicle}</td>
                        <td>${item.type}</td>
                        <td>${item.description}</td>
                        <td>${formatRupiah(item.cost)}</td>
                    </tr>
                `).join('');
            } else {
                serviceBody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">No service data</td></tr>';
            }

            // Update expense details
            const expenseBody = document.getElementById('expenseDetailsBody');
            if (data.expenseDetails && data.expenseDetails.length > 0) {
                expenseBody.innerHTML = data.expenseDetails.map(item => `
                    <tr>
                        <td>${item.date}</td>
                        <td>${item.vehicle}</td>
                        <td>${item.category}</td>
                        <td>${item.description}</td>
                        <td>${formatRupiah(item.amount)}</td>
                    </tr>
                `).join('');
            } else {
                expenseBody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">No expense data</td></tr>';
            }

            // Show success notification
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success alert-dismissible fade show';
            alertDiv.style.position = 'fixed';
            alertDiv.style.top = '20px';
            alertDiv.style.right = '20px';
            alertDiv.style.zIndex = '9999';
            alertDiv.style.minWidth = '300px';
            alertDiv.innerHTML = `
                <strong><i class="bi bi-check-circle"></i> Success!</strong> Report has been generated successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(alertDiv);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to generate report. Please try again.');
        });
    });

    // Clear Filter
    document.getElementById('clearFilter').addEventListener('click', function() {
        document.getElementById('vehicleFilter').value = 'all';
        document.getElementById('periodFilter').value = 'last_month';
        document.getElementById('incomeToggle').checked = true;
        document.getElementById('serviceToggle').checked = true;
        document.getElementById('expenseToggle').checked = true;
        document.getElementById('customVehicleSelection').style.display = 'none';
        document.getElementById('customPeriodSelection').style.display = 'none';
        
        // Clear vehicle selections and reset display
        const vehicleSelect = document.getElementById('vehicleIds');
        for (let option of vehicleSelect.options) {
            option.selected = false;
        }
        document.getElementById('vehicleSelectBox').style.display = 'block';
        document.getElementById('selectedVehiclesDisplay').style.display = 'none';
        updateSelectedVehiclesDisplay();
        
        // Reset status indicators
        ['income', 'service', 'expense'].forEach(type => {
            document.getElementById(type + 'Status').textContent = 'ON';
            document.getElementById(type + 'Status').className = 'toggle-status on';
            document.getElementById(type + 'TypeSelection').classList.add('show');
        });
    });

    // Cancel - Clear filter and hide report
    document.getElementById('cancelFilter').addEventListener('click', function() {
        // Clear filter
        document.getElementById('clearFilter').click();
        
        // Hide report display
        document.getElementById('reportDisplay').classList.remove('show');
        
        // Collapse filter section
        const filterBody = document.getElementById('filterBody');
        const filterIcon = document.getElementById('filterIcon');
        filterBody.classList.add('collapsed');
        filterIcon.classList.remove('bi-chevron-up');
        filterIcon.classList.add('bi-chevron-down');
    });

    // Download buttons
    document.getElementById('downloadGeneral').addEventListener('click', function() {
        window.location.href = '{{ route("reports.download.general") }}';
    });

    document.getElementById('downloadDetail').addEventListener('click', function() {
        window.location.href = '{{ route("reports.download.detail") }}';
    });
});
</script>
@endsection
