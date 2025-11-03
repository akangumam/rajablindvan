<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investor extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'id_number',
        'investment_percentage',
        'notes',
        'status'
    ];

    protected $casts = [
        'investment_percentage' => 'decimal:2',
    ];

    /**
     * Get all vehicles owned by this investor
     */
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    /**
     * Get total investment value (sum of vehicles)
     */
    public function getTotalInvestmentAttribute()
    {
        return $this->vehicles->sum('purchase_price') ?? 0;
    }

    /**
     * Get total rental income for this investor
     */
    public function getTotalIncomeAttribute()
    {
        $vehicleIds = $this->vehicles->pluck('id');
        return Rental::whereIn('vehicle_id', $vehicleIds)
            ->where('status', 'completed')
            ->sum('total_price') ?? 0;
    }

    /**
     * Get total expenses for investor's vehicles
     */
    public function getTotalExpensesAttribute()
    {
        $vehicleIds = $this->vehicles->pluck('id');
        
        $fuelCost = FuelFill::whereIn('vehicle_id', $vehicleIds)->sum('total_price') ?? 0;
        $maintenanceCost = Maintenance::whereIn('vehicle_id', $vehicleIds)->sum('cost') ?? 0;
        $expenseCost = Expense::whereIn('vehicle_id', $vehicleIds)->sum('amount') ?? 0;
        
        return $fuelCost + $maintenanceCost + $expenseCost;
    }

    /**
     * Get net profit
     */
    public function getNetProfitAttribute()
    {
        return $this->total_income - $this->total_expenses;
    }

    /**
     * Get investor's share based on percentage
     */
    public function getInvestorShareAttribute()
    {
        return $this->net_profit * ($this->investment_percentage / 100);
    }
}

