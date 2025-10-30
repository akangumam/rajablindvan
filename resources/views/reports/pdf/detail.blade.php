<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10px; line-height: 1.3; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        table th, table td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        table th { background-color: #f8f9fa; font-weight: bold; font-size: 10px; }
        .text-end { text-align: right; }
        .section-title { margin-top: 25px; margin-bottom: 10px; font-size: 14px; font-weight: bold; color: #fff; padding: 8px; }
        .section-income { background-color: #28a745; }
        .section-service { background-color: #007bff; }
        .section-expense { background-color: #dc3545; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <div class="header">
        <h1>DETAIL REPORT</h1>
        <p>Period: {{ $data['date_range']['startDate'] }} to {{ $data['date_range']['endDate'] }}</p>
        <p>Generated: {{ date('d F Y, H:i') }} WIB</p>
    </div>

    @if(!empty($data['details']['incomeDetails']))
    <div class="section-title section-income">Income Details</div>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Vehicle</th>
                <th>Customer</th>
                <th>Type</th>
                <th class="text-end">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['details']['incomeDetails'] as $item)
            <tr>
                <td>{{ $item['date'] }}</td>
                <td>{{ $item['vehicle'] }}</td>
                <td>{{ $item['customer'] }}</td>
                <td>{{ $item['type'] }}</td>
                <td class="text-end">Rp {{ number_format($item['amount'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot style="background-color: #d4edda; font-weight: bold;">
            <tr>
                <td colspan="4" class="text-end">Total Income:</td>
                <td class="text-end">Rp {{ number_format(collect($data['details']['incomeDetails'])->sum('amount'), 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
    @endif

    @if(!empty($data['details']['serviceDetails']))
    <div class="page-break"></div>
    <div class="section-title section-service">Service Details</div>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Vehicle</th>
                <th>Type</th>
                <th>Description</th>
                <th class="text-end">Cost</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['details']['serviceDetails'] as $item)
            <tr>
                <td>{{ $item['date'] }}</td>
                <td>{{ $item['vehicle'] }}</td>
                <td>{{ $item['type'] }}</td>
                <td>{{ $item['description'] }}</td>
                <td class="text-end">Rp {{ number_format($item['cost'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot style="background-color: #cfe2ff; font-weight: bold;">
            <tr>
                <td colspan="4" class="text-end">Total Service Cost:</td>
                <td class="text-end">Rp {{ number_format(collect($data['details']['serviceDetails'])->sum('cost'), 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
    @endif

    @if(!empty($data['details']['expenseDetails']))
    <div class="page-break"></div>
    <div class="section-title section-expense">Expense Details</div>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Vehicle</th>
                <th>Category</th>
                <th>Description</th>
                <th class="text-end">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['details']['expenseDetails'] as $item)
            <tr>
                <td>{{ $item['date'] }}</td>
                <td>{{ $item['vehicle'] }}</td>
                <td>{{ $item['category'] }}</td>
                <td>{{ $item['description'] }}</td>
                <td class="text-end">Rp {{ number_format($item['amount'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot style="background-color: #f8d7da; font-weight: bold;">
            <tr>
                <td colspan="4" class="text-end">Total Expense Cost:</td>
                <td class="text-end">Rp {{ number_format(collect($data['details']['expenseDetails'])->sum('amount'), 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
    @endif

    <div style="margin-top: 40px; text-align: center; color: #999; font-size: 10px;">
        <p>© {{ date('Y') }} Radja Blind Van. All rights reserved.</p>
    </div>
</body>
</html>
