<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Vehicle;
use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicles = Vehicle::all();
        $customers = Customer::all();

        if ($vehicles->isEmpty() || $customers->isEmpty()) {
            $this->command->warn('Please run VehicleSeeder and CustomerSeeder first!');
            return;
        }

        $orders = [
            // Sewa Harian - akan berwarna hijau
            [
                'vehicle_id' => $vehicles->random()->id,
                'customer_id' => $customers->random()->id,
                'rental_type' => 'Sewa Harian',
                'start_date' => Carbon::now()->subDays(2),
                'end_date' => Carbon::now()->addDays(1),
                'status' => Order::STATUS_ACTIVE,
            ],
            [
                'vehicle_id' => $vehicles->random()->id,
                'customer_id' => $customers->random()->id,
                'rental_type' => 'Sewa Harian',
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(3),
                'status' => Order::STATUS_ACTIVE,
            ],
            
            // Sewa Bulanan - akan jatuh tempo dalam 5 hari (kuning)
            [
                'vehicle_id' => $vehicles->random()->id,
                'customer_id' => $customers->random()->id,
                'rental_type' => 'Sewa Bulanan',
                'start_date' => Carbon::now()->subDays(25),
                'end_date' => Carbon::now()->addDays(5),
                'status' => Order::STATUS_ACTIVE,
            ],
            
            // Sewa Bulanan - sudah lewat jatuh tempo (merah)
            [
                'vehicle_id' => $vehicles->random()->id,
                'customer_id' => $customers->random()->id,
                'rental_type' => 'Sewa Bulanan',
                'start_date' => Carbon::now()->subMonths(2),
                'end_date' => Carbon::now()->subDays(3),
                'status' => Order::STATUS_ACTIVE,
            ],
            
            // Sewa Bulanan - masih aman (hijau)
            [
                'vehicle_id' => $vehicles->random()->id,
                'customer_id' => $customers->random()->id,
                'rental_type' => 'Sewa Bulanan',
                'start_date' => Carbon::now()->subDays(10),
                'end_date' => Carbon::now()->addDays(20),
                'status' => Order::STATUS_ACTIVE,
            ],
        ];

        foreach ($orders as $order) {
            Order::create($order);
        }

        $this->command->info('Order seeder completed successfully!');
    }
}
