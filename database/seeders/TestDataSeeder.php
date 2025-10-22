<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;
use App\Models\FuelFill;
use App\Models\Maintenance;
use App\Models\Expense;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating test data...');

        // Get first vehicle
        $vehicle = Vehicle::first();
        
        if (!$vehicle) {
            $this->command->error('No vehicles found! Please add vehicles first.');
            return;
        }

        // Create 3 fuel fills
        $this->command->info('Creating fuel fills...');
        FuelFill::create([
            'vehicle_id' => $vehicle->id,
            'fill_date' => now()->subDays(10),
            'odometer' => $vehicle->odometer + 100,
            'liters' => 45,
            'price_per_liter' => 15000,
            'total_cost' => 45 * 15000,
            'fuel_type' => 'Pertalite',
            'gas_station' => 'Shell',
            'payment_method' => 'Tunai',
            'is_full_tank' => true
        ]);

        FuelFill::create([
            'vehicle_id' => $vehicle->id,
            'fill_date' => now()->subDays(5),
            'odometer' => $vehicle->odometer + 250,
            'liters' => 40,
            'price_per_liter' => 15000,
            'total_cost' => 40 * 15000,
            'fuel_type' => 'Pertalite',
            'gas_station' => 'Pertamina',
            'payment_method' => 'Kartu Debit',
            'is_full_tank' => true
        ]);

        FuelFill::create([
            'vehicle_id' => $vehicle->id,
            'fill_date' => now(),
            'odometer' => $vehicle->odometer + 400,
            'liters' => 42,
            'price_per_liter' => 15000,
            'total_cost' => 42 * 15000,
            'fuel_type' => 'Pertalite',
            'gas_station' => 'Shell',
            'payment_method' => 'Tunai',
            'is_full_tank' => true
        ]);

        // Create 2 maintenance records
        $this->command->info('Creating maintenance records...');
        Maintenance::create([
            'vehicle_id' => $vehicle->id,
            'maintenance_date' => now()->subDays(7),
            'odometer' => $vehicle->odometer + 150,
            'type' => 'Ganti Oli',
            'category' => 'Routine',
            'description' => 'Ganti oli mesin dan filter oli',
            'cost' => 350000,
            'workshop' => 'Bengkel Resmi Toyota'
        ]);

        Maintenance::create([
            'vehicle_id' => $vehicle->id,
            'maintenance_date' => now()->subDays(2),
            'odometer' => $vehicle->odometer + 380,
            'type' => 'Service Rutin',
            'category' => 'Routine',
            'description' => 'Servis rutin 10.000 km',
            'cost' => 500000,
            'workshop' => 'Bengkel Resmi Toyota'
        ]);

        // Create 2 expenses
        $this->command->info('Creating expenses...');
        Expense::create([
            'vehicle_id' => $vehicle->id,
            'expense_date' => now()->subDays(8),
            'odometer' => $vehicle->odometer + 120,
            'category' => 'Parkir',
            'description' => 'Parkir mall',
            'amount' => 15000,
            'payment_method' => 'Tunai'
        ]);

        Expense::create([
            'vehicle_id' => $vehicle->id,
            'expense_date' => now()->subDays(3),
            'odometer' => $vehicle->odometer + 350,
            'category' => 'Tol',
            'description' => 'Tol Jakarta-Bandung PP',
            'amount' => 150000,
            'payment_method' => 'E-Toll'
        ]);

        $this->command->info('========================================');
        $this->command->info('✅ Test data created successfully!');
        $this->command->info('========================================');
        $this->command->info('Vehicle: ' . $vehicle->full_name);
        $this->command->info('Fuel Fills: 3 records');
        $this->command->info('Maintenances: 2 records');
        $this->command->info('Expenses: 2 records');
        $this->command->info('========================================');
    }
}
