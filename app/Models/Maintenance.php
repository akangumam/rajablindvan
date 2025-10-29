<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Maintenance extends Model
{
    protected $fillable = [
        'vehicle_id',
        'user_id',
        'maintenance_date',
        'service_date',
        'service_time',
        'odometer',
        'type',
        'service_type',
        'category',
        'description',
        'workshop',
        'place',
        'cost',
        'total_cost',
        'payment_method',
        'next_maintenance_date',
        'next_maintenance_odometer',
        'parts_replaced',
        'status',
        'notes',
        'attachment'
    ];

    protected $casts = [
        'maintenance_date' => 'date',
        'service_date' => 'date',
        'next_maintenance_date' => 'date',
        'odometer' => 'decimal:2',
        'next_maintenance_odometer' => 'decimal:2',
        'cost' => 'decimal:2',
        'total_cost' => 'decimal:2'
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
    public function scopeOverdue($query)
    {
        return $query->where('status', 'Scheduled')
                    ->where('next_maintenance_date', '<', now());
    }

    public function scopeUpcoming($query, $days = 30)
    {
        return $query->where('status', 'Scheduled')
                    ->whereBetween('next_maintenance_date', [now(), now()->addDays($days)]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereYear('maintenance_date', now()->year)
                    ->whereMonth('maintenance_date', now()->month);
    }

    public function scopeThisYear($query)
    {
        return $query->whereYear('maintenance_date', now()->year);
    }

    // Helper methods
    public function isOverdue(): bool
    {
        return $this->status === 'Scheduled' &&
               $this->next_maintenance_date &&
               $this->next_maintenance_date < now();
    }

    public function daysUntilDue(): int
    {
        if (!$this->next_maintenance_date) {
            return 0;
        }
        
        return max(0, now()->diffInDays($this->next_maintenance_date, false));
    }
}
