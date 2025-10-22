@extends('layouts.drivvo')

@section('title', 'Pengaturan - Jenis layanan')

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
                    <a href="{{ route('settings.service-types') }}" class="list-group-item list-group-item-action active">
                        <i class="bi bi-wrench text-primary me-2"></i>
                        Jenis layanan
                    </a>
                    <a href="{{ route('settings.expense-types') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-wallet2 text-muted me-2"></i>
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
                        <h5 class="mb-0 me-3">Jenis layanan</h5>
                        <button type="button" class="btn btn-link text-primary p-0" id="toggleSearch">
                            <i class="bi bi-search fs-5"></i>
                        </button>
                    </div>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addServiceTypeModal">
                        TAMBAH BARU
                    </button>
                </div>
                
                <!-- Search Bar (Hidden by default) -->
                <div class="card-body border-bottom bg-light" id="searchBar" style="display: none;">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control" id="searchInput" placeholder="Cari jenis layanan...">
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="serviceTable">
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
                                    <td><a href="#" class="text-primary text-decoration-none">AC</a></td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-link p-0 me-2" data-bs-toggle="modal" data-bs-target="#editServiceTypeModal1">
                                            <i class="bi bi-pencil-fill text-primary"></i>
                                        </button>
                                        <button class="btn btn-sm btn-link p-0" data-bs-toggle="modal" data-bs-target="#deleteServiceTypeModal1">
                                            <i class="bi bi-info-circle-fill text-primary"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td><a href="#" class="text-primary text-decoration-none">Ban Baru</a></td>
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
                                    <td><a href="#" class="text-primary text-decoration-none">Batere</a></td>
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
                                    <td><a href="#" class="text-primary text-decoration-none">Biaya Tenaga Kerja</a></td>
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
                                    <td><a href="#" class="text-primary text-decoration-none">Brake Fluid</a></td>
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
                                    <td><a href="#" class="text-primary text-decoration-none">Brake Pad</a></td>
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
                                    <td><a href="#" class="text-primary text-decoration-none">Cuci Mobil</a></td>
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
                                    <td><a href="#" class="text-primary text-decoration-none">Inspeksi</a></td>
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
                                    <td>9</td>
                                    <td><a href="#" class="text-primary text-decoration-none">Lampu</a></td>
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
                                    <td>10</td>
                                    <td><a href="#" class="text-primary text-decoration-none">Penggantian Oli</a></td>
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
                                    <td>11</td>
                                    <td><a href="#" class="text-primary text-decoration-none">perpanjang</a></td>
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
                                    <td>12</td>
                                    <td><a href="#" class="text-primary text-decoration-none">Rotasi Ban</a></td>
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
                                    <td>13</td>
                                    <td><a href="#" class="text-primary text-decoration-none">Sabuk</a></td>
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
                                    <td>14</td>
                                    <td><a href="#" class="text-primary text-decoration-none">Saringan Bahan Bakar</a></td>
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
                                    <td>15</td>
                                    <td><a href="#" class="text-primary text-decoration-none">Saringan oli</a></td>
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
                                    <td>16</td>
                                    <td><a href="#" class="text-primary text-decoration-none">Saringan Udara</a></td>
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
                                    <td>17</td>
                                    <td><a href="#" class="text-primary text-decoration-none">Sistem suspensi</a></td>
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
                                    <td>18</td>
                                    <td><a href="#" class="text-primary text-decoration-none">Spooring/Balancing</a></td>
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
                                    <td>19</td>
                                    <td><a href="#" class="text-primary text-decoration-none">Tekanan Ban</a></td>
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

<!-- Modal Tambah Jenis Layanan -->
<div class="modal fade" id="addServiceTypeModal" tabindex="-1" aria-labelledby="addServiceTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addServiceTypeModalLabel">Tambah Jenis Layanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="#">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="serviceName" class="form-label">Nama Jenis Layanan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="serviceName" name="name" required placeholder="Contoh: Tune Up">
                    </div>
                    <div class="mb-3">
                        <label for="serviceDescription" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="serviceDescription" name="description" rows="3" placeholder="Deskripsi jenis layanan (opsional)"></textarea>
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

<!-- Modal Edit Jenis Layanan (Example for first item) -->
<div class="modal fade" id="editServiceTypeModal1" tabindex="-1" aria-labelledby="editServiceTypeModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editServiceTypeModalLabel1">Edit Jenis Layanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="#">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editServiceName1" class="form-label">Nama Jenis Layanan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editServiceName1" name="name" value="AC" required>
                    </div>
                    <div class="mb-3">
                        <label for="editServiceDescription1" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="editServiceDescription1" name="description" rows="3" placeholder="Deskripsi jenis layanan (opsional)"></textarea>
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

<!-- Modal Info/Delete Jenis Layanan (Example for first item) -->
<div class="modal fade" id="deleteServiceTypeModal1" tabindex="-1" aria-labelledby="deleteServiceTypeModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="deleteServiceTypeModalLabel1">Info Jenis Layanan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="fw-bold">AC</h6>
                <p class="text-muted mb-3">Jenis layanan untuk perawatan dan perbaikan sistem AC kendaraan.</p>
                
                <hr>
                
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">Total penggunaan:</span>
                    <strong>0 kali</strong>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteServiceModal1">
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Confirm Delete -->
<div class="modal fade" id="confirmDeleteServiceModal1" tabindex="-1" aria-labelledby="confirmDeleteServiceModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="confirmDeleteServiceModalLabel1">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus jenis layanan <strong>"AC"</strong>?</p>
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
        const table = document.getElementById('serviceTable');
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
