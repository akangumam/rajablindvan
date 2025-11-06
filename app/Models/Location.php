<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'address',
        'phone',
        'manager_name',
        'is_active',
        'latitude',
        'longitude',
        'google_place_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Helper methods
    public function getActiveVehiclesCount()
    {
        return $this->vehicles()->where('is_active', true)->count();
    }

    public function getAvailableVehiclesCount()
    {
        return $this->vehicles()
            ->where('is_active', true)
            ->where('status', 'available')
            ->count();
    }

    public function getMonthlyRevenue($month = null, $year = null)
    {
        $query = $this->rentals()->where('status', 'completed');
        
        if ($month && $year) {
            $query->whereMonth('start_date', $month)
                  ->whereYear('start_date', $year);
        }
        
        return $query->sum('total_cost');
    }

    public function getMonthlyExpenses($month = null, $year = null)
    {
        $query = $this->expenses();
        
        if ($month && $year) {
            $query->whereMonth('date', $month)
                  ->whereYear('date', $year);
        }
        
        return $query->sum('amount');
    }
}