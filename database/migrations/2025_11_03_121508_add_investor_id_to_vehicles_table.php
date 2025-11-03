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
            $table->foreignId('investor_id')->nullable()->after('id')->constrained('investors')->onDelete('set null');
            $table->enum('ownership_type', ['company', 'investor'])->default('company')->after('investor_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropForeign(['investor_id']);
            $table->dropColumn(['investor_id', 'ownership_type']);
        });
    }
};
