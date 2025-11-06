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
        // Add unique constraint to service_types table
        Schema::table('service_types', function (Blueprint $table) {
            $table->unique('name', 'service_types_name_unique');
        });
        
        // Add unique constraint to expense_types table
        Schema::table('expense_types', function (Blueprint $table) {
            $table->unique('name', 'expense_types_name_unique');
        });
        
        // Add unique constraint to income_types table
        Schema::table('income_types', function (Blueprint $table) {
            $table->unique('name', 'income_types_name_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove unique constraint from service_types table
        Schema::table('service_types', function (Blueprint $table) {
            $table->dropUnique('service_types_name_unique');
        });
        
        // Remove unique constraint from expense_types table
        Schema::table('expense_types', function (Blueprint $table) {
            $table->dropUnique('expense_types_name_unique');
        });
        
        // Remove unique constraint from income_types table
        Schema::table('income_types', function (Blueprint $table) {
            $table->dropUnique('income_types_name_unique');
        });
    }
};
