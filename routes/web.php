<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\FuelFillController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Middleware\LocationFilter;

// =====================================================
// Authentication Routes
// =====================================================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// =====================================================
// Protected Routes (Require Authentication)
// =====================================================
// =====================================================
// Protected Routes (Require Authentication)
// =====================================================
Route::middleware(['auth', LocationFilter::class])->group(function () {
    
    // ========================================
    // DASHBOARD
    // ========================================
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // ========================================
    // VEHICLE ROUTES (Must be ordered correctly!)
    // ========================================
    
    // 1. Specific Actions (Create, Store) - Admin/Manager Only
    Route::get('vehicles/create', [VehicleController::class, 'create'])
        ->name('vehicles.create')
        ->middleware('role:super_admin,manager');
        
    Route::post('vehicles', [VehicleController::class, 'store'])
        ->name('vehicles.store')
        ->middleware('role:super_admin,manager');
        
    // 2. Index - All Roles
    Route::get('vehicles', [VehicleController::class, 'index'])
        ->name('vehicles.index');
        
    // 3. Specific Vehicle Actions (Edit, Update, Delete) - Admin/Manager Only
    // MUST be before 'show' if using same URI pattern, but here we use /edit suffix so it's safe
    Route::get('vehicles/{vehicle}/edit', [VehicleController::class, 'edit'])
        ->name('vehicles.edit')
        ->middleware('role:super_admin,manager');
        
    Route::put('vehicles/{vehicle}', [VehicleController::class, 'update'])
        ->name('vehicles.update')
        ->middleware('role:super_admin,manager');
        
    Route::patch('vehicles/{vehicle}', [VehicleController::class, 'update']);
    
    Route::delete('vehicles/{vehicle}', [VehicleController::class, 'destroy'])
        ->name('vehicles.destroy')
        ->middleware('role:super_admin,manager');
        
    // 4. Special Vehicle Actions - Admin/Manager Only
    Route::group(['middleware' => ['role:super_admin,manager']], function () {
        Route::get('vehicles/{vehicle}/export-pdf', [VehicleController::class, 'exportPdf'])->name('vehicles.export-pdf');
        Route::get('vehicles/{vehicle}/assign-drivers', [VehicleController::class, 'assignDrivers'])->name('vehicles.assign-drivers');
        Route::post('vehicles/{vehicle}/assign-drivers', [VehicleController::class, 'storeDriverAssignment'])->name('vehicles.store-driver-assignment');
        Route::delete('vehicles/{vehicle}/drivers/{user}', [VehicleController::class, 'removeDriverAssignment'])->name('vehicles.remove-driver-assignment');
        Route::delete('vehicles/{vehicle}/barcode', [VehicleController::class, 'deleteBarcode'])->name('vehicles.delete-barcode');
        Route::delete('vehicles/{vehicle}/document', [VehicleController::class, 'deleteDocument'])->name('vehicles.delete-document');
        Route::delete('vehicles/documents/{documentId}', [VehicleController::class, 'deleteVehicleDocument'])->name('vehicles.delete-vehicle-document');
        
    });

    // 5. Show Detail - All Roles (Wildcard route MUST be last)
    Route::get('vehicles/{vehicle}', [VehicleController::class, 'show'])
        ->name('vehicles.show')
        ->where('vehicle', '[0-9]+');

    // ========================================
    // OTHER ROUTES
    // ========================================

    // Language Switcher
    Route::get('/locale/{locale}', [\App\Http\Controllers\LocaleController::class, 'switch'])->name('locale.switch');

    // ... (rest of the routes)

    // History - All can view
    Route::resource('history', HistoryController::class);
    Route::get('history/download', [HistoryController::class, 'downloadDetail'])->name('history.download');

    // Fuel Fills - All can view, Operation can create
    Route::resource('fuel-fills', FuelFillController::class);
    Route::get('vehicles/{vehicle}/fuel-fills/create', [FuelFillController::class, 'createForVehicle'])
        ->name('fuel-fills.create-for-vehicle');

    // Maintenances - All can view, Operation can create
    Route::resource('maintenances', MaintenanceController::class);
    Route::get('vehicles/{vehicle}/maintenances/create', [MaintenanceController::class, 'createForVehicle'])
        ->name('maintenances.create-for-vehicle');

    // Expenses - All can view, Operation can create
    Route::resource('expenses', ExpenseController::class);
    Route::get('vehicles/{vehicle}/expenses/create', [ExpenseController::class, 'createForVehicle'])
        ->name('expenses.create-for-vehicle');

    // Incomes - All can view, Operation can create
    Route::resource('incomes', \App\Http\Controllers\IncomeController::class);
    Route::get('vehicles/{vehicle}/incomes/create', [\App\Http\Controllers\IncomeController::class, 'createForVehicle'])
        ->name('incomes.create-for-vehicle');

    // Trips (Rute)
    Route::resource('trips', \App\Http\Controllers\TripController::class);
    Route::get('vehicles/{vehicle}/trips/create', [\App\Http\Controllers\TripController::class, 'createForVehicle'])
        ->name('trips.create-for-vehicle');

    // Customers - All roles
    Route::resource('customers', \App\Http\Controllers\CustomerController::class);

// Checklists - All roles
Route::resource('checklists', \App\Http\Controllers\ChecklistController::class);

// Reminders - All roles
Route::resource('reminders', \App\Http\Controllers\ReminderController::class);

// Orders - All roles can view and create
Route::post('orders/{order}/complete', [\App\Http\Controllers\OrderController::class, 'complete'])
    ->name('orders.complete');
Route::resource('orders', \App\Http\Controllers\OrderController::class);

// Rentals - All roles can view and create
Route::post('rentals/{rental}/start', [\App\Http\Controllers\RentalController::class, 'startRental'])
    ->name('rentals.start');
Route::post('rentals/{rental}/complete', [\App\Http\Controllers\RentalController::class, 'completeRental'])
    ->name('rentals.complete');
Route::resource('rentals', \App\Http\Controllers\RentalController::class);

// ========================================
// ADMINISTRATOR ONLY
// ========================================

// ========================================
// ADMINISTRATOR ONLY
// ========================================

// Users (Only Administrator)
Route::middleware(['role:super_admin'])->group(function () {
    Route::get('users/{user}/reset-password', [\App\Http\Controllers\UserController::class, 'showResetPasswordForm'])
        ->name('users.reset-password.form');
    Route::post('users/{user}/reset-password', [\App\Http\Controllers\UserController::class, 'resetPassword'])
        ->name('users.reset-password');
    Route::resource('users', \App\Http\Controllers\UserController::class);
    
    // Investors - Administrator Only (Financial & Strategic Data)
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/investors', [\App\Http\Controllers\InvestorController::class, 'index'])->name('investors.index');
        Route::get('/investors/create', [\App\Http\Controllers\InvestorController::class, 'create'])->name('investors.create');
        Route::post('/investors', [\App\Http\Controllers\InvestorController::class, 'store'])->name('investors.store');
        Route::get('/investors/{investor}', [\App\Http\Controllers\InvestorController::class, 'show'])->name('investors.show');
        Route::get('/investors/{investor}/edit', [\App\Http\Controllers\InvestorController::class, 'edit'])->name('investors.edit');
        Route::put('/investors/{investor}', [\App\Http\Controllers\InvestorController::class, 'update'])->name('investors.update');
        Route::delete('/investors/{investor}', [\App\Http\Controllers\InvestorController::class, 'destroy'])->name('investors.destroy');
        Route::get('/investors/{investor}/report', [\App\Http\Controllers\InvestorController::class, 'generateReport'])->name('investors.report');
    });
});

// Reports routes - All roles can view
Route::prefix('reports')->name('reports.')->group(function () {
    Route::get('/', [\App\Http\Controllers\ReportController::class, 'index'])->name('index');
    Route::post('generate', [\App\Http\Controllers\ReportController::class, 'generate'])->name('generate');
    Route::get('download/general', [\App\Http\Controllers\ReportController::class, 'downloadGeneral'])->name('download.general');
    Route::get('download/detail', [\App\Http\Controllers\ReportController::class, 'downloadDetail'])->name('download.detail');
    
    // Old routes (keep for backward compatibility)
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
    Route::post('/account/password', [\App\Http\Controllers\SettingsController::class, 'updatePassword'])->name('account.password');
    
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

}); // End of auth middleware group
