<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Expense;
use Carbon\Carbon;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Fuel', 'Maintenance', 'Insurance', 'Tax', 'Parking', 'Repair', 'Supplies'];
        $vehicleIds = \App\Models\Vehicle::pluck('id')->toArray();
        
        // Create expenses for the last 6 months
        for ($i = 0; $i < 50; $i++) {
            Expense::create([
                'vehicle_id' => $vehicleIds[array_rand($vehicleIds)],
                'expense_date' => Carbon::now()->subDays(rand(1, 180))->format('Y-m-d'),
                'category' => $categories[array_rand($categories)],
                'description' => 'Sample expense description ' . ($i + 1),
                'amount' => rand(50000, 2000000), // 50k - 2M rupiah
                'vendor' => 'Vendor ' . ($i + 1),
                'payment_method' => ['Cash', 'Transfer', 'Credit Card'][array_rand(['Cash', 'Transfer', 'Credit Card'])],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
