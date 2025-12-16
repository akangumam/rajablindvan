<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        // Filter trips based on user type
        if ($user && $user->isPengelola()) {
            $trips = Trip::with('vehicle')
                ->latest('trip_date')
                ->paginate(20);
        } elseif ($user && $user->isSopir()) {
            $vehicleIds = $user->vehicles()->pluck('vehicles.id');
            $trips = Trip::with('vehicle')
                ->whereIn('vehicle_id', $vehicleIds)
                ->latest('trip_date')
                ->paginate(20);
        } else {
            $trips = Trip::with('vehicle')
                ->latest('trip_date')
                ->paginate(20);
        }

        return view('trips.index', compact('trips'));
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

        // If vehicle_id is provided in query string
        if ($request->has('vehicle_id')) {
            $vehicle = Vehicle::findOrFail($request->vehicle_id);

            // Check access for Sopir
            if ($user && $user->isSopir() && !$user->hasAccessToVehicle($vehicle->id)) {
                abort(403, 'Anda tidak memiliki akses ke kendaraan ini.');
            }

            return view('trips.create', compact('vehicles', 'vehicle'));
        }

        return view('trips.create', compact('vehicles'));
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
            'trip_date' => 'required|date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'start_odometer' => 'required|numeric|min:0',
            'end_odometer' => 'nullable|numeric|min:0',
            'distance' => 'nullable|numeric|min:0',
            'start_location' => 'nullable|string|max:255',
            'end_location' => 'nullable|string|max:255',
            'driver' => 'nullable|string|max:255',
            'purpose' => 'nullable|string|max:255',
            'route_type' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        // Validate Start Odometer (Must be >= last recorded)
        $lastOdometer = $vehicle->getLatestOdometer();
        if ($validated['start_odometer'] < $lastOdometer) {
            return back()->withErrors(['start_odometer' => "Odometer Awal tidak boleh lebih kecil dari nilai terakhir tercatat ($lastOdometer KM)."])->withInput();
        }

        // Calculate distance if end_odometer is provided
        if (!empty($validated['end_odometer']) && empty($validated['distance'])) {
            $validated['distance'] = $validated['end_odometer'] - $validated['start_odometer'];
        }

        Trip::create($validated);

        return redirect()->route('trips.index')
            ->with('success', 'Rute/Perjalanan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Trip $trip)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trip $trip)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trip $trip)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trip $trip)
    {
        //
    }
}
