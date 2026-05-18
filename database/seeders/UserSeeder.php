<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Location;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $jakartaLocation = Location::where('code', 'JKT')->first();
        $bekasiLocation = Location::where('code', 'BKS')->first();

        $users = [
            // Super Admin - can access all locations
            [
                'name' => 'Super Admin',
                'email' => 'admin@carrental.com',
                'phone' => '+62 812 3456 7890',
                'role' => 'admin',
                'location_id' => null, // Admin can access all locations
                'is_active' => true,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            
            // Jakarta Location Team
            [
                'name' => 'Budi Santoso',
                'email' => 'manager.jakarta@carrental.com',
                'phone' => '+62 813 1111 2222',
                'role' => 'manager',
                'location_id' => $jakartaLocation->id,
                'is_active' => true,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Andi Wijaya',
                'email' => 'staff1.jakarta@carrental.com',
                'phone' => '+62 814 1111 3333',
                'role' => 'staff',
                'location_id' => $jakartaLocation->id,
                'is_active' => true,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Rina Sari',
                'email' => 'staff2.jakarta@carrental.com',
                'phone' => '+62 815 1111 4444',
                'role' => 'staff',
                'location_id' => $jakartaLocation->id,
                'is_active' => true,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            
            // Bekasi Location Team
            [
                'name' => 'Sari Indahwati',
                'email' => 'manager.bekasi@carrental.com',
                'phone' => '+62 816 2222 5555',
                'role' => 'manager',
                'location_id' => $bekasiLocation->id,
                'is_active' => true,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Dedi Kurniawan',
                'email' => 'staff1.bekasi@carrental.com',
                'phone' => '+62 817 2222 6666',
                'role' => 'staff',
                'location_id' => $bekasiLocation->id,
                'is_active' => true,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Maya Putri',
                'email' => 'staff2.bekasi@carrental.com',
                'phone' => '+62 818 2222 7777',
                'role' => 'staff',
                'location_id' => $bekasiLocation->id,
                'is_active' => true,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
