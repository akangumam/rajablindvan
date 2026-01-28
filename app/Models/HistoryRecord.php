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
        // Try to match location with registered locations
        $locationText = $fuelFill->location ?? $fuelFill->gas_station ?? $fuelFill->station_name;
        $matchedLocation = static::findMatchingLocation($locationText);

        return static::create([
            'vehicle_id' => $fuelFill->vehicle_id,
            'type' => 'refueling',
            'title' => 'Pengisian BBM',
            'description' => $fuelFill->notes,
            'location' => $matchedLocation ?: $locationText,
            'cost' => $fuelFill->total_cost ?? $fuelFill->cost,
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
        if (str_contains(strtolower($maintenance->service_type ?? ''), 'oli') ||
            str_contains(strtolower($maintenance->type ?? ''), 'oil')) {
            $type = 'oil_change';
            $title = 'Ganti Oli';
        }

        $date = $maintenance->maintenance_date ?? $maintenance->service_date;

        // Try to match location with registered locations
        $locationText = $maintenance->workshop ?? $maintenance->workshop_name ?? $maintenance->location;
        $matchedLocation = static::findMatchingLocation($locationText);

        // Try to match service type with registered service types
        $serviceTypeText = $maintenance->service_type ?? $maintenance->type;
        $matchedServiceType = static::findMatchingServiceType($serviceTypeText);

        return static::create([
            'vehicle_id' => $maintenance->vehicle_id,
            'type' => $type,
            'title' => $title,
            'description' => $maintenance->notes,
            'location' => $matchedLocation ?: $locationText,
            'cost' => $maintenance->cost ?? $maintenance->total_cost,
            'odometer' => $maintenance->odometer,
            'date' => $date,
            'extra_data' => [
                'service_type' => $matchedServiceType ?: $serviceTypeText,
                'workshop' => $matchedLocation ?: ($maintenance->workshop ?? $maintenance->workshop_name),
                'checklist' => 'checklist',
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
        // Map expense categories to history types
        $typeMapping = [
            'parkir' => 'parking',
            'parking' => 'parking',
            'tol' => 'toll',
            'toll' => 'toll',
            'cuci' => 'wash',
            'wash' => 'wash',
        ];

        $type = 'other';
        $category = strtolower($expense->category ?? '');

        foreach ($typeMapping as $key => $value) {
            if (str_contains($category, $key)) {
                $type = $value;
                break;
            }
        }

        // Try to match expense category with registered expense types
        $matchedExpenseType = static::findMatchingExpenseType($expense->category);

        // Try to match payment method with registered payment methods
        $matchedPaymentMethod = static::findMatchingPaymentMethod($expense->payment_method);

        return static::create([
            'vehicle_id' => $expense->vehicle_id,
            'type' => $type,
            'title' => $expense->description ?? $expense->category,
            'description' => $expense->notes,
            'location' => $expense->location,
            'cost' => $expense->amount ?? $expense->cost,
            'odometer' => null,
            'date' => $expense->expense_date,
            'extra_data' => [
                'category' => $matchedExpenseType ?: $expense->category,
                'payment_method' => $matchedPaymentMethod ?: $expense->payment_method,
            ],
            'related_id' => $expense->id,
            'related_type' => 'App\Models\Expense',
        ]);
    }

    /**
     * Find matching registered location by name
     */
    private static function findMatchingLocation($locationText)
    {
        if (empty($locationText)) {
            return null;
        }

        // Try exact match first
        $location = \App\Models\Location::where('is_active', true)
            ->where('name', $locationText)
            ->first();

        if ($location) {
            return $location->name . ($location->address ? ' - ' . $location->address : '');
        }

        // Try partial match (case insensitive)
        $location = \App\Models\Location::where('is_active', true)
            ->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($locationText) . '%'])
            ->first();

        if ($location) {
            return $location->name . ($location->address ? ' - ' . $location->address : '');
        }

        // No match found, return original text
        return null;
    }

    /**
     * Find matching service type by name
     */
    private static function findMatchingServiceType($serviceTypeText)
    {
        if (empty($serviceTypeText)) {
            return null;
        }

        // Try exact match
        $serviceType = \App\Models\ServiceType::where('is_active', true)
            ->where('name', $serviceTypeText)
            ->first();

        if ($serviceType) {
            return $serviceType->name;
        }

        // Try partial match (case insensitive)
        $serviceType = \App\Models\ServiceType::where('is_active', true)
            ->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($serviceTypeText) . '%'])
            ->first();

        if ($serviceType) {
            return $serviceType->name;
        }

        return null;
    }

    /**
     * Find matching expense type by category
     */
    private static function findMatchingExpenseType($categoryText)
    {
        if (empty($categoryText)) {
            return null;
        }

        // Try exact match
        $expenseType = \App\Models\ExpenseType::where('is_active', true)
            ->where('name', $categoryText)
            ->first();

        if ($expenseType) {
            return $expenseType->name;
        }

        // Try partial match (case insensitive)
        $expenseType = \App\Models\ExpenseType::where('is_active', true)
            ->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($categoryText) . '%'])
            ->first();

        if ($expenseType) {
            return $expenseType->name;
        }

        return null;
    }

    /**
     * Find matching payment method by name
     */
    private static function findMatchingPaymentMethod($paymentMethodText)
    {
        if (empty($paymentMethodText)) {
            return null;
        }

        // Try exact match
        $paymentMethod = \App\Models\PaymentMethod::where('is_active', true)
            ->where('name', $paymentMethodText)
            ->first();

        if ($paymentMethod) {
            return $paymentMethod->name;
        }

        // Try partial match (case insensitive)
        $paymentMethod = \App\Models\PaymentMethod::where('is_active', true)
            ->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($paymentMethodText) . '%'])
            ->first();

        if ($paymentMethod) {
            return $paymentMethod->name;
        }

        return null;
    }
}
