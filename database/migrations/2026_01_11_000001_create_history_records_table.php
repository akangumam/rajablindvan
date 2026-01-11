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
        Schema::create('history_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade');
            $table->string('type', 50); // refueling, oil_change, service, registration, etc.
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->decimal('cost', 15, 2)->nullable();
            $table->integer('odometer')->nullable();
            $table->date('date');
            $table->json('extra_data')->nullable();
            $table->foreignId('related_id')->nullable(); // ID dari tabel asli (fuel_fills, maintenances, dll)
            $table->string('related_type')->nullable(); // Tipe model asli
            $table->timestamps();

            // Indexes
            $table->index('vehicle_id');
            $table->index('type');
            $table->index('date');
            $table->index(['related_id', 'related_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_records');
    }
};
