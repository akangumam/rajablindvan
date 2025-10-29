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
        Schema::table('expenses', function (Blueprint $table) {
            $table->time('expense_time')->nullable()->after('expense_date');
            $table->string('expense_type')->nullable()->after('expense_time');
            $table->string('place')->nullable()->after('expense_type');
            $table->foreignId('user_id')->nullable()->constrained()->after('place');
            $table->string('attachment')->nullable()->after('notes');
            $table->decimal('total_cost', 15, 2)->nullable()->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn(['expense_time', 'expense_type', 'place', 'user_id', 'attachment', 'total_cost']);
        });
    }
};
