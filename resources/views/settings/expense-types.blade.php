@extends('layouts.drivvo')

@section('title', 'Pengaturan - Jenis biaya')

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
                    <!-- Sub-menu Pengaturan -->
                    <a href="{{ route('settings.units') }}" class="list-group-item list-group-item-action ps-4">
                        <i class="bi bi-speedometer2 text-muted me-2"></i>
                        Satuan
                    </a>
                    <a href="{{ route('settings.reminders') }}" class="list-group-item list-group-item-action ps-4">
                        <i class="bi bi-bell text-muted me-2"></i>
                        Pengingat
                    </a>
                    <a href="{{ route('settings.format') }}" class="list-group-item list-group-item-action ps-4">
                        <i class="bi bi-calendar3 text-muted me-2"></i>
                        Format
                    </a>
                    
                    <!-- Divider -->
                    <div class="list-group-item bg-light py-1"></div>
                    
                    <a href="{{ route('settings.account') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-person-circle text-muted me-2"></i>
                        Akun saya
                    </a>
                    <a href="{{ route('settings.index') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-file-earmark-text text-muted me-2"></i>
                        File dan penyimpanan
                    </a>
                    <a href="{{ route('settings.fuel-types') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-fuel-pump text-muted me-2"></i>
                        Bahan bakar
                    </a>
                    <a href="{{ route('settings.fuel-stations') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-shop text-muted me-2"></i>
                        Spbu
                    </a>
                    <a href="{{ route('settings.locations') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-geo-alt text-muted me-2"></i>
                        Lokasi
                    </a>
                    <a href="{{ route('settings.service-types') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-wrench text-muted me-2"></i>
                        Jenis layanan
                    </a>
                    <a href="{{ route('settings.expense-types') }}" class="list-group-item list-group-item-action active">
                        <i class="bi bi-wallet2 text-primary me-2"></i>
                        Jenis biaya
                    </a>
                    <a href="{{ route('settings.income-types') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-cash-stack text-muted me-2"></i>
                        Jenis pendapatan
                    </a>
                    <a href="{{ route('settings.reasons') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-briefcase text-muted me-2"></i>
                        Alasan
                    </a>
                    <a href="{{ route('settings.payment-methods') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-credit-card text-muted me-2"></i>
                        Cara Pembayaran
                    </a>
                    <a href="{{ route('settings.forms') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-file-earmark text-muted me-2"></i>
                        Formulir
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
                        <h5 class="mb-0 me-3">Jenis biaya</h5>
                        <button type="button" class="btn btn-link text-primary p-0" id="toggleSearch">
                            <i class="bi bi-search fs-5"></i>
                        </button>
                    </div>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addExpenseTypeModal">
                        TAMBAH BARU
                    </button>
                </div>
                
                <!-- Search Bar (Hidden by default) -->
                <div class="card-body border-bottom bg-light" id="searchBar" style="display: none;">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control" id="searchInput" placeholder="Cari jenis biaya...">
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="expenseTable">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 60px;">#</th>
                                    <th>Nama <i class="bi bi-arrow-up-short"></i></th>
                                    <th style="width: 120px;" class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><a href="#" class="text-primary text-decoration-none">Denda</a></td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-link p-0 me-2" data-bs-toggle="modal" data-bs-target="#editExpenseTypeModal1">
                                            <i class="bi bi-pencil-fill text-primary"></i>
                                        </button>
                                        <button class="btn btn-sm btn-link p-0" data-bs-toggle="modal" data-bs-target="#deleteExpenseTypeModal1">
                                            <i class="bi bi-info-circle-fill text-primary"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td><a href="#" class="text-primary text-decoration-none">Pajak</a></td>
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
                                    <td><a href="#" class="text-primary text-decoration-none">Parkir</a></td>
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
                                    <td><a href="#" class="text-primary text-decoration-none">Pembayaran</a></td>
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
                                    <td><a href="#" class="text-primary text-decoration-none">Pembiayaan</a></td>
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
                                    <td>6</td>
                                    <td><a href="#" class="text-primary text-decoration-none">Pendaftaran</a></td>
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
                                    <td>7</td>
                                    <td><a href="#" class="text-primary text-decoration-none">Pengembalian</a></td>
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
                                    <td>8</td>
                                    <td><a href="#" class="text-primary text-decoration-none">Tol</a></td>
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

<!-- Modal Tambah Jenis Biaya -->
<div class="modal fade" id="addExpenseTypeModal" tabindex="-1" aria-labelledby="addExpenseTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addExpenseTypeModalLabel">Tambah Jenis Biaya</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="#">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="expenseName" class="form-label">Nama Jenis Biaya <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="expenseName" name="name" required placeholder="Contoh: Asuransi">
                    </div>
                    <div class="mb-3">
                        <label for="expenseDescription" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="expenseDescription" name="description" rows="3" placeholder="Deskripsi jenis biaya (opsional)"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="expenseCategory" class="form-label">Kategori</label>
                        <select class="form-select" id="expenseCategory" name="category">
                            <option value="">Pilih Kategori</option>
                            <option value="operational">Operasional</option>
                            <option value="maintenance">Perawatan</option>
                            <option value="administrative">Administrasi</option>
                            <option value="other">Lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Jenis Biaya (Example for first item) -->
<div class="modal fade" id="editExpenseTypeModal1" tabindex="-1" aria-labelledby="editExpenseTypeModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editExpenseTypeModalLabel1">Edit Jenis Biaya</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="#">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editExpenseName1" class="form-label">Nama Jenis Biaya <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editExpenseName1" name="name" value="Denda" required>
                    </div>
                    <div class="mb-3">
                        <label for="editExpenseDescription1" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="editExpenseDescription1" name="description" rows="3" placeholder="Deskripsi jenis biaya (opsional)"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editExpenseCategory1" class="form-label">Kategori</label>
                        <select class="form-select" id="editExpenseCategory1" name="category">
                            <option value="">Pilih Kategori</option>
                            <option value="operational">Operasional</option>
                            <option value="maintenance">Perawatan</option>
                            <option value="administrative" selected>Administrasi</option>
                            <option value="other">Lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Info/Delete Jenis Biaya (Example for first item) -->
<div class="modal fade" id="deleteExpenseTypeModal1" tabindex="-1" aria-labelledby="deleteExpenseTypeModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="deleteExpenseTypeModalLabel1">Info Jenis Biaya</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="fw-bold">Denda</h6>
                <p class="text-muted mb-3">Jenis biaya untuk denda pelanggaran atau keterlambatan.</p>
                
                <hr>
                
                <div class="mb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Total penggunaan:</span>
                        <strong>0 kali</strong>
                    </div>
                </div>
                <div class="mb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Total biaya:</span>
                        <strong>Rp 0</strong>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteExpenseModal1">
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Confirm Delete -->
<div class="modal fade" id="confirmDeleteExpenseModal1" tabindex="-1" aria-labelledby="confirmDeleteExpenseModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="confirmDeleteExpenseModalLabel1">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus jenis biaya <strong>"Denda"</strong>?</p>
                <p class="text-muted small mb-0">Data yang sudah dihapus tidak dapat dikembalikan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form method="POST" action="#" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
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
        const table = document.getElementById('expenseTable');
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
