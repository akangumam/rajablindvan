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

    // Calculate remaining days for Sewa Bulanan
    public function getRemainingDaysAttribute()
    {
        if ($this->rental_type === 'Sewa Bulanan' && $this->status === 'Active') {
            $today = now()->startOfDay();
            $endDate = $this->end_date->startOfDay();
            $daysRemaining = $today->diffInDays($endDate, false);
            return $daysRemaining;
        }
        return null;
    }

    // Get status color for display
    public function getStatusColorAttribute()
    {
        if ($this->rental_type === 'Sewa Harian' && $this->status === 'Active') {
            return 'success'; // Hijau untuk semua sewa harian
        }
        
        if ($this->rental_type === 'Sewa Bulanan' && $this->status === 'Active') {
            $remaining = $this->remaining_days;
            if ($remaining < 0) {
                return 'danger'; // Merah - Lewat jatuh tempo
            } elseif ($remaining <= 7) {
                return 'warning'; // Kuning - akan jatuh tempo 7 hari sebelum
            } else {
                return 'success'; // Hijau - masih aman
            }
        }
        
        return 'secondary';
    }

    // Get status text for display
    public function getStatusTextAttribute()
    {
        if ($this->rental_type === 'Sewa Harian' && $this->status === 'Active') {
            return 'Active';
        }
        
        if ($this->rental_type === 'Sewa Bulanan' && $this->status === 'Active') {
            $remaining = $this->remaining_days;
            if ($remaining < 0) {
                return 'Overdue';
            } elseif ($remaining <= 7) {
                return 'Due Soon (' . $remaining . ' days)';
            } else {
                return 'Active';
            }
        }
        
        return 'Inactive';
    }
}
