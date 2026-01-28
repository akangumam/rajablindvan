<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Testing Observer Connection ===\n\n";

// Check existing history records
$totalHistory = App\Models\HistoryRecord::count();
$withRelated = App\Models\HistoryRecord::whereNotNull('related_id')->count();

echo "Total History Records: $totalHistory\n";
echo "Records with related_id: $withRelated\n\n";

// Show sample records
echo "Sample History Records:\n";
App\Models\HistoryRecord::limit(3)->get()->each(function($record) {
    echo "- {$record->title} (Type: {$record->type}, Related: {$record->related_type} #{$record->related_id})\n";
});

echo "\n=== Connection Status ===\n";
if ($withRelated === $totalHistory && $totalHistory > 0) {
    echo "✓ Semua history records terkoneksi dengan transaksi asli\n";
} else if ($withRelated > 0) {
    echo "⚠ Sebagian history records terkoneksi ({$withRelated}/{$totalHistory})\n";
} else {
    echo "✗ History records TIDAK terkoneksi dengan transaksi asli\n";
}

echo "\n=== Testing Create New Transaction ===\n";

// Get a vehicle
$vehicle = App\Models\Vehicle::first();
if ($vehicle) {
    echo "Using vehicle: {$vehicle->name} ({$vehicle->license_plate})\n";

    $beforeCount = App\Models\HistoryRecord::where('vehicle_id', $vehicle->id)->count();

    // Create a test fuel fill
    $fuelFill = App\Models\FuelFill::create([
        'vehicle_id' => $vehicle->id,
        'fill_date' => now(),
        'odometer' => 50000,
        'liters' => 40,
        'price_per_liter' => 10500,
        'total_cost' => 420000,
        'fuel_type' => 'Pertamax',
        'gas_station' => 'Test Station',
        'is_full_tank' => true,
        'notes' => 'Test Observer - ' . now(),
    ]);

    $afterCount = App\Models\HistoryRecord::where('vehicle_id', $vehicle->id)->count();

    echo "\nBefore: $beforeCount records\n";
    echo "After: $afterCount records\n";

    if ($afterCount > $beforeCount) {
        echo "✓ Observer BEKERJA! History otomatis tercatat\n";

        // Show the created history
        $newHistory = App\Models\HistoryRecord::where('vehicle_id', $vehicle->id)
            ->orderBy('created_at', 'desc')
            ->first();
        echo "\nNew history record:\n";
        echo "  Title: {$newHistory->title}\n";
        echo "  Type: {$newHistory->type}\n";
        echo "  Cost: Rp " . number_format($newHistory->cost, 0, ',', '.') . "\n";
        echo "  Related: {$newHistory->related_type} #{$newHistory->related_id}\n";
    } else {
        echo "✗ Observer TIDAK bekerja!\n";
    }

    // Clean up
    $fuelFill->delete();
    echo "\n(Test data cleaned up)\n";
} else {
    echo "No vehicle found for testing\n";
}
