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
        Schema::create('checklists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->date('check_date');
            $table->decimal('odometer', 10, 2)->nullable();
            $table->string('checklist_type'); // Pre-trip, Post-trip, Weekly, Monthly
            $table->boolean('tire_pressure')->default(false);
            $table->boolean('tire_condition')->default(false);
            $table->boolean('brake_system')->default(false);
            $table->boolean('lights')->default(false);
            $table->boolean('fluids')->default(false);
            $table->boolean('battery')->default(false);
            $table->boolean('wipers')->default(false);
            $table->boolean('mirrors')->default(false);
            $table->boolean('horn')->default(false);
            $table->boolean('seat_belts')->default(false);
            $table->boolean('emergency_kit')->default(false);
            $table->boolean('documents')->default(false);
            $table->string('checked_by')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checklists');
    }
};
