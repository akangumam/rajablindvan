<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maintenance;
use App\Models\Vehicle;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        
        // Filter maintenances based on user type
        if ($user && $user->isPengelola()) {
            $maintenances = Maintenance::with('vehicle')
                ->latest('maintenance_date')
                ->paginate(20);
        } elseif ($user && $user->isSopir()) {
            $vehicleIds = $user->vehicles()->pluck('vehicles.id');
            $maintenances = Maintenance::with('vehicle')
                ->whereIn('vehicle_id', $vehicleIds)
                ->latest('maintenance_date')
                ->paginate(20);
        } else {
            $maintenances = Maintenance::with('vehicle')
                ->latest('maintenance_date')
                ->paginate(20);
        }

        return view('maintenances.index', compact('maintenances'));
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
        
        $users = \App\Models\User::orderBy('name')->get();
        
        // If vehicle_id is provided in query string
        if ($request->has('vehicle_id')) {
            $vehicle = Vehicle::findOrFail($request->vehicle_id);
            
            // Check access for Sopir
            if ($user && $user->isSopir() && !$user->hasAccessToVehicle($vehicle->id)) {
                abort(403, 'Anda tidak memiliki akses ke kendaraan ini.');
            }
            
            return view('maintenances.create-new', compact('vehicles', 'vehicle', 'users'));
        }
        
        return view('maintenances.create-new', compact('vehicles', 'users'));
    }

    /**
     * Create maintenance for specific vehicle
     */
    public function createForVehicle(Vehicle $vehicle)
    {
        return view('maintenances.create-new', compact('vehicle'));
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
            'maintenance_date' => 'required|date',
            'odometer' => [
                'required',
                'numeric',
                'min:' . $vehicle->getMinimumOdometer(),
            ],
            'type' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'workshop' => 'nullable|string|max:255',
            'cost' => 'required|numeric|min:0',
            'next_maintenance_date' => 'nullable|date|after:maintenance_date',
            'next_maintenance_odometer' => 'nullable|numeric|min:0',
            'parts_replaced' => 'nullable|string',
            'notes' => 'nullable|string'
        ], [
            'odometer.min' => $vehicle->getOdometerValidationMessage(),
        ]);

        $validated['status'] = 'Completed';

        Maintenance::create($validated);

        return redirect()->route('maintenances.index')
            ->with('success', 'Data perawatan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Maintenance $maintenance)
    {
        $maintenance->load('vehicle');
        return view('maintenances.show', compact('maintenance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Maintenance $maintenance)
    {
        $vehicles = Vehicle::active()->orderBy('name')->get();
        return view('maintenances.edit', compact('maintenance', 'vehicles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Maintenance $maintenance)
    {
        $vehicle = Vehicle::findOrFail($request->vehicle_id);
        // For updates, we need to consider if we're updating the same record
        $minOdometer = $maintenance->odometer == $vehicle->getLatestOdometer() ? 
                      $maintenance->odometer : $vehicle->getMinimumOdometer();
        
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'maintenance_date' => 'required|date',
            'odometer' => [
                'required',
                'numeric',
                'min:' . $minOdometer,
            ],
            'type' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'workshop' => 'nullable|string|max:255',
            'cost' => 'required|numeric|min:0',
            'next_maintenance_date' => 'nullable|date|after:maintenance_date',
            'next_maintenance_odometer' => 'nullable|numeric|min:0',
            'parts_replaced' => 'nullable|string',
            'status' => 'required|in:Completed,Scheduled,Overdue',
            'notes' => 'nullable|string'
        ]);

        $maintenance->update($validated);

        return redirect()->route('maintenances.index')
            ->with('success', 'Data perawatan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Maintenance $maintenance)
    {
        $maintenance->delete();

        return redirect()->route('maintenances.index')
            ->with('success', 'Data perawatan berhasil dihapus!');
    }
}
