<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReferenceDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed Income Types
        \App\Models\IncomeType::create([
            'name' => 'Rental',
            'description' => 'Vehicle rental income',
            'is_active' => true
        ]);
        
        \App\Models\IncomeType::create([
            'name' => 'Transport Service',
            'description' => 'Transportation service income',
            'is_active' => true
        ]);
        
        \App\Models\IncomeType::create([
            'name' => 'Delivery Service',
            'description' => 'Delivery service income',
            'is_active' => true
        ]);
        
        \App\Models\IncomeType::create([
            'name' => 'Tour Service',
            'description' => 'Tour and travel service income',
            'is_active' => true
        ]);

        // Seed Service Types
        \App\Models\ServiceType::create([
            'name' => 'Oil Change',
            'description' => 'Engine oil change service',
            'is_active' => true
        ]);
        
        \App\Models\ServiceType::create([
            'name' => 'Tire Change',
            'description' => 'Tire replacement service',
            'is_active' => true
        ]);
        
        \App\Models\ServiceType::create([
            'name' => 'Brake Service',
            'description' => 'Brake system maintenance',
            'is_active' => true
        ]);
        
        \App\Models\ServiceType::create([
            'name' => 'Engine Service',
            'description' => 'Engine maintenance and repair',
            'is_active' => true
        ]);
        
        \App\Models\ServiceType::create([
            'name' => 'AC Service',
            'description' => 'Air conditioning maintenance',
            'is_active' => true
        ]);

        // Seed Expense Types
        \App\Models\ExpenseType::create([
            'name' => 'Fuel',
            'description' => 'Fuel expenses',
            'is_active' => true
        ]);
        
        \App\Models\ExpenseType::create([
            'name' => 'Maintenance',
            'description' => 'Vehicle maintenance expenses',
            'is_active' => true
        ]);
        
        \App\Models\ExpenseType::create([
            'name' => 'Insurance',
            'description' => 'Vehicle insurance expenses',
            'is_active' => true
        ]);
        
        \App\Models\ExpenseType::create([
            'name' => 'Tax & License',
            'description' => 'Tax and license expenses',
            'is_active' => true
        ]);
        
        \App\Models\ExpenseType::create([
            'name' => 'Parking & Toll',
            'description' => 'Parking and toll expenses',
            'is_active' => true
        ]);

        // Seed Payment Methods
        \App\Models\PaymentMethod::create([
            'name' => 'Cash',
            'description' => 'Cash payment',
            'is_active' => true
        ]);
        
        \App\Models\PaymentMethod::create([
            'name' => 'Bank Transfer',
            'description' => 'Bank transfer payment',
            'is_active' => true
        ]);
        
        \App\Models\PaymentMethod::create([
            'name' => 'Credit Card',
            'description' => 'Credit card payment',
            'is_active' => true
        ]);
        
        \App\Models\PaymentMethod::create([
            'name' => 'Debit Card',
            'description' => 'Debit card payment',
            'is_active' => true
        ]);
        
        \App\Models\PaymentMethod::create([
            'name' => 'E-Wallet',
            'description' => 'Digital wallet payment (OVO, GoPay, DANA, etc)',
            'is_active' => true
        ]);
        
        \App\Models\PaymentMethod::create([
            'name' => 'Check',
            'description' => 'Check payment',
            'is_active' => true
        ]);
    }
}
