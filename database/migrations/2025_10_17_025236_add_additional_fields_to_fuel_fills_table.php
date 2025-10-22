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
        Schema::table('fuel_fills', function (Blueprint $table) {
            $table->time('time')->nullable()->after('fill_date'); // Jam pengisian
            $table->string('spbu')->nullable()->after('gas_station'); // SPBU name
            $table->string('driver')->nullable()->after('spbu'); // Pengendara
            $table->string('reason')->nullable()->after('driver'); // Alasan
            $table->string('payment_method')->nullable()->after('reason'); // Cara pembayaran
            $table->boolean('missed_filling')->default(false)->after('payment_method'); // Pengisian terlewatkan
            $table->boolean('full_tank')->default(false)->after('missed_filling'); // Tanki penuh
            $table->string('attachment')->nullable()->after('notes'); // File attachment path
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fuel_fills', function (Blueprint $table) {
            $table->dropColumn([
                'time',
                'spbu',
                'driver',
                'reason',
                'payment_method',
                'missed_filling',
                'full_tank',
                'attachment'
            ]);
        });
    }
};
