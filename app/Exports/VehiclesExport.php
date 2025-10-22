<?php

namespace App\Exports;

use App\Models\Vehicle;
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

class VehiclesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle
{
    public function collection()
    {
        return Vehicle::with(['rentals', 'expenses', 'fuelFills', 'maintenances'])->get();
    }

    public function headings(): array
    {
        return [
            'Plat Nomor',
            'Merek',
            'Model',
            'Tahun',
            'Tipe',
            'Status',
            'Tarif Harian (Rp)',
            'Tarif Bulanan (Rp)',
            'Total Sewa',
            'Total Pengeluaran',
            'Keuntungan'
        ];
    }

    public function map($vehicle): array
    {
        $totalRentals = $vehicle->rentals->sum('total_cost');
        $totalExpenses = $vehicle->expenses->sum('amount') + 
                        $vehicle->fuelFills->sum('total_cost') + 
                        $vehicle->maintenances->sum('cost');
        $profit = $totalRentals - $totalExpenses;

        return [
            $vehicle->license_plate,
            $vehicle->brand,
            $vehicle->model,
            $vehicle->year,
            $vehicle->type,
            $vehicle->status,
            number_format($vehicle->daily_rate ?? 0, 0, ',', '.'),
            number_format($vehicle->monthly_rate ?? 0, 0, ',', '.'),
            number_format($totalRentals, 0, ',', '.'),
            number_format($totalExpenses, 0, ',', '.'),
            number_format($profit, 0, ',', '.')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header style
        $sheet->getStyle('A1:K1')->applyFromArray([
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
            ]
        ]);

        // All data with borders
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:K' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN
                ]
            ]
        ]);

        // Center align for certain columns
        $sheet->getStyle('D2:D' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F2:F' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Right align for money columns
        $sheet->getStyle('G2:K' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 12,
            'B' => 12,
            'C' => 15,
            'D' => 8,
            'E' => 10,
            'F' => 10,
            'G' => 15,
            'H' => 15,
            'I' => 15,
            'J' => 15,
            'K' => 15,
        ];
    }

    public function title(): string
    {
        return 'Data Kendaraan';
    }
}