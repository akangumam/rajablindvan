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
        Schema::table('incomes', function (Blueprint $table) {
            $table->time('income_time')->nullable()->after('income_date');
            $table->foreignId('user_id')->nullable()->after('vehicle_id')->constrained()->onDelete('set null');
            $table->string('type')->nullable()->after('odometer'); // Type of Income
            $table->string('attachment')->nullable()->after('notes'); // File attachment path
            
            // Drop unused columns
            $table->dropColumn(['category', 'source', 'payment_method', 'invoice_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->dropColumn(['income_time', 'user_id', 'type', 'attachment']);
            
            // Restore dropped columns
            $table->string('category')->nullable();
            $table->string('source')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('invoice_number')->nullable();
        });
    }
};
