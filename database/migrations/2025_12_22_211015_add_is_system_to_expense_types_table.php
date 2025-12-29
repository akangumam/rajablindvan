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
        Schema::table('expense_types', function (Blueprint $table) {
            $table->boolean('is_system')->default(false)->after('is_active');
        });

        // Seed default system expense types
        $systemTypes = [
            'Perpanjangan GPS',
            'Perpanjangan KIR',
            'Perpanjangan Pajak Tahunan - STNK'
        ];

        foreach ($systemTypes as $type) {
            \Illuminate\Support\Facades\DB::table('expense_types')->updateOrInsert(
                ['name' => $type],
                [
                    'description' => 'System default expense type',
                    'is_active' => true,
                    'is_system' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expense_types', function (Blueprint $table) {
            $table->dropColumn('is_system');
        });
    }
};
