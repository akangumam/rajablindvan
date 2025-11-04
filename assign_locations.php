<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Location;
use App\Models\Vehicle;
use App\Models\Expense;

echo "=== CHECKING LOCATIONS ===\n";
$locations = Location::all();
echo "Total locations: " . $locations->count() . "\n";
foreach ($locations as $loc) {
    echo "  - {$loc->name} (Code: {$loc->code}, ID: {$loc->id})\n";
}

// Use existing location codes
$hq = Location::where('code', 'HQ')->first();
$jakarta = Location::where('code', 'JKT')->first();

if (!$hq || !$jakarta) {
    echo "\n❌ ERROR: Locations not found!\n";
    echo "Available codes: " . $locations->pluck('code')->implode(', ') . "\n";
    exit(1);
}

echo "\n=== ASSIGNING VEHICLES ===\n";
$vehicles = Vehicle::whereNull('location_id')->get();
echo "Vehicles without location: " . $vehicles->count() . "\n";

$halfway = (int) ceil($vehicles->count() / 2);
foreach ($vehicles as $index => $vehicle) {
    $locationId = ($index < $halfway) ? $hq->id : $jakarta->id;
    $locationName = ($index < $halfway) ? 'Kantor Pusat' : 'Jakarta Office';
    
    $vehicle->location_id = $locationId;
    $vehicle->save();
    
    echo "  ✓ Vehicle #{$vehicle->id} ({$vehicle->name}) -> {$locationName}\n";
}

echo "\n=== ASSIGNING EXPENSES ===\n";
$expenses = Expense::whereNull('location_id')->get();
echo "Expenses without location: " . $expenses->count() . "\n";

foreach ($expenses as $expense) {
    if ($expense->vehicle_id) {
        $vehicle = Vehicle::find($expense->vehicle_id);
        if ($vehicle && $vehicle->location_id) {
            $expense->location_id = $vehicle->location_id;
            $expense->save();
            echo "  ✓ Expense #{$expense->id} -> {$vehicle->location->name} (from vehicle)\n";
            continue;
        }
    }
    
    $locationId = (rand(0, 1) == 0) ? $hq->id : $jakarta->id;
    $locationName = ($locationId == $hq->id) ? 'Kantor Pusat' : 'Jakarta Office';
    $expense->location_id = $locationId;
    $expense->save();
    echo "  ✓ Expense #{$expense->id} -> {$locationName} (random)\n";
}

echo "\n=== SUMMARY ===\n";
echo "Vehicles in Kantor Pusat: " . Vehicle::where('location_id', $hq->id)->count() . "\n";
echo "Vehicles in Jakarta Office: " . Vehicle::where('location_id', $jakarta->id)->count() . "\n";
echo "Vehicles without location: " . Vehicle::whereNull('location_id')->count() . "\n";
echo "\nExpenses in Kantor Pusat: " . Expense::where('location_id', $hq->id)->count() . "\n";
echo "Expenses in Jakarta Office: " . Expense::where('location_id', $jakarta->id)->count() . "\n";
echo "Expenses without location: " . Expense::whereNull('location_id')->count() . "\n";

echo "\n✅ DONE!\n";
