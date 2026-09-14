<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create Administrator (Full Access - previously Super Admin)
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@rajablindvan.com')],
            [
                'name' => 'Administrator',
                'first_name' => 'Admin',
                'last_name' => 'System',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'admin123')),
                'role' => 'super_admin',
                'user_type' => 'admin',
                'title' => 'Administrator',
                'phone' => '080000000000',
                'is_active' => true,
                'status' => 'active',
                'is_verified' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create Sales User
        User::updateOrCreate(
            ['email' => 'sales@rajablindvan.com'],
            [
                'name' => 'Sales Team',
                'first_name' => 'Sales',
                'last_name' => 'Demo',
                'password' => Hash::make('sales123'),
                'role' => 'manager',
                'user_type' => 'manager',
                'title' => 'Sales',
                'phone' => '080000000001',
                'is_active' => true,
                'status' => 'active',
                'is_verified' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create Operation User
        User::updateOrCreate(
            ['email' => 'operation@rajablindvan.com'],
            [
                'name' => 'Operation Team',
                'first_name' => 'Operation',
                'last_name' => 'Demo',
                'password' => Hash::make('operation123'),
                'role' => 'operator',
                'user_type' => 'driver',
                'title' => 'Operation',
                'phone' => '080000000002',
                'is_active' => true,
                'status' => 'active',
                'is_verified' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
