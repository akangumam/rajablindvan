<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Income extends Model
{
    protected $fillable = [
        'vehicle_id',
        'user_id',
        'income_date',
        'income_time',
        'odometer',
        'type',
        'amount',
        'notes',
        'attachment',
        // Keep old fields for backward compatibility
        'description',
    ];

    protected $casts = [
        'income_date' => 'date',
        'odometer' => 'decimal:2',
        'amount' => 'decimal:2'
    ];

    // Relationships
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('income_date', [$startDate, $endDate]);
    }
}
