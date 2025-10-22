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
        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('category'); // Service, Tax, Insurance, License, Inspection
            $table->date('due_date');
            $table->decimal('due_odometer', 10, 2)->nullable();
            $table->integer('advance_notice_days')->default(7); // Alert X days before
            $table->boolean('is_recurring')->default(false);
            $table->string('recurring_interval')->nullable(); // Monthly, Quarterly, Yearly
            $table->decimal('estimated_cost', 12, 2)->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_completed')->default(false);
            $table->date('completed_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminders');
    }
};
