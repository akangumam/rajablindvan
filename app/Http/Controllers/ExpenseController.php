<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Vehicle;
use App\Models\Location;
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
        return view('expenses.create-new', compact('vehicle'));
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
            'vehicle_id' => 'required|exists:vehicles,id',
            'expense_date' => 'required|date',
            'expense_time' => 'nullable',
            'odometer' => 'nullable|numeric|min:0',
            'expense_type' => 'nullable|string|max:255',
            'place' => 'nullable|string|max:255',
            'user_id' => 'nullable|exists:users,id',
            'category' => 'required|string|max:255',
            'subcategory' => 'nullable|string|max:255',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'total_cost' => 'nullable|numeric|min:0',
            'vendor' => 'nullable|string|max:255',
            'payment_method' => 'nullable|string|max:255',
            'receipt_number' => 'nullable|string|max:255',
            'is_recurring' => 'boolean',
            'recurring_period' => 'nullable|string|max:255',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
            'notes' => 'nullable|string',
            'stnk_expiry_date' => 'nullable|date',
            'kir_expiry_date' => 'nullable|date'
        ]);

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $validated['attachment'] = $file->storeAs('expenses', $filename, 'public');
        }

        // Set user_id if not provided
        if (!isset($validated['user_id'])) {
            $validated['user_id'] = auth()->id();
        }
        
        // Set location_id from vehicle
        $validated['location_id'] = $vehicle->location_id;

        Expense::create($validated);

        return redirect()->route('expenses.index')
            ->with('success', 'Expense data successfully added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
