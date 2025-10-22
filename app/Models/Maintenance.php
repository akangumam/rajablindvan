<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Maintenance extends Model
{
    protected $fillable = [
        'vehicle_id',
        'maintenance_date',
        'odometer',
        'type',
        'category',
        'description',
        'workshop',
        'cost',
        'next_maintenance_date',
        'next_maintenance_odometer',
        'parts_replaced',
        'status',
        'notes'
    ];

    protected $casts = [
        'maintenance_date' => 'date',
        'next_maintenance_date' => 'date',
        'odometer' => 'decimal:2',
        'next_maintenance_odometer' => 'decimal:2',
        'cost' => 'decimal:2'
    ];

    // Relationships
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
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
