<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;
use App\Models\FuelFill;
use App\Models\Maintenance;
use App\Models\Expense;
use App\Models\Location;
use App\Models\ServiceType;
use App\Models\ExpenseType;
use App\Models\PaymentMethod;
use Carbon\Carbon;

class HistoryDemoSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating demo vehicles and transactions...');

        // Create master data first
        $location1 = Location::firstOrCreate(
            ['name' => 'Depok'],
            [
                'code' => 'DPK',
                'address' => 'Jl. Margonda Raya, Depok',
                'is_active' => true
            ]
        );

        $location2 = Location::firstOrCreate(
            ['name' => 'Jakarta Office'],
            [
                'code' => 'JKT',
                'address' => 'Jl. Sudirman, Jakarta',
                'is_active' => true
            ]
        );

        $location3 = Location::firstOrCreate(
            ['name' => 'Kantor Pusat'],
            [
                'code' => 'HQ',
                'address' => 'Jl. Thamrin, Jakarta Pusat',
                'is_active' => true
            ]
        );

        ServiceType::firstOrCreate(
            ['name' => 'Oil Change'],
            ['description' => 'Engine oil change service', 'is_active' => true]
        );

        ServiceType::firstOrCreate(
            ['name' => 'Tune Up'],
            ['description' => 'Engine tune up service', 'is_active' => true]
        );

        ServiceType::firstOrCreate(
            ['name' => 'Brake Service'],
            ['description' => 'Brake system service', 'is_active' => true]
        );

        ExpenseType::firstOrCreate(
            ['name' => 'Parking'],
            ['is_active' => true]
        );

        ExpenseType::firstOrCreate(
            ['name' => 'Toll'],
            ['is_active' => true]
        );

        ExpenseType::firstOrCreate(
            ['name' => 'Car Wash'],
            ['is_active' => true]
        );

        PaymentMethod::firstOrCreate(
            ['name' => 'Cash'],
            ['is_active' => true]
        );

        PaymentMethod::firstOrCreate(
            ['name' => 'E-Wallet'],
            ['is_active' => true]
        );

        $this->command->info('✓ Master data created');

        // Vehicle 1: Toyota Avanza
        $avanza = Vehicle::firstOrCreate(
            ['license_plate' => 'B 1234 XYZ'],
            [
                'name' => 'Toyota Avanza',
                'brand' => 'Toyota',
                'model' => 'Avanza 1.3 G',
                'year' => '2020',
                'color' => 'Silver',
                'is_active' => true,
                'odometer' => 45000,
                'location_id' => $location1->id,
            ]
        );

        // Vehicle 2: Honda Jazz
        $jazz = Vehicle::firstOrCreate(
            ['license_plate' => 'B 5678 ABC'],
            [
                'name' => 'Honda Jazz',
                'brand' => 'Honda',
                'model' => 'Jazz RS CVT',
                'year' => '2019',
                'color' => 'White',
                'is_active' => true,
                'odometer' => 52000,
                'location_id' => $location2->id,
            ]
        );

        $this->command->info('✓ Vehicles created');

        // Transactions for Avanza
        $this->createAvanzaTransactions($avanza);
        $this->command->info('✓ Avanza transactions created');

        // Transactions for Jazz
        $this->createJazzTransactions($jazz);
        $this->command->info('✓ Jazz transactions created');

        $this->command->info('');
        $this->command->info('✅ Demo data created successfully!');
        $this->command->info('Vehicle 1: ' . $avanza->name . ' (' . $avanza->license_plate . ')');
        $this->command->info('Vehicle 2: ' . $jazz->name . ' (' . $jazz->license_plate . ')');
    }

    private function createAvanzaTransactions($vehicle)
    {
        // October 2025 - Refueling
        FuelFill::create([
            'vehicle_id' => $vehicle->id,
            'fill_date' => Carbon::parse('2025-10-29'),
            'odometer' => 45123,
            'liters' => 45,
            'price_per_liter' => 10500,
            'total_cost' => 472500,
            'fuel_type' => 'Pertamax',
            'gas_station' => 'Depok',
            'is_full_tank' => true,
            'notes' => 'Full tank - Highway trip',
        ]);

        // October 2025 - Oil Change
        Maintenance::create([
            'vehicle_id' => $vehicle->id,
            'maintenance_date' => Carbon::parse('2025-10-15'),
            'odometer' => 45000,
            'type' => 'Oil Change',
            'description' => 'Engine oil change + filter',
            'cost' => 350000,
            'workshop' => 'Jakarta Office',
            'notes' => 'Used synthetic oil 5W-30',
        ]);

        // October 2025 - General Service
        Maintenance::create([
            'vehicle_id' => $vehicle->id,
            'maintenance_date' => Carbon::parse('2025-10-15'),
            'odometer' => 45000,
            'type' => 'Service',
            'description' => 'Periodic maintenance 45000 km',
            'cost' => 850000,
            'workshop' => 'Kantor Pusat',
            'notes' => 'Includes oil, filters, brake check, AC service',
        ]);

        // September 2025 - Refueling
        FuelFill::create([
            'vehicle_id' => $vehicle->id,
            'fill_date' => Carbon::parse('2025-09-22'),
            'odometer' => 44878,
            'liters' => 40,
            'price_per_liter' => 10300,
            'total_cost' => 412000,
            'fuel_type' => 'Pertamax',
            'gas_station' => 'Depok',
            'is_full_tank' => true,
            'notes' => 'Regular commute',
        ]);

        // September 2025 - Labor Cost
        Expense::create([
            'vehicle_id' => $vehicle->id,
            'expense_date' => Carbon::parse('2025-09-10'),
            'category' => 'labor_cost',
            'description' => 'Driver salary - September',
            'amount' => 3500000,
            'payment_method' => 'Transfer',
            'notes' => 'Monthly driver salary',
        ]);

        // August 2025 - Refueling
        FuelFill::create([
            'vehicle_id' => $vehicle->id,
            'fill_date' => Carbon::parse('2025-08-15'),
            'odometer' => 44545,
            'liters' => 43,
            'price_per_liter' => 10200,
            'total_cost' => 438600,
            'fuel_type' => 'Pertamax',
            'gas_station' => 'Depok',
            'is_full_tank' => true,
            'notes' => 'Long distance trip',
        ]);

        // August 2025 - Registration
        Expense::create([
            'vehicle_id' => $vehicle->id,
            'expense_date' => Carbon::parse('2025-08-05'),
            'category' => 'registration',
            'description' => 'STNK renewal - Annual tax',
            'amount' => 2250000,
            'payment_method' => 'Cash',
            'notes' => 'Vehicle registration + tax payment',
        ]);

        // July 2025 - Refueling
        FuelFill::create([
            'vehicle_id' => $vehicle->id,
            'fill_date' => Carbon::parse('2025-07-20'),
            'odometer' => 44234,
            'liters' => 38,
            'price_per_liter' => 10100,
            'total_cost' => 383800,
            'fuel_type' => 'Pertamax',
            'gas_station' => 'Jakarta Office',
            'is_full_tank' => true,
            'notes' => 'City driving',
        ]);

        // July 2025 - Tire Rotation
        Maintenance::create([
            'vehicle_id' => $vehicle->id,
            'maintenance_date' => Carbon::parse('2025-07-10'),
            'odometer' => 44100,
            'type' => 'Other',
            'description' => 'Tire rotation and balance',
            'cost' => 250000,
            'workshop' => 'Kantor Pusat',
            'notes' => 'All 4 tires rotated and balanced',
        ]);
    }

    private function createJazzTransactions($vehicle)
    {
        // October 2025 - Refueling
        FuelFill::create([
            'vehicle_id' => $vehicle->id,
            'fill_date' => Carbon::parse('2025-10-25'),
            'odometer' => 52345,
            'liters' => 35,
            'price_per_liter' => 10500,
            'total_cost' => 367500,
            'fuel_type' => 'Pertamax',
            'gas_station' => 'Jakarta Office',
            'is_full_tank' => true,
            'notes' => 'Regular fill-up',
        ]);

        // October 2025 - Work Expense
        Expense::create([
            'vehicle_id' => $vehicle->id,
            'expense_date' => Carbon::parse('2025-10-20'),
            'category' => 'work',
            'description' => 'Parking fees - Monthly',
            'amount' => 500000,
            'payment_method' => 'Transfer',
            'notes' => 'Office parking subscription',
        ]);

        // September 2025 - Oil Change
        Maintenance::create([
            'vehicle_id' => $vehicle->id,
            'maintenance_date' => Carbon::parse('2025-09-15'),
            'odometer' => 52000,
            'type' => 'Oil Change',
            'description' => 'Engine oil change',
            'cost' => 400000,
            'workshop' => 'Depok',
            'notes' => 'Honda Genuine Oil 0W-20',
        ]);

        // September 2025 - Refueling
        FuelFill::create([
            'vehicle_id' => $vehicle->id,
            'fill_date' => Carbon::parse('2025-09-10'),
            'odometer' => 51967,
            'liters' => 32,
            'price_per_liter' => 10300,
            'total_cost' => 329600,
            'fuel_type' => 'Pertamax',
            'gas_station' => 'Kantor Pusat',
            'is_full_tank' => true,
            'notes' => 'Weekend trip',
        ]);

        // August 2025 - AC Service
        Maintenance::create([
            'vehicle_id' => $vehicle->id,
            'maintenance_date' => Carbon::parse('2025-08-20'),
            'odometer' => 51750,
            'type' => 'Service',
            'description' => 'AC system check and recharge',
            'cost' => 550000,
            'workshop' => 'Jakarta Office',
            'notes' => 'AC cooling improved, freon refilled',
        ]);

        // August 2025 - Refueling
        FuelFill::create([
            'vehicle_id' => $vehicle->id,
            'fill_date' => Carbon::parse('2025-08-08'),
            'odometer' => 51598,
            'liters' => 33,
            'price_per_liter' => 10200,
            'total_cost' => 336600,
            'fuel_type' => 'Pertamax',
            'gas_station' => 'Depok',
            'is_full_tank' => true,
            'notes' => 'Commute fuel',
        ]);
    }
}
