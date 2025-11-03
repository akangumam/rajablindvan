<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        
        // Build query based on user type
        if ($user && $user->isPengelola()) {
            // Pengelola sees all vehicles
            $query = Vehicle::with(['fuelFills', 'maintenances', 'expenses']);
        } elseif ($user && $user->isSopir()) {
            // Sopir only sees assigned vehicles
            $query = $user->vehicles()->with(['fuelFills', 'maintenances', 'expenses']);
        } else {
            // Guest or no user_type - show all (fallback)
            $query = Vehicle::with(['fuelFills', 'maintenances', 'expenses']);
        }
        
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('license_plate', 'like', "%{$search}%");
            });
        }
        
        // Sorting functionality
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        $query->orderBy($sortBy, $sortOrder);
        
        $vehicles = $query->paginate(10)->appends($request->except('page'));

        return view('vehicles.index', compact('vehicles', 'sortBy', 'sortOrder'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vehicles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'nullable|string|max:255',
                'brand' => 'required|string|max:255',
                'model' => 'required|string|max:255',
                'year' => 'nullable|string|max:4',
                'license_plate' => 'nullable|string|max:20',
                'vehicle_type' => 'nullable|string|max:255',
                'chassis_number' => 'nullable|string|max:255',
                'engine_number' => 'nullable|string|max:255',
                'stnk_number' => 'nullable|string|max:255',
                'stnk_expiry_date' => 'nullable|date',
                'kir_number' => 'nullable|string|max:255',
                'kir_expiry_date' => 'nullable|date',
                'document_name' => 'nullable|string|max:255',
                'barcode_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'vehicle_document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
                'engine_type' => 'nullable|string|max:255',
                'transmission' => 'nullable|string|max:255',
                'tank_capacity' => 'nullable|numeric|min:0',
                'odometer' => 'nullable|numeric|min:0',
                'color' => 'nullable|string|max:255',
                'notes' => 'nullable|string',
                'is_active' => 'nullable|boolean'
            ]);

            // Auto-generate name if not provided
            if (empty($validated['name'])) {
                $validated['name'] = $validated['brand'] . ' ' . $validated['model'];
            }

            // Handle barcode image upload
            if ($request->hasFile('barcode_image')) {
                $barcodePath = $request->file('barcode_image')->store('vehicle_barcodes', 'public');
                $validated['barcode_path'] = $barcodePath;
            }

            // Handle vehicle document upload
            if ($request->hasFile('vehicle_document')) {
                $documentPath = $request->file('vehicle_document')->store('vehicle_documents', 'public');
                $validated['document_path'] = $documentPath;
            }

            // Set defaults for first vehicle form
            $validated['year'] = $validated['year'] ?? date('Y');
            $validated['license_plate'] = $validated['license_plate'] ?? 'B ' . rand(1000, 9999) . ' XXX';
            $validated['engine_type'] = $validated['engine_type'] ?? 'Gasoline';
            $validated['transmission'] = $validated['transmission'] ?? 'Manual';
            $validated['odometer'] = $validated['odometer'] ?? 0;
            $validated['tank_capacity'] = $validated['tank_capacity'] ?? 45;
            $validated['is_active'] = $validated['is_active'] ?? true;

            Vehicle::create($validated);

            // Check if this was from first vehicle form (no existing vehicles)
            $totalVehicles = Vehicle::where('is_active', true)->count();
            
            if ($totalVehicles <= 1) {
                return redirect()->route('dashboard')
                    ->with('success', 'Selamat! Kendaraan pertama Anda berhasil ditambahkan!');
            }

            return redirect()->route('vehicles.index')
                ->with('success', 'Kendaraan berhasil ditambahkan!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data kendaraan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['fuelFills', 'maintenances', 'expenses']);
        
        $stats = [
            'total_fuel_fills' => $vehicle->fuelFills->count(),
            'total_fuel_cost' => $vehicle->fuelFills->sum('total_cost'),
            'total_maintenance_cost' => $vehicle->maintenances->sum('cost'),
            'total_expenses' => $vehicle->getTotalExpenses(),
            'avg_fuel_efficiency' => $vehicle->getAverageFuelEfficiency(),
            'latest_odometer' => $vehicle->getLatestOdometer()
        ];

        return view('vehicles.show', compact('vehicle', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        return view('vehicles.edit', compact('vehicle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'nullable|string|max:4',
            'license_plate' => 'nullable|string|max:20|unique:vehicles,license_plate,' . $vehicle->id,
            'vehicle_type' => 'nullable|string|max:255',
            'chassis_number' => 'nullable|string|max:255',
            'engine_number' => 'nullable|string|max:255',
            'stnk_number' => 'nullable|string|max:255',
            'stnk_expiry_date' => 'nullable|date',
            'kir_number' => 'nullable|string|max:255',
            'kir_expiry_date' => 'nullable|date',
            'document_name' => 'nullable|string|max:255',
            'barcode_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'vehicle_document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'engine_type' => 'nullable|string|max:255',
            'transmission' => 'nullable|string|max:255',
            'tank_capacity' => 'nullable|numeric|min:0',
            'odometer' => 'nullable|numeric|min:0',
            'color' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        // Handle barcode image upload
        if ($request->hasFile('barcode_image')) {
            // Delete old barcode if exists
            if ($vehicle->barcode_path) {
                Storage::disk('public')->delete($vehicle->barcode_path);
            }
            $barcodePath = $request->file('barcode_image')->store('vehicle_barcodes', 'public');
            $validated['barcode_path'] = $barcodePath;
        }

        // Handle vehicle document upload
        if ($request->hasFile('vehicle_document')) {
            // Delete old document if exists
            if ($vehicle->document_path) {
                Storage::disk('public')->delete($vehicle->document_path);
            }
            $documentPath = $request->file('vehicle_document')->store('vehicle_documents', 'public');
            $validated['document_path'] = $documentPath;
        }

        $vehicle->update($validated);

        return redirect()->route('vehicles.show', $vehicle)
            ->with('success', 'Kendaraan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        try {
            // Check if vehicle has related records
            $hasFuelFills = $vehicle->fuelFills()->count() > 0;
            $hasMaintenances = $vehicle->maintenances()->count() > 0;
            $hasExpenses = $vehicle->expenses()->count() > 0;
            
            if ($hasFuelFills || $hasMaintenances || $hasExpenses) {
                return redirect()->route('vehicles.index')
                    ->with('error', 'Tidak dapat menghapus kendaraan yang memiliki riwayat transaksi. Nonaktifkan kendaraan sebagai gantinya.');
            }
            
            $vehicle->delete();

            return redirect()->route('vehicles.index')
                ->with('success', 'Kendaraan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('vehicles.index')
                ->with('error', 'Gagal menghapus kendaraan: ' . $e->getMessage());
        }
    }
    
    /**
     * Export vehicle data to PDF
     */
    public function exportPdf(Vehicle $vehicle)
    {
        // Load relationships
        $vehicle->load(['fuelFills', 'maintenances', 'expenses']);
        
        // Calculate statistics
        $stats = [
            'total_fuel_fills' => $vehicle->fuelFills->count(),
            'total_fuel_cost' => $vehicle->fuelFills->sum('total_cost'),
            'total_maintenance_cost' => $vehicle->maintenances->sum('cost'),
            'total_expenses' => $vehicle->getTotalExpenses(),
            'avg_fuel_efficiency' => $vehicle->getAverageFuelEfficiency(),
            'latest_odometer' => $vehicle->getLatestOdometer()
        ];
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('vehicles.pdf', compact('vehicle', 'stats'));
        
        return $pdf->download('Kendaraan_' . $vehicle->license_plate . '_' . date('Y-m-d') . '.pdf');
    }
    
    /**
     * Show driver assignment page for a vehicle
     */
    public function assignDrivers(Vehicle $vehicle)
    {
        // Only Pengelola can access this page
        $user = auth()->user();
        if (!$user || !$user->isPengelola()) {
            abort(403, 'Anda tidak memiliki akses untuk mengelola penugasan sopir.');
        }
        
        // Get all sopir users
        $allDrivers = \App\Models\User::where('user_type', 'Sopir')
            ->orderBy('name')
            ->get();
        
        // Get currently assigned drivers for this vehicle
        $assignedDrivers = $vehicle->assignedDrivers;
        
        // Get available drivers (not yet assigned to this vehicle)
        $availableDrivers = $allDrivers->diff($assignedDrivers);
        
        return view('vehicles.assign-drivers', compact('vehicle', 'assignedDrivers', 'availableDrivers'));
    }
    
    /**
     * Assign a driver to a vehicle
     */
    public function storeDriverAssignment(Request $request, Vehicle $vehicle)
    {
        // Only Pengelola can assign drivers
        $user = auth()->user();
        if (!$user || !$user->isPengelola()) {
            abort(403, 'Anda tidak memiliki akses untuk mengelola penugasan sopir.');
        }
        
        $validated = $request->validate([
            'driver_id' => 'required|exists:users,id'
        ]);
        
        $driver = \App\Models\User::findOrFail($validated['driver_id']);
        
        // Check if driver is actually a Sopir
        if ($driver->user_type !== 'Sopir') {
            return redirect()->back()
                ->with('error', 'User yang dipilih bukan sopir.');
        }
        
        // Check if already assigned
        if ($vehicle->users()->where('user_id', $driver->id)->exists()) {
            return redirect()->back()
                ->with('error', 'Sopir sudah ditugaskan ke kendaraan ini.');
        }
        
        // Assign the driver
        $vehicle->users()->attach($driver->id);
        
        return redirect()->back()
            ->with('success', "Sopir {$driver->name} berhasil ditugaskan ke {$vehicle->name}!");
    }
    
    /**
     * Remove driver assignment from vehicle
     */
    public function removeDriverAssignment(Vehicle $vehicle, \App\Models\User $user)
    {
        // Only Pengelola can remove assignments
        $authUser = auth()->user();
        if (!$authUser || !$authUser->isPengelola()) {
            abort(403, 'Anda tidak memiliki akses untuk mengelola penugasan sopir.');
        }
        
        // Remove the assignment
        $vehicle->users()->detach($user->id);
        
        return redirect()->back()
            ->with('success', "Sopir {$user->name} berhasil dihapus dari {$vehicle->name}!");
    }
}
