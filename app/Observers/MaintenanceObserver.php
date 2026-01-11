<?php

namespace App\Observers;

use App\Models\Maintenance;
use App\Models\HistoryRecord;

class MaintenanceObserver
{
    /**
     * Handle the Maintenance "created" event.
     */
    public function created(Maintenance $maintenance): void
    {
        if ($maintenance->vehicle_id) {
            HistoryRecord::createFromMaintenance($maintenance);
        }
    }

    /**
     * Handle the Maintenance "updated" event.
     */
    public function updated(Maintenance $maintenance): void
    {
        $history = HistoryRecord::where('related_id', $maintenance->id)
            ->where('related_type', 'App\Models\Maintenance')
            ->first();

        if ($history) {
            $type = 'service';
            $title = 'Servis';

            // Detect oil change
            if (str_contains(strtolower($maintenance->service_type ?? ''), 'oli')) {
                $type = 'oil_change';
                $title = 'Ganti Oli';
            }

            $history->update([
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
            ]);
        }
    }

    /**
     * Handle the Maintenance "deleted" event.
     */
    public function deleted(Maintenance $maintenance): void
    {
        HistoryRecord::where('related_id', $maintenance->id)
            ->where('related_type', 'App\Models\Maintenance')
            ->delete();
    }
}
