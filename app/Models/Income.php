<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Income extends Model
{
    protected $fillable = [
        'vehicle_id',
        'income_date',
        'odometer',
        'category',
        'source',
        'description',
        'amount',
        'payment_method',
        'invoice_number',
        'notes'
    ];

    protected $casts = [
        'income_date' => 'date',
        'odometer' => 'decimal:2',
        'amount' => 'decimal:2'
    ];

    // Relationships
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    // Scopes
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('income_date', [$startDate, $endDate]);
    }
}
