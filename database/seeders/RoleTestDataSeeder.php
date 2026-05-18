<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Hash;

class RoleTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default location if not exists
        $location = \App\Models\Location::firstOrCreate(
            ['id' => 1],
            [
                'code' => 'HQ',
                'name' => 'Kantor Pusat',
                'address' => 'Jakarta',
            ]
        );

        // Create or get Pengelola users
        $pengelola1 = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin Utama',
                'password' => Hash::make('password'),
                'user_type' => 'Pengelola',
                'phone' => '081234567890',
            ]
        );

        $pengelola2 = User::firstOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name' => 'Manager Operasional',
                'password' => Hash::make('password'),
                'user_type' => 'Pengelola',
                'phone' => '081234567891',
            ]
        );

        // Create or get Sopir users
        $sopir1 = User::firstOrCreate(
            ['email' => 'budi@example.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'user_type' => 'Sopir',
                'phone' => '081234567892',
            ]
        );

        $sopir2 = User::firstOrCreate(
            ['email' => 'ahmad@example.com'],
            [
                'name' => 'Ahmad Wijaya',
                'password' => Hash::make('password'),
                'user_type' => 'Sopir',
                'phone' => '081234567893',
            ]
        );

        $sopir3 = User::firstOrCreate(
            ['email' => 'slamet@example.com'],
            [
                'name' => 'Slamet Raharjo',
                'password' => Hash::make('password'),
                'user_type' => 'Sopir',
                'phone' => '081234567894',
            ]
        );

        $sopir4 = User::firstOrCreate(
            ['email' => 'joko@example.com'],
            [
                'name' => 'Joko Susilo',
                'password' => Hash::make('password'),
                'user_type' => 'Sopir',
                'phone' => '081234567895',
            ]
        );

        // Create vehicles if they don't exist
        $vehicles = Vehicle::all();
        
        if ($vehicles->isEmpty()) {
            $vehicle1 = Vehicle::create([
                'name' => 'Toyota Avanza Silver',
                'brand' => 'Toyota',
                'model' => 'Avanza',
                'year' => '2020',
                'license_plate' => 'B 1234 ABC',
                'engine_type' => 'Gasoline',
                'transmission' => 'Manual',
                'tank_capacity' => 45,
                'odometer' => 15000,
                'color' => 'Silver',
                'is_active' => true,
            ]);

            $vehicle2 = Vehicle::create([
                'name' => 'Honda Mobilio Putih',
                'brand' => 'Honda',
                'model' => 'Mobilio',
                'year' => '2019',
                'license_plate' => 'B 5678 XYZ',
                'engine_type' => 'Gasoline',
                'transmission' => 'Automatic',
                'tank_capacity' => 42,
                'odometer' => 25000,
                'color' => 'Putih',
                'is_active' => true,
            ]);

            $vehicle3 = Vehicle::create([
                'name' => 'Mitsubishi Xpander Hitam',
                'brand' => 'Mitsubishi',
                'model' => 'Xpander',
                'year' => '2021',
                'license_plate' => 'B 9012 DEF',
                'engine_type' => 'Gasoline',
                'transmission' => 'Manual',
                'tank_capacity' => 45,
                'odometer' => 8000,
                'color' => 'Hitam',
                'is_active' => true,
            ]);

            $vehicle4 = Vehicle::create([
                'name' => 'Suzuki Ertiga Abu-abu',
                'brand' => 'Suzuki',
                'model' => 'Ertiga',
                'year' => '2020',
                'license_plate' => 'B 3456 GHI',
                'engine_type' => 'Gasoline',
                'transmission' => 'Manual',
                'tank_capacity' => 45,
                'odometer' => 18000,
                'color' => 'Abu-abu',
                'is_active' => true,
            ]);

            $vehicle5 = Vehicle::create([
                'name' => 'Daihatsu Terios Merah',
                'brand' => 'Daihatsu',
                'model' => 'Terios',
                'year' => '2018',
                'license_plate' => 'B 7890 JKL',
                'engine_type' => 'Gasoline',
                'transmission' => 'Automatic',
                'tank_capacity' => 50,
                'odometer' => 35000,
                'color' => 'Merah',
                'is_active' => true,
            ]);

            $vehicles = collect([$vehicle1, $vehicle2, $vehicle3, $vehicle4, $vehicle5]);
        }

        // Clear existing assignments first
        foreach ($vehicles as $vehicle) {
            $vehicle->users()->detach();
        }

        // Assign drivers to vehicles
        // Sopir 1 - assigned to 2 vehicles
        $vehicles[0]->users()->attach($sopir1->id);
        $vehicles[1]->users()->attach($sopir1->id);

        // Sopir 2 - assigned to 2 vehicles
        $vehicles[1]->users()->attach($sopir2->id);
        $vehicles[2]->users()->attach($sopir2->id);

        // Sopir 3 - assigned to 1 vehicle
        $vehicles[3]->users()->attach($sopir3->id);

        // Sopir 4 - not assigned to any vehicle (available for assignment)

        $this->command->info('✅ Test data created successfully!');
        $this->command->info('');
        $this->command->info('=== LOGIN CREDENTIALS ===');
        $this->command->info('');
        $this->command->info('PENGELOLA 1:');
        $this->command->info('Email: admin@example.com');
        $this->command->info('Password: password');
        $this->command->info('');
        $this->command->info('PENGELOLA 2:');
        $this->command->info('Email: manager@example.com');
        $this->command->info('Password: password');
        $this->command->info('');
        $this->command->info('SOPIR 1 (Has 2 vehicles):');
        $this->command->info('Email: budi@example.com');
        $this->command->info('Password: password');
        $this->command->info('');
        $this->command->info('SOPIR 2 (Has 2 vehicles):');
        $this->command->info('Email: ahmad@example.com');
        $this->command->info('Password: password');
        $this->command->info('');
        $this->command->info('SOPIR 3 (Has 1 vehicle):');
        $this->command->info('Email: slamet@example.com');
        $this->command->info('Password: password');
        $this->command->info('');
        $this->command->info('SOPIR 4 (No vehicles assigned):');
        $this->command->info('Email: joko@example.com');
        $this->command->info('Password: password');
    }
}
