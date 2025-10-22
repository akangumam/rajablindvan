<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Rental extends Model
{
    protected $fillable = [
        'location_id',
        'vehicle_id',
        'customer_id',
        'rental_code',
        'rental_type',
        'start_date',
        'end_date',
        'start_odometer',
        'end_odometer',
        'daily_rate',
        'weekly_rate',
        'monthly_rate',
        'duration_days',
        'total_amount',
        'deposit',
        'additional_charges',
        'additional_charges_notes',
        'status',
        'pickup_location',
        'return_location',
        'notes',
        'actual_start_time',
        'actual_end_time'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'start_odometer' => 'decimal:2',
        'end_odometer' => 'decimal:2',
        'daily_rate' => 'decimal:2',
        'weekly_rate' => 'decimal:2',
        'monthly_rate' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'deposit' => 'decimal:2',
        'additional_charges' => 'decimal:2',
        'actual_start_time' => 'datetime',
        'actual_end_time' => 'datetime'
    ];

    // Relationships
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeThisMonth($query)
    {
        return $query->whereYear('start_date', now()->year)
                    ->whereMonth('start_date', now()->month);
    }

    // Accessors
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'reserved' => 'Reservasi',
            'active' => 'Aktif',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => $this->status
        };
    }

    public function getStatusClassAttribute(): string
    {
        return match($this->status) {
            'reserved' => 'warning',
            'active' => 'success',
            'completed' => 'primary',
            'cancelled' => 'danger',
            default => 'secondary'
        };
    }

    // Helper methods
    public function getTotalDistance(): float
    {
        return $this->end_odometer ? ($this->end_odometer - $this->start_odometer) : 0;
    }

    public function getFinalAmount(): float
    {
        return $this->total_amount + $this->additional_charges;
    }

    public function isOverdue(): bool
    {
        return $this->status === 'active' && now()->isAfter($this->end_date);
    }

    public function getDaysOverdue(): int
    {
        if (!$this->isOverdue()) return 0;
        return now()->diffInDays($this->end_date);
    }

    public function canBeStarted(): bool
    {
        return $this->status === 'reserved' && now()->isAfter($this->start_date->startOfDay());
    }

    public function canBeCompleted(): bool
    {
        return $this->status === 'active';
    }

    // Rental type methods
    public function getRentalTypeLabel(): string
    {
        return match($this->rental_type) {
            'daily' => 'Harian',
            'weekly' => 'Mingguan', 
            'monthly' => 'Bulanan',
            default => 'Harian'
        };
    }

    public function getEffectiveRate(): float
    {
        return match($this->rental_type) {
            'weekly' => $this->weekly_rate ?? $this->daily_rate * 7,
            'monthly' => $this->monthly_rate ?? $this->daily_rate * 30,
            default => $this->daily_rate
        };
    }

    public function getEffectiveDuration(): int
    {
        return match($this->rental_type) {
            'weekly' => ceil($this->duration_days / 7),
            'monthly' => ceil($this->duration_days / 30),
            default => $this->duration_days
        };
    }

    public function calculateOptimalRate(): array
    {
        $days = $this->duration_days;
        $dailyTotal = $this->daily_rate * $days;
        
        $options = [
            'daily' => [
                'type' => 'daily',
                'rate' => $this->daily_rate,
                'units' => $days,
                'unit_label' => 'hari',
                'total' => $dailyTotal
            ]
        ];

        if ($this->weekly_rate && $days >= 7) {
            $weeks = ceil($days / 7);
            $weeklyTotal = $this->weekly_rate * $weeks;
            $options['weekly'] = [
                'type' => 'weekly',
                'rate' => $this->weekly_rate,
                'units' => $weeks,
                'unit_label' => 'minggu',
                'total' => $weeklyTotal
            ];
        }

        if ($this->monthly_rate && $days >= 30) {
            $months = ceil($days / 30);
            $monthlyTotal = $this->monthly_rate * $months;
            $options['monthly'] = [
                'type' => 'monthly',
                'rate' => $this->monthly_rate,
                'units' => $months,
                'unit_label' => 'bulan',
                'total' => $monthlyTotal
            ];
        }

        // Return the cheapest option
        return collect($options)->sortBy('total')->first();
    }

    // Generate rental code
    public static function generateRentalCode(): string
    {
        $year = now()->year;
        $month = now()->format('m');
        $count = self::whereYear('created_at', $year)
                    ->whereMonth('created_at', now()->month)
                    ->count() + 1;
        
        return "RNT-{$year}{$month}-" . str_pad($count, 3, '0', STR_PAD_LEFT);
    }
}
