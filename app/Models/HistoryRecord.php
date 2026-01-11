<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'type',
        'title',
        'description',
        'location',
        'cost',
        'odometer',
        'date',
        'extra_data',
        'related_id',
        'related_type',
    ];

    protected $casts = [
        'date' => 'date',
        'cost' => 'decimal:2',
        'extra_data' => 'array',
    ];

    /**
     * Relationship to vehicle
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Get the related model (polymorphic)
     */
    public function related()
    {
        return $this->morphTo();
    }

    /**
     * Scope for filtering by vehicle
     */
    public function scopeForVehicle($query, $vehicleId)
    {
        return $query->where('vehicle_id', $vehicleId);
    }

    /**
     * Scope for filtering by type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope for date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    /**
     * Create history record from FuelFill
     */
    public static function createFromFuelFill($fuelFill)
    {
        return static::create([
            'vehicle_id' => $fuelFill->vehicle_id,
            'type' => 'refueling',
            'title' => 'Pengisian BBM',
            'description' => $fuelFill->notes,
            'location' => $fuelFill->location ?? $fuelFill->station_name,
            'cost' => $fuelFill->cost,
            'odometer' => $fuelFill->odometer,
            'date' => $fuelFill->fill_date,
            'extra_data' => [
                'fuel_type' => $fuelFill->fuel_type,
                'liters' => $fuelFill->liters,
                'price_per_liter' => $fuelFill->price_per_liter,
            ],
            'related_id' => $fuelFill->id,
            'related_type' => 'App\Models\FuelFill',
        ]);
    }

    /**
     * Create history record from Maintenance
     */
    public static function createFromMaintenance($maintenance)
    {
        $type = 'service';
        $title = 'Servis';

        // Detect oil change
        if (str_contains(strtolower($maintenance->service_type ?? ''), 'oli')) {
            $type = 'oil_change';
            $title = 'Ganti Oli';
        }

        return static::create([
            'vehicle_id' => $maintenance->vehicle_id,
            'type' => $type,
            'title' => $title,
            'description' => $maintenance->notes,
            'location' => $maintenance->workshop_name ?? $maintenance->location,
            'cost' => $maintenance->total_cost,
            'odometer' => $maintenance->odometer,
            'date' => $maintenance->service_date,
            'extra_data' => [
                'service_type' => $maintenance->service_type,
                'workshop' => $maintenance->workshop_name,
            ],
            'related_id' => $maintenance->id,
            'related_type' => 'App\Models\Maintenance',
        ]);
    }

    /**
     * Create history record from Expense
     */
    public static function createFromExpense($expense)
    {
        // Map expense category to history type
        $typeMapping = [
            'registration' => 'registration',
            'stnk' => 'registration',
            'labor' => 'labor_cost',
            'transport' => 'transport_application',
        ];

        $type = 'other';
        foreach ($typeMapping as $key => $value) {
            if (str_contains(strtolower($expense->category ?? ''), $key)) {
                $type = $value;
                break;
            }
        }

        return static::create([
            'vehicle_id' => $expense->vehicle_id,
            'type' => $type,
            'title' => $expense->description ?? $expense->category,
            'description' => $expense->notes,
            'location' => $expense->location,
            'cost' => $expense->amount,
            'odometer' => null,
            'date' => $expense->expense_date,
            'extra_data' => [
                'category' => $expense->category,
                'payment_method' => $expense->payment_method,
            ],
            'related_id' => $expense->id,
            'related_type' => 'App\Models\Expense',
        ]);
    }

    /**
     * Create history record from Income (for rental/work)
     */
    public static function createFromIncome($income)
    {
        return static::create([
            'vehicle_id' => $income->vehicle_id,
            'type' => 'work',
            'title' => $income->description ?? 'Pekerjaan',
            'description' => $income->notes,
            'location' => $income->location,
            'cost' => -$income->amount, // Negative untuk income
            'odometer' => null,
            'date' => $income->income_date,
            'extra_data' => [
                'type' => $income->type,
                'customer' => $income->customer_name,
            ],
            'related_id' => $income->id,
            'related_type' => 'App\Models\Income',
        ]);
    }
}
