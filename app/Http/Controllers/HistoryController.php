<?php
// cspell:disable

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\HistoryRecord;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $vehicles = Vehicle::where('is_active', true)
            ->orderBy('name')
            ->get();

        $selectedVehicle = null;
        $groupedHistory = [];
        $performance = null;

        if ($request->has('vehicle_id') && $request->vehicle_id) {
            $selectedVehicle = Vehicle::findOrFail($request->vehicle_id);

            $groupedHistory = $this->getVehicleHistory($selectedVehicle->id);

            $performance = $this->getPerformance(
                $selectedVehicle->id,
                $request->input('period', 'last_month'),
                $request->input('start_date'),
                $request->input('end_date')
            );
        }

        return view('history.index', compact(
            'vehicles',
            'selectedVehicle',
            'groupedHistory',
            'performance'
        ));
    }

    private function getVehicleHistory($vehicleId)
    {
        $records = HistoryRecord::where('vehicle_id', $vehicleId)
            ->with('vehicle')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Group by month
        $grouped = $records->groupBy(function($record) {
            return Carbon::parse($record->date)->format('F Y');
        });

        return $grouped;
    }

    private function getPerformance($vehicleId, $period = 'last_month', $customStart = null, $customEnd = null)
    {
        $now = Carbon::now();

        if ($period === 'all') {
            $records = HistoryRecord::where('vehicle_id', $vehicleId)->get();
            $label = 'Semua Waktu';
        } elseif ($period === 'custom' && $customStart && $customEnd) {
            $start = Carbon::parse($customStart)->startOfDay();
            $end   = Carbon::parse($customEnd)->endOfDay();
            $label = $start->format('d M Y') . ' – ' . $end->format('d M Y');
            $records = HistoryRecord::where('vehicle_id', $vehicleId)
                ->whereBetween('date', [$start, $end])
                ->get();
        } elseif ($period === 'this_month') {
            $start = $now->copy()->startOfMonth();
            $end   = $now->copy();
            $label = 'Bulan Ini (' . $start->format('F Y') . ')';
            $records = HistoryRecord::where('vehicle_id', $vehicleId)
                ->whereBetween('date', [$start, $end])
                ->get();
        } else {
            // default: last_month
            $start = $now->copy()->subMonth()->startOfMonth();
            $end   = $now->copy()->subMonth()->endOfMonth();
            $label = 'Bulan Lalu (' . $start->format('F Y') . ')';
            $records = HistoryRecord::where('vehicle_id', $vehicleId)
                ->whereBetween('date', [$start, $end])
                ->get();
        }

        $totalCost         = $records->sum('cost');
        $totalTransactions = $records->count();

        return [
            'label'              => $label,
            'total_cost'         => $totalCost,
            'total_transactions' => $totalTransactions,
            'avg_cost'           => $totalTransactions > 0 ? $totalCost / $totalTransactions : 0,
        ];
    }

    public function downloadPdf(Request $request)
    {
        $vehicleId = $request->input('vehicle_id');
        $vehicle = Vehicle::findOrFail($vehicleId);
        $groupedHistory = $this->getVehicleHistory($vehicleId);

        $pdf = Pdf::loadView('history.pdf', compact('vehicle', 'groupedHistory'));
        return $pdf->download('vehicle-history-' . $vehicle->name . '.pdf');
    }

    public function downloadDetail(Request $request)
    {
        return $this->downloadPdf($request);
    }

    /**
     * Get history record data for edit (AJAX or direct).
     */
    public function edit(Request $request, $id)
    {
        $record = HistoryRecord::with('vehicle')->findOrFail($id);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $record,
            ]);
        }

        return redirect()->route('history.index', ['vehicle_id' => $record->vehicle_id]);
    }

    /**
     * Update history record and synchronize with its source model.
     */
    public function update(Request $request, $id)
    {
        $record = HistoryRecord::findOrFail($id);
        $vehicle = Vehicle::findOrFail($record->vehicle_id);

        $validated = $request->validate([
            'date' => 'required|date',
            'title' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'odometer' => 'nullable|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            // Refueling specific fields
            'liters' => 'nullable|numeric|min:0',
            'price_per_liter' => 'nullable|numeric|min:0',
            'fuel_type' => 'nullable|string|max:255',
            // Service specific fields
            'service_type' => 'nullable|string|max:255',
            'workshop' => 'nullable|string|max:255',
        ]);

        // Merge extra_data safely
        $extraData = [];
        if (is_array($record->extra_data)) {
            $extraData = $record->extra_data;
        } elseif (is_string($record->extra_data)) {
            $extraData = json_decode($record->extra_data, true) ?: [];
        }

        if ($request->filled('liters')) {
            $extraData['liters'] = $validated['liters'];
        }
        if ($request->filled('price_per_liter')) {
            $extraData['price_per_liter'] = $validated['price_per_liter'];
        }
        if ($request->filled('fuel_type')) {
            $extraData['fuel_type'] = $validated['fuel_type'];
        }
        if ($request->filled('service_type')) {
            $extraData['service_type'] = $validated['service_type'];
        }
        if ($request->filled('workshop')) {
            $extraData['workshop'] = $validated['workshop'];
        }

        // Update HistoryRecord
        $record->update([
            'date' => $validated['date'],
            'title' => $validated['title'],
            'cost' => $validated['cost'],
            'odometer' => $validated['odometer'] ?? $record->odometer,
            'location' => $validated['location'],
            'description' => $validated['description'],
            'extra_data' => $extraData,
        ]);

        // Synchronize with related source model if linked
        if ($record->related_type && $record->related_id) {
            try {
                if ($record->related_type === 'App\Models\FuelFill' || $record->related_type === 'FuelFill') {
                    $fuel = \App\Models\FuelFill::find($record->related_id);
                    if ($fuel) {
                        $fuelUpdate = [
                            'fill_date' => $validated['date'],
                            'notes' => $validated['description'],
                            'gas_station' => $validated['location'],
                            'spbu' => $validated['location'],
                        ];
                        if (isset($validated['odometer'])) {
                            $fuelUpdate['odometer'] = $validated['odometer'];
                        }
                        if (isset($validated['liters'])) {
                            $fuelUpdate['liters'] = $validated['liters'];
                        }
                        if (isset($validated['price_per_liter'])) {
                            $fuelUpdate['price_per_liter'] = $validated['price_per_liter'];
                        }
                        if (isset($validated['fuel_type'])) {
                            $fuelUpdate['fuel_type'] = $validated['fuel_type'];
                        }
                        if (isset($validated['liters']) && isset($validated['price_per_liter'])) {
                            $fuelUpdate['total_cost'] = $validated['liters'] * $validated['price_per_liter'];
                        } else {
                            $fuelUpdate['total_cost'] = $validated['cost'];
                        }
                        $fuel->update($fuelUpdate);
                    }
                } elseif ($record->related_type === 'App\Models\Maintenance' || $record->related_type === 'Maintenance') {
                    $maintenance = \App\Models\Maintenance::find($record->related_id);
                    if ($maintenance) {
                        $maintenanceUpdate = [
                            'maintenance_date' => $validated['date'],
                            'service_date' => $validated['date'],
                            'notes' => $validated['description'],
                            'cost' => $validated['cost'],
                            'total_cost' => $validated['cost'],
                            'workshop' => $validated['location'] ?? $request->input('workshop'),
                            'place' => $validated['location'] ?? $request->input('workshop'),
                        ];
                        if (isset($validated['odometer'])) {
                            $maintenanceUpdate['odometer'] = $validated['odometer'];
                        }
                        if ($request->filled('service_type')) {
                            $maintenanceUpdate['service_type'] = $validated['service_type'];
                        }
                        $maintenance->update($maintenanceUpdate);
                    }
                } elseif ($record->related_type === 'App\Models\Expense' || $record->related_type === 'Expense') {
                    $exp = \App\Models\Expense::find($record->related_id);
                    if ($exp) {
                        $expUpdate = [
                            'expense_date' => $validated['date'],
                            'amount' => $validated['cost'],
                            'total_cost' => $validated['cost'],
                            'location' => $validated['location'],
                            'place' => $validated['location'],
                            'notes' => $validated['description'],
                        ];
                        if (isset($validated['odometer'])) {
                            $expUpdate['odometer'] = $validated['odometer'];
                        }
                        $exp->update($expUpdate);
                    }
                }
            } catch (\Exception $e) {
                \Log::warning('Error syncing history to related record: ' . $e->getMessage());
            }
        }

        // Keep vehicle latest odometer updated if higher
        if (!empty($validated['odometer']) && $validated['odometer'] > ($vehicle->odometer ?? 0)) {
            $vehicle->update(['odometer' => $validated['odometer']]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Catatan riwayat berhasil diperbarui!',
            ]);
        }

        return redirect()->route('history.index', ['vehicle_id' => $record->vehicle_id])
            ->with('success', 'Catatan riwayat berhasil diperbarui!');
    }

    /**
     * Delete history record and its source record.
     */
    public function destroy($id)
    {
        if (!auth()->user()->canDeleteRecords()) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus data riwayat.');
        }

        $record = HistoryRecord::findOrFail($id);
        $vehicleId = $record->vehicle_id;

        // Delete related model if present
        if ($record->related_type && $record->related_id) {
            try {
                if ($record->related_type === 'App\Models\FuelFill' || $record->related_type === 'FuelFill') {
                    \App\Models\FuelFill::where('id', $record->related_id)->delete();
                } elseif ($record->related_type === 'App\Models\Maintenance' || $record->related_type === 'Maintenance') {
                    \App\Models\Maintenance::where('id', $record->related_id)->delete();
                } elseif ($record->related_type === 'App\Models\Expense' || $record->related_type === 'Expense') {
                    \App\Models\Expense::where('id', $record->related_id)->delete();
                }
            } catch (\Exception $e) {
                \Log::warning('Error deleting related record: ' . $e->getMessage());
            }
        }

        $record->delete();

        return redirect()->route('history.index', ['vehicle_id' => $vehicleId])
            ->with('success', 'Catatan riwayat berhasil dihapus!');
    }
}
