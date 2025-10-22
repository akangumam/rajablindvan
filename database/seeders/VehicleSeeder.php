<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get location IDs or use 1 as default
        $jakartaLocationId = \App\Models\Location::where('code', 'JKT')->first()->id ?? 1;
        $bekasiLocationId = \App\Models\Location::where('code', 'BKS')->first()->id ?? 1;

                // Jakarta Location Vehicles
        $jakartaVehicles = [
            [
                'location_id' => $jakartaLocationId,
                'name' => 'Avanza Jakarta 1',
                'license_plate' => 'B 1234 JKT',
                'brand' => 'Toyota',
                'model' => 'Avanza',
                'year' => '2019',
                'engine_type' => 'Gasoline',
                'transmission' => 'Manual',
                'tank_capacity' => 45,
                'odometer' => 75000,
                'color' => 'Silver',
                'notes' => 'Mobil keluarga untuk Jakarta'
            ],
            [
                'location_id' => $jakartaLocationId,
                'name' => 'Jazz Jakarta 1',
                'license_plate' => 'B 5678 JKT',
                'brand' => 'Honda',
                'model' => 'Jazz',
                'year' => '2020',
                'engine_type' => 'Gasoline',
                'transmission' => 'CVT',
                'tank_capacity' => 40,
                'odometer' => 45000,
                'color' => 'Putih',
                'notes' => 'Mobil compact untuk Jakarta'
            ],
            [
                'location_id' => $jakartaLocationId,
                'name' => 'Innova Jakarta 1',
                'license_plate' => 'B 9999 JKT',
                'brand' => 'Toyota',
                'model' => 'Innova',
                'year' => '2018',
                'engine_type' => 'Gasoline',
                'transmission' => 'Manual',
                'tank_capacity' => 55,
                'odometer' => 85000,
                'color' => 'Hitam',
                'notes' => 'MPV premium untuk Jakarta'
            ],
            [
                'location_id' => $jakartaLocationId,
                'name' => 'Civic Jakarta 1',
                'license_plate' => 'B 1111 JKT',
                'brand' => 'Honda',
                'model' => 'Civic',
                'year' => '2021',
                'engine_type' => 'Gasoline',
                'transmission' => 'CVT',
                'tank_capacity' => 47,
                'odometer' => 25000,
                'color' => 'Merah',
                'notes' => 'Sedan sport untuk Jakarta'
            ]
        ];

        // Bekasi Location Vehicles
        $bekasiVehicles = [
            [
                'location_id' => $bekasiLocationId,
                'name' => 'Calya Bekasi 1',
                'license_plate' => 'B 2222 BKS',
                'brand' => 'Toyota',
                'model' => 'Calya',
                'year' => '2020',
                'engine_type' => 'Gasoline',
                'transmission' => 'Manual',
                'tank_capacity' => 36,
                'odometer' => 35000,
                'color' => 'Abu-abu',
                'notes' => 'LCGC ekonomis untuk Bekasi'
            ],
            [
                'location_id' => $bekasiLocationId,
                'name' => 'Xenia Bekasi 1',
                'license_plate' => 'B 3333 BKS',
                'brand' => 'Daihatsu',
                'model' => 'Xenia',
                'year' => '2019',
                'engine_type' => 'Gasoline',
                'transmission' => 'Manual',
                'tank_capacity' => 45,
                'odometer' => 65000,
                'color' => 'Biru',
                'notes' => 'MPV keluarga untuk Bekasi'
            ],
            [
                'location_id' => $bekasiLocationId,
                'name' => 'Pajero Bekasi 1',
                'license_plate' => 'B 4444 BKS',
                'brand' => 'Mitsubishi',
                'model' => 'Pajero Sport',
                'year' => '2020',
                'engine_type' => 'Diesel',
                'transmission' => 'Automatic',
                'tank_capacity' => 68,
                'odometer' => 42000,
                'color' => 'Putih',
                'notes' => 'SUV premium untuk Bekasi'
            ],
            [
                'location_id' => $bekasiLocationId,
                'name' => 'Fortuner Bekasi 1',
                'license_plate' => 'B 5555 BKS',
                'brand' => 'Toyota',
                'model' => 'Fortuner',
                'year' => '2021',
                'engine_type' => 'Diesel',
                'transmission' => 'Automatic',
                'tank_capacity' => 80,
                'odometer' => 18000,
                'color' => 'Hitam',
                'notes' => 'SUV mewah untuk Bekasi'
            ]
        ];

        // Additional 10 Vehicles (Trucks and Cars)
        $additionalVehicles = [
            // Trucks
            [
                'location_id' => $jakartaLocationId,
                'name' => 'Colt Diesel Blind Van',
                'license_plate' => 'B 7001 TRK',
                'brand' => 'Mitsubishi',
                'model' => 'Colt Diesel FE 74',
                'year' => '2020',
                'engine_type' => 'Diesel',
                'transmission' => 'Manual',
                'tank_capacity' => 60,
                'odometer' => 125000,
                'color' => 'Putih',
                'notes' => 'Blind van untuk pengiriman barang'
            ],
            [
                'location_id' => $jakartaLocationId,
                'name' => 'Dyna Box',
                'license_plate' => 'B 7002 TRK',
                'brand' => 'Toyota',
                'model' => 'Dyna 130 HT',
                'year' => '2019',
                'engine_type' => 'Diesel',
                'transmission' => 'Manual',
                'tank_capacity' => 80,
                'odometer' => 156000,
                'color' => 'Putih',
                'notes' => 'Truk box untuk logistik'
            ],
            [
                'location_id' => $bekasiLocationId,
                'name' => 'Isuzu Elf Blind Van',
                'license_plate' => 'B 7003 TRK',
                'brand' => 'Isuzu',
                'model' => 'Elf NLR 55 BX',
                'year' => '2021',
                'engine_type' => 'Diesel',
                'transmission' => 'Manual',
                'tank_capacity' => 70,
                'odometer' => 82000,
                'color' => 'Putih',
                'notes' => 'Blind van kapasitas besar'
            ],
            [
                'location_id' => $bekasiLocationId,
                'name' => 'Hino Dutro Cargo',
                'license_plate' => 'B 7004 TRK',
                'brand' => 'Hino',
                'model' => 'Dutro 130 MDL',
                'year' => '2020',
                'engine_type' => 'Diesel',
                'transmission' => 'Manual',
                'tank_capacity' => 75,
                'odometer' => 143000,
                'color' => 'Putih',
                'notes' => 'Truk cargo untuk distribusi'
            ],
            // Cars
            [
                'location_id' => $jakartaLocationId,
                'name' => 'Xpander Cross',
                'license_plate' => 'B 8001 CAR',
                'brand' => 'Mitsubishi',
                'model' => 'Xpander Cross',
                'year' => '2022',
                'engine_type' => 'Gasoline',
                'transmission' => 'CVT',
                'tank_capacity' => 45,
                'odometer' => 28000,
                'color' => 'Merah',
                'notes' => 'MPV compact modern'
            ],
            [
                'location_id' => $jakartaLocationId,
                'name' => 'Rush TRD',
                'license_plate' => 'B 8002 CAR',
                'brand' => 'Toyota',
                'model' => 'Rush 1.5 TRD',
                'year' => '2021',
                'engine_type' => 'Gasoline',
                'transmission' => 'Automatic',
                'tank_capacity' => 45,
                'odometer' => 52000,
                'color' => 'Putih',
                'notes' => 'SUV kompak keluarga'
            ],
            [
                'location_id' => $bekasiLocationId,
                'name' => 'BR-V Prestige',
                'license_plate' => 'B 8003 CAR',
                'brand' => 'Honda',
                'model' => 'BR-V Prestige',
                'year' => '2020',
                'engine_type' => 'Gasoline',
                'transmission' => 'CVT',
                'tank_capacity' => 42,
                'odometer' => 67000,
                'color' => 'Abu-abu Metalik',
                'notes' => 'MPV 7 seater nyaman'
            ],
            [
                'location_id' => $bekasiLocationId,
                'name' => 'Ertiga Sport',
                'license_plate' => 'B 8004 CAR',
                'brand' => 'Suzuki',
                'model' => 'Ertiga Sport',
                'year' => '2022',
                'engine_type' => 'Gasoline',
                'transmission' => 'Automatic',
                'tank_capacity' => 45,
                'odometer' => 15000,
                'color' => 'Hitam',
                'notes' => 'MPV ekonomis sporty'
            ],
            [
                'location_id' => $jakartaLocationId,
                'name' => 'CRV Turbo',
                'license_plate' => 'B 8005 CAR',
                'brand' => 'Honda',
                'model' => 'CR-V Turbo',
                'year' => '2021',
                'engine_type' => 'Gasoline',
                'transmission' => 'CVT',
                'tank_capacity' => 57,
                'odometer' => 38000,
                'color' => 'Silver Metalik',
                'notes' => 'SUV premium turbo'
            ],
            [
                'location_id' => $jakartaLocationId,
                'name' => 'Terios R MT',
                'license_plate' => 'B 8006 CAR',
                'brand' => 'Daihatsu',
                'model' => 'Terios R MT',
                'year' => '2019',
                'engine_type' => 'Gasoline',
                'transmission' => 'Manual',
                'tank_capacity' => 45,
                'odometer' => 89000,
                'color' => 'Biru Metalik',
                'notes' => 'SUV compact tangguh'
            ]
        ];

        foreach (array_merge($jakartaVehicles, $bekasiVehicles, $additionalVehicles) as $vehicle) {
            \App\Models\Vehicle::create($vehicle);
        }
    }
}
