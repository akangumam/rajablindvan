<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\FuelFill;
use App\Models\Maintenance;
use App\Models\Expense;
use App\Models\HistoryRecord;

class MigrateHistoryData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'history:migrate {--fresh : Clear existing history records first}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate existing transaction data to history_records table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('fresh')) {
            $this->info('Clearing existing history records...');
            HistoryRecord::truncate();
        }

        $this->info('Migrating Fuel Fill records...');
        $fuelFills = FuelFill::whereNotNull('vehicle_id')->get();
        $bar = $this->output->createProgressBar($fuelFills->count());

        foreach ($fuelFills as $fuelFill) {
            // Check if history already exists
            $exists = HistoryRecord::where('related_id', $fuelFill->id)
                ->where('related_type', 'App\Models\FuelFill')
                ->exists();

            if (!$exists) {
                HistoryRecord::createFromFuelFill($fuelFill);
            }
            $bar->advance();
        }
        $bar->finish();
        $this->newLine();
        $this->info("Migrated {$fuelFills->count()} fuel fill records.");

        $this->info('Migrating Maintenance records...');
        $maintenances = Maintenance::whereNotNull('vehicle_id')->get();
        $bar = $this->output->createProgressBar($maintenances->count());

        foreach ($maintenances as $maintenance) {
            $exists = HistoryRecord::where('related_id', $maintenance->id)
                ->where('related_type', 'App\Models\Maintenance')
                ->exists();

            if (!$exists) {
                HistoryRecord::createFromMaintenance($maintenance);
            }
            $bar->advance();
        }
        $bar->finish();
        $this->newLine();
        $this->info("Migrated {$maintenances->count()} maintenance records.");

        $this->info('Migrating Expense records...');
        $expenses = Expense::whereNotNull('vehicle_id')->get();
        $bar = $this->output->createProgressBar($expenses->count());

        foreach ($expenses as $expense) {
            $exists = HistoryRecord::where('related_id', $expense->id)
                ->where('related_type', 'App\Models\Expense')
                ->exists();

            if (!$exists) {
                HistoryRecord::createFromExpense($expense);
            }
            $bar->advance();
        }
        $bar->finish();
        $this->newLine();
        $this->info("Migrated {$expenses->count()} expense records.");

        $total = HistoryRecord::count();
        $this->newLine();
        $this->info("✓ Migration completed! Total history records: {$total}");

        return Command::SUCCESS;
    }
}
