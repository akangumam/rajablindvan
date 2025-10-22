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
        Schema::table('vehicles', function (Blueprint $table) {
            $table->decimal('daily_rental_rate', 12, 2)->nullable()->after('purchase_date');
            $table->decimal('weekly_rental_rate', 12, 2)->nullable()->after('daily_rental_rate');
            $table->decimal('monthly_rental_rate', 12, 2)->nullable()->after('weekly_rental_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn(['daily_rental_rate', 'weekly_rental_rate', 'monthly_rental_rate']);
        });
    }
};
