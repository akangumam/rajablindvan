<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;
use App\Models\Expense;
use App\Models\Location;
use Illuminate\Support\Facades\DB;

class AssignLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get locations
        $jakarta = Location::where('code', 'JKT')->first();
        $bekasi = Location::where('code', 'BKS')->first();
        
        if (!$jakarta || !$bekasi) {
            $this->command->error('Locations not found! Please run LocationSeeder first.');
            $this->command->info('Run: php artisan db:seed --class=LocationSeeder');
            return;
        }
        
        $this->command->info("Jakarta ID: {$jakarta->id}");
        $this->command->info("Bekasi ID: {$bekasi->id}");
        
        // Get vehicles without location
        $vehiclesWithoutLocation = Vehicle::whereNull('location_id')->get();
        $totalVehicles = $vehiclesWithoutLocation->count();
        
        if ($totalVehicles == 0) {
            $this->command->info('All vehicles already have location assigned.');
        } else {
            $this->command->info("Found {$totalVehicles} vehicles without location. Assigning...");
            
            // Split vehicles 50/50 between Jakarta and Bekasi
            $halfway = (int) ceil($totalVehicles / 2);
            
            foreach ($vehiclesWithoutLocation as $index => $vehicle) {
                // First half -> Jakarta, second half -> Bekasi
                $locationId = ($index < $halfway) ? $jakarta->id : $bekasi->id;
                $locationName = ($index < $halfway) ? 'Jakarta Pusat' : 'Bekasi Timur';
                
                $vehicle->location_id = $locationId;
                $vehicle->save();
                
                $this->command->info("  ✓ Vehicle #{$vehicle->id} ({$vehicle->name}) -> {$locationName}");
            }
            
            $this->command->info("\n✅ Assigned {$totalVehicles} vehicles to locations");
        }
        
        // Get expenses without location
        $expensesWithoutLocation = Expense::whereNull('location_id')->get();
        $totalExpenses = $expensesWithoutLocation->count();
        
        if ($totalExpenses == 0) {
            $this->command->info('All expenses already have location assigned.');
        } else {
            $this->command->info("\nFound {$totalExpenses} expenses without location. Assigning...");
            
            foreach ($expensesWithoutLocation as $expense) {
                // Get location from vehicle if exists
                if ($expense->vehicle_id) {
                    $vehicle = Vehicle::find($expense->vehicle_id);
                    if ($vehicle && $vehicle->location_id) {
                        $expense->location_id = $vehicle->location_id;
                        $expense->save();
                        
                        $locationName = $vehicle->location ? $vehicle->location->name : 'Unknown';
                        $this->command->info("  ✓ Expense #{$expense->id} -> {$locationName} (from vehicle #{$vehicle->id})");
                        continue;
                    }
                }
                
                // If no vehicle or vehicle has no location, assign randomly
                $locationId = (rand(0, 1) == 0) ? $jakarta->id : $bekasi->id;
                $locationName = ($locationId == $jakarta->id) ? 'Jakarta Pusat' : 'Bekasi Timur';
                
                $expense->location_id = $locationId;
                $expense->save();
                
                $this->command->info("  ✓ Expense #{$expense->id} -> {$locationName} (random)");
            }
            
            $this->command->info("\n✅ Assigned {$totalExpenses} expenses to locations");
        }
        
        // Summary
        $this->command->info("\n" . str_repeat('=', 50));
        $this->command->info('SUMMARY');
        $this->command->info(str_repeat('=', 50));
        
        $jakartaVehicles = Vehicle::where('location_id', $jakarta->id)->count();
        $bekasiVehicles = Vehicle::where('location_id', $bekasi->id)->count();
        $nullVehicles = Vehicle::whereNull('location_id')->count();
        
        $this->command->info("Vehicles in Jakarta Pusat: {$jakartaVehicles}");
        $this->command->info("Vehicles in Bekasi Timur: {$bekasiVehicles}");
        $this->command->info("Vehicles without location: {$nullVehicles}");
        
        $jakartaExpenses = Expense::where('location_id', $jakarta->id)->count();
        $bekasiExpenses = Expense::where('location_id', $bekasi->id)->count();
        $nullExpenses = Expense::whereNull('location_id')->count();
        
        $this->command->info("\nExpenses in Jakarta Pusat: {$jakartaExpenses}");
        $this->command->info("Expenses in Bekasi Timur: {$bekasiExpenses}");
        $this->command->info("Expenses without location: {$nullExpenses}");
    }
}
