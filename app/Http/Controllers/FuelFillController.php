<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FuelFill;
use App\Models\Vehicle;

class FuelFillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        
        // Filter fuel fills based on user type
        if ($user && $user->isPengelola()) {
            $fuelFills = FuelFill::with('vehicle')
                ->latest('fill_date')
                ->paginate(20);
        } elseif ($user && $user->isSopir()) {
            // Get vehicle IDs assigned to this driver
            $vehicleIds = $user->vehicles()->pluck('vehicles.id');
            $fuelFills = FuelFill::with('vehicle')
                ->whereIn('vehicle_id', $vehicleIds)
                ->latest('fill_date')
                ->paginate(20);
        } else {
            $fuelFills = FuelFill::with('vehicle')
                ->latest('fill_date')
                ->paginate(20);
        }

        return view('fuel-fills.index', compact('fuelFills'));
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
        
        $users = \App\Models\User::orderBy('name')->get(); // Get all users for driver dropdown
        
        // If vehicle_id is provided in query string
        if ($request->has('vehicle_id')) {
            $vehicle = Vehicle::findOrFail($request->vehicle_id);
            
            // Check access for Sopir
            if ($user && $user->isSopir() && !$user->hasAccessToVehicle($vehicle->id)) {
                abort(403, 'Anda tidak memiliki akses ke kendaraan ini.');
            }
            
            return view('fuel-fills.create-new', compact('vehicles', 'vehicle', 'users'));
        }
        
        return view('fuel-fills.create-new', compact('vehicles', 'users'));
    }

    /**
     * Create fuel fill for specific vehicle
     */
    public function createForVehicle(Vehicle $vehicle)
    {
        return view('fuel-fills.create-new', compact('vehicle'));
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
            'fill_date' => 'required|date',
            'time' => 'nullable|date_format:H:i',
            'odometer' => [
                'required',
                'numeric',
                'min:' . $vehicle->getMinimumOdometer(),
            ],
            'liters' => 'required|numeric|min:0',
            'price_per_liter' => 'required|numeric|min:0',
            'fuel_type' => 'required|string|max:255',
            'gas_station' => 'nullable|string|max:255',
            'spbu' => 'nullable|string|max:255',
            'driver' => 'nullable|string|max:255',
            'reason' => 'nullable|string|max:255',
            'payment_method' => 'nullable|string|max:255',
            'missed_filling' => 'nullable|boolean',
            'full_tank' => 'nullable|boolean',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // max 5MB
            'is_full_tank' => 'boolean',
            'notes' => 'nullable|string'
        ], [
            'odometer.min' => $vehicle->getOdometerValidationMessage(),
        ]);

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('fuel-fills', $filename, 'public');
            $validated['attachment'] = $path;
        }

        // Calculate total cost
        $validated['total_cost'] = $validated['liters'] * $validated['price_per_liter'];

        // Calculate trip distance and fuel efficiency if this is not the first fill
        $lastFill = FuelFill::where('vehicle_id', $validated['vehicle_id'])
            ->where('odometer', '<', $validated['odometer'])
            ->orderBy('odometer', 'desc')
            ->first();

        if ($lastFill) {
            $validated['trip_distance'] = $validated['odometer'] - $lastFill->odometer;
            if ($lastFill->liters > 0) {
                $validated['fuel_efficiency'] = $validated['trip_distance'] / $lastFill->liters;
            }
        }

        FuelFill::create($validated);

        return redirect()->route('fuel-fills.index')
            ->with('success', 'Data isi bensin berhasil ditambahkan!');
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
