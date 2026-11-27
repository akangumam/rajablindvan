<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Vehicle;
use App\Models\Location;
use App\Models\UploadedFile;
use Illuminate\Support\Str;
use App\Http\Middleware\LocationFilter;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        // Apply location filter
        $locationId = LocationFilter::getLocationId();

        // Filter expenses based on user type
        if ($user && $user->isPengelola()) {
            $query = Expense::with(['vehicle', 'location']);

            if ($locationId) {
                $query->where('location_id', $locationId);
            }

            $expenses = $query->latest('expense_date')->paginate(20);
        } elseif ($user && $user->isSopir()) {
            $vehicleIds = $user->vehicles()->pluck('vehicles.id');
            $query = Expense::with(['vehicle', 'location'])
                ->whereIn('vehicle_id', $vehicleIds);

            if ($locationId) {
                $query->where('location_id', $locationId);
            }

            $expenses = $query->latest('expense_date')->paginate(20);
        } else {
            $query = Expense::with(['vehicle', 'location']);

            if ($locationId) {
                $query->where('location_id', $locationId);
            }

            $expenses = $query->latest('expense_date')->paginate(20);
        }

        // Get locations for filter dropdown
        $locations = Location::active()->get();
        $selectedLocation = $locationId;

        return view('expenses.index', compact('expenses', 'locations', 'selectedLocation'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = auth()->user();

        // Filter vehicles based on user type
        if ($user && $user->isPengelola()) {
            $vehicles = Vehicle::active()->orderBy('name')->get();
        } elseif ($user && $user->isSopir()) {
            $vehicles = $user->vehicles()->where('is_active', true)->orderBy('name')->get();
        } else {
            $vehicles = Vehicle::active()->orderBy('name')->get();
        }

        // Get reference data for dropdowns
        $expenseTypes = \App\Models\ExpenseType::active()->orderBy('name')->get();
        $paymentMethods = \App\Models\PaymentMethod::active()->orderBy('name')->get();

        // Get reference data for dropdowns
        $expenseTypes = \App\Models\ExpenseType::active()->orderBy('name')->get();
        $paymentMethods = \App\Models\PaymentMethod::active()->orderBy('name')->get();

        // If vehicle_id is provided in query string
        if ($request->has('vehicle_id')) {
            $vehicle = Vehicle::findOrFail($request->vehicle_id);

            // Check access for Sopir
            if ($user && $user->isSopir() && !$user->hasAccessToVehicle($vehicle->id)) {
                abort(403, 'Anda tidak memiliki akses ke kendaraan ini.');
            }

            return view('expenses.create-new', compact('vehicles', 'vehicle', 'expenseTypes', 'paymentMethods'));
        }

        return view('expenses.create-new', compact('vehicles', 'expenseTypes', 'paymentMethods'));
    }

    /**
     * Create expense for specific vehicle
     */
    public function createForVehicle(Vehicle $vehicle)
    {
        $user = auth()->user();

        // Get vehicles based on user role
        if ($user && $user->isPengelola()) {
            $vehicles = Vehicle::where('is_active', true)->orderBy('name')->get();
        } elseif ($user && $user->isSopir()) {
            $vehicles = $user->vehicles()->where('is_active', true)->orderBy('name')->get();
        } else {
            $vehicles = Vehicle::where('is_active', true)->orderBy('name')->get();
        }

        return view('expenses.create-new', compact('vehicle', 'vehicles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $vehicle = Vehicle::findOrFail($request->vehicle_id);

        // Check access for Sopir
        if ($user && $user->isSopir() && !$user->hasAccessToVehicle($vehicle->id)) {
            abort(403, 'Anda tidak memiliki akses ke kendaraan ini.');
        }

        $validated = $request->validate([
            'vehicle_id'        => 'required|exists:vehicles,id',
            'expense_date'      => 'required|date',
            'expense_time'      => 'nullable',
            'odometer'          => 'nullable|numeric|min:0',
            'expense_type_id'   => 'required|exists:expense_types,id',
            'place'             => 'nullable|string|max:255',
            'user_id'           => 'nullable|exists:users,id',
            'amount'            => 'required|numeric|min:0',
            'notes'             => 'nullable|string',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
            'stnk_expiry_date'  => 'nullable|date',
            'kir_expiry_date'   => 'nullable|date',
            'gps_expiry_date'   => 'nullable|date',
            'attachment'        => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx',
        ]);

        // Validate Odometer (Must be >= last recorded)
        // Only if odometer is provided
        if (!empty($validated['odometer'])) {
            $lastOdometer = $vehicle->getLatestOdometer();
            if ($validated['odometer'] < $lastOdometer) {
                return back()->withErrors(['odometer' => "Odometer tidak boleh lebih kecil dari nilai terakhir tercatat ($lastOdometer KM)."])->withInput();
            }

            // Update Vehicle Odometer if higher
            if ($validated['odometer'] > $vehicle->odometer) {
                $vehicle->update(['odometer' => $validated['odometer']]);
            }
        }

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $storedName = Str::uuid() . '.' . $extension;

            $path = $file->storeAs('expenses', $storedName, 'public');
            $validated['attachment'] = $path;

            // Track file in storage management
            UploadedFile::create([
                'original_name' => $originalName,
                'stored_name' => $storedName,
                'file_path' => $path,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'file_type' => $this->determineFileType($file->getMimeType(), $extension),
                'category' => 'expense',
            ]);
        }

        // Set user_id if not provided
        if (!isset($validated['user_id'])) {
            $validated['user_id'] = auth()->id();
        }

        // Set location_id from vehicle
        $validated['location_id'] = $vehicle->location_id;

        // Populate derived fields (Category, Description, etc)
        $expenseType = \App\Models\ExpenseType::find($validated['expense_type_id']);
        if ($expenseType) {
            $validated['category'] = $expenseType->name;
            $validated['expense_type'] = $expenseType->name; // Legacy support if column exists
        } else {
             $validated['category'] = 'General';
        }

        // Use notes as description if description is missing
        $validated['description'] = $request->notes ?? ($validated['category'] . ' - ' . $vehicle->license_plate);

        // Map Payment Method Name if needed by legacy columns
        if (!empty($validated['payment_method_id'])) {
             $pm = \App\Models\PaymentMethod::find($validated['payment_method_id']);
             if ($pm) {
                 $validated['payment_method'] = $pm->name;
             }
        }

        // Update vehicle expiry dates if provided
        $vehicleUpdates = [];
        if (!empty($validated['stnk_expiry_date'])) {
            $vehicleUpdates['stnk_expiry_date'] = $validated['stnk_expiry_date'];
        }
        if (!empty($validated['kir_expiry_date'])) {
            $vehicleUpdates['kir_expiry_date'] = $validated['kir_expiry_date'];
        }
        if (!empty($validated['gps_expiry_date'])) {
            $vehicleUpdates['gps_expiry_date'] = $validated['gps_expiry_date'];
        }

        if (!empty($vehicleUpdates)) {
            $vehicle->update($vehicleUpdates);
        }

        Expense::create($validated);

        return redirect()->route('history.index', ['vehicle_id' => $vehicle->id])
            ->with('success', 'Pengeluaran berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $expense = Expense::with(['vehicle', 'user', 'location'])->findOrFail($id);
        return view('expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $expense = Expense::with('vehicle')->findOrFail($id);
        $user = auth()->user();

        if ($user && $user->isSopir() && $expense->vehicle_id && !$user->hasAccessToVehicle($expense->vehicle_id)) {
            abort(403, 'Anda tidak memiliki akses ke kendaraan ini.');
        }

        $vehicles       = Vehicle::where('is_active', true)->orderBy('name')->get();
        $expenseTypes   = \App\Models\ExpenseType::active()->orderBy('name')->get();
        $places         = \App\Models\Place::getAllActive();
        $paymentMethods = \App\Models\PaymentMethod::active()->orderBy('name')->get();
        $users          = \App\Models\User::active()->orderBy('name')->get();

        return view('expenses.edit', compact(
            'expense',
            'vehicles',
            'expenseTypes',
            'places',
            'paymentMethods',
            'users'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $expense = Expense::findOrFail($id);
        $vehicle = Vehicle::findOrFail($request->vehicle_id);

        $validated = $request->validate([
            'vehicle_id'        => 'required|exists:vehicles,id',
            'expense_date'      => 'required|date',
            'expense_time'      => 'nullable',
            'odometer'          => 'nullable|numeric|min:0',
            'expense_type_id'   => 'nullable|exists:expense_types,id',
            'category'          => 'nullable|string|max:255',
            'place'             => 'nullable|string|max:255',
            'user_id'           => 'nullable|exists:users,id',
            'amount'            => 'required|numeric|min:0',
            'notes'             => 'nullable|string',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
            'payment_method'    => 'nullable|string|max:255',
            'attachment'        => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx',
        ]);

        if ($request->filled('expense_type_id')) {
            $expenseType = \App\Models\ExpenseType::find($validated['expense_type_id']);
            if ($expenseType) {
                $validated['category'] = $expenseType->name;
                $validated['expense_type'] = $expenseType->name;
            }
        } elseif (!empty($validated['category'])) {
            $validated['expense_type'] = $validated['category'];
        }

        if ($request->filled('payment_method_id')) {
            $pm = \App\Models\PaymentMethod::find($validated['payment_method_id']);
            if ($pm) {
                $validated['payment_method'] = $pm->name;
            }
        }

        $validated['total_cost'] = $validated['amount'];
        $validated['description'] = $request->notes ?: ($validated['category'] ?? $expense->category) . ' - ' . $vehicle->license_plate;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $storedName = Str::uuid() . '.' . $extension;

            $path = $file->storeAs('expenses', $storedName, 'public');
            $validated['attachment'] = $path;

            UploadedFile::create([
                'original_name' => $originalName,
                'stored_name' => $storedName,
                'file_path' => $path,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'file_type' => $this->determineFileType($file->getMimeType(), $extension),
                'category' => 'expense',
            ]);
        }

        $expense->update($validated);

        if (!empty($validated['odometer']) && $validated['odometer'] > ($vehicle->odometer ?? 0)) {
            $vehicle->update(['odometer' => $validated['odometer']]);
        }

        return redirect()->route('expenses.show', $expense)
            ->with('success', 'Data pengeluaran berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!auth()->user()->canDeleteRecords()) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus data pengeluaran.');
        }

        $expense = Expense::findOrFail($id);
        $vehicleId = $expense->vehicle_id;
        $expense->delete();

        return $vehicleId
            ? redirect()->route('vehicles.show', $vehicleId)->with('success', 'Data pengeluaran berhasil dihapus!')
            : redirect()->route('expenses.index')->with('success', 'Data pengeluaran berhasil dihapus!');
    }

    /**
     * Determine file type based on mime type and extension
     */
    private function determineFileType($mimeType, $extension)
    {
        if (str_contains($mimeType, 'pdf')) {
            return 'pdf';
        } elseif (str_contains($mimeType, 'image')) {
            return 'image';
        } elseif (str_contains($mimeType, 'spreadsheet') || in_array($extension, ['xlsx', 'xls', 'csv'])) {
            return 'excel';
        } elseif (str_contains($mimeType, 'word') || in_array($extension, ['docx', 'doc'])) {
            return 'word';
        }
        return 'file';
    }
}
