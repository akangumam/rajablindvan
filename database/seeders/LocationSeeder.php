<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            [
                'name' => 'Jakarta Pusat',
                'code' => 'JKT',
                'address' => 'Jl. MH Thamrin No. 10, Jakarta Pusat, DKI Jakarta 10340',
                'phone' => '+62 21 2345 6789',
                'manager_name' => 'Budi Santoso',
                'is_active' => true,
            ],
            [
                'name' => 'Bekasi Timur',
                'code' => 'BKS',
                'address' => 'Jl. Raya Kalimalang No. 25, Bekasi Timur, Jawa Barat 17113',
                'phone' => '+62 21 8765 4321',
                'manager_name' => 'Sari Indahwati',
                'is_active' => true,
            ]
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
    }
}