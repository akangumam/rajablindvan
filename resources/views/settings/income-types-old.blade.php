@extends('layouts.drivvo')

@section('title', 'Pengaturan - Income Types')

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
                    <a href="{{ route('settings.fuel-types') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-fuel-pump text-muted me-2"></i>
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
                    <a href="{{ route('settings.income-types') }}" class="list-group-item list-group-item-action active">
                        <i class="bi bi-cash-stack text-primary me-2"></i>
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
                        <h5 class="mb-0 me-3">Income Types</h5>
                        <button type="button" class="btn btn-link text-primary p-0" id="toggleSearch">
                            <i class="bi bi-search fs-5"></i>
                        </button>
                    </div>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addIncomeTypeModal">
                        TAMBAH BARU
                    </button>
                </div>
                
                <!-- Search Bar (Hidden by default) -->
                <div class="card-body border-bottom bg-light" id="searchBar" style="display: none;">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control" id="searchInput" Tempatholder="Search Income Types...">
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="incomeTable">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 60px;">#</th>
                                    <th>Name <i class="bi bi-arrow-up-short"></i></th>
                                    <th style="width: 120px;" class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><a href="#" class="text-primary text-decoration-none">Transportation App</a></td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-link p-0 me-2" data-bs-toggle="modal" data-bs-target="#editIncomeTypeModal1">
                                            <i class="bi bi-pencil-fill text-primary"></i>
                                        </button>
                                        <button class="btn btn-sm btn-link p-0" data-bs-toggle="modal" data-bs-target="#deleteIncomeTypeModal1">
                                            <i class="bi bi-info-circle-fill text-primary"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td><a href="#" class="text-primary text-decoration-none">Kargo</a></td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-link p-0 me-2">
                                            <i class="bi bi-pencil-fill text-primary"></i>
                                        </button>
                                        <button class="btn btn-sm btn-link p-0">
                                            <i class="bi bi-info-circle-fill text-primary"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td><a href="#" class="text-primary text-decoration-none">Mengendarai</a></td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-link p-0 me-2">
                                            <i class="bi bi-pencil-fill text-primary"></i>
                                        </button>
                                        <button class="btn btn-sm btn-link p-0">
                                            <i class="bi bi-info-circle-fill text-primary"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td><a href="#" class="text-primary text-decoration-none">Fund Refund</a></td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-link p-0 me-2">
                                            <i class="bi bi-pencil-fill text-primary"></i>
                                        </button>
                                        <button class="btn btn-sm btn-link p-0">
                                            <i class="bi bi-info-circle-fill text-primary"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td><a href="#" class="text-primary text-decoration-none">Vehicle Sale</a></td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-link p-0 me-2">
                                            <i class="bi bi-pencil-fill text-primary"></i>
                                        </button>
                                        <button class="btn btn-sm btn-link p-0">
                                            <i class="bi bi-info-circle-fill text-primary"></i>
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

<!-- Modal Add Income Type -->
<div class="modal fade" id="addIncomeTypeModal" tabindex="-1" aria-labelledby="addIncomeTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addIncomeTypeModalLabel">Add Income Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="#">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="incomeName" class="form-label">Name Income Types <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="incomeName" name="name" required Tempatholder="Contoh: Sewa Vehicle">
                    </div>
                    <div class="mb-3">
                        <label for="incomeDescription" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="incomeDescription" name="description" rows="3" Tempatholder="Deskripsi Income Types (opsional)"></textarea>
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

<!-- Modal Edit Jenis Pendapatan (Example for first item) -->
<div class="modal fade" id="editIncomeTypeModal1" tabindex="-1" aria-labelledby="editIncomeTypeModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editIncomeTypeModalLabel1">Edit Jenis Pendapatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="#">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editIncomeName1" class="form-label">Name Income Types <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editIncomeName1" name="name" value="Transportation App" required>
                    </div>
                    <div class="mb-3">
                        <label for="editIncomeDescription1" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="editIncomeDescription1" name="description" rows="3" Tempatholder="Deskripsi Income Types (opsional)"></textarea>
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

<!-- Modal Info/Delete Income Types (Example for first item) -->
<div class="modal fade" id="deleteIncomeTypeModal1" tabindex="-1" aria-labelledby="deleteIncomeTypeModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="deleteIncomeTypeModalLabel1">Info Income Types</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="fw-bold">Transportation App</h6>
                <p class="text-muted mb-3">Income from online transportation apps like Gojek, Grab, etc.</p>
                
                <hr>
                
                <div class="mb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Total usage:</span>
                        <strong>0 kali</strong>
                    </div>
                </div>
                <div class="mb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Total Income:</span>
                        <strong>Rp 0</strong>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteIncomeModal1">
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Confirm Delete -->
<div class="modal fade" id="confirmDeleteIncomeModal1" tabindex="-1" aria-labelledby="confirmDeleteIncomeModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="confirmDeleteIncomeModalLabel1">Konfirmasi Delete</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure want to delete Income Types <strong>"Transportation App"</strong>?</p>
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
        const table = document.getElementById('incomeTable');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        
        for (let i = 0; i < rows.length; i++) {
            const nameCell = rows[i].getElementsByTagName('td')[1];
            if (nameCell) {
                const nameText = nameCell.textContent || nameCell.innerText;
                if (nameText.toLowerCase().indexOf(searchTerm) > -1) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }
    }
});
</script>
@endsection






























