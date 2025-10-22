<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'phone',
        'email',
        'user_type',
        'id_number',
        'license_category',
        'license_expiry',
        'address',
        'birth_date',
        'gender',
        'emergency_contact',
        'emergency_phone',
        'notes',
        'is_active'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'license_expiry' => 'date',
        'is_active' => 'boolean'
    ];

    // Relationships
    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessors
    public function getFullNameAttribute(): string
    {
        return $this->name;
    }

    public function getAgeAttribute(): ?int
    {
        return $this->birth_date ? $this->birth_date->age : null;
    }

    // Helper methods
    public function getActiveRentals()
    {
        return $this->rentals()->whereIn('status', ['reserved', 'active'])->get();
    }

    public function getTotalRentals(): int
    {
        return $this->rentals()->count();
    }

    public function getTotalSpent(): float
    {
        return $this->rentals()->sum('total_amount');
    }
}
