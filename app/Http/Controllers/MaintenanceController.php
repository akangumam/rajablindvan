<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maintenance;
use App\Models\Vehicle;
use App\Models\UploadedFile;
use Illuminate\Support\Str;

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

        // Get reference data for dropdowns
        $serviceTypes = \App\Models\ServiceType::active()->orderBy('name')->get();
        $paymentMethods = \App\Models\PaymentMethod::active()->orderBy('name')->get();

        // If vehicle_id is provided in query string
        if ($request->has('vehicle_id')) {
            $vehicle = Vehicle::findOrFail($request->vehicle_id);

            // Check access for Sopir
            if ($user && $user->isSopir() && !$user->hasAccessToVehicle($vehicle->id)) {
                abort(403, 'Anda tidak memiliki akses ke kendaraan ini.');
            }

            return view('maintenances.create', compact('vehicles', 'vehicle', 'users', 'serviceTypes', 'paymentMethods'));
        }

        return view('maintenances.create', compact('vehicles', 'users', 'serviceTypes', 'paymentMethods'));
    }

    /**
     * Create maintenance for specific vehicle
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

        // Get users for dropdown
        $users = \App\Models\User::whereIn('user_type', ['manager', 'super_admin', 'sopir'])->orderBy('name')->get();

        // Get service types
        $serviceTypes = \App\Models\ServiceType::where('is_active', true)->orderBy('name')->get();

        // Get payment methods
        $paymentMethods = \App\Models\PaymentMethod::where('is_active', true)->orderBy('name')->get();

        return view('maintenances.create', compact('vehicle', 'vehicles', 'users', 'serviceTypes', 'paymentMethods'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate vehicle_id first before anything else
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
        ], [
            'vehicle_id.required' => 'Please select a vehicle first before adding service.',
            'vehicle_id.exists' => 'Selected vehicle not found.',
        ]);

        $user = auth()->user();
        $vehicle = Vehicle::findOrFail($request->vehicle_id);

        // Check access for Sopir
        if ($user && $user->isSopir() && !$user->hasAccessToVehicle($vehicle->id)) {
            abort(403, 'Anda tidak memiliki akses ke kendaraan ini.');
        }

        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'maintenance_date' => 'nullable|date',
            'service_date' => 'required|date',
            'service_time' => 'required',
            'odometer' => [
                'required',
                'numeric',
                'min:0',
            ],
            'type' => 'nullable|string|max:255',
            'selected_services' => 'required|json', // Validate JSON input
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'workshop' => 'nullable|string|max:255',
            'place' => 'required|string|max:255',
            'user_id' => 'nullable|exists:users,id',
            'payment_method' => 'required|string|max:255',
            'cost' => 'nullable|numeric|min:0',
            'total_cost' => 'nullable|numeric|min:0',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
            'next_maintenance_date' => 'nullable|date|after:service_date',
            'next_maintenance_odometer' => 'nullable|numeric|min:0',
            'parts_replaced' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        // Validate Odometer (Must be >= last recorded)
        $lastOdometer = $vehicle->getLatestOdometer();
        if ($validated['odometer'] < $lastOdometer) {
            return back()->withErrors(['odometer' => "Odometer tidak boleh lebih kecil dari nilai terakhir tercatat ($lastOdometer KM)."])->withInput();
        }

        // Process selected_services
        $selectedServices = json_decode($request->selected_services, true);
        $serviceNames = [];
        $serviceDetails = [];
        $calculatedTotalCost = 0;

        if (is_array($selectedServices)) {
            foreach ($selectedServices as $service) {
                $name = $service['name'] ?? 'Unknown Service';
                $price = isset($service['price']) ? (float)$service['price'] : 0;

                $serviceNames[] = $name;
                $serviceDetails[] = "$name (Rp " . number_format($price, 0, ',', '.') . ")";
                $calculatedTotalCost += $price;
            }
        }

        // Populate service_type with comma-separated names (truncate if too long)
        $validated['service_type'] = Str::limit(implode(', ', $serviceNames), 250);

        // Add detailed breakdown to description or parts_replaced
        $breakdown = implode("\n", $serviceDetails);
        if (!empty($validated['description'])) {
            $validated['description'] .= "\n\nService Breakdown:\n" . $breakdown;
        } else {
            $validated['description'] = "Service Breakdown:\n" . $breakdown;
        }

        // Use calculated total cost if not provided or override it
        // The form sends total_cost, but recalculating is safer
        $validated['total_cost'] = $calculatedTotalCost;
        $validated['cost'] = $calculatedTotalCost; // Map to cost as well for backward compatibility

        // Set default type if not provided (required field in database)
        if (!isset($validated['type']) || empty($validated['type'])) {
            $validated['type'] = 'Service';
        }

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $storedName = Str::uuid() . '.' . $extension;

            $path = $file->storeAs('maintenances', $storedName, 'public');
            $validated['attachment'] = $path;

            // Track file in storage management
            UploadedFile::create([
                'original_name' => $originalName,
                'stored_name' => $storedName,
                'file_path' => $path,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'file_type' => $this->determineFileType($file->getMimeType(), $extension),
                'category' => 'service',
            ]);
        }

        // Set maintenance_date from service_date if not provided
        if (!isset($validated['maintenance_date'])) {
            $validated['maintenance_date'] = $validated['service_date'];
        }

        // Set user_id from auth if not provided
        if (!isset($validated['user_id'])) {
            $validated['user_id'] = auth()->id();
        }

        // Set default values
        $validated['status'] = 'Completed';

        Maintenance::create($validated);

        return redirect()->route('maintenances.index')
            ->with('success', 'Service data has been added successfully!');
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
        // Only Administrator & Sales can delete
        if (!auth()->user()->canDeleteRecords()) {
            abort(403, 'Unauthorized action. Only Administrator and Sales can delete maintenance records.');
        }

        $maintenance->delete();

        return redirect()->route('maintenances.index')
            ->with('success', 'Data perawatan berhasil dihapus!');
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
