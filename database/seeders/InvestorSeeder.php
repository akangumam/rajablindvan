<?php

namespace Database\Seeders;

use App\Models\Investor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvestorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $investors = [
            [
                'name' => 'PT Mitra Investasi Sejahtera',
                'email' => 'investor@mitrasejahtera.co.id',
                'phone' => '021-12345678',
                'address' => 'Jl. Sudirman No. 123, Jakarta Selatan',
                'id_number' => '3174012345678901',
                'investment_percentage' => 60.00,
                'notes' => 'Investor utama dengan 2 unit kendaraan',
                'status' => 'active'
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@email.com',
                'phone' => '0812-3456-7890',
                'address' => 'Jl. Gatot Subroto No. 45, Jakarta Pusat',
                'id_number' => '3171012345678902',
                'investment_percentage' => 50.00,
                'notes' => 'Investor perorangan dengan 1 unit kendaraan',
                'status' => 'active'
            ],
            [
                'name' => 'CV Mandiri Jaya Transport',
                'email' => 'contact@mandirijaya.co.id',
                'phone' => '021-87654321',
                'address' => 'Jl. HR Rasuna Said No. 78, Jakarta Selatan',
                'id_number' => '3174056789012345',
                'investment_percentage' => 70.00,
                'notes' => 'Partnership dengan sistem bagi hasil 70%',
                'status' => 'active'
            ]
        ];

        foreach ($investors as $investor) {
            Investor::create($investor);
        }
    }
}

