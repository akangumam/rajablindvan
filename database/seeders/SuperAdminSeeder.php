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
            ['email' => 'admin@rajablindvan.com'],
            [
                'name' => 'Administrator',
                'first_name' => 'Admin',
                'last_name' => 'Rajablindvan',
                'password' => Hash::make('admin123'),
                'role' => 'super_admin',
                'user_type' => 'admin',
                'title' => 'Administrator',
                'phone' => '081234567890',
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
                'last_name' => 'Rajablindvan',
                'password' => Hash::make('sales123'),
                'role' => 'manager',
                'user_type' => 'manager',
                'title' => 'Sales',
                'phone' => '081234567891',
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
                'last_name' => 'Rajablindvan',
                'password' => Hash::make('operation123'),
                'role' => 'operator',
                'user_type' => 'driver',
                'title' => 'Operation',
                'phone' => '081234567892',
                'is_active' => true,
                'status' => 'active',
                'is_verified' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
