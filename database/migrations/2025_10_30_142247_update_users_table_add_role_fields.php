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
        Schema::table('users', function (Blueprint $table) {
            // Only add columns that don't exist yet
            if (!Schema::hasColumn('users', 'verification_code')) {
                $table->string('verification_code')->nullable()->after('remember_token');
            }
            if (!Schema::hasColumn('users', 'code_expires_at')) {
                $table->timestamp('code_expires_at')->nullable()->after('verification_code');
            }
            if (!Schema::hasColumn('users', 'is_verified')) {
                $table->boolean('is_verified')->default(false)->after('code_expires_at');
            }
            
            // Update role column to use enum if it exists
            if (Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('viewer')->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['verification_code', 'code_expires_at', 'is_verified']);
        });
    }
};
