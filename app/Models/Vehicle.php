<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    protected $fillable = [
        'name',
        'brand',
        'model',
        'year',
        'license_plate',
        'vehicle_type',
        'chassis_number',
        'engine_number',
        'stnk_number',
        'stnk_expiry_date',
        'kir_number',
        'kir_expiry_date',
        'barcode_path',
        'document_name',
        'document_path',
        'engine_type',
        'transmission',
        'tank_capacity',
        'odometer',
        'color',
        'notes',
        'location_id',
        'is_active',
        'daily_rate',
        'monthly_rate',
        'investor_id',
        'ownership_type'
    ];

    protected $casts = [
        'tank_capacity' => 'decimal:2',
        'odometer' => 'decimal:2',
        'is_active' => 'boolean',
        'daily_rental_rate' => 'decimal:2',
        'weekly_rental_rate' => 'decimal:2',
        'monthly_rental_rate' => 'decimal:2',
        'stnk_expiry_date' => 'date',
        'kir_expiry_date' => 'date'
    ];

    // Relationships
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function investor()
    {
        return $this->belongsTo(Investor::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_vehicles')
                    ->withTimestamps();
    }

    public function assignedDrivers()
    {
        return $this->users()->where('user_type', 'Sopir');
    }

    public function fuelFills(): HasMany
    {
        return $this->hasMany(FuelFill::class);
    }

    public function maintenances(): HasMany
    {
        return $this->hasMany(Maintenance::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }

    // Accessor & Mutator
    public function getFullNameAttribute(): string
    {
        return "{$this->brand} {$this->model} ({$this->year})";
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Helper methods
    public function getLatestOdometer(): float
    {
        $latestFuel = $this->fuelFills()->latest('fill_date')->first();
        $latestMaintenance = $this->maintenances()->latest('maintenance_date')->first();
        
        $fuelOdo = $latestFuel ? $latestFuel->odometer : 0;
        $maintenanceOdo = $latestMaintenance ? $latestMaintenance->odometer : 0;
        
        return (float) max($this->odometer ?? 0, $fuelOdo, $maintenanceOdo);
    }

    public function getTotalExpenses(): float
    {
        return $this->expenses()->sum('amount');
    }

    public function getAverageFuelEfficiency(): float
    {
        return $this->fuelFills()->where('fuel_efficiency', '>', 0)->avg('fuel_efficiency') ?? 0;
    }

    /**
     * Get minimum valid odometer for next entry
     * For rental business - odometer must always increase
     */
    public function getMinimumOdometer(): float
    {
        return $this->getLatestOdometer();
    }

    /**
     * Validate if new odometer reading is valid
     */
    public function isValidOdometer(float $newOdometer): bool
    {
        return $newOdometer >= $this->getMinimumOdometer();
    }

    /**
     * Get odometer validation message
     */
    public function getOdometerValidationMessage(): string
    {
        $minOdo = $this->getMinimumOdometer();
        return "Odometer harus lebih besar atau sama dengan {$minOdo} km (odometer terakhir)";
    }

    /**
     * Check if vehicle is available for rental
     */
    public function isAvailableForRental($startDate = null, $endDate = null): bool
    {
        if (!$this->is_active) {
            return false;
        }

        // Check if there's any active rental
        $activeRental = $this->rentals()->whereIn('status', ['reserved', 'active'])->first();
        if ($activeRental) {
            return false;
        }

        // If dates provided, check for conflicts
        if ($startDate && $endDate) {
            $conflictingRentals = $this->rentals()
                ->whereIn('status', ['reserved', 'active'])
                ->where(function($query) use ($startDate, $endDate) {
                    $query->whereBetween('start_date', [$startDate, $endDate])
                          ->orWhereBetween('end_date', [$startDate, $endDate])
                          ->orWhere(function($q) use ($startDate, $endDate) {
                              $q->where('start_date', '<=', $startDate)
                                ->where('end_date', '>=', $endDate);
                          });
                })->exists();
            
            return !$conflictingRentals;
        }

        return true;
    }

    /**
     * Get current rental status
     */
    public function getCurrentRentalStatus(): ?string
    {
        $activeRental = $this->rentals()->whereIn('status', ['reserved', 'active'])->first();
        return $activeRental ? $activeRental->status : null;
    }

    /**
     * Get current rental
     */
    public function getCurrentRental(): ?Rental
    {
        return $this->rentals()->whereIn('status', ['reserved', 'active'])->first();
    }

    /**
     * Get brand logo path
     */
    public function getBrandLogo(): string
    {
        $brandLower = strtolower($this->brand);
        $logoPath = "assets/logos/brands/{$brandLower}.svg";
        
        // Check if specific brand logo exists
        if (file_exists(public_path($logoPath))) {
            return $logoPath;
        }
        
        // Return default logo if brand specific doesn't exist
        return "assets/logos/brands/default.svg";
    }

    /**
     * Get brand logo URL
     */
    public function getBrandLogoUrl(): string
    {
        return asset($this->getBrandLogo());
    }
}
