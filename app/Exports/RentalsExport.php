<?php

namespace App\Exports;

use App\Models\Rental;
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

class RentalsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle
{
    protected $startDate;
    protected $endDate;
    protected $status;

    public function __construct($startDate = null, $endDate = null, $status = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->status = $status;
    }

    public function collection()
    {
        $query = Rental::with(['vehicle', 'customer']);
        
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('start_date', [$this->startDate, $this->endDate]);
        }
        
        if ($this->status) {
            $query->where('status', $this->status);
        }
        
        return $query->orderBy('start_date', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Kendaraan',
            'Pelanggan',
            'Tipe Sewa',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Durasi (Hari)',
            'Tarif Dasar',
            'Biaya Tambahan',
            'Total Biaya',
            'Status',
            'Tanggal Dibuat'
        ];
    }

    public function map($rental): array
    {
        $startDate = Carbon::parse($rental->start_date);
        $endDate = $rental->end_date ? Carbon::parse($rental->end_date) : Carbon::now();
        $duration = $endDate->diffInDays($startDate) + 1;

        return [
            $rental->id,
            $rental->vehicle->license_plate ?? '-',
            $rental->customer->name ?? '-',
            ucfirst($rental->rental_type),
            $startDate->format('d/m/Y'),
            $rental->end_date ? $endDate->format('d/m/Y') : '-',
            $duration,
            number_format($rental->base_amount ?? 0, 0, ',', '.'),
            number_format($rental->additional_charges ?? 0, 0, ',', '.'),
            number_format($rental->total_cost, 0, ',', '.'),
            ucfirst($rental->status),
            Carbon::parse($rental->created_at)->format('d/m/Y H:i')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header style
        $sheet->getStyle('A1:L1')->applyFromArray([
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
        $sheet->getStyle('A1:L' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN
                ]
            ]
        ]);

        // Center align for certain columns
        $sheet->getStyle('A2:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D2:D' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E2:F' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G2:G' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('K2:K' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Right align for money columns
        $sheet->getStyle('H2:J' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 12,
            'C' => 20,
            'D' => 12,
            'E' => 12,
            'F' => 12,
            'G' => 10,
            'H' => 15,
            'I' => 15,
            'J' => 15,
            'K' => 10,
            'L' => 15,
        ];
    }

    public function title(): string
    {
        $period = '';
        if ($this->startDate && $this->endDate) {
            $period = ' (' . Carbon::parse($this->startDate)->format('d/m/Y') . ' - ' . Carbon::parse($this->endDate)->format('d/m/Y') . ')';
        }
        return 'Data Sewa' . $period;
    }
}