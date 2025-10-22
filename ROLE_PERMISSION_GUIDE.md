# 🔐 Role & Permission System Guide

## ✅ Implementation Status

**COMPLETED:**

-   ✅ Database migrations (user_vehicles table, user_type column)
-   ✅ User & Vehicle models with relationships
-   ✅ Middleware: CheckUserType, CheckVehicleAccess
-   ✅ All controllers updated with role-based filtering:
    -   VehicleController
    -   FuelFillController
    -   MaintenanceController
    -   ExpenseController
    -   IncomeController
    -   TripController
    -   DashboardController

**PENDING:**

-   ⏳ Vehicle assignment management UI
-   ⏳ Blade view updates with permission checks
-   ⏳ Test data seeder

---

## Overview

Sistem Role & Permission telah diimplementasikan untuk mengontrol akses berdasarkan tipe pengguna (User Type). Ada 2 tipe pengguna:

1. **Pengelola** - Full access ke semua fitur dan kendaraan
2. **Sopir** - Limited access, hanya ke kendaraan yang ditugaskan

---

## 📊 Database Structure

### 1. Tabel `users`

Ditambahkan kolom baru:

-   `user_type` (string, nullable) - Values: 'Pengelola' atau 'Sopir'

### 2. Tabel `user_vehicles` (New)

Pivot table untuk many-to-many relationship antara users dan vehicles:

-   `id` - Primary key
-   `user_id` - Foreign key ke users table
-   `vehicle_id` - Foreign key ke vehicles table
-   `created_at`, `updated_at` - Timestamps
-   **Unique constraint** pada kombinasi (user_id, vehicle_id)

---

## 🎭 User Types & Permissions

### Pengelola (Manager/Admin)

**Akses:**

-   ✅ Semua kendaraan (tidak perlu assignment)
-   ✅ Menambah/edit/hapus kendaraan
-   ✅ Mengelola user (tambah Pengelola & Sopir baru)
-   ✅ Assign kendaraan ke sopir
-   ✅ Akses penuh dashboard & reports
-   ✅ Manage fuel fills, maintenance, expenses, rentals

### Sopir (Driver)

**Akses:**

-   ⚠️ Hanya kendaraan yang di-assign ke mereka
-   ✅ Input fuel fill untuk kendaraan assigned
-   ✅ Input maintenance untuk kendaraan assigned
-   ❌ TIDAK bisa menambah kendaraan baru
-   ❌ TIDAK bisa mengelola user
-   ❌ TIDAK bisa melihat kendaraan lain
-   ⚠️ Dashboard terbatas (hanya data kendaraan mereka)

---

## 🔧 Implementation Details

### User Model Methods

```php
// Check user type
$user->isPengelola();  // returns boolean
$user->isSopir();      // returns boolean

// Check vehicle access
$user->hasAccessToVehicle($vehicleId);  // Pengelola: always true, Sopir: check assignment

// Check permissions
$user->canManageUsers();     // Pengelola only
$user->canManageVehicles();  // Pengelola only

// Get assigned vehicles (for Sopir)
$vehicles = $user->vehicles;  // Collection of Vehicle models
```

### Vehicle Model Methods

```php
// Get all users assigned to vehicle
$users = $vehicle->users;

// Get only drivers (Sopir) assigned to vehicle
$drivers = $vehicle->assignedDrivers;
```

### Scopes

```php
// Users
User::pengelola()->get();  // Get all Pengelola
User::sopir()->get();      // Get all Sopir

// Filter by user type
User::where('user_type', 'Pengelola')->get();
```

---

## 🛡️ Middleware Usage

### 1. CheckUserType Middleware

Untuk proteksi route berdasarkan user type:

```php
// routes/web.php

// Only Pengelola can access
Route::middleware(['auth', 'user.type:Pengelola'])->group(function () {
    Route::resource('vehicles', VehicleController::class);
    Route::resource('customers', CustomerController::class);
});

// Only Sopir can access
Route::middleware(['auth', 'user.type:Sopir'])->group(function () {
    Route::get('/my-vehicles', [VehicleController::class, 'myVehicles']);
});

// Both can access (just need to be authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});
```

### 2. CheckVehicleAccess Middleware

Untuk proteksi akses ke kendaraan spesifik:

```php
// routes/web.php

Route::middleware(['auth', 'vehicle.access'])->group(function () {
    Route::resource('fuel-fills', FuelFillController::class);
    Route::resource('maintenances', MaintenanceController::class);
    Route::resource('expenses', ExpenseController::class);
});
```

**Cara Kerja:**

-   Pengelola: Langsung lolos, akses semua kendaraan
-   Sopir: Cek apakah vehicle_id ada di assignments mereka

---

## 💻 Controller Implementation

### Example: Filter vehicles based on user type

```php
// VehicleController.php

public function index()
{
    $user = auth()->user();

    if ($user->isPengelola()) {
        // Pengelola sees all vehicles
        $vehicles = Vehicle::with('location')->paginate(20);
    } else {
        // Sopir only sees assigned vehicles
        $vehicles = $user->vehicles()->with('location')->paginate(20);
    }

    return view('vehicles.index', compact('vehicles'));
}
```

### Example: FuelFillController with authorization

