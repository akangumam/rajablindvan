@extends('layouts.drivvo')

@section('title', 'Pengaturan - Fuel Types')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar Menu -->
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-gear-fill text-primary me-2"></i>
                        Pengaturan
                    </h5>
                </div>
                <div class="list-group list-group-flush">
                    <!-- Pengaturan Sub-menu -->
                    <a href="{{ route('settings.units') }}" class="list-group-item list-group-item-action ps-4">
                        <i class="bi bi-speedometer2 text-muted me-2"></i>
                        Units
                    </a>
                    <a href="{{ route('settings.reminders') }}" class="list-group-item list-group-item-action ps-4">
                        <i class="bi bi-bell text-muted me-2"></i>
                        Reminders
                    </a>
                    <a href="{{ route('settings.format') }}" class="list-group-item list-group-item-action ps-4">
                        <i class="bi bi-calendar3 text-muted me-2"></i>
                        Format
                    </a>
                    
                    <!-- Divider -->
                    <div class="list-group-item bg-light py-1"></div>
                    
                    <a href="{{ route('settings.account') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-person-circle text-muted me-2"></i>
                        Akun Saya
                    </a>
                    <a href="{{ route('settings.index') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-file-earmark-text text-muted me-2"></i>
                        Files and Storage
                    </a>
                    <a href="{{ route('settings.fuel-types') }}" class="list-group-item list-group-item-action active">
                        <i class="bi bi-fuel-pump text-primary me-2"></i>
                        Fuel Types
                    </a>
                    <a href="{{ route('settings.fuel-stations') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-shop text-muted me-2"></i>
                        Gas Stations
                    </a>
                    <a href="{{ route('settings.locations') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-geo-alt text-muted me-2"></i>
                        Locations
                    </a>
                    <a href="{{ route('settings.service-types') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-wrench text-muted me-2"></i>
                        Service Types
                    </a>
                    <a href="{{ route('settings.expense-types') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-wallet2 text-muted me-2"></i>
                        Expense Types
                    </a>
                    <a href="{{ route('settings.income-types') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-cash-stack text-muted me-2"></i>
                        Income Types
                    </a>
                    <a href="{{ route('settings.reasons') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-briefcase text-muted me-2"></i>
                        Reasons
                    </a>
                    <a href="{{ route('settings.payment-methods') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-credit-card text-muted me-2"></i>
                        Metode Pembayaran
                    </a>
                    <a href="{{ route('settings.forms') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-file-earmark text-muted me-2"></i>
                        Forms
                    </a>
                    <a href="{{ route('settings.contacts') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-envelope text-muted me-2"></i>
                        Menghubungi
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 me-3">fuel</h5>
                        <button type="button" class="btn btn-link text-primary p-0" id="toggleSearch">
                            <i class="bi bi-search fs-5"></i>
                        </button>
                    </div>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addFuelTypeModal">
                        TAMBAH BARU
                    </button>
                </div>
                
                <!-- Search Bar (Hidden by default) -->
                <div class="card-body border-bottom bg-light" id="searchBar" style="display: none;">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control" id="searchInput" Tempatholder="Search fuel...">
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="fuelTable">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 60px;">#</th>
                                    <th>Name <i class="bi bi-arrow-up-short"></i></th>
                                    <th>Type bbm</th>
                                    <th style="width: 120px;" class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><a href="#" class="text-primary text-decoration-none">Gasoline</a></td>
                                    <td>Cairan</td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-link p-0 me-2" data-bs-toggle="modal" data-bs-target="#editFuelTypeModal1">
                                            <i class="bi bi-pencil-fill text-primary"></i>
                                        </button>
                                        <button class="btn btn-sm btn-link p-0" data-bs-toggle="modal" data-bs-target="#deleteFuelTypeModal1">
                                            <i class="bi bi-trash-fill text-primary"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td><a href="#" class="text-primary text-decoration-none">Bensin Premium</a></td>
                                    <td>Cairan</td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-link p-0 me-2">
                                            <i class="bi bi-pencil-fill text-primary"></i>
                                        </button>
                                        <button class="btn btn-sm btn-link p-0">
                                            <i class="bi bi-trash-fill text-primary"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td><a href="#" class="text-primary text-decoration-none">CNG</a></td>
                                    <td>Compressed natural gas</td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-link p-0 me-2">
                                            <i class="bi bi-pencil-fill text-primary"></i>
                                        </button>
                                        <button class="btn btn-sm btn-link p-0">
                                            <i class="bi bi-trash-fill text-primary"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td><a href="#" class="text-primary text-decoration-none">Disel</a></td>
                                    <td>Cairan</td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-link p-0 me-2">
                                            <i class="bi bi-pencil-fill text-primary"></i>
                                        </button>
                                        <button class="btn btn-sm btn-link p-0">
                                            <i class="bi bi-trash-fill text-primary"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td><a href="#" class="text-primary text-decoration-none">Etanol</a></td>
                                    <td>Cairan</td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-link p-0 me-2">
                                            <i class="bi bi-pencil-fill text-primary"></i>
                                        </button>
                                        <button class="btn btn-sm btn-link p-0">
                                            <i class="bi bi-trash-fill text-primary"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td><a href="#" class="text-primary text-decoration-none">Gas Midgrade</a></td>
                                    <td>Cairan</td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-link p-0 me-2">
                                            <i class="bi bi-pencil-fill text-primary"></i>
                                        </button>
                                        <button class="btn btn-sm btn-link p-0">
                                            <i class="bi bi-trash-fill text-primary"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td><a href="#" class="text-primary text-decoration-none">Electric</a></td>
                                    <td>Kelistrikan</td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-link p-0 me-2">
                                            <i class="bi bi-pencil-fill text-primary"></i>
                                        </button>
                                        <button class="btn btn-sm btn-link p-0">
                                            <i class="bi bi-trash-fill text-primary"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td><a href="#" class="text-primary text-decoration-none">LPG</a></td>
                                    <td>Liquefied petroleum gas</td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-link p-0 me-2">
                                            <i class="bi bi-pencil-fill text-primary"></i>
                                        </button>
                                        <button class="btn btn-sm btn-link p-0">
                                            <i class="bi bi-trash-fill text-primary"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Fuel Type -->
