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
        Schema::table('locations', function (Blueprint $table) {
            if (!Schema::hasColumn('locations', 'address')) {
                $table->text('address')->nullable()->after('name');
            }
            if (!Schema::hasColumn('locations', 'latitude')) {
                $table->decimal('latitude', 10, 8)->nullable()->after('address');
            }
            if (!Schema::hasColumn('locations', 'longitude')) {
                $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            // We shouldn't strictly drop them if they might have existed before, but standard down would drop them.
            // For safety in this messy state, we might just leave them or check.
            // But strict rollback of THIS migration should drop what IT added.
            // Since we don't know if IT added them, safest is to try drop if exists?
            // Actually, let's just leave down empty or cautious to avoid dropping columns created by other migrations.

            // $table->dropColumn(['address', 'latitude', 'longitude']);
        });
    }
};
