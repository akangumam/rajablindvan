<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Location;
use App\Models\UploadedFile;
use App\Http\Middleware\LocationFilter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            $query = Vehicle::with(['fuelFills', 'maintenances', 'expenses', 'location']);
        } elseif ($user && $user->isSopir()) {
            // Sopir only sees assigned vehicles
            $query = $user->vehicles()->with(['fuelFills', 'maintenances', 'expenses', 'location']);
        } else {
            // Guest or no user_type - show all (fallback)
            $query = Vehicle::with(['fuelFills', 'maintenances', 'expenses', 'location']);
        }

        // Apply location filter
        $locationId = LocationFilter::getLocationId();
        if ($locationId) {
            $query->where('location_id', $locationId);
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

        // Sorting functionality — whitelist kolom yang boleh diurutkan
        $allowedSortColumns = ['created_at', 'name', 'brand', 'model', 'license_plate', 'year', 'vehicle_type'];
        $allowedSortOrders  = ['asc', 'desc'];

        $sortBy    = in_array($request->get('sort_by'), $allowedSortColumns) ? $request->get('sort_by') : 'created_at';
        $sortOrder = in_array(strtolower($request->get('sort_order')), $allowedSortOrders) ? strtolower($request->get('sort_order')) : 'desc';

        $query->orderBy($sortBy, $sortOrder);

        $vehicles = $query->paginate(10)->appends($request->except('page'));

        // Get locations for filter dropdown
        $locations = Location::active()->get();
        $selectedLocation = $locationId;

        return view('vehicles.index', compact('vehicles', 'sortBy', 'sortOrder', 'locations', 'selectedLocation'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::active()->get();
        return view('vehicles.create', compact('locations'));
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
                'gps_expiry_date' => 'nullable|date',
                'ownership_type' => 'required|in:company,investor',
                'investor_id' => 'nullable|exists:investors,id',
                'location_id' => 'required|exists:locations,id',
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

            // Set investor_id to null if ownership_type is company
            if ($validated['ownership_type'] === 'company') {
                $validated['investor_id'] = null;
            }

            // Handle barcode image upload
            if ($request->hasFile('barcode_image')) {
                $barcodeFile = $request->file('barcode_image');
                $originalName = $barcodeFile->getClientOriginalName();
                $extension = $barcodeFile->getClientOriginalExtension();
                $storedName = Str::uuid() . '.' . $extension;

                // Store file in vehicle_barcodes directory
                $barcodePath = $barcodeFile->storeAs('vehicle_barcodes', $storedName, 'public');
                $validated['barcode_path'] = $barcodePath;

                // Also save to uploaded_files table for centralized tracking
                UploadedFile::create([
                    'original_name' => $originalName,
                    'stored_name' => $storedName,
                    'file_path' => $barcodePath,
                    'mime_type' => $barcodeFile->getMimeType(),
                    'file_size' => $barcodeFile->getSize(),
                    'file_type' => 'image', // Barcode is always image
                    'category' => 'vehicle',
                ]);
            }

            // Set defaults for first vehicle form
            $validated['year'] = $validated['year'] ?? date('Y');
            $validated['license_plate'] = $validated['license_plate'] ?? 'B ' . rand(1000, 9999) . ' XXX';
            $validated['engine_type'] = $validated['engine_type'] ?? 'Gasoline';
            $validated['transmission'] = $validated['transmission'] ?? 'Manual';
            $validated['odometer'] = $validated['odometer'] ?? 0;
            $validated['tank_capacity'] = $validated['tank_capacity'] ?? 45;
            $validated['is_active'] = $validated['is_active'] ?? true;

            // Remove document_path from validated as we'll handle it separately
            unset($validated['vehicle_document']);

            $vehicle = Vehicle::create($validated);

            // Handle vehicle document upload (multiple documents)
            if ($request->hasFile('vehicle_document')) {
                $documentFile = $request->file('vehicle_document');
                $originalName = $documentFile->getClientOriginalName();
                $extension = $documentFile->getClientOriginalExtension();
                $storedName = Str::uuid() . '.' . $extension;

                // Store file
                $documentPath = $documentFile->storeAs('vehicle_documents', $storedName, 'public');

                // Save to vehicle_documents table
                \App\Models\VehicleDocument::create([
                    'vehicle_id' => $vehicle->id,
                    'document_name' => $request->input('document_name') ?: $originalName,
                    'document_path' => $documentPath,
                    'document_type' => $request->input('document_type', 'Other'),
                    'file_type' => $this->determineFileType($documentFile->getMimeType(), $extension),
                    'file_size' => $documentFile->getSize(),
                ]);

                // Also save to uploaded_files table for centralized tracking
                UploadedFile::create([
                    'original_name' => $originalName,
                    'stored_name' => $storedName,
                    'file_path' => $documentPath,
                    'mime_type' => $documentFile->getMimeType(),
                    'file_size' => $documentFile->getSize(),
                    'file_type' => $this->determineFileType($documentFile->getMimeType(), $extension),
                    'category' => 'vehicle',
                ]);
            }


            // Check if this was from first vehicle form (no existing vehicles)
            $totalVehicles = Vehicle::where('is_active', true)->count();

            if ($totalVehicles <= 1) {
                session()->forget('selected_location_id'); // Clear location filter
                return redirect()->route('dashboard')
                    ->with('success', 'Selamat! Kendaraan pertama Anda berhasil ditambahkan!');
            }

            session()->forget('selected_location_id'); // Clear location filter
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
        $vehicle->load(['fuelFills', 'maintenances', 'expenses', 'documents', 'incomes']);

        // Calculate statistics
        $totalMaintenance = $vehicle->maintenances->sum('cost');
        $totalExpenses = $vehicle->expenses->sum('amount');
        $totalIncome = $vehicle->incomes->sum('amount');

        $stats = [
            'total_fuel_fills' => $vehicle->fuelFills->count(),
            'total_fuel_cost' => $vehicle->fuelFills->sum('total_cost'),
            'total_maintenance' => $totalMaintenance,
            'total_maintenance_count' => $vehicle->maintenances->count(),
            'total_expenses' => $totalExpenses,
            'total_expenses_count' => $vehicle->expenses->count(),
            'total_cost' => $totalMaintenance + $totalExpenses,
            'total_income' => $totalIncome,
            'total_income_count' => $vehicle->incomes->count(),
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
            'gps_expiry_date' => 'nullable|date',
            'ownership_type' => 'required|in:company,investor',
            'investor_id' => 'nullable|exists:investors,id',
            'location_id' => 'required|exists:locations,id',
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


        // Set investor_id to null if ownership_type is company
        if ($validated['ownership_type'] === 'company') {
            $validated['investor_id'] = null;
        }

        // Handle barcode image upload
        if ($request->hasFile('barcode_image')) {
            // Delete old barcode file if exists
            if ($vehicle->barcode_path) {
                Storage::disk('public')->delete($vehicle->barcode_path);

                // Also delete from uploaded_files table
                UploadedFile::where('file_path', $vehicle->barcode_path)
                    ->where('category', 'vehicle')
                    ->delete();
            }

            $barcodeFile = $request->file('barcode_image');
            $originalName = $barcodeFile->getClientOriginalName();
            $extension = $barcodeFile->getClientOriginalExtension();
            $storedName = Str::uuid() . '.' . $extension;

            // Store new file
            $barcodePath = $barcodeFile->storeAs('vehicle_barcodes', $storedName, 'public');
            $validated['barcode_path'] = $barcodePath;

            // Save to uploaded_files table
            UploadedFile::create([
                'original_name' => $originalName,
                'stored_name' => $storedName,
                'file_path' => $barcodePath,
                'mime_type' => $barcodeFile->getMimeType(),
                'file_size' => $barcodeFile->getSize(),
                'file_type' => 'image',
                'category' => 'vehicle',
            ]);
        }

        // Handle vehicle document upload (ADD new document, don't replace)
        if ($request->hasFile('vehicle_document')) {
            $documentFile = $request->file('vehicle_document');
            $originalName = $documentFile->getClientOriginalName();
            $extension = $documentFile->getClientOriginalExtension();
            $storedName = Str::uuid() . '.' . $extension;

            // Store new file
            $documentPath = $documentFile->storeAs('vehicle_documents', $storedName, 'public');

            // Save to vehicle_documents table (ADD, not replace)
            \App\Models\VehicleDocument::create([
                'vehicle_id' => $vehicle->id,
                'document_name' => $request->input('document_name') ?: $originalName,
                'document_path' => $documentPath,
                'document_type' => $request->input('document_type', 'Other'),
                'file_type' => $this->determineFileType($documentFile->getMimeType(), $extension),
                'file_size' => $documentFile->getSize(),
            ]);

            // Save to uploaded_files table
            UploadedFile::create([
                'original_name' => $originalName,
                'stored_name' => $storedName,
                'file_path' => $documentPath,
                'mime_type' => $documentFile->getMimeType(),
                'file_size' => $documentFile->getSize(),
                'file_type' => $this->determineFileType($documentFile->getMimeType(), $extension),
                'category' => 'vehicle',
            ]);
        }


        $vehicle->update($validated);

        session()->forget('selected_location_id'); // Clear location filter
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

    /**
     * Delete barcode image from vehicle
     */
    public function deleteBarcode(Vehicle $vehicle)
    {
        try {
            // Check if vehicle has barcode
            if (!$vehicle->barcode_path) {
                return redirect()->back()
                    ->with('error', 'Barcode tidak ditemukan!');
            }

            // Delete physical file
            Storage::disk('public')->delete($vehicle->barcode_path);

            // Delete from uploaded_files table
            UploadedFile::where('file_path', $vehicle->barcode_path)
                ->where('category', 'vehicle')
                ->delete();

            // Update vehicle record
            $vehicle->update(['barcode_path' => null]);

            return redirect()->back()
                ->with('success', 'Barcode berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus barcode: ' . $e->getMessage());
        }
    }

    /**
     * Delete vehicle document
     */
    public function deleteDocument(Vehicle $vehicle)
    {
        try {
            // Check if vehicle has document
            if (!$vehicle->document_path) {
                return redirect()->back()
                    ->with('error', 'Dokumen tidak ditemukan!');
            }

            // Delete physical file
            Storage::disk('public')->delete($vehicle->document_path);

            // Delete from uploaded_files table
            UploadedFile::where('file_path', $vehicle->document_path)
                ->where('category', 'vehicle')
                ->delete();

            // Update vehicle record
            $vehicle->update(['document_path' => null]);

            return redirect()->back()
                ->with('success', 'Dokumen berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus dokumen: ' . $e->getMessage());
        }
    }

    /**
     * Determine file type based on mime type and extension
     */
    private function determineFileType($mimeType, $extension)
    {
        if (str_contains($mimeType, 'pdf')) {
            return 'pdf';
        } elseif (str_contains($mimeType, 'spreadsheet') || in_array($extension, ['xlsx', 'xls', 'csv'])) {
            return 'excel';
        } elseif (str_contains($mimeType, 'word') || in_array($extension, ['docx', 'doc'])) {
            return 'word';
        } elseif (str_contains($mimeType, 'image')) {
            return 'image';
        } elseif (str_contains($mimeType, 'video')) {
            return 'video';
        } elseif (str_contains($mimeType, 'audio')) {
            return 'audio';
        } elseif (in_array($extension, ['zip', 'rar', '7z', 'tar', 'gz'])) {
            return 'archive';
        } elseif (in_array($extension, ['js', 'php', 'html', 'css', 'json', 'xml'])) {
            return 'code';
        }

        return 'file';
    }

    /**
     * Delete individual vehicle document
     */
    public function deleteVehicleDocument($documentId)
    {
        try {
            $document = \App\Models\VehicleDocument::findOrFail($documentId);

            // Delete physical file
            Storage::disk('public')->delete($document->document_path);

            // Delete from uploaded_files table
            UploadedFile::where('file_path', $document->document_path)
                ->where('category', 'vehicle')
                ->delete();

            // Delete document record
            $document->delete();

            return redirect()->back()
                ->with('success', 'Dokumen berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus dokumen: ' . $e->getMessage());
        }
    }

    /**
     * Upload barcode via AJAX
     */
    public function uploadBarcode(Request $request, Vehicle $vehicle)
    {
        try {
            $request->validate([
                'barcode_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Delete old barcode if exists
            if ($vehicle->barcode_path) {
                Storage::disk('public')->delete($vehicle->barcode_path);
            }

            // Store new barcode
            $barcodePath = $request->file('barcode_image')->store('vehicle-barcodes', 'public');
            $vehicle->update(['barcode_path' => $barcodePath]);

            return response()->json([
                'success' => true,
                'message' => 'Barcode berhasil diupload!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal upload barcode: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload document via AJAX
     */
    public function uploadDocument(Request $request, Vehicle $vehicle)
    {
        try {
            $validated = $request->validate([
                'document_name' => 'required|string|max:255',
                'document_type' => 'required|string|max:255',
                'vehicle_document' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120'
            ]);

            $file = $request->file('vehicle_document');
            $filePath = $file->store('vehicle-documents', 'public');

            // Create vehicle document record
            $document = $vehicle->documents()->create([
                'document_name' => $validated['document_name'],
                'document_type' => $validated['document_type'],
                'document_path' => $filePath,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType()
            ]);

            // Log file upload
            UploadedFile::create([
                'original_name' => $file->getClientOriginalName(),
                'stored_name' => basename($filePath),
                'file_name' => $validated['document_name'],
                'file_path' => $filePath,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'file_type' => $this->determineFileType($file->getMimeType(), $file->getClientOriginalExtension()),
                'category' => 'vehicle',
                'uploaded_by' => auth()->id(),
                'related_id' => $vehicle->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Dokumen berhasil diupload!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal upload dokumen: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update expiry dates via AJAX
     */
    public function updateExpiryDates(Request $request, Vehicle $vehicle)
    {
        try {
            $validated = $request->validate([
                'stnk_expiry_date' => 'nullable|date',
                'kir_expiry_date' => 'nullable|date',
                'gps_expiry_date' => 'nullable|date'
            ]);

            // Only update fields that were provided
            $updateData = [];
            if ($request->has('stnk_expiry_date') && $request->stnk_expiry_date) {
                $updateData['stnk_expiry_date'] = $validated['stnk_expiry_date'];
            }
            if ($request->has('kir_expiry_date') && $request->kir_expiry_date) {
                $updateData['kir_expiry_date'] = $validated['kir_expiry_date'];
            }
            if ($request->has('gps_expiry_date') && $request->gps_expiry_date) {
                $updateData['gps_expiry_date'] = $validated['gps_expiry_date'];
            }

            if (empty($updateData)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada tanggal yang diubah'
                ], 400);
            }

            $vehicle->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Tanggal masa berlaku berhasil diupdate!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal update tanggal: ' . $e->getMessage()
            ], 500);
        }
    }
}

