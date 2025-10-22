<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Add location_id to vehicles table
        if (!Schema::hasColumn('vehicles', 'location_id')) {
            Schema::table('vehicles', function (Blueprint $table) {
                $table->unsignedBigInteger('location_id')->after('id')->default(1);
                $table->foreign('location_id')->references('id')->on('locations');
            });
        }

        // Add location_id to rentals table
        if (!Schema::hasColumn('rentals', 'location_id')) {
            Schema::table('rentals', function (Blueprint $table) {
                $table->unsignedBigInteger('location_id')->after('id')->default(1);
                $table->foreign('location_id')->references('id')->on('locations');
            });
        }

        // Add location_id to expenses table
        if (!Schema::hasColumn('expenses', 'location_id')) {
            Schema::table('expenses', function (Blueprint $table) {
                $table->unsignedBigInteger('location_id')->after('id')->default(1);
                $table->foreign('location_id')->references('id')->on('locations');
            });
        }
    }

    public function down()
    {
        Schema::table('expenses', function (Blueprint $table) {
            if (Schema::hasColumn('expenses', 'location_id')) {
                $table->dropForeign(['location_id']);
                $table->dropColumn('location_id');
            }
        });

        Schema::table('rentals', function (Blueprint $table) {
            if (Schema::hasColumn('rentals', 'location_id')) {
                $table->dropForeign(['location_id']);
                $table->dropColumn('location_id');
            }
        });

        Schema::table('vehicles', function (Blueprint $table) {
            if (Schema::hasColumn('vehicles', 'location_id')) {
                $table->dropForeign(['location_id']);
                $table->dropColumn('location_id');
            }
        });
    }
};