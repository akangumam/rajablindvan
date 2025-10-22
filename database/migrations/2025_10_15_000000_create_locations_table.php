<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Jakarta Pusat", "Bekasi"
            $table->string('code')->unique(); // e.g., "JKT", "BKS"
            $table->text('address');
            $table->string('phone')->nullable();
            $table->string('manager_name')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Add location_id to existing tables with default value
        Schema::table('vehicles', function (Blueprint $table) {
            $table->unsignedBigInteger('location_id')->after('id')->default(1);
            $table->foreign('location_id')->references('id')->on('locations');
        });

        Schema::table('rentals', function (Blueprint $table) {
            $table->unsignedBigInteger('location_id')->after('id')->default(1);
            $table->foreign('location_id')->references('id')->on('locations');
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->unsignedBigInteger('location_id')->after('id')->default(1);
            $table->foreign('location_id')->references('id')->on('locations');
        });
    }

    public function down()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropColumn('location_id');
        });

        Schema::table('rentals', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropColumn('location_id');
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropColumn('location_id');
        });

        Schema::dropIfExists('locations');
    }
};