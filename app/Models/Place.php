<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Place extends Model
{
    protected $fillable = ['name', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Ensure places table exists, running pending migration or creating schema if missing.
     */
    public static function ensureTableExists(): bool
    {
        if (Schema::hasTable('places')) {
            return true;
        }

        try {
            Artisan::call('migrate', ['--force' => true]);
            if (Schema::hasTable('places')) {
                return true;
            }
        } catch (\Throwable $e) {
            Log::warning('Artisan migrate call failed: ' . $e->getMessage());
        }

        try {
            if (!Schema::hasTable('places')) {
                Schema::create('places', function ($table) {
                    $table->id();
                    $table->string('name')->unique();
                    $table->boolean('is_active')->default(true);
                    $table->timestamps();
                });

                if (Schema::hasTable('locations')) {
                    $locations = DB::table('locations')->where('is_active', true)->get();
                    foreach ($locations as $loc) {
                        DB::table('places')->insertOrIgnore([
                            'name'       => $loc->name,
                            'is_active'  => true,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
                return true;
            }
        } catch (\Throwable $e) {
            Log::error('Direct places table creation failed: ' . $e->getMessage());
            return false;
        }

        return Schema::hasTable('places');
    }

    /**
     * Safely get all active places, falling back to locations if table not yet available
     */
    public static function getAllActive()
    {
        static::ensureTableExists();

        try {
            return static::active()->orderBy('name')->get();
        } catch (\Throwable $e) {
            try {
                return \App\Models\Location::active()->orderBy('name')->get();
            } catch (\Throwable $e2) {
                return collect();
            }
        }
    }
}
