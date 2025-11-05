<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        
        // Filter incomes based on user type
        if ($user && $user->isPengelola()) {
            $incomes = Income::with(['vehicle', 'user'])
                ->latest('income_date')
                ->paginate(20);
        } elseif ($user && $user->isSopir()) {
            $vehicleIds = $user->vehicles()->pluck('vehicles.id');
            $incomes = Income::with(['vehicle', 'user'])
                ->whereIn('vehicle_id', $vehicleIds)
                ->latest('income_date')
                ->paginate(20);
        } else {
            $incomes = Income::with(['vehicle', 'user'])
                ->latest('income_date')
                ->paginate(20);
        }

        return view('incomes.index', compact('incomes'));
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
        $incomeTypes = \App\Models\IncomeType::active()->orderBy('name')->get();
        $paymentMethods = \App\Models\PaymentMethod::active()->orderBy('name')->get();
        
        // If vehicle_id is provided in query string
        if ($request->has('vehicle_id')) {
            $vehicle = Vehicle::findOrFail($request->vehicle_id);
            
            // Check access for Sopir
            if ($user && $user->isSopir() && !$user->hasAccessToVehicle($vehicle->id)) {
                abort(403, 'Anda tidak memiliki akses ke kendaraan ini.');
            }
            
            return view('incomes.create', compact('vehicles', 'vehicle', 'incomeTypes', 'paymentMethods'));
        }
        
        return view('incomes.create', compact('vehicles', 'incomeTypes', 'paymentMethods'));
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
            'income_date' => 'required|date',
            'income_time' => 'nullable|date_format:H:i',
            'odometer' => 'nullable|numeric|min:0',
            'type' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120'
        ]);

        // Set default time to now if not provided
        if (empty($validated['income_time'])) {
            $validated['income_time'] = now()->format('H:i');
        }

        // Set user_id to logged in user
        $validated['user_id'] = auth()->id();
        
        // Keep description for backward compatibility (use notes as description)
        $validated['description'] = $validated['notes'] ?? 'Income entry';

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('incomes', $filename, 'public');
            $validated['attachment'] = $path;
        }

        Income::create($validated);

        return redirect()->route('incomes.index')
            ->with('success', 'Income has been added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Income $income)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Income $income)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Income $income)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Income $income)
    {
        //
    }
}
