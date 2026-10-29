<?php

namespace App\Observers;

use App\Models\Income;
use App\Models\HistoryRecord;

class IncomeObserver
{
    /**
     * Handle the Income "created" event.
     */
    public function created(Income $income): void
    {
        if ($income->vehicle_id) {
            HistoryRecord::createFromIncome($income);
        }
    }

    /**
     * Handle the Income "updated" event.
     */
    public function updated(Income $income): void
    {
        $history = HistoryRecord::where('related_id', $income->id)
            ->where('related_type', 'App\Models\Income')
            ->first();

        if ($history) {
            $history->update([
                'vehicle_id'  => $income->vehicle_id,
                'type'        => 'income',
                'title'       => $income->type ?? 'Pendapatan',
                'description' => $income->notes ?? $income->description,
                'cost'        => $income->amount,
                'odometer'    => $income->odometer ?? null,
                'date'        => $income->income_date,
                'extra_data'  => [
                    'income_type'    => $income->type,
                    'payment_method' => null,
                ],
            ]);
        }
    }

    /**
     * Handle the Income "deleted" event.
     */
    public function deleted(Income $income): void
    {
        HistoryRecord::where('related_id', $income->id)
            ->where('related_type', 'App\Models\Income')
            ->delete();
    }
}

