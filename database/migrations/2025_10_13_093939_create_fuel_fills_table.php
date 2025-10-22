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
        Schema::create('fuel_fills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->date('fill_date'); // Tanggal isi bensin
            $table->decimal('odometer', 12, 2); // Kilometer saat isi
            $table->decimal('liters', 8, 2); // Jumlah liter
            $table->decimal('price_per_liter', 8, 2); // Harga per liter
            $table->decimal('total_cost', 10, 2); // Total biaya
            $table->string('fuel_type')->default('Premium'); // Jenis bahan bakar
            $table->string('gas_station')->nullable(); // SPBU
            $table->boolean('is_full_tank')->default(true); // Full tank atau tidak
            $table->decimal('trip_distance', 10, 2)->nullable(); // Jarak tempuh dari isi sebelumnya
            $table->decimal('fuel_efficiency', 8, 2)->nullable(); // Konsumsi BBM (km/l)
            $table->text('notes')->nullable(); // Catatan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuel_fills');
    }
};
