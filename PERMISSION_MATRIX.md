# PERMISSION MATRIX - RAJABLINDVAN

## Role Hierarchy & Access Control

### 1. ADMINISTRATOR (super_admin)

**Full System Access**

✅ **User Management**

-   Create, Edit, Delete users
-   Reset passwords for other users
-   View all users

✅ **Vehicle Management**

-   Full CRUD on vehicles
-   Assign drivers
-   Export vehicle data

✅ **Financial Management**

-   Manage fuel fills
-   Manage maintenance records
-   Manage expenses & incomes

✅ **Operations**

-   Manage orders & rentals
-   Create/Complete orders
-   Manage trips & checklists

✅ **Sales & Customers**

-   Full customer management
-   Full order management
-   View all reports

✅ **Settings**

-   Manage locations
-   Manage reminders
-   System settings

---

### 2. SALES (manager)

**Sales & Vehicle Management**

❌ **User Management**

-   Cannot create/edit/delete users
-   Cannot reset passwords
-   Cannot view users list

✅ **Vehicle Management**

-   Full CRUD on vehicles
-   Assign drivers
-   Export vehicle data

✅ **Financial Management**

-   View fuel fills (read-only)
-   View maintenance (read-only)
-   View expenses & incomes (read-only)

✅ **Sales & Customers**

-   Full customer management
-   Full order management
-   Create/Complete orders
-   Manage rentals

✅ **Reports**

-   View all reports
-   Generate sales reports

⚠️ **Limited Access**

-   Cannot manage system settings
-   Cannot manage users
-   Cannot delete critical records

---

### 3. OPERATION (operator)

**Operations Only**

❌ **User Management**

-   No access to users module

❌ **Vehicle Management**

-   Cannot create/edit vehicles
-   Cannot assign drivers
-   View only assigned vehicles

✅ **Operations Access**

-   View orders & rentals
-   Create operational records (fuel, maintenance)
-   Update trip status
-   Manage checklists

✅ **Read-Only Access**

-   View customers (no edit/delete)
-   View vehicles (assigned only)
-   View expenses & incomes
-   View reports (operational only)

❌ **Restrictions**

-   Cannot delete any records
-   Cannot manage financial data
-   Cannot manage customers
-   Cannot access system settings

---

## Current Implementation Status

### ✅ Implemented Permissions:

1. User management restricted to Administrator only
2. Delete protection for Administrator account
3. Password reset by Administrator only

### ⚠️ Issues Found:

1. **ALL routes have NO role middleware** except Users
2. Sales and Operation can access ALL modules (not restricted)
3. No differentiation between read/write access
4. Operation can create/delete everything (should be limited)

### 🔧 Recommended Fixes:

#### Priority 1: Route Protection

```php
// Users - Administrator only
Route::middleware(['role:super_admin'])->group(function () {
    Route::resource('users', UserController::class);
});

// Vehicles - Administrator & Sales
Route::middleware(['role:super_admin,manager'])->group(function () {
    Route::resource('vehicles', VehicleController::class);
});

// Operations - All roles (but with controller-level checks)
Route::resource('orders', OrderController::class);
Route::resource('rentals', RentalController::class);
```

#### Priority 2: Controller Authorization

Add checks in controllers:

```php
// In VehicleController destroy()
if (!auth()->user()->canDeleteRecords()) {
    abort(403, 'Unauthorized action.');
}
```

#### Priority 3: View-Level Restrictions

Hide buttons based on permissions:

```blade
@if(auth()->user()->canManageVehicles())
    <a href="{{ route('vehicles.create') }}">Add Vehicle</a>
@endif
```

---

## Proposed Permission Structure

| Feature         | Administrator | Sales        | Operation      |
| --------------- | ------------- | ------------ | -------------- |
| **Dashboard**   | ✅ Full       | ✅ Full      | ✅ Limited     |
| **Vehicles**    | ✅ CRUD       | ✅ CRUD      | 👁️ View Only   |
| **Fuel Fills**  | ✅ CRUD       | 👁️ View      | ✅ Create/Edit |
| **Maintenance** | ✅ CRUD       | 👁️ View      | ✅ Create/Edit |
| **Expenses**    | ✅ CRUD       | 👁️ View      | 👁️ View Only   |
| **Incomes**     | ✅ CRUD       | ✅ CRUD      | 👁️ View Only   |
| **Orders**      | ✅ CRUD       | ✅ CRUD      | ✅ Create/View |
| **Rentals**     | ✅ CRUD       | ✅ CRUD      | ✅ Create/View |
| **Customers**   | ✅ CRUD       | ✅ CRUD      | 👁️ View Only   |
| **Users**       | ✅ CRUD       | ❌ No Access | ❌ No Access   |
| **Locations**   | ✅ CRUD       | 👁️ View      | 👁️ View Only   |
| **Reminders**   | ✅ CRUD       | ✅ CRUD      | ✅ CRUD        |
| **Checklists**  | ✅ CRUD       | ✅ CRUD      | ✅ CRUD        |
| **Trips**       | ✅ CRUD       | ✅ CRUD      | ✅ CRUD        |
| **Reports**     | ✅ All        | ✅ Sales     | ✅ Operations  |
| **Settings**    | ✅ Full       | ❌ Limited   | ❌ No Access   |

**Legend:**

-   ✅ = Full Access (Create, Read, Update, Delete)
-   👁️ = View Only (Read-only)
-   ❌ = No Access

---

Last Updated: October 31, 2025
