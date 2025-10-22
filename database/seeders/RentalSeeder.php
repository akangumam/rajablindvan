<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rental;
use App\Models\Customer;
use App\Models\Vehicle;
use Carbon\Carbon;

class RentalSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $customers = Customer::all();
        $vehicles = Vehicle::all();

        if ($customers->count() == 0 || $vehicles->count() == 0) {
            $this->command->info('Tidak ada customer atau vehicle. Jalankan seeder Customer dan Vehicle terlebih dahulu.');
            return;
        }

        $rentals = [
            // Rental Completed
            [
                'customer_id' => $customers->first()->id,
                'vehicle_id' => $vehicles->first()->id,
                'rental_code' => 'RNT-202510-001',
                'start_date' => Carbon::now()->subDays(10),
                'end_date' => Carbon::now()->subDays(7),
                'start_odometer' => 75000,
                'end_odometer' => 75500,
                'daily_rate' => 300000,
                'duration_days' => 4,
                'total_amount' => 1200000,
                'deposit' => 500000,
                'additional_charges' => 0,
                'status' => 'completed',
                'pickup_location' => 'Kantor Rental - Jl. Sudirman No. 123',
                'return_location' => 'Kantor Rental - Jl. Sudirman No. 123',
                'notes' => 'Rental bisnis, return tepat waktu',
                'actual_start_time' => Carbon::now()->subDays(10)->setTime(8, 0),
                'actual_end_time' => Carbon::now()->subDays(7)->setTime(17, 0),
            ],
            // Rental Active
            [
                'customer_id' => $customers->skip(1)->first()->id,
                'vehicle_id' => $vehicles->skip(1)->first()->id,
                'rental_code' => 'RNT-202510-002',
                'start_date' => Carbon::now()->subDays(2),
                'end_date' => Carbon::now()->addDays(3),
                'start_odometer' => 82000,
                'end_odometer' => null,
                'daily_rate' => 350000,
                'duration_days' => 6,
                'total_amount' => 2100000,
                'deposit' => 600000,
                'additional_charges' => 0,
                'status' => 'active',
                'pickup_location' => 'Hotel Grand Indonesia',
                'return_location' => 'Bandara Soekarno Hatta',
                'notes' => 'Rental untuk perjalanan dinas',
                'actual_start_time' => Carbon::now()->subDays(2)->setTime(9, 30),
                'actual_end_time' => null,
            ],
            // Rental Reserved (after active rental ends)
            [
                'customer_id' => $customers->skip(2)->first()->id,
                'vehicle_id' => $vehicles->skip(1)->first()->id, // Use second vehicle
                'rental_code' => 'RNT-202510-003',
                'start_date' => Carbon::now()->addDays(5), // After active rental ends
                'end_date' => Carbon::now()->addDays(9),
                'start_odometer' => 95000,
                'end_odometer' => null,
                'daily_rate' => 275000,
                'duration_days' => 5,
                'total_amount' => 1375000,
                'deposit' => 400000,
                'additional_charges' => 0,
                'status' => 'reserved',
                'pickup_location' => 'Rumah Customer - Jl. Mawar No. 78',
                'return_location' => 'Kantor Rental - Jl. Sudirman No. 123',
                'notes' => 'Pickup service diminta',
                'actual_start_time' => null,
                'actual_end_time' => null,
            ],
            // Rental Completed dengan Additional Charges
            [
                'customer_id' => $customers->skip(3)->first()->id,
                'vehicle_id' => $vehicles->first()->id, // Reuse vehicle after completed rental
                'rental_code' => 'RNT-202510-004',
                'start_date' => Carbon::now()->subDays(15),
                'end_date' => Carbon::now()->subDays(13),
                'start_odometer' => 75500,
                'end_odometer' => 76200,
                'daily_rate' => 300000,
                'duration_days' => 3,
                'total_amount' => 900000,
                'deposit' => 500000,
                'additional_charges' => 150000,
                'additional_charges_notes' => 'Denda keterlambatan 2 jam + bahan bakar',
                'status' => 'completed',
                'pickup_location' => 'Mall Central Park',
                'return_location' => 'Kantor Rental - Jl. Sudirman No. 123',
                'notes' => 'Return terlambat 2 jam',
                'actual_start_time' => Carbon::now()->subDays(15)->setTime(10, 0),
                'actual_end_time' => Carbon::now()->subDays(13)->setTime(19, 0),
            ]
        ];

        foreach ($rentals as $rentalData) {
            Rental::create($rentalData);
        }

        $this->command->info('Sample rental data created successfully!');
    }
}
