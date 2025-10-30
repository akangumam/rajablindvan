<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>General Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        table th, table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        table th { background-color: #f8f9fa; font-weight: bold; }
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        .summary-table { width: 100%; margin: 20px 0; }
        .summary-table td { padding: 15px; border: 2px solid #ddd; text-align: center; vertical-align: middle; background-color: #fff; }
        .summary-title { font-size: 14px; font-weight: bold; margin: 0 0 10px 0; }
        .summary-amount { font-size: 18px; font-weight: bold; margin: 0; }
        .section-title { margin-top: 20px; margin-bottom: 10px; font-size: 14px; font-weight: bold; border-bottom: 2px solid #333; padding-bottom: 5px; }
        tfoot { background-color: #e9ecef; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>GENERAL REPORT</h1>
        <p>Period: {{ $data['date_range']['startDate'] }} to {{ $data['date_range']['endDate'] }}</p>
        <p>Generated: {{ date('d F Y, H:i') }} WIB</p>
    </div>

    <!-- Item to Show -->
    <table class="summary-table" cellspacing="5" cellpadding="0">
        <tr>
            <td style="border-color: #28a745; width: 32%;">
                <p class="summary-title">Income</p>
                <p class="summary-amount" style="color: #28a745;">Rp {{ number_format($data['totals']['totalIncome'], 0, ',', '.') }}</p>
            </td>
            <td style="border-color: #dc3545; width: 32%;">
                <p class="summary-title">Cost</p>
                <p class="summary-amount" style="color: #dc3545;">Rp {{ number_format($data['totals']['totalCost'], 0, ',', '.') }}</p>
            </td>
            <td style="border-color: #007bff; width: 32%;">
                <p class="summary-title">Balance</p>
                <p class="summary-amount" style="color: #007bff;">Rp {{ number_format($data['totals']['totalBalance'], 0, ',', '.') }}</p>
            </td>
        </tr>
    </table>

    <div class="section-title">Cost Split</div>
    <table style="width: 60%;">
        <tr>
            <td>Service Cost</td>
            <td class="text-end"><strong>Rp {{ number_format($data['totals']['totalServiceCost'], 0, ',', '.') }}</strong></td>
        </tr>
        <tr>
            <td>Expense Cost</td>
            <td class="text-end"><strong>Rp {{ number_format($data['totals']['totalExpenseCost'], 0, ',', '.') }}</strong></td>
        </tr>
    </table>

    <div class="section-title">Report by Vehicle</div>
    <table>
        <thead>
            <tr>
                <th>Vehicle Name</th>
                <th class="text-end">Income</th>
                <th class="text-end">Service</th>
                <th class="text-end">Expense</th>
                <th class="text-end">Cost</th>
                <th class="text-end">Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['vehicles'] as $vehicle)
            <tr>
                <td>{{ $vehicle['name'] }}</td>
                <td class="text-end">Rp {{ number_format($vehicle['income'], 0, ',', '.') }}</td>
                <td class="text-end">Rp {{ number_format($vehicle['service'], 0, ',', '.') }}</td>
                <td class="text-end">Rp {{ number_format($vehicle['expense'], 0, ',', '.') }}</td>
                <td class="text-end">Rp {{ number_format($vehicle['cost'], 0, ',', '.') }}</td>
                <td class="text-end">Rp {{ number_format($vehicle['balance'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td>TOTAL</td>
                <td class="text-end">Rp {{ number_format($data['totals']['totalIncome'], 0, ',', '.') }}</td>
                <td class="text-end">Rp {{ number_format($data['totals']['totalServiceCost'], 0, ',', '.') }}</td>
                <td class="text-end">Rp {{ number_format($data['totals']['totalExpenseCost'], 0, ',', '.') }}</td>
                <td class="text-end">Rp {{ number_format($data['totals']['totalCost'], 0, ',', '.') }}</td>
                <td class="text-end">Rp {{ number_format($data['totals']['totalBalance'], 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 40px; text-align: center; color: #999; font-size: 10px;">
        <p>© {{ date('Y') }} Radja Blind Van. All rights reserved.</p>
    </div>
</body>
</html>
