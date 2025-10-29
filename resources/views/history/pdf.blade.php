<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Vehicle History - {{ $vehicle->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0 0 10px 0;
            color: #667eea;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .vehicle-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .vehicle-info table {
            width: 100%;
            border-collapse: collapse;
        }
        .vehicle-info td {
            padding: 5px 10px;
        }
        .vehicle-info td:first-child {
            font-weight: bold;
            width: 150px;
            color: #555;
        }
        .section-title {
            background: #667eea;
            color: white;
            padding: 10px 15px;
            margin: 20px 0 10px 0;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
        }
        .performance-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .performance-item {
            display: table-cell;
            width: 25%;
            text-align: center;
            padding: 15px;
            background: #f8f9fa;
            border: 1px solid #e0e0e0;
        }
        .performance-label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .performance-value {
            font-size: 16px;
            font-weight: bold;
        }
        .value-income { color: #27ae60; }
        .value-service { color: #3498db; }
        .value-expense { color: #e67e22; }
        .value-balance { color: #9b59b6; }
        
        .history-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .history-table thead {
            background: #667eea;
            color: white;
        }
        .history-table th {
            padding: 10px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }
        .history-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #e0e0e0;
        }
        .history-table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }
        .badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            display: inline-block;
        }
        .badge-income {
            background: #d4edda;
            color: #155724;
        }
        .badge-service {
            background: #d1ecf1;
            color: #0c5460;
        }
        .badge-expense {
            background: #f8d7da;
            color: #721c24;
        }
        .amount-positive {
            color: #27ae60;
            font-weight: bold;
        }
        .amount-negative {
            color: #e74c3c;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #e0e0e0;
            text-align: center;
            color: #999;
            font-size: 10px;
        }
        .summary-box {
            background: #fff3cd;
            border: 2px solid #ffc107;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .summary-box h3 {
            margin: 0 0 10px 0;
            color: #856404;
            font-size: 14px;
        }
        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
        }
        .summary-item strong {
            color: #333;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Vehicle History Report</h1>
        <p>Generated on {{ date('d F Y, H:i') }}</p>
    </div>

    <!-- Vehicle Information -->
    <div class="vehicle-info">
        <table>
            <tr>
                <td>Vehicle Name</td>
                <td>: {{ $vehicle->name }}</td>
            </tr>
            <tr>
                <td>License Plate</td>
                <td>: {{ $vehicle->license_plate }}</td>
            </tr>
            <tr>
                <td>Brand</td>
                <td>: {{ $vehicle->brand }}</td>
            </tr>
            <tr>
                <td>Model</td>
                <td>: {{ $vehicle->model }}</td>
            </tr>
            <tr>
                <td>Year</td>
                <td>: {{ $vehicle->year }}</td>
            </tr>
        </table>
    </div>

    <!-- Last Month Performance -->
    @if($lastMonthPerformance)
    <div class="section-title">Last Month Performance - {{ $lastMonthPerformance['month'] }}</div>
    
    <div class="performance-grid">
        <div class="performance-item">
            <div class="performance-label">Income</div>
            <div class="performance-value value-income">Rp {{ number_format($lastMonthPerformance['income'], 0, ',', '.') }}</div>
        </div>
        <div class="performance-item">
            <div class="performance-label">Service</div>
            <div class="performance-value value-service">Rp {{ number_format($lastMonthPerformance['service'], 0, ',', '.') }}</div>
        </div>
        <div class="performance-item">
            <div class="performance-label">Expense</div>
            <div class="performance-value value-expense">Rp {{ number_format($lastMonthPerformance['expense'], 0, ',', '.') }}</div>
        </div>
        <div class="performance-item">
            <div class="performance-label">Balance</div>
            <div class="performance-value value-balance">Rp {{ number_format($lastMonthPerformance['balance'], 0, ',', '.') }}</div>
        </div>
    </div>
    @endif

    <!-- Transaction History -->
    <div class="section-title">Complete Transaction History</div>
    
    @if($historyData && count($historyData) > 0)
    <table class="history-table">
        <thead>
            <tr>
                <th style="width: 12%;">Date</th>
                <th style="width: 15%;">Type</th>
                <th style="width: 18%;">Category</th>
                <th style="width: 20%;">Amount</th>
                <th style="width: 35%;">Notes</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalIncome = 0;
                $totalService = 0;
                $totalExpense = 0;
            @endphp
            @foreach($historyData as $item)
            @php
                if($item['type'] == 'Income') {
                    $totalIncome += $item['amount'];
                } elseif($item['type'] == 'Service') {
                    $totalService += $item['amount'];
                } else {
                    $totalExpense += $item['amount'];
                }
            @endphp
            <tr>
                <td>{{ $item['date'] }}</td>
                <td>
                    <span class="badge badge-{{ strtolower($item['type']) }}">
                        {{ $item['type'] }}
                    </span>
                </td>
                <td>{{ $item['category'] }}</td>
                <td>
                    <span class="{{ $item['type'] == 'Income' ? 'amount-positive' : 'amount-negative' }}">
                        {{ $item['type'] == 'Income' ? '+' : '-' }} Rp {{ number_format($item['amount'], 0, ',', '.') }}
                    </span>
                </td>
                <td>{{ $item['notes'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Summary Box -->
    <div class="summary-box">
        <h3>Transaction Summary</h3>
        <div class="summary-item">
            <span>Total Income:</span>
            <strong style="color: #27ae60;">+ Rp {{ number_format($totalIncome, 0, ',', '.') }}</strong>
        </div>
        <div class="summary-item">
            <span>Total Service:</span>
            <strong style="color: #3498db;">- Rp {{ number_format($totalService, 0, ',', '.') }}</strong>
        </div>
        <div class="summary-item">
            <span>Total Expense:</span>
            <strong style="color: #e67e22;">- Rp {{ number_format($totalExpense, 0, ',', '.') }}</strong>
        </div>
        <div class="summary-item" style="border-top: 2px solid #856404; margin-top: 10px; padding-top: 10px;">
            <span><strong>Net Balance:</strong></span>
            <strong style="color: #9b59b6;">Rp {{ number_format($totalIncome - ($totalService + $totalExpense), 0, ',', '.') }}</strong>
        </div>
    </div>
    @else
    <p style="text-align: center; padding: 30px; color: #999;">No transaction history available.</p>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>This document was automatically generated by Vehicle Dashboard System</p>
        <p>© {{ date('Y') }} Vehicle Management System. All rights reserved.</p>
    </div>
</body>
</html>
