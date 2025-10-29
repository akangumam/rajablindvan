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
        'expense_time',
        'expense_type',
        'place',
        'user_id',
        'odometer',
        'category',
        'subcategory',
        'description',
        'amount',
        'total_cost',
        'vendor',
        'payment_method',
        'receipt_number',
        'is_recurring',
        'recurring_period',
        'attachment',
        'notes',
        'stnk_expiry_date',
        'kir_expiry_date'
    ];

    protected $casts = [
        'expense_date' => 'date',
        'stnk_expiry_date' => 'date',
        'kir_expiry_date' => 'date',
        'odometer' => 'decimal:2',
        'amount' => 'decimal:2',
        'total_cost' => 'decimal:2',
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
