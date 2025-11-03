<?php

namespace Database\Seeders;

use App\Models\Reminder;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ReminderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada vehicles dulu
        $vehicles = Vehicle::all();
        
        if ($vehicles->isEmpty()) {
            $this->command->warn('No vehicles found. Please run VehicleSeeder first.');
            return;
        }

        $categories = ['Oil Change', 'Tire Rotation', 'Insurance Renewal', 'Registration Renewal', 'Inspection', 'Battery Check', 'Brake Service'];
        
        $reminders = [
            [
                'vehicle_id' => $vehicles->first()->id,
                'title' => 'Ganti Oli Mesin',
                'category' => 'Oil Change',
                'due_date' => Carbon::now()->addDays(15),
                'due_odometer' => 15000,
                'advance_notice_days' => 7,
                'is_recurring' => true,
                'recurring_interval' => '3_months',
                'estimated_cost' => 500000,
                'description' => 'Ganti oli mesin rutin setiap 3 bulan atau 5000 km',
                'is_completed' => false,
                'notes' => 'Gunakan oli SAE 10W-40',
            ],
            [
                'vehicle_id' => $vehicles->first()->id,
                'title' => 'Perpanjang STNK',
                'category' => 'Registration Renewal',
                'due_date' => Carbon::now()->addDays(30),
                'advance_notice_days' => 14,
                'is_recurring' => true,
                'recurring_interval' => '1_year',
                'estimated_cost' => 350000,
                'description' => 'Perpanjangan STNK tahunan',
                'is_completed' => false,
                'notes' => 'Siapkan KTP, BPKB, STNK lama',
            ],
            [
                'vehicle_id' => $vehicles->skip(1)->first()->id ?? $vehicles->first()->id,
                'title' => 'Rotasi Ban',
                'category' => 'Tire Rotation',
                'due_date' => Carbon::now()->addDays(20),
                'due_odometer' => 20000,
                'advance_notice_days' => 5,
                'is_recurring' => true,
                'recurring_interval' => '6_months',
                'estimated_cost' => 200000,
                'description' => 'Rotasi ban untuk meratakan keausan',
                'is_completed' => false,
            ],
            [
                'vehicle_id' => $vehicles->skip(1)->first()->id ?? $vehicles->first()->id,
                'title' => 'Cek Rem',
                'category' => 'Brake Service',
                'due_date' => Carbon::now()->addDays(10),
                'advance_notice_days' => 3,
                'is_recurring' => false,
                'estimated_cost' => 800000,
                'description' => 'Cek kondisi kampas rem dan minyak rem',
                'is_completed' => false,
                'notes' => 'Terakhir diganti 6 bulan lalu',
            ],
            [
                'vehicle_id' => $vehicles->skip(2)->first()->id ?? $vehicles->first()->id,
                'title' => 'Perpanjang Asuransi',
                'category' => 'Insurance Renewal',
                'due_date' => Carbon::now()->addDays(45),
                'advance_notice_days' => 30,
                'is_recurring' => true,
                'recurring_interval' => '1_year',
                'estimated_cost' => 3500000,
                'description' => 'Perpanjangan asuransi all risk',
                'is_completed' => false,
                'notes' => 'Hubungi agent: 081234567890',
            ],
            [
                'vehicle_id' => $vehicles->skip(2)->first()->id ?? $vehicles->first()->id,
                'title' => 'Service Besar 40.000 km',
                'category' => 'Inspection',
                'due_date' => Carbon::now()->addDays(60),
                'due_odometer' => 40000,
                'advance_notice_days' => 14,
                'is_recurring' => false,
                'estimated_cost' => 2500000,
                'description' => 'Service besar meliputi ganti oli, filter, tune up',
                'is_completed' => false,
            ],
            [
                'vehicle_id' => $vehicles->skip(3)->first()->id ?? $vehicles->first()->id,
                'title' => 'Cek Aki',
                'category' => 'Battery Check',
                'due_date' => Carbon::now()->addDays(7),
                'advance_notice_days' => 3,
                'is_recurring' => true,
                'recurring_interval' => '6_months',
                'estimated_cost' => 150000,
                'description' => 'Cek kondisi aki dan air aki',
                'is_completed' => false,
            ],
            [
                'vehicle_id' => $vehicles->skip(4)->first()->id ?? $vehicles->first()->id,
                'title' => 'Ganti Filter Udara',
                'category' => 'Inspection',
                'due_date' => Carbon::now()->addDays(25),
                'due_odometer' => 25000,
                'advance_notice_days' => 7,
                'is_recurring' => true,
                'recurring_interval' => '6_months',
                'estimated_cost' => 350000,
                'description' => 'Ganti filter udara dan filter AC',
                'is_completed' => false,
            ],
            // Completed reminders (untuk testing)
            [
                'vehicle_id' => $vehicles->first()->id,
                'title' => 'Ganti Oli Mesin (Completed)',
                'category' => 'Oil Change',
                'due_date' => Carbon::now()->subDays(10),
                'due_odometer' => 10000,
                'advance_notice_days' => 7,
                'is_recurring' => true,
                'recurring_interval' => '3_months',
                'estimated_cost' => 500000,
                'description' => 'Ganti oli mesin rutin',
                'is_completed' => true,
                'completed_date' => Carbon::now()->subDays(5),
                'notes' => 'Sudah selesai dikerjakan',
            ],
            [
                'vehicle_id' => $vehicles->skip(1)->first()->id ?? $vehicles->first()->id,
                'title' => 'Servis AC (Completed)',
                'category' => 'Inspection',
                'due_date' => Carbon::now()->subDays(5),
                'advance_notice_days' => 3,
                'is_recurring' => false,
                'estimated_cost' => 450000,
                'description' => 'Servis AC dan tambah freon',
                'is_completed' => true,
                'completed_date' => Carbon::now()->subDays(2),
                'notes' => 'AC sudah dingin kembali',
            ],
        ];

        foreach ($reminders as $reminder) {
            Reminder::create($reminder);
        }

        $this->command->info('✅ Created ' . count($reminders) . ' reminders successfully!');
    }
}
