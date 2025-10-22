<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trip extends Model
{
    protected $fillable = [
        'vehicle_id',
        'trip_date',
        'start_time',
        'end_time',
        'start_odometer',
        'end_odometer',
        'distance',
        'start_location',
        'end_location',
        'driver',
        'purpose',
        'route_type',
        'notes'
    ];

    protected $casts = [
        'trip_date' => 'date',
        'start_odometer' => 'decimal:2',
        'end_odometer' => 'decimal:2',
        'distance' => 'decimal:2'
    ];

    // Relationships
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    // Scopes
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('trip_date', [$startDate, $endDate]);
    }

    public function scopeByPurpose($query, $purpose)
    {
        return $query->where('purpose', $purpose);
    }
}
