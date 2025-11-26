<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update all uploaded files with null category to 'vehicle'
        // Since most files without category are likely vehicle barcodes
        DB::table('uploaded_files')
            ->whereNull('category')
            ->update(['category' => 'vehicle']);
            
        // Also update any files that might have empty string category
        DB::table('uploaded_files')
            ->where('category', '')
            ->update(['category' => 'vehicle']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We don't reverse this migration as it's a data cleanup
    }
};
