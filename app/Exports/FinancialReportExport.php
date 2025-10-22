<?php

namespace App\Exports;

use App\Models\Rental;
use App\Models\Expense;
use App\Models\FuelFill;
use App\Models\Maintenance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Carbon\Carbon;

class FinancialReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle
{
    protected $startDate;
    protected $endDate;
    protected $vehicleId;

    public function __construct($startDate = null, $endDate = null, $vehicleId = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->vehicleId = $vehicleId;
    }

    public function collection()
    {
        // Get all financial data
        $data = collect();

        // Add summary row
        $totalIncome = $this->getTotalIncome();
        $totalExpenses = $this->getTotalExpenses();
        $netProfit = $totalIncome - $totalExpenses;

        $data->push([
            'type' => 'SUMMARY',
            'description' => 'Total Pendapatan',
            'amount' => $totalIncome,
            'date' => '',
            'vehicle' => '',
            'customer' => ''
        ]);

        $data->push([
            'type' => 'SUMMARY',
            'description' => 'Total Pengeluaran',
            'amount' => -$totalExpenses,
            'date' => '',
            'vehicle' => '',
            'customer' => ''
        ]);

        $data->push([
            'type' => 'SUMMARY',
            'description' => 'Keuntungan Bersih',
            'amount' => $netProfit,
            'date' => '',
            'vehicle' => '',
            'customer' => ''
        ]);

        // Add empty row
        $data->push([
            'type' => '',
            'description' => '',
            'amount' => '',
            'date' => '',
            'vehicle' => '',
            'customer' => ''
        ]);

        // Add rental income details
        $rentals = $this->getRentals();
        foreach ($rentals as $rental) {
            $data->push([
                'type' => 'PENDAPATAN',
                'description' => 'Sewa - ' . $rental->rental_type,
                'amount' => $rental->total_cost,
                'date' => $rental->start_date,
                'vehicle' => $rental->vehicle->license_plate ?? '',
                'customer' => $rental->customer->name ?? ''
            ]);
        }

        // Add expense details
        $expenses = $this->getExpenses();
        foreach ($expenses as $expense) {
            $data->push([
                'type' => 'PENGELUARAN',
                'description' => $expense->description,
                'amount' => -$expense->amount,
                'date' => $expense->date,
                'vehicle' => $expense->vehicle->license_plate ?? '',
                'customer' => ''
            ]);
        }

        // Add fuel expenses
        $fuelFills = $this->getFuelFills();
        foreach ($fuelFills as $fuel) {
            $data->push([
                'type' => 'PENGELUARAN',
                'description' => 'Bahan Bakar - ' . $fuel->fuel_type,
                'amount' => -$fuel->total_cost,
                'date' => $fuel->date,
                'vehicle' => $fuel->vehicle->license_plate ?? '',
                'customer' => ''
            ]);
        }

        // Add maintenance expenses
        $maintenances = $this->getMaintenances();
        foreach ($maintenances as $maintenance) {
            $data->push([
                'type' => 'PENGELUARAN',
                'description' => 'Maintenance - ' . $maintenance->description,
                'amount' => -$maintenance->cost,
                'date' => $maintenance->date,
                'vehicle' => $maintenance->vehicle->license_plate ?? '',
                'customer' => ''
            ]);
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'Tipe',
            'Deskripsi',
            'Jumlah (Rp)',
            'Tanggal',
            'Kendaraan',
            'Pelanggan'
        ];
    }

    public function map($row): array
    {
        return [
            $row['type'],
            $row['description'],
            is_numeric($row['amount']) ? number_format($row['amount'], 0, ',', '.') : $row['amount'],
            $row['date'] ? Carbon::parse($row['date'])->format('d/m/Y') : $row['date'],
            $row['vehicle'],
            $row['customer']
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F81BD']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN
                ]
            ]
        ]);

        // Style for summary rows (first 3 rows after header)
        $sheet->getStyle('A2:F4')->applyFromArray([
            'font' => [
                'bold' => true
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E6F3FF']
            ]
        ]);

        // Style for all data with borders
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:F' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN
                ]
            ]
        ]);

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 30,
            'C' => 15,
            'D' => 12,
            'E' => 15,
            'F' => 20,
        ];
    }

    public function title(): string
    {
        $period = '';
        if ($this->startDate && $this->endDate) {
            $period = ' (' . Carbon::parse($this->startDate)->format('d/m/Y') . ' - ' . Carbon::parse($this->endDate)->format('d/m/Y') . ')';
        }
        return 'Laporan Keuangan' . $period;
    }

    private function getRentals()
    {
        $query = Rental::with(['vehicle', 'customer']);
        
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('start_date', [$this->startDate, $this->endDate]);
        }
        
        if ($this->vehicleId) {
            $query->where('vehicle_id', $this->vehicleId);
        }
        
        return $query->get();
    }

    private function getExpenses()
    {
        $query = Expense::with('vehicle');
        
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('date', [$this->startDate, $this->endDate]);
        }
        
        if ($this->vehicleId) {
            $query->where('vehicle_id', $this->vehicleId);
        }
        
        return $query->get();
    }

    private function getFuelFills()
    {
        $query = FuelFill::with('vehicle');
        
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('date', [$this->startDate, $this->endDate]);
        }
        
        if ($this->vehicleId) {
            $query->where('vehicle_id', $this->vehicleId);
        }
        
        return $query->get();
    }

    private function getMaintenances()
    {
        $query = Maintenance::with('vehicle');
        
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('date', [$this->startDate, $this->endDate]);
        }
        
        if ($this->vehicleId) {
            $query->where('vehicle_id', $this->vehicleId);
        }
        
        return $query->get();
    }

    private function getTotalIncome()
    {
        return $this->getRentals()->sum('total_cost');
    }

    private function getTotalExpenses()
    {
        return $this->getExpenses()->sum('amount') + 
               $this->getFuelFills()->sum('total_cost') + 
               $this->getMaintenances()->sum('cost');
    }
}