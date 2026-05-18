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
            ['email' => env('ADMIN_EMAIL', 'admin@example.com')],
            [
                'name' => 'Administrator',
                'first_name' => 'Admin',
                'last_name' => 'System',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'password')),
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
            ['email' => 'sales@example.com'],
            [
                'name' => 'Sales Team',
                'first_name' => 'Sales',
                'last_name' => 'Demo',
                'password' => Hash::make('password'),
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
            ['email' => 'operation@example.com'],
            [
                'name' => 'Operation Team',
                'first_name' => 'Operation',
                'last_name' => 'Demo',
                'password' => Hash::make('password'),
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
