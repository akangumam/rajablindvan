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
                'name' => 'PT. Maju Jaya Transport',
                'company_name' => 'PT. Maju Jaya Transport',
                'company_address' => 'Jl. Sudirman No. 123, RT 01/RW 05, Kelurahan Sudirman, Kecamatan Pusat, Jakarta Selatan 12190',
                'pic_name' => 'Ahmad Budiman',
                'contact_number' => '081234567890',
                'phone' => '081234567890',
                'is_active' => true
            ],
            [
                'name' => 'CV. Berkah Logistik',
                'company_name' => 'CV. Berkah Logistik',
                'company_address' => 'Jl. Gatot Subroto No. 45, RT 02/RW 03, Kelurahan Gatsu, Kecamatan Timur, Jakarta Timur 13220',
                'pic_name' => 'Sari Dewi',
                'contact_number' => '082345678901',
                'phone' => '082345678901',
                'is_active' => true
            ],
            [
                'name' => 'UD. Sentosa Jaya',
                'company_name' => 'UD. Sentosa Jaya',
                'company_address' => 'Jl. Thamrin No. 78, RT 03/RW 04, Kelurahan Thamrin, Kecamatan Barat, Jakarta Barat 11340',
                'pic_name' => 'Joko Santoso',
                'contact_number' => '083456789012',
                'phone' => '083456789012',
                'is_active' => true
            ],
            [
                'name' => 'PT. Global Ekspedisi',
                'company_name' => 'PT. Global Ekspedisi',
                'company_address' => 'Jl. Rasuna Said No. 12, RT 04/RW 02, Kelurahan Kuningan, Kecamatan Selatan, Jakarta Selatan 12940',
                'pic_name' => 'Rina Kartika',
                'contact_number' => '084567890123',
                'phone' => '084567890123',
                'is_active' => true
            ],
            [
                'name' => 'CV. Mandiri Cargo',
                'company_name' => 'CV. Mandiri Cargo',
                'company_address' => 'Jl. HR Rasuna Said No. 99, RT 05/RW 01, Kelurahan Setia Budi, Kecamatan Utara, Jakarta Utara 14350',
                'pic_name' => 'Bambang Suryadi',
                'contact_number' => '085678901234',
                'phone' => '085678901234',
                'is_active' => true
            ]
        ];

        foreach ($customers as $customerData) {
            Customer::create($customerData);
        }
    }
}
