<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\UploadedFile;
use App\Models\Location;
use App\Models\ServiceType;
use App\Models\ExpenseType;
use App\Models\IncomeType;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class SettingsController extends Controller
{
    /**
     * Display settings main page - redirect to format
     */
    public function index()
    {
        return redirect()->route('settings.format');
    }

    /**
     * Satuan Settings (Unit Settings)
     */
    public function units()
    {
        return view('settings.units');
    }

    /**
     * Pengingat Settings (Reminders)
     */
    public function reminders()
    {
        return view('settings.reminders');
    }

    /**
     * Format Settings (Date, Currency, etc)
     */
    public function format()
    {
        $dateFormat = Setting::get('date_format', 'd/m/Y');
        $currencyFormat = Setting::get('currency_format', 'idr');

        return view('settings.format', compact('dateFormat', 'currencyFormat'));
    }

    /**
     * Save Format Settings
     */
    public function saveFormat(Request $request)
    {
        $request->validate([
            'date_format' => 'required|string',
            'currency_format' => 'required|string',
        ]);

        Setting::set('date_format', $request->date_format);
        Setting::set('currency_format', $request->currency_format);

        return redirect()->route('settings.format')
            ->with('success', 'Format settings saved successfully!');
    }

    /**
     * Account Settings
     */
    public function account()
    {
        return view('settings.account');
    }

    /**
     * Update Password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();
        $user->password = \Illuminate\Support\Facades\Hash::make($request->new_password);
        $user->save();

        return redirect()->route('settings.account')
            ->with('success', 'Password updated successfully!');
    }

    /**
     * File and Storage Settings
     */
    public function fileStorage()
    {
        $files = UploadedFile::orderBy('created_at', 'desc')->get();

        // Calculate total storage used
        $totalSize = UploadedFile::sum('file_size');
        $totalSizeGB = $totalSize / 1073741824; // Convert to GB
        $storageLimit = 10240 / 1024; // 10240 MB = 10 GB limit
        $usagePercentage = $totalSizeGB > 0 ? ($totalSizeGB / $storageLimit) * 100 : 0;

        // Calculate storage by category (only valid categories)
        $categories = [
            'fuel' => UploadedFile::where('category', 'fuel')->sum('file_size'),
            'expense' => UploadedFile::where('category', 'expense')->sum('file_size'),
            'income' => UploadedFile::where('category', 'income')->sum('file_size'),
            'service' => UploadedFile::where('category', 'service')->sum('file_size'),
            'vehicle' => UploadedFile::where('category', 'vehicle')->sum('file_size'),
        ];

        // Convert to MB and calculate percentages
        $categoryStats = [];
        foreach ($categories as $cat => $size) {
            $sizeMB = $size / 1048576;
            $percentage = $totalSize > 0 ? ($size / $totalSize) * 100 : 0;
            $categoryStats[$cat] = [
                'size' => $sizeMB,
                'percentage' => $percentage
            ];
        }

        // Calculate unused storage
        $usedStorageMB = $totalSize / 1048576;
        $storageLimitMB = $storageLimit * 1024; // Convert GB to MB
        $unusedMB = $storageLimitMB - $usedStorageMB;
        $unusedPercentage = $storageLimitMB > 0 ? ($unusedMB / $storageLimitMB) * 100 : 100;

        return view('settings.file-storage', compact(
            'files',
            'totalSize',
            'totalSizeGB',
            'storageLimit',
            'usagePercentage',
            'categoryStats',
            'unusedMB',
            'unusedPercentage',
            'usedStorageMB',
            'storageLimitMB'
        ));
    }

    /**
     * Upload file
     */
    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'max:10240', // Max 10MB
                'mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,xls,xlsx,csv,zip',
            ],
            'category' => 'required|string|in:fuel,expense,income,service,vehicle'
        ]);

        try {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $storedName = Str::uuid() . '.' . $extension;

            // Store file
            $path = $file->storeAs('uploads', $storedName, 'public');

            // Determine file type
            $mimeType = $file->getMimeType();
            $fileType = $this->determineFileType($mimeType, $extension);

            // Save to database
            UploadedFile::create([
                'original_name' => $originalName,
                'stored_name' => $storedName,
                'file_path' => $path,
                'mime_type' => $mimeType,
                'file_size' => $file->getSize(),
                'file_type' => $fileType,
                'category' => $request->category,
            ]);

            return redirect()->route('settings.file-storage')
                ->with('success', 'File uploaded successfully!');

        } catch (\Exception $e) {
            return redirect()->route('settings.file-storage')
                ->with('error', 'Failed to upload file: ' . $e->getMessage());
        }
    }

    /**
     * Download single file
     */
    public function downloadFile($id)
    {
        $file = UploadedFile::findOrFail($id);
        $filePath = storage_path('app/public/' . $file->file_path);

        if (!file_exists($filePath)) {
            return redirect()->route('settings.file-storage')
                ->with('error', 'File not found!');
        }

        return response()->download($filePath, $file->original_name);
    }

    /**
     * Delete file
     */
    public function deleteFile($id)
    {
        try {
            $file = UploadedFile::findOrFail($id);

            // Delete physical file
            Storage::disk('public')->delete($file->file_path);

            // Delete from database
            $file->delete();

            return redirect()->route('settings.file-storage')
                ->with('success', 'File deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->route('settings.file-storage')
                ->with('error', 'Failed to delete file: ' . $e->getMessage());
        }
    }

    /**
     * Download all files as ZIP
     */
    public function downloadAllFiles()
    {
        $files = UploadedFile::all();

        if ($files->isEmpty()) {
            return redirect()->route('settings.file-storage')
                ->with('error', 'No files to download!');
        }

        $zipFileName = 'all_files_' . now()->format('Y-m-d_His') . '.zip';
        $zipPath = storage_path('app/public/' . $zipFileName);

        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            foreach ($files as $file) {
                $filePath = storage_path('app/public/' . $file->file_path);
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, $file->original_name);
                }
            }
            $zip->close();
        }

        return response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);
    }

    /**
     * Determine file type based on mime type
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
     * Bahan Bakar Settings
     */
    public function fuelTypes()
    {
        return view('settings.fuel-types');
    }

    /**
     * Jenis BBM Settings
     */
    public function fuelGrades()
    {
        return view('settings.fuel-grades');
    }

    /**
     * SPBU Settings
     */
    public function fuelStations()
    {
        return view('settings.fuel-stations');
    }

    /**
     * Lokasi Settings
     */
    public function locations()
    {
        $locations = Location::orderBy('name')->get();
        return view('settings.locations', compact('locations'));
    }

    public function storeLocation(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:locations,name',
            'code' => 'required|string|max:10|unique:locations,code',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'manager_name' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'google_place_id' => 'nullable|string'
        ], [
            'name.unique' => __('common.place_already_exists'),
            'code.unique' => __('common.place_code_already_exists'),
            'name.required' => __('common.name') . ' is required',
            'code.required' => __('common.code') . ' is required',
            'address.required' => __('common.address') . ' is required'
        ]);

        $location = Location::create([
            'name' => $validated['name'],
            'code' => strtoupper($validated['code']),
            'address' => $validated['address'],
            'phone' => $validated['phone'] ?? null,
            'manager_name' => $validated['manager_name'] ?? null,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'google_place_id' => $validated['google_place_id'] ?? null,
            'is_active' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => __('common.data_saved'),
            'data' => $location
        ]);
    }

    public function updateLocation(Request $request, $id)
    {
        $location = Location::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:locations,name,' . $id,
            'code' => 'required|string|max:10|unique:locations,code,' . $id,
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'manager_name' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'google_place_id' => 'nullable|string'
        ], [
            'name.unique' => __('common.place_already_exists'),
            'code.unique' => __('common.place_code_already_exists'),
            'name.required' => __('common.name') . ' is required',
            'code.required' => __('common.code') . ' is required',
            'address.required' => __('common.address') . ' is required'
        ]);

        $location->update([
            'name' => $validated['name'],
            'code' => strtoupper($validated['code']),
            'address' => $validated['address'],
            'phone' => $validated['phone'] ?? null,
            'manager_name' => $validated['manager_name'] ?? null,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'google_place_id' => $validated['google_place_id'] ?? null
        ]);

        return response()->json([
            'success' => true,
            'message' => __('common.data_updated'),
            'data' => $location
        ]);
    }

    public function destroyLocation($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();

        return response()->json([
            'success' => true,
            'message' => 'Place deleted successfully'
        ]);
    }

    /**
     * Jenis Layanan Settings
     */
    public function serviceTypes()
    {
        $serviceTypes = ServiceType::orderBy('name')->get();
        return view('settings.service-types', compact('serviceTypes'));
    }

    public function storeServiceType(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:service_types,name',
                'description' => 'nullable|string',
                'price' => 'nullable|numeric|min:0'
            ], [
                'name.required' => __('common.service_type_name_required'),
                'name.unique' => __('common.service_type_name_unique'),
                'name.max' => __('common.service_type_name_max'),
                'price.numeric' => 'Harga harus berupa angka',
                'price.min' => 'Harga tidak boleh negatif',
            ]);

            $serviceType = ServiceType::create([
                'name' => $validated['name'],
                'description' => $request->description ?? null,
                'price' => $request->price ?? null,
                'is_active' => true
            ]);

            return response()->json([
                'success' => true,
                'message' => __('common.service_type_added_successfully'),
                'data' => $serviceType
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateServiceType(Request $request, $id)
    {
        try {
            $serviceType = ServiceType::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:service_types,name,' . $id,
                'description' => 'nullable|string',
                'price' => 'nullable|numeric|min:0'
            ], [
                'name.required' => __('common.service_type_name_required'),
                'name.unique' => __('common.service_type_name_unique'),
                'name.max' => __('common.service_type_name_max'),
                'price.numeric' => 'Harga harus berupa angka',
                'price.min' => 'Harga tidak boleh negatif',
            ]);

            // Update fields explicitly
            $serviceType->name = $validated['name'];
            $serviceType->description = $validated['description'] ?? null;
            $serviceType->price = $validated['price'] ?? null;
            $serviceType->save();

            return response()->json([
                'success' => true,
                'message' => __('common.service_type_updated_successfully'),
                'data' => $serviceType
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroyServiceType($id)
    {
        $serviceType = ServiceType::findOrFail($id);
        $serviceType->delete();

        return response()->json([
            'success' => true,
            'message' => 'Service type deleted successfully'
        ]);
    }

    /**
     * Jenis Biaya Settings
     */
    public function expenseTypes()
    {
        $expenseTypes = ExpenseType::orderBy('name')->get();
        return view('settings.expense-types', compact('expenseTypes'));
    }

    public function storeExpenseType(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:expense_types,name',
            'description' => 'nullable|string'
        ], [
            'name.required' => __('common.expense_type_name_required'),
            'name.unique' => __('common.expense_type_name_unique'),
            'name.max' => __('common.expense_type_name_max'),
        ]);

        $expenseType = ExpenseType::create([
            'name' => $validated['name'],
            'description' => $request->description ?? null,
            'is_active' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => __('common.expense_type_added_successfully'),
            'data' => $expenseType
        ]);
    }

    public function updateExpenseType(Request $request, $id)
    {
        $expenseType = ExpenseType::findOrFail($id);

        if ($expenseType->is_system) {
            return response()->json([
                'success' => false,
                'message' => 'System default types cannot be edited.'
            ], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:expense_types,name,' . $id,
            'description' => 'nullable|string'
        ], [
            'name.required' => __('common.expense_type_name_required'),
            'name.unique' => __('common.expense_type_name_unique'),
            'name.max' => __('common.expense_type_name_max'),
        ]);

        $expenseType->update($validated);

        return response()->json([
            'success' => true,
            'message' => __('common.expense_type_updated_successfully'),
            'data' => $expenseType
        ]);
    }

    public function destroyExpenseType($id)
    {
        $expenseType = ExpenseType::findOrFail($id);

        if ($expenseType->is_system) {
            return response()->json([
                'success' => false,
                'message' => 'System default types cannot be deleted.'
            ], 403);
        }
        $expenseType->delete();

        return response()->json([
            'success' => true,
            'message' => 'Expense type deleted successfully'
        ]);
    }

    /**
     * Jenis Pendapatan Settings
     */
    public function incomeTypes()
    {
        $incomeTypes = IncomeType::orderBy('name')->get();
        return view('settings.income-types', compact('incomeTypes'));
    }

    public function storeIncomeType(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:income_types,name',
            'description' => 'nullable|string'
        ], [
            'name.required' => __('common.income_type_name_required'),
            'name.unique' => __('common.income_type_name_unique'),
            'name.max' => __('common.income_type_name_max'),
        ]);

        $incomeType = IncomeType::create([
            'name' => $validated['name'],
            'description' => $request->description ?? null,
            'is_active' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => __('common.income_type_added_successfully'),
            'data' => $incomeType
        ]);
    }

    public function updateIncomeType(Request $request, $id)
    {
        $incomeType = IncomeType::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:income_types,name,' . $id,
            'description' => 'nullable|string'
        ], [
            'name.required' => __('common.income_type_name_required'),
            'name.unique' => __('common.income_type_name_unique'),
            'name.max' => __('common.income_type_name_max'),
        ]);

        $incomeType->update($validated);

        return response()->json([
            'success' => true,
            'message' => __('common.income_type_updated_successfully'),
            'data' => $incomeType
        ]);
    }

    public function destroyIncomeType($id)
    {
        $incomeType = IncomeType::findOrFail($id);
        $incomeType->delete();

        return response()->json([
            'success' => true,
            'message' => 'Income type deleted successfully'
        ]);
    }

    /**
     * Alasan Settings
     */
    public function reasons()
    {
        return view('settings.reasons');
    }

    /**
     * Cara Pembayaran Settings
     */
    public function paymentMethods()
    {
        $paymentMethods = PaymentMethod::orderBy('name')->get();
        return view('settings.payment-methods', compact('paymentMethods'));
    }

    public function storePaymentMethod(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $paymentMethod = PaymentMethod::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'is_active' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment method added successfully',
            'data' => $paymentMethod
        ]);
    }

    public function updatePaymentMethod(Request $request, $id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $paymentMethod->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Payment method updated successfully',
            'data' => $paymentMethod
        ]);
    }

    public function destroyPaymentMethod($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        $paymentMethod->delete();

        return response()->json([
            'success' => true,
            'message' => 'Payment method deleted successfully'
        ]);
    }

    /**
     * Formulir Settings
     */
    public function forms()
    {
        return view('settings.forms');
    }

    /**
     * Menghubungi Settings
     */
    public function contacts()
    {
        return view('settings.contacts');
    }

    /**
     * Terjemahan Settings
     */
    public function translations()
    {
        return view('settings.translations');
    }
}
