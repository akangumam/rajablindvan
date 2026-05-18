<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\Location;
use Illuminate\Support\Facades\Hash;

class ComprehensiveTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default location if not exists
        Location::firstOrCreate(
            ['id' => 1],
            [
                'code' => 'HQ',
                'name' => 'Kantor Pusat',
                'address' => 'Jakarta',
            ]
        );

        $this->command->info('Creating 12 Users & Customers...');
        
        // ===== CREATE 3 PENGELOLA =====
        $pengelolaData = [
            [
                'name' => 'Ahmad Suharto',
                'email' => 'ahmad.suharto@example.com',
                'phone' => '081234567801',
                'id_number' => '3171010101900001',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@example.com',
                'phone' => '081234567802',
                'id_number' => '3171020202900002',
            ],
            [
                'name' => 'Citra Dewi',
                'email' => 'citra.dewi@example.com',
                'phone' => '081234567803',
                'id_number' => '3171030303900003',
            ],
        ];

        foreach ($pengelolaData as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'user_type' => 'Pengelola',
                    'phone' => $data['phone'],
                ]
            );

            Customer::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'first_name' => explode(' ', $data['name'])[0],
                    'last_name' => explode(' ', $data['name'])[1] ?? '',
                    'email' => $data['email'],
                    'user_type' => 'Pengelola',
                    'phone' => $data['phone'],
                    'id_number' => $data['id_number'],
                    'address' => 'Jakarta, Indonesia',
                    'is_active' => true,
                ]
            );
        }

        // ===== CREATE 9 SOPIR =====
        $sopirData = [
            [
                'name' => 'Dedi Kurniawan',
                'email' => 'dedi.kurniawan@example.com',
                'phone' => '081234567804',
                'id_number' => '3171040404900004',
                'license' => 'A',
            ],
            [
                'name' => 'Eko Prasetyo',
                'email' => 'eko.prasetyo@example.com',
                'phone' => '081234567805',
                'id_number' => '3171050505900005',
                'license' => 'A',
            ],
            [
                'name' => 'Fajar Ramadhan',
                'email' => 'fajar.ramadhan@example.com',
                'phone' => '081234567806',
                'id_number' => '3171060606900006',
                'license' => 'B1',
            ],
            [
                'name' => 'Guntur Wibowo',
                'email' => 'guntur.wibowo@example.com',
                'phone' => '081234567807',
                'id_number' => '3171070707900007',
                'license' => 'A',
            ],
            [
                'name' => 'Hendra Saputra',
                'email' => 'hendra.saputra@example.com',
                'phone' => '081234567808',
                'id_number' => '3171080808900008',
                'license' => 'B1',
            ],
            [
                'name' => 'Indra Kusuma',
                'email' => 'indra.kusuma@example.com',
                'phone' => '081234567809',
                'id_number' => '3171090909900009',
                'license' => 'A',
            ],
            [
                'name' => 'Joko Widodo',
                'email' => 'joko.widodo@example.com',
                'phone' => '081234567810',
                'id_number' => '3171101010900010',
                'license' => 'A',
            ],
            [
                'name' => 'Kurniadi Setiawan',
                'email' => 'kurniadi.setiawan@example.com',
                'phone' => '081234567811',
                'id_number' => '3171111111900011',
                'license' => 'B1',
            ],
            [
                'name' => 'Lukman Hakim',
                'email' => 'lukman.hakim@example.com',
                'phone' => '081234567812',
                'id_number' => '3171121212900012',
                'license' => 'B2',
            ],
        ];

        $sopirUsers = [];
        foreach ($sopirData as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'user_type' => 'Sopir',
                    'phone' => $data['phone'],
                ]
            );

            Customer::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'first_name' => explode(' ', $data['name'])[0],
                    'last_name' => explode(' ', $data['name'])[1] ?? '',
                    'email' => $data['email'],
                    'id_number' => $data['id_number'],
                    'user_type' => 'Sopir',
                    'phone' => $data['phone'],
                    'address' => 'Jakarta, Indonesia',
                    'license_category' => $data['license'],
                    'is_active' => true,
                ]
            );

            $sopirUsers[] = $user;
        }

        $this->command->info('✓ Created 12 Users (3 Pengelola, 9 Sopir)');

        // ===== CREATE 15 VEHICLES =====
        $this->command->info('Creating 15 Vehicles...');

        $vehiclesData = [
            // Toyota (4 units)
            [
                'name' => 'Toyota Avanza Veloz',
                'brand' => 'Toyota',
                'model' => 'Avanza Veloz',
                'year' => '2022',
                'license_plate' => 'B 1234 ABC',
                'color' => 'Silver Metalik',
                'transmission' => 'Manual',
                'tank_capacity' => 45,
                'odometer' => 12500,
            ],
            [
                'name' => 'Toyota Innova Reborn',
                'brand' => 'Toyota',
                'model' => 'Innova Reborn',
                'year' => '2021',
                'license_plate' => 'B 5678 DEF',
                'color' => 'Putih',
                'transmission' => 'Automatic',
                'tank_capacity' => 50,
                'odometer' => 25000,
            ],
            [
                'name' => 'Toyota Hiace Commuter',
                'brand' => 'Toyota',
                'model' => 'Hiace Commuter',
                'year' => '2020',
                'license_plate' => 'B 9012 GHI',
                'color' => 'Putih',
                'transmission' => 'Manual',
                'tank_capacity' => 70,
                'odometer' => 45000,
            ],
            [
                'name' => 'Toyota Fortuner VRZ',
                'brand' => 'Toyota',
                'model' => 'Fortuner',
                'year' => '2023',
                'license_plate' => 'B 3456 JKL',
                'color' => 'Hitam',
                'transmission' => 'Automatic',
                'tank_capacity' => 80,
                'odometer' => 8500,
            ],
            // Honda (3 units)
            [
                'name' => 'Honda Mobilio RS',
                'brand' => 'Honda',
                'model' => 'Mobilio',
                'year' => '2021',
                'license_plate' => 'B 7890 MNO',
                'color' => 'Abu-abu',
                'transmission' => 'Manual',
                'tank_capacity' => 42,
                'odometer' => 18000,
            ],
            [
                'name' => 'Honda BR-V Prestige',
                'brand' => 'Honda',
                'model' => 'BR-V',
                'year' => '2022',
                'license_plate' => 'B 2345 PQR',
                'color' => 'Merah Marun',
                'transmission' => 'Automatic',
                'tank_capacity' => 50,
                'odometer' => 15000,
            ],
            [
                'name' => 'Honda CR-V Turbo',
                'brand' => 'Honda',
                'model' => 'CR-V',
                'year' => '2023',
                'license_plate' => 'B 6789 STU',
                'color' => 'Hitam',
                'transmission' => 'Automatic',
                'tank_capacity' => 57,
                'odometer' => 5000,
            ],
            // Mitsubishi (3 units)
            [
                'name' => 'Mitsubishi Xpander Ultimate',
                'brand' => 'Mitsubishi',
                'model' => 'Xpander',
                'year' => '2022',
                'license_plate' => 'B 1357 VWX',
                'color' => 'Silver',
                'transmission' => 'Automatic',
                'tank_capacity' => 45,
                'odometer' => 20000,
            ],
            [
                'name' => 'Mitsubishi Pajero Sport',
                'brand' => 'Mitsubishi',
                'model' => 'Pajero Sport',
                'year' => '2021',
                'license_plate' => 'B 2468 YZA',
                'color' => 'Putih Mutiara',
                'transmission' => 'Automatic',
                'tank_capacity' => 68,
                'odometer' => 35000,
            ],
            [
                'name' => 'Mitsubishi L300 Blind Van',
                'brand' => 'Mitsubishi',
                'model' => 'L300',
                'year' => '2019',
                'license_plate' => 'B 3579 BCD',
                'color' => 'Putih',
                'transmission' => 'Manual',
                'tank_capacity' => 55,
                'odometer' => 55000,
            ],
            // Suzuki (2 units)
            [
                'name' => 'Suzuki Ertiga Sport',
                'brand' => 'Suzuki',
                'model' => 'Ertiga',
                'year' => '2021',
                'license_plate' => 'B 4680 EFG',
                'color' => 'Biru Metalik',
                'transmission' => 'Manual',
                'tank_capacity' => 45,
                'odometer' => 28000,
            ],
            [
                'name' => 'Suzuki XL7 Beta',
                'brand' => 'Suzuki',
                'model' => 'XL7',
                'year' => '2022',
                'license_plate' => 'B 5791 HIJ',
                'color' => 'Hitam',
                'transmission' => 'Automatic',
                'tank_capacity' => 45,
                'odometer' => 12000,
            ],
            // Daihatsu (2 units)
            [
                'name' => 'Daihatsu Terios R',
                'brand' => 'Daihatsu',
                'model' => 'Terios',
                'year' => '2020',
                'license_plate' => 'B 6802 KLM',
                'color' => 'Silver',
                'transmission' => 'Manual',
                'tank_capacity' => 50,
                'odometer' => 38000,
            ],
            [
                'name' => 'Daihatsu Gran Max Minibus',
                'brand' => 'Daihatsu',
                'model' => 'Gran Max',
                'year' => '2021',
                'license_plate' => 'B 7913 NOP',
                'color' => 'Putih',
                'transmission' => 'Manual',
                'tank_capacity' => 43,
                'odometer' => 32000,
            ],
            // Isuzu (1 unit)
            [
                'name' => 'Isuzu Elf NLR Microbus',
                'brand' => 'Isuzu',
                'model' => 'Elf',
                'year' => '2020',
                'license_plate' => 'B 8024 QRS',
                'color' => 'Putih',
                'transmission' => 'Manual',
                'tank_capacity' => 100,
                'odometer' => 48000,
            ],
        ];

        $vehicles = [];
        foreach ($vehiclesData as $data) {
            $vehicle = Vehicle::firstOrCreate(
                ['license_plate' => $data['license_plate']],
                [
                    'name' => $data['name'],
                    'brand' => $data['brand'],
                    'model' => $data['model'],
                    'year' => $data['year'],
                    'engine_type' => 'Gasoline',
                    'transmission' => $data['transmission'],
                    'tank_capacity' => $data['tank_capacity'],
                    'odometer' => $data['odometer'],
                    'color' => $data['color'],
                    'is_active' => true,
                ]
            );
            $vehicles[] = $vehicle;
        }

        $this->command->info('✓ Created 15 Vehicles');

        // ===== ASSIGN DRIVERS TO VEHICLES =====
        $this->command->info('Assigning drivers to vehicles...');

        // Clear existing assignments
        foreach ($vehicles as $vehicle) {
            $vehicle->users()->detach();
        }

        // Assign 2-3 drivers per vehicle (randomly)
        foreach ($vehicles as $index => $vehicle) {
            // Each vehicle gets 2-3 random drivers
            $driversCount = rand(2, 3);
            $randomDrivers = collect($sopirUsers)->random($driversCount);
            
            foreach ($randomDrivers as $driver) {
                $vehicle->users()->syncWithoutDetaching($driver->id);
            }
        }

        $this->command->info('✓ Assigned drivers to vehicles');

        // Display summary
        $this->command->info('');
        $this->command->info('========================================');
        $this->command->info('✅ COMPREHENSIVE TEST DATA CREATED!');
        $this->command->info('========================================');
        $this->command->info('');
        $this->command->info('USERS (12 total):');
        $this->command->info('  • 3 Pengelola');
        $this->command->info('  • 9 Sopir');
        $this->command->info('');
        $this->command->info('VEHICLES (15 total):');
        $this->command->info('  • Toyota: 4 units');
        $this->command->info('  • Honda: 3 units');
        $this->command->info('  • Mitsubishi: 3 units');
        $this->command->info('  • Suzuki: 2 units');
        $this->command->info('  • Daihatsu: 2 units');
        $this->command->info('  • Isuzu: 1 unit');
        $this->command->info('');
        $this->command->info('VEHICLE ASSIGNMENTS:');
        $this->command->info('  • Each vehicle has 2-3 drivers assigned');
        $this->command->info('');
        $this->command->info('DEFAULT LOGIN:');
        $this->command->info('  Email: [any email from list above]');
        $this->command->info('  Password: password');
        $this->command->info('');
        $this->command->info('========================================');
    }
}
