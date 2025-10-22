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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('rental_code')->unique(); // RNT-001
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('start_odometer', 10, 2);
            $table->decimal('end_odometer', 10, 2)->nullable();
            $table->decimal('daily_rate', 10, 2); // tarif per hari
            $table->integer('duration_days');
            $table->decimal('total_amount', 12, 2);
            $table->decimal('deposit', 12, 2)->default(0);
            $table->decimal('additional_charges', 12, 2)->default(0); // biaya tambahan
            $table->text('additional_charges_notes')->nullable();
            $table->enum('status', ['reserved', 'active', 'completed', 'cancelled'])->default('reserved');
            $table->text('pickup_location')->nullable();
            $table->text('return_location')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('actual_start_time')->nullable();
            $table->timestamp('actual_end_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
