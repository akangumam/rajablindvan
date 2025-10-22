<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FuelFillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicles = \App\Models\Vehicle::all();
        
        foreach ($vehicles as $vehicle) {
            // Create some fuel fill records
            for ($i = 0; $i < 5; $i++) {
                $baseOdometer = $vehicle->odometer + ($i * 500);
                
                \App\Models\FuelFill::create([
                    'vehicle_id' => $vehicle->id,
                    'fill_date' => now()->subDays(rand(1, 30)),
                    'odometer' => $baseOdometer + rand(0, 100),
                    'liters' => rand(30, 50),
                    'price_per_liter' => rand(10000, 13000),
                    'total_cost' => 0, // Will be calculated
                    'fuel_type' => collect(['Pertalite', 'Pertamax', 'Premium'])->random(),
                    'gas_station' => collect(['Pertamina', 'Shell', 'Total', 'BP'])->random(),
                    'is_full_tank' => true,
                    'notes' => 'Data contoh untuk testing'
                ]);
            }
        }
        
        // Recalculate fuel efficiency for all records
        $fuelFills = \App\Models\FuelFill::orderBy('vehicle_id')->orderBy('odometer')->get();
        
        foreach ($fuelFills as $fuel) {
            $fuel->total_cost = $fuel->liters * $fuel->price_per_liter;
            
            $lastFill = \App\Models\FuelFill::where('vehicle_id', $fuel->vehicle_id)
                ->where('odometer', '<', $fuel->odometer)
                ->orderBy('odometer', 'desc')
                ->first();
                
            if ($lastFill) {
                $fuel->trip_distance = $fuel->odometer - $lastFill->odometer;
                if ($lastFill->liters > 0) {
                    $fuel->fuel_efficiency = $fuel->trip_distance / $lastFill->liters;
                }
            }
            
            $fuel->save();
        }
    }
}
