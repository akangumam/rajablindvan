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
        Schema::table('places', function (Blueprint $table) {
            if (!Schema::hasColumn('places', 'address')) {
                $table->text('address')->nullable()->after('name');
            }
            if (!Schema::hasColumn('places', 'latitude')) {
                $table->decimal('latitude', 10, 8)->nullable()->after('address');
            }
            if (!Schema::hasColumn('places', 'longitude')) {
                $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('places', function (Blueprint $table) {
            $columnsToDrop = [];
            if (Schema::hasColumn('places', 'longitude')) {
                $columnsToDrop[] = 'longitude';
            }
            if (Schema::hasColumn('places', 'latitude')) {
                $columnsToDrop[] = 'latitude';
            }
            if (Schema::hasColumn('places', 'address')) {
                $columnsToDrop[] = 'address';
            }
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
