<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'sqlite') {
            DB::statement("
                CREATE TABLE orders_new (
                    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                    vehicle_id INTEGER NOT NULL,
                    customer_id INTEGER NOT NULL,
                    rental_type TEXT CHECK(rental_type IN ('Sewa Harian', 'Sewa Bulanan')) NOT NULL,
                    start_date DATE NOT NULL,
                    end_date DATE NOT NULL,
                    status TEXT CHECK(status IN ('active', 'inactive', 'completed', 'cancelled')) NOT NULL DEFAULT 'active',
                    completed_at DATETIME,
                    created_at DATETIME,
                    updated_at DATETIME,
                    FOREIGN KEY (vehicle_id) REFERENCES vehicles (id) ON DELETE CASCADE,
                    FOREIGN KEY (customer_id) REFERENCES customers (id) ON DELETE CASCADE
                )
            ");

            DB::statement("
                INSERT INTO orders_new (id, vehicle_id, customer_id, rental_type, start_date, end_date, status, completed_at, created_at, updated_at)
                SELECT
                    id, vehicle_id, customer_id, rental_type, start_date, end_date,
                    CASE
                        WHEN status = 'Active' THEN 'active'
                        WHEN status = 'Inactive' THEN 'completed'
                        WHEN status = 'Completed' THEN 'completed'
                        WHEN status = 'Cancelled' THEN 'cancelled'
                        ELSE LOWER(status)
                    END,
                    completed_at, created_at, updated_at
                FROM orders
            ");

            DB::statement("DROP TABLE orders");
            DB::statement("ALTER TABLE orders_new RENAME TO orders");
        } else {
            DB::statement("
                UPDATE orders SET status = CASE
                    WHEN status = 'Active' THEN 'active'
                    WHEN status = 'Inactive' THEN 'completed'
                    WHEN status = 'Completed' THEN 'completed'
                    WHEN status = 'Cancelled' THEN 'cancelled'
                    ELSE LOWER(status)
                END
            ");

            DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('active','inactive','completed','cancelled') NOT NULL DEFAULT 'active'");
        }
    }

    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'sqlite') {
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

            DB::statement("
                INSERT INTO orders_new (id, vehicle_id, customer_id, rental_type, start_date, end_date, status, completed_at, created_at, updated_at)
                SELECT
                    id, vehicle_id, customer_id, rental_type, start_date, end_date,
                    CASE
                        WHEN status = 'active' THEN 'Active'
                        WHEN status = 'completed' THEN 'Completed'
                        WHEN status = 'cancelled' THEN 'Cancelled'
                        WHEN status = 'inactive' THEN 'Inactive'
                        ELSE 'Active'
                    END,
                    completed_at, created_at, updated_at
                FROM orders
            ");

            DB::statement("DROP TABLE orders");
            DB::statement("ALTER TABLE orders_new RENAME TO orders");
        } else {
            DB::statement("
                UPDATE orders SET status = CASE
                    WHEN status = 'active' THEN 'Active'
                    WHEN status = 'completed' THEN 'Completed'
                    WHEN status = 'cancelled' THEN 'Cancelled'
                    ELSE 'Inactive'
                END
            ");

            DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('Active','Inactive','Completed','Cancelled') NOT NULL DEFAULT 'Active'");
        }
    }
};
