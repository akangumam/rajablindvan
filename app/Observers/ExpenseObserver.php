<?php

namespace App\Observers;

use App\Models\Expense;
use App\Models\HistoryRecord;

class ExpenseObserver
{
    /**
     * Handle the Expense "created" event.
     */
    public function created(Expense $expense): void
    {
        if ($expense->vehicle_id) {
            HistoryRecord::createFromExpense($expense);
        }
    }

    /**
     * Handle the Expense "updated" event.
     */
    public function updated(Expense $expense): void
    {
        $history = HistoryRecord::where('related_id', $expense->id)
            ->where('related_type', 'App\Models\Expense')
            ->first();

        if ($history) {
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

            $locationName = is_object($expense->location) ? ($expense->location->name ?? null) : $expense->location;
            if (empty($locationName) && !empty($expense->place)) {
                $locationName = $expense->place;
            }

            $history->update([
                'vehicle_id' => $expense->vehicle_id,
                'type' => $type,
                'title' => $expense->description ?? $expense->category,
                'description' => $expense->notes,
                'location' => $locationName,
                'cost' => $expense->amount ?? $expense->total_cost,
                'odometer' => $expense->odometer,
                'date' => $expense->expense_date,
                'extra_data' => [
                    'category' => $expense->category,
                    'payment_method' => $expense->payment_method,
                    'time' => $expense->expense_time,
                    'user_id' => $expense->user_id,
                ],
            ]);
        }
    }

    /**
     * Handle the Expense "deleted" event.
     */
    public function deleted(Expense $expense): void
    {
        HistoryRecord::where('related_id', $expense->id)
            ->where('related_type', 'App\Models\Expense')
            ->delete();
    }
}
