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
            $type = $history->type ?: 'service';
            $title = $history->title ?: 'Servis';

            if (!in_array($type, ['service', 'oil_change'])) {
                $type = 'service';
            }
            if (empty($history->title) || in_array($history->title, ['Servis', 'Ganti Oli'])) {
                if (str_contains(strtolower($maintenance->service_type ?? ''), 'oli') ||
                    str_contains(strtolower($maintenance->type ?? ''), 'oil')) {
                    $type = 'oil_change';
                    $title = 'Ganti Oli';
                } else {
                    $type = 'service';
                    $title = 'Servis';
                }
            }

            $location = $maintenance->place ?? $maintenance->workshop ?? $maintenance->workshop_name ?? $maintenance->location;
            $serviceItems = HistoryRecord::parseServiceItemsFromMaintenance($maintenance);

            $history->update([
                'vehicle_id' => $maintenance->vehicle_id,
                'type' => $type,
                'title' => $title,
                'description' => $maintenance->notes,
                'location' => $location,
                'cost' => $maintenance->total_cost ?? $maintenance->cost,
                'odometer' => $maintenance->odometer,
                'date' => $maintenance->service_date ?? $maintenance->maintenance_date,
                'extra_data' => [
                    'service_type' => $maintenance->service_type ?? $maintenance->type,
                    'service_items' => $serviceItems,
                    'workshop' => $location,
                    'time' => $maintenance->service_time,
                    'user_id' => $maintenance->user_id,
                    'payment_method' => $maintenance->payment_method,
                    'checklist' => 'checklist',
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
