<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\FuelFillController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\HistoryController;

// Language Switcher
Route::get('/locale/{locale}', [\App\Http\Controllers\LocaleController::class, 'switch'])->name('locale.switch');

// Test route
Route::get('/test', function () {
    return 'Laravel is working!';
});

// Debug locale route
Route::get('/debug-locale', function () {
    return [
        'current_locale' => app()->getLocale(),
        'session_locale' => session('locale'),
        'config_locale' => config('app.locale'),
        'available_locales' => ['id', 'en'],
        'test_translation_id' => __('common.dashboard'),
        'test_translation_direct' => trans('common.dashboard'),
        'test_vehicles' => __('common.vehicles'),
        'test_customers' => __('common.customers'),
        'test_add_new' => __('common.add_new'),
    ];
});

// Test locale manually
Route::get('/test-locale/{locale}', function ($locale) {
    if (!in_array($locale, ['id', 'en'])) {
        return 'Invalid locale';
    }
    
    session(['locale' => $locale]);
    app()->setLocale($locale);
    
    return [
        'locale_set' => $locale,
        'app_locale' => app()->getLocale(),
        'session_locale' => session('locale'),
        'test_dashboard' => __('common.dashboard'),
        'test_vehicles' => __('common.vehicles'),
        'test_customers' => __('common.customers'),
        'test_add_new' => __('common.add_new'),
        'test_reminders' => __('common.reminders'),
        'test_reports' => __('common.reports'),
        'test_settings' => __('common.settings'),
        'lang_path' => lang_path(),
        'file_exists_id' => file_exists(lang_path('id/common.php')),
        'file_exists_en' => file_exists(lang_path('en/common.php')),
    ];
});

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// History
Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
Route::get('/history/download', [HistoryController::class, 'downloadDetail'])->name('history.download');

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

// Users
Route::resource('users', \App\Http\Controllers\UserController::class);

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
    Route::post('/format', [\App\Http\Controllers\SettingsController::class, 'saveFormat'])->name('format.save');
    
    // Account
    Route::get('/account', [\App\Http\Controllers\SettingsController::class, 'account'])->name('account');
    
    // File and Storage
    Route::get('/file-storage', [\App\Http\Controllers\SettingsController::class, 'fileStorage'])->name('file-storage');
    Route::post('/file-storage/upload', [\App\Http\Controllers\SettingsController::class, 'uploadFile'])->name('file-storage.upload');
    Route::get('/file-storage/download/{id}', [\App\Http\Controllers\SettingsController::class, 'downloadFile'])->name('file-storage.download');
    Route::delete('/file-storage/delete/{id}', [\App\Http\Controllers\SettingsController::class, 'deleteFile'])->name('file-storage.delete');
    Route::get('/file-storage/download-all', [\App\Http\Controllers\SettingsController::class, 'downloadAllFiles'])->name('file-storage.download-all');
    
    Route::get('/fuel-types', [\App\Http\Controllers\SettingsController::class, 'fuelTypes'])->name('fuel-types');
    Route::get('/fuel-grades', [\App\Http\Controllers\SettingsController::class, 'fuelGrades'])->name('fuel-grades');
    Route::get('/fuel-stations', [\App\Http\Controllers\SettingsController::class, 'fuelStations'])->name('fuel-stations');
    
    // Locations
    Route::get('/locations', [\App\Http\Controllers\SettingsController::class, 'locations'])->name('locations');
    Route::post('/locations', [\App\Http\Controllers\SettingsController::class, 'storeLocation'])->name('locations.store');
    Route::put('/locations/{id}', [\App\Http\Controllers\SettingsController::class, 'updateLocation'])->name('locations.update');
    Route::delete('/locations/{id}', [\App\Http\Controllers\SettingsController::class, 'destroyLocation'])->name('locations.destroy');
    
    // Service Types
    Route::get('/service-types', [\App\Http\Controllers\SettingsController::class, 'serviceTypes'])->name('service-types');
    Route::post('/service-types', [\App\Http\Controllers\SettingsController::class, 'storeServiceType'])->name('service-types.store');
    Route::put('/service-types/{id}', [\App\Http\Controllers\SettingsController::class, 'updateServiceType'])->name('service-types.update');
    Route::delete('/service-types/{id}', [\App\Http\Controllers\SettingsController::class, 'destroyServiceType'])->name('service-types.destroy');
    
    // Expense Types
    Route::get('/expense-types', [\App\Http\Controllers\SettingsController::class, 'expenseTypes'])->name('expense-types');
    Route::post('/expense-types', [\App\Http\Controllers\SettingsController::class, 'storeExpenseType'])->name('expense-types.store');
    Route::put('/expense-types/{id}', [\App\Http\Controllers\SettingsController::class, 'updateExpenseType'])->name('expense-types.update');
    Route::delete('/expense-types/{id}', [\App\Http\Controllers\SettingsController::class, 'destroyExpenseType'])->name('expense-types.destroy');
    
    // Income Types
    Route::get('/income-types', [\App\Http\Controllers\SettingsController::class, 'incomeTypes'])->name('income-types');
    Route::post('/income-types', [\App\Http\Controllers\SettingsController::class, 'storeIncomeType'])->name('income-types.store');
    Route::put('/income-types/{id}', [\App\Http\Controllers\SettingsController::class, 'updateIncomeType'])->name('income-types.update');
    Route::delete('/income-types/{id}', [\App\Http\Controllers\SettingsController::class, 'destroyIncomeType'])->name('income-types.destroy');
    
    // Payment Methods
    Route::get('/payment-methods', [\App\Http\Controllers\SettingsController::class, 'paymentMethods'])->name('payment-methods');
    Route::post('/payment-methods', [\App\Http\Controllers\SettingsController::class, 'storePaymentMethod'])->name('payment-methods.store');
    Route::put('/payment-methods/{id}', [\App\Http\Controllers\SettingsController::class, 'updatePaymentMethod'])->name('payment-methods.update');
    Route::delete('/payment-methods/{id}', [\App\Http\Controllers\SettingsController::class, 'destroyPaymentMethod'])->name('payment-methods.destroy');
    
    Route::get('/reasons', [\App\Http\Controllers\SettingsController::class, 'reasons'])->name('reasons');
    Route::get('/forms', [\App\Http\Controllers\SettingsController::class, 'forms'])->name('forms');
    Route::get('/contacts', [\App\Http\Controllers\SettingsController::class, 'contacts'])->name('contacts');
    Route::get('/translations', [\App\Http\Controllers\SettingsController::class, 'translations'])->name('translations');
});
