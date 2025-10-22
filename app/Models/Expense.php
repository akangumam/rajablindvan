<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    protected $fillable = [
        'location_id',
        'vehicle_id',
        'expense_date',
        'odometer',
        'category',
        'subcategory',
        'description',
        'amount',
        'vendor',
        'payment_method',
        'receipt_number',
        'is_recurring',
        'recurring_period',
        'notes'
    ];

    protected $casts = [
        'expense_date' => 'date',
        'odometer' => 'decimal:2',
        'amount' => 'decimal:2',
        'is_recurring' => 'boolean'
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

    // Scopes
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereYear('expense_date', now()->year)
                    ->whereMonth('expense_date', now()->month);
    }

    public function scopeThisYear($query)
    {
        return $query->whereYear('expense_date', now()->year);
    }

    public function scopeRecurring($query)
    {
        return $query->where('is_recurring', true);
    }

    // Helper methods
    public static function getCategories(): array
    {
        return [
            'Fuel' => 'Bahan Bakar',
            'Maintenance' => 'Perawatan',
            'Insurance' => 'Asuransi',
            'Tax' => 'Pajak',
            'Parking' => 'Parkir',
            'Toll' => 'Tol',
            'Fine' => 'Denda',
            'Accessories' => 'Aksesoris',
            'Other' => 'Lainnya'
        ];
    }

    public function getCategoryLabelAttribute(): string
    {
        $categories = self::getCategories();
        return $categories[$this->category] ?? $this->category;
    }
}
