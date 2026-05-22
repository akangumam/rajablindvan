<?php

namespace App\Console\Commands;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AutoCompleteOrders extends Command
{
    protected $signature = 'orders:auto-complete';
    protected $description = 'Automatically mark orders as completed when end_date has passed';

    public function handle()
    {
        $today = Carbon::today();

        $expiredOrders = Order::whereIn('status', ['active', 'Active', 'ACTIVE'])
            ->where('end_date', '<', $today)
            ->get();

        $count = $expiredOrders->count();

        foreach ($expiredOrders as $order) {
            $order->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);
        }

        $this->info("Auto-completed {$count} expired order(s).");

        return Command::SUCCESS;
    }
}
