<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FuelFill extends Model
{
    protected $fillable = [
        'vehicle_id',
        'fill_date',
        'time',
        'odometer',
        'liters',
        'price_per_liter',
        'total_cost',
        'fuel_type',
        'gas_station',
        'spbu',
        'driver',
        'reason',
        'payment_method',
        'missed_filling',
        'full_tank',
        'is_full_tank',
        'trip_distance',
        'fuel_efficiency',
        'attachment',
        'notes'
    ];

    protected $casts = [
        'fill_date' => 'date',
        'odometer' => 'decimal:2',
        'liters' => 'decimal:2',
        'price_per_liter' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'trip_distance' => 'decimal:2',
        'fuel_efficiency' => 'decimal:2',
        'is_full_tank' => 'boolean',
        'missed_filling' => 'boolean',
        'full_tank' => 'boolean'
    ];

    // Relationships
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    // Mutators
    public function setTotalCostAttribute($value)
    {
        $this->attributes['total_cost'] = $this->liters * $this->price_per_liter;
    }

    // Scopes
    public function scopeThisMonth($query)
    {
        return $query->whereYear('fill_date', now()->year)
                    ->whereMonth('fill_date', now()->month);
    }

    public function scopeThisYear($query)
    {
        return $query->whereYear('fill_date', now()->year);
    }

    // Helper methods
    public function calculateFuelEfficiency(): float
    {
        if ($this->trip_distance && $this->liters > 0) {
            return round($this->trip_distance / $this->liters, 2);
        }
        return 0;
    }
}
