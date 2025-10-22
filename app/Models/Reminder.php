<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reminder extends Model
{
    protected $fillable = [
        'vehicle_id', 'title', 'category', 'due_date', 'due_odometer',
        'advance_notice_days', 'is_recurring', 'recurring_interval',
        'estimated_cost', 'description', 'is_completed', 'completed_date', 'notes'
    ];

    protected $casts = [
        'due_date' => 'date',
        'completed_date' => 'date',
        'due_odometer' => 'decimal:2',
        'estimated_cost' => 'decimal:2',
        'is_recurring' => 'boolean',
        'is_completed' => 'boolean'
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}
