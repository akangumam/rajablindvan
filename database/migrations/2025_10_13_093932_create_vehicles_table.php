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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama kendaraan/nickname
            $table->string('brand'); // Merek (Toyota, Honda, dll)
            $table->string('model'); // Model (Avanza, Jazz, dll)
            $table->string('year'); // Tahun pembuatan
            $table->string('license_plate')->unique(); // Plat nomor
            $table->string('engine_type')->default('Gasoline'); // Jenis mesin
            $table->string('transmission')->default('Manual'); // Transmisi
            $table->decimal('tank_capacity', 8, 2)->nullable(); // Kapasitas tangki (liter)
            $table->decimal('odometer', 12, 2)->default(0); // Kilometer saat ini
            $table->string('color')->nullable(); // Warna kendaraan
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->boolean('is_active')->default(true); // Status aktif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
