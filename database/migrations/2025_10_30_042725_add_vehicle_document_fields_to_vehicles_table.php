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
            // Add new fields (check if they don't exist first)
            if (!Schema::hasColumn('vehicles', 'vehicle_type')) {
                $table->string('vehicle_type')->nullable()->after('id');
            }
            if (!Schema::hasColumn('vehicles', 'chassis_number')) {
                $table->string('chassis_number')->nullable()->after('license_plate');
            }
            if (!Schema::hasColumn('vehicles', 'engine_number')) {
                $table->string('engine_number')->nullable()->after('chassis_number');
            }
            if (!Schema::hasColumn('vehicles', 'stnk_number')) {
                $table->string('stnk_number')->nullable()->after('engine_number');
            }
            if (!Schema::hasColumn('vehicles', 'kir_number')) {
                $table->string('kir_number')->nullable()->after('kir_expiry_date');
            }
            if (!Schema::hasColumn('vehicles', 'barcode_path')) {
                $table->string('barcode_path')->nullable()->after('kir_number');
            }
            if (!Schema::hasColumn('vehicles', 'document_name')) {
                $table->string('document_name')->nullable()->after('barcode_path');
            }
            if (!Schema::hasColumn('vehicles', 'document_path')) {
                $table->string('document_path')->nullable()->after('document_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn(['vehicle_type', 'chassis_number', 'engine_number', 'stnk_number', 'kir_number', 'barcode_path', 'document_name', 'document_path']);
        });
    }
};
