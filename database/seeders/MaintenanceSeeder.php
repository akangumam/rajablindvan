<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaintenanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicles = \App\Models\Vehicle::all();
        
        $maintenanceTypes = ['Service Berkala', 'Ganti Oli', 'Tune Up', 'Ganti Ban', 'Service AC', 'Service Rem'];
        $categories = ['Routine', 'Repair', 'Emergency'];
        $workshops = ['Honda Bintaro', 'Auto2000', 'Bengkel Jaya', 'Service Center ABC'];
        
        foreach ($vehicles as $vehicle) {
            // Create some maintenance records
            for ($i = 0; $i < 3; $i++) {
                $maintenanceDate = now()->subDays(rand(10, 90));
                $type = $maintenanceTypes[array_rand($maintenanceTypes)];
                $category = $categories[array_rand($categories)];
                
                \App\Models\Maintenance::create([
                    'vehicle_id' => $vehicle->id,
                    'maintenance_date' => $maintenanceDate,
                    'odometer' => $vehicle->odometer + rand(1000, 5000),
                    'type' => $type,
                    'category' => $category,
                    'description' => "Service {$type} - pemeriksaan rutin dan penggantian sparepart sesuai kebutuhan",
                    'workshop' => $workshops[array_rand($workshops)],
                    'cost' => rand(200000, 1500000),
                    'next_maintenance_date' => $maintenanceDate->copy()->addMonths(rand(3, 6)),
                    'next_maintenance_odometer' => $vehicle->odometer + rand(8000, 15000),
                    'parts_replaced' => $this->getRandomParts($type),
                    'status' => 'Completed',
                    'notes' => 'Service completed successfully, all systems checked and working properly'
                ]);
            }
        }
    }
    
    private function getRandomParts($type): string
    {
        $parts = [
            'Service Berkala' => 'Oli mesin, Filter oli, Filter udara',
            'Ganti Oli' => 'Oli mesin 4L, Filter oli',
            'Tune Up' => 'Busi, Filter udara, Filter bensin',
            'Ganti Ban' => 'Ban depan 2 buah',
            'Service AC' => 'Freon R134a, Filter AC',
            'Service Rem' => 'Minyak rem, Kampas rem depan'
        ];
        
        return $parts[$type] ?? 'Berbagai sparepart sesuai kebutuhan';
    }
}
