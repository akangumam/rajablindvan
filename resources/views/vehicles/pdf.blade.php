<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kendaraan - {{ $vehicle->license_plate }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #3498db;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #3498db;
            font-size: 24px;
            margin-bottom: 5px;
        }
        .header p {
            color: #666;
            font-size: 14px;
        }
        .info-section {
            margin-bottom: 25px;
        }
        .info-section h2 {
            background: #3498db;
            color: white;
            padding: 8px 12px;
            font-size: 16px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            font-weight: bold;
            padding: 8px 12px;
            width: 35%;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
        }
        .info-value {
            display: table-cell;
            padding: 8px 12px;
            border: 1px solid #e9ecef;
        }
        .stats-grid {
            display: table;
            width: 100%;
            margin-top: 20px;
        }
        .stat-item {
            display: table-cell;
            text-align: center;
            padding: 15px;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            width: 33.33%;
        }
        .stat-value {
            font-size: 20px;
            font-weight: bold;
            color: #3498db;
            margin-bottom: 5px;
        }
        .stat-label {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
        }
        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 2px solid #e9ecef;
            text-align: center;
            color: #999;
            font-size: 10px;
        }
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
        }
        .badge-success {
            background: #d4edda;
            color: #155724;
        }
        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>LAPORAN DATA KENDARAAN</h1>
        <p>{{ $vehicle->brand }} {{ $vehicle->model }} - {{ $vehicle->license_plate }}</p>
        <p style="font-size: 11px;">Dicetak pada: {{ date('d F Y, H:i') }} WIB</p>
    </div>

    <!-- Informasi Kendaraan -->
    <div class="info-section">
        <h2>Informasi Kendaraan</h2>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Nama Kendaraan</div>
                <div class="info-value">{{ $vehicle->name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Brand</div>
                <div class="info-value">{{ $vehicle->brand }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Model</div>
                <div class="info-value">{{ $vehicle->model }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Tahun</div>
                <div class="info-value">{{ $vehicle->year }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Plat Nomor</div>
                <div class="info-value"><strong>{{ $vehicle->license_plate }}</strong></div>
            </div>
            <div class="info-row">
                <div class="info-label">Jenis Mesin</div>
                <div class="info-value">{{ $vehicle->engine_type }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Transmisi</div>
                <div class="info-value">{{ $vehicle->transmission }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Kapasitas Tangki</div>
                <div class="info-value">{{ $vehicle->tank_capacity }} Liter</div>
            </div>
            <div class="info-row">
                <div class="info-label">Odometer Terakhir</div>
                <div class="info-value">{{ number_format($stats['latest_odometer'], 0, ',', '.') }} km</div>
            </div>
            <div class="info-row">
                <div class="info-label">Warna</div>
                <div class="info-value">{{ $vehicle->color ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Status</div>
                <div class="info-value">
                    <span class="badge {{ $vehicle->is_active ? 'badge-success' : 'badge-danger' }}">
                        {{ $vehicle->is_active ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik -->
    <div class="info-section">
        <h2>Statistik Kendaraan</h2>
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-value">{{ $stats['total_fuel_fills'] }}</div>
                <div class="stat-label">Total Pengisian BBM</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ number_format($stats['avg_fuel_efficiency'], 1) }}</div>
                <div class="stat-label">Rata-rata Konsumsi (km/L)</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $vehicle->maintenances->count() }}</div>
                <div class="stat-label">Total Perawatan</div>
            </div>
        </div>
    </div>

    <!-- Ringkasan Biaya -->
    <div class="info-section">
        <h2>Ringkasan Biaya</h2>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Biaya BBM</div>
                <div class="info-value">Rp {{ number_format($stats['total_fuel_cost'], 0, ',', '.') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Biaya Perawatan</div>
                <div class="info-value">Rp {{ number_format($stats['total_maintenance_cost'], 0, ',', '.') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label" style="background: #e3f2fd; font-size: 14px;">Total Pengeluaran</div>
                <div class="info-value" style="background: #e3f2fd; font-weight: bold; font-size: 14px; color: #e74c3c;">
                    Rp {{ number_format($stats['total_expenses'], 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

    @if($vehicle->notes)
    <!-- Catatan -->
    <div class="info-section">
        <h2>Catatan</h2>
        <div style="padding: 12px; background: #fff3cd; border: 1px solid #ffc107; border-radius: 4px;">
            {{ $vehicle->notes }}
        </div>
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis oleh Raja BlindVan Dashboard</p>
        <p>© {{ date('Y') }} Radja Blind Van. All rights reserved.</p>
    </div>
</body>
</html>
