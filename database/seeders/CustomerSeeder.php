<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $customers = [
            [
                'name' => 'Ahmad Budiman',
                'phone' => '081234567890',
                'email' => 'ahmad.budiman@email.com',
                'id_number' => '3201234567890001',
                'address' => 'Jl. Merdeka No. 123, RT 01/RW 05, Kelurahan Merdeka, Kecamatan Pusat, Jakarta',
                'birth_date' => '1985-03-15',
                'gender' => 'male',
                'emergency_contact' => 'Siti Budiman',
                'emergency_phone' => '082345678901',
                'notes' => 'Customer reguler, pembayaran lancar',
                'is_active' => true
            ],
            [
                'name' => 'Sari Dewi',
                'phone' => '082345678901',
                'email' => 'sari.dewi@email.com',
                'id_number' => '3201234567890002',
                'address' => 'Jl. Anggrek No. 45, RT 02/RW 03, Kelurahan Anggrek, Kecamatan Timur, Jakarta',
                'birth_date' => '1990-07-20',
                'gender' => 'female',
                'emergency_contact' => 'Budi Dewi',
                'emergency_phone' => '083456789012',
                'notes' => 'Memerlukan pickup/drop service',
                'is_active' => true
            ],
            [
                'name' => 'Joko Santoso',
                'phone' => '083456789012',
                'email' => null,
                'id_number' => '3201234567890003',
                'address' => 'Jl. Mawar No. 78, RT 03/RW 04, Kelurahan Mawar, Kecamatan Barat, Jakarta',
                'birth_date' => '1988-12-10',
                'gender' => 'male',
                'emergency_contact' => 'Sri Santoso',
                'emergency_phone' => '084567890123',
                'notes' => 'Rental jangka panjang',
                'is_active' => true
            ],
            [
                'name' => 'Rina Kartika',
                'phone' => '084567890123',
                'email' => 'rina.kartika@email.com',
                'id_number' => '3201234567890004',
                'address' => 'Jl. Melati No. 12, RT 04/RW 02, Kelurahan Melati, Kecamatan Selatan, Jakarta',
                'birth_date' => '1992-05-25',
                'gender' => 'female',
                'emergency_contact' => 'Doni Kartika',
                'emergency_phone' => '085678901234',
                'notes' => 'Memiliki SIM A dan B',
                'is_active' => true
            ],
            [
                'name' => 'Bambang Suryadi',
                'phone' => '085678901234',
                'email' => 'bambang.suryadi@email.com',
                'id_number' => '3201234567890005',
                'address' => 'Jl. Dahlia No. 99, RT 05/RW 01, Kelurahan Dahlia, Kecamatan Utara, Jakarta',
                'birth_date' => '1980-11-08',
                'gender' => 'male',
                'emergency_contact' => 'Lisa Suryadi',
                'emergency_phone' => '086789012345',
                'notes' => 'Pengalaman mengemudi 20 tahun',
                'is_active' => true
            ]
        ];

        foreach ($customers as $customerData) {
            Customer::create($customerData);
        }
    }
}
