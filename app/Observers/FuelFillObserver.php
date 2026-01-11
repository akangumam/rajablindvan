<?php

namespace App\Observers;

use App\Models\FuelFill;
use App\Models\HistoryRecord;

class FuelFillObserver
{
    /**
     * Handle the FuelFill "created" event.
     */
    public function created(FuelFill $fuelFill): void
    {
        if ($fuelFill->vehicle_id) {
            HistoryRecord::createFromFuelFill($fuelFill);
        }
    }

    /**
     * Handle the FuelFill "updated" event.
     */
    public function updated(FuelFill $fuelFill): void
    {
        // Update corresponding history record
        $history = HistoryRecord::where('related_id', $fuelFill->id)
            ->where('related_type', 'App\Models\FuelFill')
            ->first();

        if ($history) {
            $history->update([
                'vehicle_id' => $fuelFill->vehicle_id,
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
            ]);
        }
    }

    /**
     * Handle the FuelFill "deleted" event.
     */
    public function deleted(FuelFill $fuelFill): void
    {
        HistoryRecord::where('related_id', $fuelFill->id)
            ->where('related_type', 'App\Models\FuelFill')
            ->delete();
    }
}
