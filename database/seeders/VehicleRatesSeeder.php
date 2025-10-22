<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vehicle;

class VehicleRatesSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $vehicles = Vehicle::all();
        
        foreach ($vehicles as $vehicle) {
            $dailyRate = 300000; // Base daily rate
            
            // Different rates based on vehicle brand/type
            if (str_contains(strtolower($vehicle->brand), 'toyota')) {
                $dailyRate = 350000;
            } elseif (str_contains(strtolower($vehicle->brand), 'honda')) {
                $dailyRate = 320000;
            } elseif (str_contains(strtolower($vehicle->brand), 'suzuki')) {
                $dailyRate = 280000;
            }
            
            // Calculate weekly and monthly rates with discounts
            $weeklyRate = $dailyRate * 6.5; // 7.5% discount for weekly
            $monthlyRate = $dailyRate * 25; // 16.7% discount for monthly
            
            $vehicle->update([
                'daily_rental_rate' => $dailyRate,
                'weekly_rental_rate' => $weeklyRate,
                'monthly_rental_rate' => $monthlyRate
            ]);
        }
    }
}