<div class="modal fade" id="addFuelTypeModal" tabindex="-1" aria-labelledby="addFuelTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFuelTypeModalLabel">Add Fuel Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="#">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="fuelName" class="form-label">Name fuel <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="fuelName" name="name" required Tempatholder="Contoh: Pertalite">
                    </div>
                    <div class="mb-3">
                        <label for="fuelType" class="form-label">Type BBM <span class="text-danger">*</span></label>
                        <select class="form-select" id="fuelType" name="type" required>
                            <option value="">Select Type BBM</option>
                            <option value="liquid">Cairan</option>
                            <option value="gas">Gas</option>
                            <option value="electric">Kelistrikan</option>
                            <option value="cng">Compressed Natural Gas</option>
                            <option value="lpg">Liquefied Petroleum Gas</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">BATAL</button>
                    <button type="submit" class="btn btn-primary">SIMPAN</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Fuel Type (Example for first item) -->
<div class="modal fade" id="editFuelTypeModal1" tabindex="-1" aria-labelledby="editFuelTypeModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFuelTypeModalLabel1">Edit Fuel Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="#">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editFuelName1" class="form-label">Name fuel <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editFuelName1" name="name" value="Bensin" required>
                    </div>
                    <div class="mb-3">
                        <label for="editFuelType1" class="form-label">Type BBM <span class="text-danger">*</span></label>
                        <select class="form-select" id="editFuelType1" name="type" required>
                            <option value="liquid" selected>Cairan</option>
                            <option value="gas">Gas</option>
                            <option value="electric">Kelistrikan</option>
                            <option value="cng">Compressed Natural Gas</option>
                            <option value="lpg">Liquefied Petroleum Gas</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">BATAL</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete fuel (Example for first item) -->
<div class="modal fade" id="deleteFuelTypeModal1" tabindex="-1" aria-labelledby="deleteFuelTypeModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteFuelTypeModalLabel1">Delete fuel</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure want to delete fuel <strong>"Bensin"</strong>?</p>
                <p class="text-muted small mb-0">Deleted data cannot be restored.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">BATAL</button>
                <form method="POST" action="#" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.list-group-item-action:hover {
    background-color: #f8f9fa;
}
.list-group-item-action.active {
    background-color: #e7f3ff;
    border-left: 3px solid #0d6efd;
    color: #0d6efd;
}
.table tbody tr:hover {
    background-color: #f8f9fa;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle search bar
    const toggleSearchBtn = document.getElementById('toggleSearch');
    const searchBar = document.getElementById('searchBar');
    const searchInput = document.getElementById('searchInput');
    
    toggleSearchBtn.addEventListener('click', function() {
        if (searchBar.style.display === 'none') {
            searchBar.style.display = 'block';
            searchInput.focus();
        } else {
            searchBar.style.display = 'none';
            searchInput.value = '';
            filterTable('');
        }
    });
    
    // Search functionality
    searchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        filterTable(searchTerm);
    });
    
    function filterTable(searchTerm) {
        const table = document.getElementById('fuelTable');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        
        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            let found = false;
            
            for (let j = 1; j < cells.length - 1; j++) { // Skip first (number) and last (action) columns
                const cellText = cells[j].textContent || cells[j].innerText;
                if (cellText.toLowerCase().indexOf(searchTerm) > -1) {
                    found = true;
                    break;
                }
            }
            
            rows[i].style.display = found ? '' : 'none';
        }
    }
});
</script>
@endsection






