```php
// FuelFillController.php

public function create()
{
    $user = auth()->user();

    if ($user->isPengelola()) {
        $vehicles = Vehicle::orderBy('name')->get();
    } else {
        $vehicles = $user->vehicles()->orderBy('name')->get();
    }

    return view('fuel-fills.create', compact('vehicles'));
}

public function store(Request $request)
{
    $user = auth()->user();
    $vehicleId = $request->vehicle_id;

    // Check access
    if (!$user->hasAccessToVehicle($vehicleId)) {
        abort(403, 'Anda tidak memiliki akses ke kendaraan ini.');
    }

    // Continue with normal process...
}
```

---

## 👥 Assign Vehicle to Driver

### In VehicleController or UserController:

```php
public function assignDriver(Request $request, Vehicle $vehicle)
{
    // Only Pengelola can assign
    if (!auth()->user()->isPengelola()) {
        abort(403, 'Hanya Pengelola yang bisa assign kendaraan.');
    }

    $request->validate([
        'user_id' => 'required|exists:users,id'
    ]);

    $driver = User::find($request->user_id);

    // Check if user is Sopir
    if (!$driver->isSopir()) {
        return back()->with('error', 'Hanya Sopir yang bisa di-assign ke kendaraan.');
    }

    // Attach vehicle to driver (will not duplicate due to unique constraint)
    $vehicle->users()->syncWithoutDetaching([$driver->id]);

    return back()->with('success', 'Driver berhasil di-assign ke kendaraan.');
}

public function unassignDriver(Vehicle $vehicle, User $driver)
{
    // Only Pengelola can unassign
    if (!auth()->user()->isPengelola()) {
        abort(403, 'Hanya Pengelola yang bisa unassign kendaraan.');
    }

    $vehicle->users()->detach($driver->id);

    return back()->with('success', 'Driver berhasil di-unassign dari kendaraan.');
}

public function getAssignedDrivers(Vehicle $vehicle)
{
    $drivers = $vehicle->assignedDrivers()->get();
    return view('vehicles.drivers', compact('vehicle', 'drivers'));
}
```

---

## 🎨 Blade Template Examples

### Show/hide based on user type

```blade
@auth
    @if(auth()->user()->isPengelola())
        <!-- Only Pengelola can see -->
        <a href="{{ route('vehicles.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Kendaraan
        </a>
    @endif

    @if(auth()->user()->isSopir())
        <!-- Only Sopir can see -->
        <p class="text-muted">
            Anda hanya bisa melihat kendaraan yang ditugaskan kepada Anda.
        </p>
    @endif
@endauth
```

### Vehicle selector with filtered list

```blade
<select name="vehicle_id" class="form-select" required>
    <option value="">Pilih Kendaraan</option>
    @if(auth()->user()->isPengelola())
        @foreach($vehicles as $vehicle)
            <option value="{{ $vehicle->id }}">{{ $vehicle->name }}</option>
        @endforeach
    @else
        @foreach(auth()->user()->vehicles as $vehicle)
            <option value="{{ $vehicle->id }}">{{ $vehicle->name }}</option>
        @endforeach
    @endif
</select>
```

---

## 📝 Next Steps

### TODO untuk implementasi penuh:

1. **Update all Controllers**

    - [ ] VehicleController - filter by user
    - [ ] FuelFillController - filter vehicles
    - [ ] MaintenanceController - filter vehicles
    - [ ] ExpenseController - filter vehicles
    - [ ] DashboardController - filter data

2. **Create Vehicle Assignment UI**

    - [ ] Page untuk assign/unassign drivers
    - [ ] List drivers per vehicle
    - [ ] List vehicles per driver

3. **Update Blade Views**

    - [ ] Hide/show buttons based on permissions
    - [ ] Filter vehicle dropdowns
    - [ ] Show warning messages for limited access

4. **Add Authorization Policies** (Optional, more Laravel way)

    ```bash
    php artisan make:policy VehiclePolicy --model=Vehicle
    ```

5. **Create Seeder untuk Testing**
    - [ ] Seed Pengelola users
    - [ ] Seed Sopir users
    - [ ] Seed vehicle assignments

---

## 🧪 Testing

### Manual Testing Steps:

1. Create 2 users:

    ```php
    // Pengelola
    User::create([
        'name' => 'Manager',
        'email' => 'manager@test.com',
        'password' => bcrypt('password'),
        'user_type' => 'Pengelola'
    ]);

    // Sopir
    User::create([
        'name' => 'Driver 1',
        'email' => 'driver@test.com',
        'password' => bcrypt('password'),
        'user_type' => 'Sopir'
    ]);
    ```

2. Assign vehicle to driver:

    ```php
    $vehicle = Vehicle::first();
    $driver = User::where('user_type', 'Sopir')->first();
    $vehicle->users()->attach($driver->id);
    ```

3. Test access:
    - Login as Pengelola → should see all vehicles
    - Login as Sopir → should only see assigned vehicle

---

## ⚠️ Important Notes

1. **Default Behavior:** Jika user_type NULL, mereka tidak akan bisa akses route yang protected
2. **Migration Safe:** Existing users akan punya user_type = NULL sampai diupdate
3. **Flexible:** Bisa tambah user_type baru di masa depan jika perlu
4. **Performance:** Use eager loading untuk relationships:
    ```php
    $user->load('vehicles');
    ```

---

## 📞 Support

Jika ada pertanyaan atau butuh modifikasi, dokumentasi ini bisa diupdate sesuai kebutuhan.

**Created:** October 17, 2025
**Version:** 1.0
