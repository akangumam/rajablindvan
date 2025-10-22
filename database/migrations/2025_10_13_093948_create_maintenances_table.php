<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->date('maintenance_date'); // Tanggal service
            $table->decimal('odometer', 12, 2); // Kilometer saat service
            $table->string('type'); // Jenis maintenance (Service Berkala, Ganti Oli, dll)
            $table->string('category')->default('Routine'); // Kategori (Routine, Repair, Emergency)
            $table->text('description'); // Deskripsi pekerjaan
            $table->string('workshop')->nullable(); // Bengkel/tempat service
            $table->decimal('cost', 10, 2); // Biaya service
            $table->date('next_maintenance_date')->nullable(); // Tanggal service berikutnya
            $table->decimal('next_maintenance_odometer', 12, 2)->nullable(); // KM service berikutnya
            $table->text('parts_replaced')->nullable(); // Sparepart yang diganti
            $table->string('status')->default('Completed'); // Status (Completed, Scheduled, Overdue)
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
