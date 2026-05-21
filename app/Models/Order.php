<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'vehicle_id',
        'customer_id',
        'rental_type',
        'start_date',
        'end_date',
        'status',
        'completed_at'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'completed_at' => 'datetime',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    public function getTotalDaysAttribute(): int
    {
        return max(1, (int) $this->start_date->diffInDays($this->end_date));
    }

    public function getTotalPriceAttribute(): float
    {
        $vehicle = $this->vehicle;
        if (!$vehicle) {
            return 0.0;
        }

        $days = $this->total_days;

        if ($this->rental_type === 'Sewa Bulanan' && $vehicle->monthly_rental_rate > 0) {
            $months = max(1, (int) ceil($days / 30));
            return (float) ($vehicle->monthly_rental_rate * $months);
        }

        return (float) (($vehicle->daily_rental_rate ?? 0) * $days);
    }

    public function getRemainingDaysAttribute()
    {
        if ($this->rental_type === 'Sewa Bulanan' && $this->status === self::STATUS_ACTIVE) {
            $today = now()->startOfDay();
            $endDate = $this->end_date->startOfDay();
            return $today->diffInDays($endDate, false);
        }
        return null;
    }

    public function getStatusColorAttribute()
    {
        if ($this->rental_type === 'Sewa Harian' && $this->status === self::STATUS_ACTIVE) {
            return 'success';
        }

        if ($this->rental_type === 'Sewa Bulanan' && $this->status === self::STATUS_ACTIVE) {
            $remaining = $this->remaining_days;
            if ($remaining < 0) {
                return 'danger';
            } elseif ($remaining <= 7) {
                return 'warning';
            }
            return 'success';
        }

        return 'secondary';
    }

    public function getStatusTextAttribute()
    {
        if ($this->rental_type === 'Sewa Harian' && $this->status === self::STATUS_ACTIVE) {
            return 'Active';
        }

        if ($this->rental_type === 'Sewa Bulanan' && $this->status === self::STATUS_ACTIVE) {
            $remaining = $this->remaining_days;
            if ($remaining < 0) {
                return 'Overdue';
            } elseif ($remaining <= 7) {
                return 'Due Soon (' . $remaining . ' days)';
            }
            return 'Active';
        }

        return ucfirst($this->status);
    }
}
