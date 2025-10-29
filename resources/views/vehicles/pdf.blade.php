<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Data - {{ $vehicle->license_plate }}</title>
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
        <h1>VEHICLE DATA REPORT</h1>
        <p>{{ $vehicle->brand }} {{ $vehicle->model }} - {{ $vehicle->license_plate }}</p>
        <p style="font-size: 11px;">Printed on: {{ date('d F Y, H:i') }} WIB</p>
    </div>

    <!-- Vehicle Information -->
    <div class="info-section">
        <h2>Vehicle Information</h2>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Vehicle Name</div>
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
                <div class="info-label">Year</div>
                <div class="info-value">{{ $vehicle->year }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Plat Nomor</div>
                <div class="info-value"><strong>{{ $vehicle->license_plate }}</strong></div>
            </div>
            <div class="info-row">
                <div class="info-label">Engine Type</div>
                <div class="info-value">{{ $vehicle->engine_type }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Transmisi</div>
                <div class="info-value">{{ $vehicle->transmission }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Kapasitas Tangki</div>
                <div class="info-value">{{ $vehicle->tank_capacity }} Liters</div>
            </div>
            <div class="info-row">
                <div class="info-label">Latest Odometer</div>
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
                        {{ $vehicle->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik -->
    <div class="info-section">
        <h2>Vehicle Statistics</h2>
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-value">{{ $stats['total_fuel_fills'] }}</div>
                <div class="stat-label">Total Fuel Fills</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ number_format($stats['avg_fuel_efficiency'], 1) }}</div>
                <div class="stat-label">Average Consumption (km/L)</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $vehicle->maintenances->count() }}</div>
                <div class="stat-label">Total Maintenance</div>
            </div>
        </div>
    </div>

    <!-- Ringkasan Cost -->
    <div class="info-section">
        <h2>Ringkasan Cost</h2>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Fuel Cost</div>
                <div class="info-value">Rp {{ number_format($stats['total_fuel_cost'], 0, ',', '.') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Cost Maintenance</div>
                <div class="info-value">Rp {{ number_format($stats['total_maintenance_cost'], 0, ',', '.') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label" style="background: #e3f2fd; font-size: 14px;">Total Expenses</div>
                <div class="info-value" style="background: #e3f2fd; font-weight: bold; font-size: 14px; color: #e74c3c;">
                    Rp {{ number_format($stats['total_expenses'], 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

    @if($vehicle->notes)
    <!-- Notes -->
    <div class="info-section">
        <h2>Notes</h2>
        <div style="padding: 12px; background: #fff3cd; border: 1px solid #ffc107; border-radius: 4px;">
            {{ $vehicle->notes }}
        </div>
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>This document is automatically generated by Raja BlindVan Dashboard</p>
        <p>© {{ date('Y') }} Radja Blind Van. All rights reserved.</p>
    </div>
</body>
</html>




























