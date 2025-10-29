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
        Schema::table('maintenances', function (Blueprint $table) {
            // Add new fields if they don't exist
            if (!Schema::hasColumn('maintenances', 'service_date')) {
                $table->date('service_date')->nullable()->after('maintenance_date');
            }
            if (!Schema::hasColumn('maintenances', 'service_time')) {
                $table->time('service_time')->nullable()->after('service_date');
            }
            if (!Schema::hasColumn('maintenances', 'service_type')) {
                $table->string('service_type')->nullable()->after('type');
            }
            if (!Schema::hasColumn('maintenances', 'place')) {
                $table->string('place')->nullable()->after('workshop');
            }
            if (!Schema::hasColumn('maintenances', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained()->after('vehicle_id');
            }
            if (!Schema::hasColumn('maintenances', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('cost');
            }
            if (!Schema::hasColumn('maintenances', 'attachment')) {
                $table->string('attachment')->nullable()->after('notes');
            }
            if (!Schema::hasColumn('maintenances', 'total_cost')) {
                $table->decimal('total_cost', 15, 2)->nullable()->after('cost');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maintenances', function (Blueprint $table) {
            $table->dropColumn([
                'service_date',
                'service_time',
                'service_type',
                'place',
                'user_id',
                'payment_method',
                'attachment',
                'total_cost'
            ]);
        });
    }
};
