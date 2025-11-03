<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // SQLite doesn't support ALTER COLUMN directly, so we need to recreate the table
        // But since we already have data, we'll use raw SQL to modify the check constraint
        
        // For SQLite: Drop the old table and recreate with new enum values
        Schema::table('orders', function (Blueprint $table) {
            // This approach won't work for SQLite with existing data
            // We need to use a different strategy
        });
        
        // Alternative: Use DB::statement for SQLite
        DB::statement("
            CREATE TABLE orders_new (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                vehicle_id INTEGER NOT NULL,
                customer_id INTEGER NOT NULL,
                rental_type TEXT CHECK(rental_type IN ('Sewa Harian', 'Sewa Bulanan')) NOT NULL,
                start_date DATE NOT NULL,
                end_date DATE NOT NULL,
                status TEXT CHECK(status IN ('Active', 'Inactive', 'Completed', 'Cancelled')) NOT NULL DEFAULT 'Active',
                completed_at DATETIME,
                created_at DATETIME,
                updated_at DATETIME,
                FOREIGN KEY (vehicle_id) REFERENCES vehicles (id) ON DELETE CASCADE,
                FOREIGN KEY (customer_id) REFERENCES customers (id) ON DELETE CASCADE
            )
        ");
        
        DB::statement("INSERT INTO orders_new SELECT * FROM orders");
        DB::statement("DROP TABLE orders");
        DB::statement("ALTER TABLE orders_new RENAME TO orders");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to old enum values
        DB::statement("
            CREATE TABLE orders_new (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                vehicle_id INTEGER NOT NULL,
                customer_id INTEGER NOT NULL,
                rental_type TEXT CHECK(rental_type IN ('Sewa Harian', 'Sewa Bulanan')) NOT NULL,
                start_date DATE NOT NULL,
                end_date DATE NOT NULL,
                status TEXT CHECK(status IN ('Active', 'Inactive')) NOT NULL DEFAULT 'Active',
                created_at DATETIME,
                updated_at DATETIME,
                FOREIGN KEY (vehicle_id) REFERENCES vehicles (id) ON DELETE CASCADE,
                FOREIGN KEY (customer_id) REFERENCES customers (id) ON DELETE CASCADE
            )
        ");
        
        DB::statement("INSERT INTO orders_new (id, vehicle_id, customer_id, rental_type, start_date, end_date, status, created_at, updated_at) 
                       SELECT id, vehicle_id, customer_id, rental_type, start_date, end_date, status, created_at, updated_at FROM orders");
        DB::statement("DROP TABLE orders");
        DB::statement("ALTER TABLE orders_new RENAME TO orders");
    }
};
