<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rental;
use App\Models\Customer;
use App\Models\Vehicle;
use Carbon\Carbon;

class RentalTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = Customer::all();
        $vehicles = Vehicle::all();
        
        if ($customers->isEmpty() || $vehicles->isEmpty()) {
            $this->command->info('Please run CustomerSeeder and ensure vehicles exist first.');
            return;
        }
        
        // Clear existing rentals to avoid conflicts
        Rental::truncate();
        
        $rentalData = [
            [
                'customer_id' => $customers->random()->id,
                'vehicle_id' => $vehicles->random()->id,
                'rental_type' => 'daily',
                'start_date' => Carbon::today(),
                'end_date' => Carbon::today()->addDays(3),
                'daily_rate' => 350000,
                'weekly_rate' => null,
                'monthly_rate' => null,
                'deposit' => 500000,
                'status' => 'reserved',
                'pickup_location' => 'Kantor Rental Jl. Sudirman No. 123',
                'return_location' => 'Kantor Rental Jl. Sudirman No. 123',
                'notes' => 'Rental harian untuk keperluan bisnis'
            ],
            [
                'customer_id' => $customers->random()->id,
                'vehicle_id' => $vehicles->random()->id,
                'rental_type' => 'weekly',
                'start_date' => Carbon::today()->addDays(1),
                'end_date' => Carbon::today()->addDays(10),
                'daily_rate' => 320000,
                'weekly_rate' => 2080000, // 6.5 days rate
                'monthly_rate' => null,
                'deposit' => 1000000,
                'status' => 'reserved',
                'pickup_location' => 'Hotel Grand Indonesia',
                'return_location' => 'Bandara Soekarno-Hatta',
                'notes' => 'Rental mingguan untuk liburan keluarga'
            ],
            [
                'customer_id' => $customers->random()->id,
                'vehicle_id' => $vehicles->random()->id,
                'rental_type' => 'monthly',
                'start_date' => Carbon::today()->addDays(7),
                'end_date' => Carbon::today()->addDays(37),
                'daily_rate' => 300000,
                'weekly_rate' => 1950000,
                'monthly_rate' => 7500000, // 25 days rate
                'deposit' => 2000000,
                'status' => 'reserved',
                'pickup_location' => 'Kantor Customer',
                'return_location' => 'Kantor Customer',
                'notes' => 'Rental bulanan untuk karyawan perusahaan'
            ],
            [
                'customer_id' => $customers->random()->id,
                'vehicle_id' => $vehicles->random()->id,
                'rental_type' => 'daily',
                'start_date' => Carbon::yesterday(),
                'end_date' => Carbon::today()->addDays(2),
                'daily_rate' => 280000,
                'weekly_rate' => null,
                'monthly_rate' => null,
                'deposit' => 400000,
                'status' => 'active',
                'actual_start_time' => Carbon::yesterday()->setTime(9, 0),
                'pickup_location' => 'Rumah Customer',
                'return_location' => 'Rumah Customer',
                'notes' => 'Rental aktif untuk acara keluarga'
            ]
        ];
        
        foreach ($rentalData as $data) {
            // Calculate duration and total
            $startDate = Carbon::parse($data['start_date']);
            $endDate = Carbon::parse($data['end_date']);
            $duration = $startDate->diffInDays($endDate) + 1;
            
            $data['duration_days'] = $duration;
            $data['rental_code'] = Rental::generateRentalCode();
            
            // Calculate total based on rental type
            switch ($data['rental_type']) {
                case 'weekly':
                    $weeks = ceil($duration / 7);
                    $rate = $data['weekly_rate'] ?? ($data['daily_rate'] * 7);
                    $data['total_amount'] = $rate * $weeks;
                    break;
                case 'monthly':
                    $months = ceil($duration / 30);
                    $rate = $data['monthly_rate'] ?? ($data['daily_rate'] * 30);
                    $data['total_amount'] = $rate * $months;
                    break;
                default: // daily
                    $data['total_amount'] = $data['daily_rate'] * $duration;
                    break;
            }
            
            // Set start odometer
            $vehicle = Vehicle::find($data['vehicle_id']);
            $data['start_odometer'] = $vehicle->getLatestOdometer();
            
            Rental::create($data);
        }
        
        $this->command->info('Created ' . count($rentalData) . ' rental records with different types.');
    }
}
