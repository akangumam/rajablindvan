<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'location_id',
        'name',
        'email',
        'phone',
        'role',
        'user_type', // Pengelola or Sopir
        'is_active',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Relationships
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class, 'user_vehicles')
                    ->withTimestamps();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    public function scopeByLocation($query, $locationId)
    {
        return $query->where('location_id', $locationId);
    }

    public function scopePengelola($query)
    {
        return $query->where('user_type', 'Pengelola');
    }

    public function scopeSopir($query)
    {
        return $query->where('user_type', 'Sopir');
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isPengelola()
    {
        return $this->user_type === 'Pengelola';
    }

    public function isSopir()
    {
        return $this->user_type === 'Sopir';
    }

    public function hasAccessToVehicle($vehicleId)
    {
        if ($this->isPengelola()) {
            return true; // Pengelola has access to all vehicles
        }

        return $this->vehicles()->where('vehicle_id', $vehicleId)->exists();
    }

    public function canManageUsers()
    {
        return $this->isPengelola();
    }

    public function canManageVehicles()
    {
        return $this->isPengelola();
    }

    public function isManager()
    {
        return $this->role === 'manager';
    }

    public function isStaff()
    {
        return $this->role === 'staff';
    }

    public function canAccessLocation($locationId)
    {
        // Admin can access all locations
        if ($this->isAdmin()) {
            return true;
        }
        
        // Manager and staff can only access their assigned location
        return $this->location_id == $locationId;
    }

    public function getAvailableLocations()
    {
        if ($this->isAdmin()) {
            return Location::active()->get();
        }
        
        return collect([$this->location]);
    }
}
