<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\FuelFillController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ExpenseController;

// Test route
Route::get('/test', function () {
    return 'Laravel is working!';
});

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Vehicles
Route::get('vehicles/{vehicle}/export-pdf', [VehicleController::class, 'exportPdf'])->name('vehicles.export-pdf');
Route::get('vehicles/{vehicle}/assign-drivers', [VehicleController::class, 'assignDrivers'])->name('vehicles.assign-drivers');
Route::post('vehicles/{vehicle}/assign-drivers', [VehicleController::class, 'storeDriverAssignment'])->name('vehicles.store-driver-assignment');
Route::delete('vehicles/{vehicle}/drivers/{user}', [VehicleController::class, 'removeDriverAssignment'])->name('vehicles.remove-driver-assignment');
Route::resource('vehicles', VehicleController::class);

// Fuel Fills
Route::resource('fuel-fills', FuelFillController::class);
Route::get('vehicles/{vehicle}/fuel-fills/create', [FuelFillController::class, 'createForVehicle'])
    ->name('fuel-fills.create-for-vehicle');

// Maintenances
Route::resource('maintenances', MaintenanceController::class);
Route::get('vehicles/{vehicle}/maintenances/create', [MaintenanceController::class, 'createForVehicle'])
    ->name('maintenances.create-for-vehicle');

// Expenses
Route::resource('expenses', ExpenseController::class);
Route::get('vehicles/{vehicle}/expenses/create', [ExpenseController::class, 'createForVehicle'])
    ->name('expenses.create-for-vehicle');

// Incomes
Route::resource('incomes', \App\Http\Controllers\IncomeController::class);
Route::get('vehicles/{vehicle}/incomes/create', [\App\Http\Controllers\IncomeController::class, 'createForVehicle'])
    ->name('incomes.create-for-vehicle');

// Trips (Rute)
Route::resource('trips', \App\Http\Controllers\TripController::class);
Route::get('vehicles/{vehicle}/trips/create', [\App\Http\Controllers\TripController::class, 'createForVehicle'])
    ->name('trips.create-for-vehicle');

// Checklists
Route::resource('checklists', \App\Http\Controllers\ChecklistController::class);

// Reminders
Route::resource('reminders', \App\Http\Controllers\ReminderController::class);

// Customers
Route::resource('customers', \App\Http\Controllers\CustomerController::class);

// Locations
Route::resource('locations', \App\Http\Controllers\LocationController::class);
Route::get('locations/{location}/compare', [\App\Http\Controllers\LocationController::class, 'compare'])->name('locations.compare');
Route::get('multi-location/dashboard', [\App\Http\Controllers\LocationController::class, 'compare'])->name('multi-location.dashboard');

// Rentals
Route::resource('rentals', \App\Http\Controllers\RentalController::class);
Route::post('rentals/{rental}/start', [\App\Http\Controllers\RentalController::class, 'startRental'])
    ->name('rentals.start');
Route::post('rentals/{rental}/complete', [\App\Http\Controllers\RentalController::class, 'completeRental'])
    ->name('rentals.complete');

// Reports routes
Route::prefix('reports')->name('reports.')->group(function () {
    Route::get('dashboard', [\App\Http\Controllers\ReportController::class, 'dashboard'])->name('dashboard');
    Route::get('rentals', [\App\Http\Controllers\ReportController::class, 'rentals'])->name('rentals');
    Route::get('vehicles', [\App\Http\Controllers\ReportController::class, 'vehicles'])->name('vehicles');
    Route::get('financial', [\App\Http\Controllers\ReportController::class, 'financial'])->name('financial');
    Route::get('customers', [\App\Http\Controllers\ReportController::class, 'customers'])->name('customers');
    
    // PDF Export routes
    Route::get('dashboard/pdf', [\App\Http\Controllers\ReportController::class, 'exportDashboardPdf'])->name('dashboard.pdf');
    Route::get('rentals/pdf', [\App\Http\Controllers\ReportController::class, 'exportRentalsPdf'])->name('rentals.pdf');
    Route::get('customers/pdf', [\App\Http\Controllers\ReportController::class, 'exportCustomersPdf'])->name('customers.pdf');
    
    // Excel Export routes
    Route::get('financial/excel', [\App\Http\Controllers\ReportController::class, 'exportFinancialExcel'])->name('financial.excel');
    Route::get('vehicles/excel', [\App\Http\Controllers\ReportController::class, 'exportVehiclesExcel'])->name('vehicles.excel');
    Route::get('customers/excel', [\App\Http\Controllers\ReportController::class, 'exportCustomersExcel'])->name('customers.excel');
    Route::get('rentals/excel', [\App\Http\Controllers\ReportController::class, 'exportRentalsExcel'])->name('rentals.excel');
});

// Settings routes
Route::prefix('settings')->name('settings.')->group(function () {
    Route::get('/', [\App\Http\Controllers\SettingsController::class, 'index'])->name('index');
    
    // Pengaturan sub-menu
    Route::get('/units', [\App\Http\Controllers\SettingsController::class, 'units'])->name('units');
    Route::get('/reminders', [\App\Http\Controllers\SettingsController::class, 'reminders'])->name('reminders');
    Route::get('/format', [\App\Http\Controllers\SettingsController::class, 'format'])->name('format');
    
    // Account
    Route::get('/account', [\App\Http\Controllers\SettingsController::class, 'account'])->name('account');
    
    Route::get('/fuel-types', [\App\Http\Controllers\SettingsController::class, 'fuelTypes'])->name('fuel-types');
    Route::get('/fuel-grades', [\App\Http\Controllers\SettingsController::class, 'fuelGrades'])->name('fuel-grades');
    Route::get('/fuel-stations', [\App\Http\Controllers\SettingsController::class, 'fuelStations'])->name('fuel-stations');
    Route::get('/locations', [\App\Http\Controllers\SettingsController::class, 'locations'])->name('locations');
    Route::get('/service-types', [\App\Http\Controllers\SettingsController::class, 'serviceTypes'])->name('service-types');
    Route::get('/expense-types', [\App\Http\Controllers\SettingsController::class, 'expenseTypes'])->name('expense-types');
    Route::get('/income-types', [\App\Http\Controllers\SettingsController::class, 'incomeTypes'])->name('income-types');
    Route::get('/reasons', [\App\Http\Controllers\SettingsController::class, 'reasons'])->name('reasons');
    Route::get('/payment-methods', [\App\Http\Controllers\SettingsController::class, 'paymentMethods'])->name('payment-methods');
    Route::get('/forms', [\App\Http\Controllers\SettingsController::class, 'forms'])->name('forms');
    Route::get('/contacts', [\App\Http\Controllers\SettingsController::class, 'contacts'])->name('contacts');
    Route::get('/translations', [\App\Http\Controllers\SettingsController::class, 'translations'])->name('translations');
});
