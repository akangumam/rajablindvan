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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->date('trip_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->decimal('start_odometer', 10, 2);
            $table->decimal('end_odometer', 10, 2)->nullable();
            $table->decimal('distance', 10, 2)->nullable(); // Calculated from odometers
            $table->string('start_location')->nullable();
            $table->string('end_location')->nullable();
            $table->string('driver')->nullable();
            $table->string('purpose')->nullable(); // Business, Personal, etc.
            $table->string('route_type')->nullable(); // Highway, City, Mixed
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
