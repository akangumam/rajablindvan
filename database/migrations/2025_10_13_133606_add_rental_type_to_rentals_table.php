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
        Schema::table('rentals', function (Blueprint $table) {
            $table->enum('rental_type', ['daily', 'weekly', 'monthly'])->default('daily')->after('rental_code');
            $table->decimal('weekly_rate', 12, 2)->nullable()->after('daily_rate');
            $table->decimal('monthly_rate', 12, 2)->nullable()->after('weekly_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn(['rental_type', 'weekly_rate', 'monthly_rate']);
        });
    }
};
