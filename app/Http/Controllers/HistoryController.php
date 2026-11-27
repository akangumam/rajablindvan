<?php
// cspell:disable

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\HistoryRecord;
use App\Models\ServiceType;
use App\Models\Place;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Models\ExpenseType;
use App\Models\IncomeType;
use App\Models\Maintenance;
use App\Models\Expense;
use App\Models\Income;
use App\Models\FuelFill;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $vehicles        = Vehicle::where('is_active', true)->orderBy('name')->get();
        $selectedVehicle = $this->resolveSelectedVehicle($request, $vehicles);
        $groupedHistory  = [];
        $performance     = null;

        if ($selectedVehicle) {
            session(['last_active_vehicle_id' => $selectedVehicle->id]);
            cookie()->queue(cookie('last_active_vehicle_id', $selectedVehicle->id, 60 * 24 * 30));

            $groupedHistory = $this->getVehicleHistory($selectedVehicle->id);
            $performance    = $this->getPerformance(
                $selectedVehicle->id,
                $request->input('period', 'last_month'),
                $request->input('start_date'),
                $request->input('end_date')
            );
        }

        return view('history.index', array_merge(
            compact('vehicles', 'selectedVehicle', 'groupedHistory', 'performance'),
            $this->getEditReferenceData()
        ));
    }

    /**
     * Resolve selected vehicle from query, session/cookie, latest activity, or first active vehicle.
     */
    private function resolveSelectedVehicle(Request $request, $vehicles): ?Vehicle
    {
        $vehicleId = $request->input('vehicle_id');

        if (!$vehicleId) {
            $rememberedId = session('last_active_vehicle_id') ?: $request->cookie('last_active_vehicle_id');
            if ($rememberedId && $vehicles->contains('id', (int) $rememberedId)) {
                $vehicleId = (int) $rememberedId;
            }

            if (!$vehicleId) {
                $latestId = HistoryRecord::whereIn('vehicle_id', $vehicles->pluck('id'))
                    ->orderBy('date', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->value('vehicle_id');

                if ($latestId && $vehicles->contains('id', (int) $latestId)) {
                    $vehicleId = (int) $latestId;
                }
            }

            if (!$vehicleId && $vehicles->isNotEmpty()) {
                $vehicleId = $vehicles->first()->id;
            }
        }

        if (!$vehicleId) {
            return null;
        }

        return $vehicles->firstWhere('id', $vehicleId) ?: Vehicle::find($vehicleId);
    }

    /**
     * Load active master reference options for the history edit modal.
     */
    private function getEditReferenceData(): array
    {
        return [
            'serviceTypes'   => ServiceType::active()->orderBy('name')->get(['id', 'name', 'price']),
            'places'         => Place::getAllActive(),
            'paymentMethods' => PaymentMethod::active()->orderBy('name')->get(['id', 'name']),
            'users'          => User::active()->orderBy('name')->get(['id', 'name', 'user_type']),
            'expenseTypes'   => ExpenseType::active()->orderBy('name')->get(['id', 'name']),
            'incomeTypes'    => IncomeType::active()->orderBy('name')->get(['id', 'name']),
        ];
    }

    private function getVehicleHistory($vehicleId)
    {
        // Auto-sync any unsynced incomes for this vehicle
        $unsyncedIncomes = Income::where('vehicle_id', $vehicleId)
            ->whereNotIn('id', function($q) {
                $q->select('related_id')
                  ->from('history_records')
                  ->where('related_type', 'App\\Models\\Income');
            })->get();

        foreach ($unsyncedIncomes as $income) {
            HistoryRecord::createFromIncome($income);
        }

        $records = HistoryRecord::where('vehicle_id', $vehicleId)
            ->with('vehicle')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Batch load related source records to avoid N+1 queries and enrich timeline/edit metadata
        $maintenanceIds = $records->filter(fn($r) => str_ends_with((string)$r->related_type, 'Maintenance') && $r->related_id)->pluck('related_id')->unique();
        $expenseIds     = $records->filter(fn($r) => str_ends_with((string)$r->related_type, 'Expense') && $r->related_id)->pluck('related_id')->unique();
        $incomeIds      = $records->filter(fn($r) => str_ends_with((string)$r->related_type, 'Income') && $r->related_id)->pluck('related_id')->unique();
        $fuelIds        = $records->filter(fn($r) => str_ends_with((string)$r->related_type, 'FuelFill') && $r->related_id)->pluck('related_id')->unique();

        $maintenances = $maintenanceIds->isNotEmpty() ? Maintenance::with('user')->whereIn('id', $maintenanceIds)->get()->keyBy('id') : collect();
        $expenses     = $expenseIds->isNotEmpty()     ? Expense::with('user')->whereIn('id', $expenseIds)->get()->keyBy('id') : collect();
        $incomes      = $incomeIds->isNotEmpty()      ? Income::with('user')->whereIn('id', $incomeIds)->get()->keyBy('id') : collect();
        $fuelFills    = $fuelIds->isNotEmpty()        ? FuelFill::whereIn('id', $fuelIds)->get()->keyBy('id') : collect();
        $userNames    = User::pluck('name', 'id');

        foreach ($records as $record) {
            /** @var HistoryRecord $record */
            $extra = is_array($record->extra_data) ? $record->extra_data : (json_decode((string)$record->extra_data, true) ?: []);

            if (str_ends_with((string)$record->related_type, 'Maintenance') && isset($maintenances[$record->related_id])) {
                $m = $maintenances[$record->related_id];
                if (empty($extra['service_items'])) {
                    $extra['service_items'] = HistoryRecord::parseServiceItemsFromMaintenance($m);
                }
                if (empty($extra['service_type'])) {
                    $extra['service_type'] = $m->service_type ?? $m->type;
                }
                if (empty($record->location)) {
                    $record->location = $m->place ?? $m->workshop;
                }
                if (empty($extra['workshop'])) {
                    $extra['workshop'] = $record->location ?? $m->place ?? $m->workshop;
                }
                $extra['time']           = $extra['time'] ?? ($m->service_time ? substr((string)$m->service_time, 0, 5) : null);
                $extra['user_id']        = $extra['user_id'] ?? $m->user_id;
                $extra['driver_name']    = $extra['driver_name'] ?? ($m->user->name ?? ($extra['user_id'] ? ($userNames[$extra['user_id']] ?? null) : null));
                $extra['payment_method'] = $extra['payment_method'] ?? $m->payment_method;
                if (empty($record->description) && !empty($m->notes)) {
                    $record->description = $m->notes;
                }
            } elseif (str_ends_with((string)$record->related_type, 'Expense') && isset($expenses[$record->related_id])) {
                $e = $expenses[$record->related_id];
                if (empty($record->location)) {
                    $record->location = $e->place;
                }
                $extra['category']       = $extra['category'] ?? ($e->category ?? $e->expense_type);
                $extra['time']           = $extra['time'] ?? ($e->expense_time ? substr((string)$e->expense_time, 0, 5) : null);
                $extra['user_id']        = $extra['user_id'] ?? $e->user_id;
                $extra['driver_name']    = $extra['driver_name'] ?? ($e->user->name ?? ($extra['user_id'] ? ($userNames[$extra['user_id']] ?? null) : null));
                $extra['payment_method'] = $extra['payment_method'] ?? $e->payment_method;
            } elseif (str_ends_with((string)$record->related_type, 'Income') && isset($incomes[$record->related_id])) {
                $inc = $incomes[$record->related_id];
                $extra['income_type'] = $extra['income_type'] ?? $inc->type;
                $extra['time']        = $extra['time'] ?? ($inc->income_time ? substr((string)$inc->income_time, 0, 5) : null);
                $extra['user_id']     = $extra['user_id'] ?? $inc->user_id;
                $extra['driver_name'] = $extra['driver_name'] ?? ($inc->user->name ?? ($extra['user_id'] ? ($userNames[$extra['user_id']] ?? null) : null));
            } elseif (str_ends_with((string)$record->related_type, 'FuelFill') && isset($fuelFills[$record->related_id])) {
                $f = $fuelFills[$record->related_id];
                $extra['fuel_type']       = $extra['fuel_type'] ?? $f->fuel_type;
                $extra['liters']          = $extra['liters'] ?? $f->liters;
                $extra['price_per_liter'] = $extra['price_per_liter'] ?? $f->price_per_liter;
                $extra['time']            = $extra['time'] ?? ($f->time ? substr((string)$f->time, 0, 5) : null);
                $extra['driver_name']     = $extra['driver_name'] ?? $f->driver;
                $extra['payment_method']  = $extra['payment_method'] ?? $f->payment_method;
            } else {
                // Standalone history record fallback for driver_name & service_items
                if (in_array($record->type, ['service', 'oil_change']) && empty($extra['service_items']) && !empty($extra['service_type'])) {
                    $parts = array_filter(array_map('trim', explode(',', (string)$extra['service_type'])));
                    $items = [];
                    foreach ($parts as $p) {
                        $items[] = [
                            'name'  => $p,
                            'price' => count($parts) === 1 ? (float)$record->cost : null,
                        ];
                    }
                    $extra['service_items'] = $items;
                }
                if (!empty($extra['user_id']) && empty($extra['driver_name'])) {
                    $extra['driver_name'] = $userNames[$extra['user_id']] ?? null;
                }
            }

            $record->enriched_extra = $extra;
        }

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

        $totalTransactions = $records->count();
        $totalIncome       = (float) $records->where('type', 'income')->sum('cost');
        $totalCost         = (float) $records->where('type', '!=', 'income')->sum('cost');
        $balance           = $totalIncome - $totalCost;

        return [
            'label'              => $label,
            'total_transactions' => $totalTransactions,
            'total_income'       => $totalIncome,
            'total_cost'         => $totalCost,
            'balance'            => $balance,
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
            'date'               => 'required|date',
            'time'               => 'nullable|string|max:10',
            'title'              => 'nullable|string|max:255',
            'cost'               => 'required|numeric|min:0',
            'odometer'           => 'nullable|numeric|min:0',
            'location'           => 'nullable|string|max:255',
            'description'        => 'nullable|string',
            'user_id'            => 'nullable|integer|exists:users,id',
            'payment_method'     => 'nullable|string|max:255',
            // Refueling specific fields
            'liters'             => 'nullable|numeric|min:0',
            'price_per_liter'    => 'nullable|numeric|min:0',
            'fuel_type'          => 'nullable|string|max:255',
            // Service specific fields
            'service_type'       => 'nullable|string|max:255',
            'service_items_json' => 'nullable|string',
            'workshop'           => 'nullable|string|max:255',
            // Expense & Income specific fields
            'expense_type'       => 'nullable|string|max:255',
            'income_type'        => 'nullable|string|max:255',
        ]);

        // Merge extra_data safely
        $extraData = [];
        $rawExtra = $record->extra_data;
        if (is_array($rawExtra)) {
            $extraData = $rawExtra;
        } elseif (is_string($rawExtra)) {
            $decoded = json_decode((string) $rawExtra, true);
            $extraData = is_array($decoded) ? $decoded : [];
        }

        // Common metadata updates
        $extraData['time'] = $validated['time'] ?? ($extraData['time'] ?? null);
        if ($request->has('user_id')) {
            $extraData['user_id'] = $validated['user_id'] ?: null;
            if (!empty($validated['user_id'])) {
                $userObj = User::find($validated['user_id']);
                $extraData['driver_name'] = $userObj ? $userObj->name : null;
            } else {
                $extraData['driver_name'] = null;
            }
        }
        if ($request->has('payment_method')) {
            $extraData['payment_method'] = $validated['payment_method'] ?: null;
        }

        // Location / workshop sync
        $location = $validated['location'] ?? null;
        if (empty($location) && !empty($validated['workshop'])) {
            $location = $validated['workshop'];
        }

        // Handle itemized services if provided
        $serviceItems = [];
        $serviceBreakdownText = '';
        if ($request->filled('service_items_json')) {
            $decodedItems = json_decode((string) $validated['service_items_json'], true);
            if (is_array($decodedItems)) {
                $names = [];
                $lines = [];
                foreach ($decodedItems as $item) {
                    $itemName = trim((string) ($item['name'] ?? ''));
                    if ($itemName === '') continue;

                    $itemPrice = isset($item['price']) && $item['price'] !== '' && $item['price'] !== null
                        ? (float) $item['price']
                        : null;

                    $serviceItems[] = [
                        'name'  => $itemName,
                        'price' => $itemPrice,
                    ];
                    $names[] = $itemName;
                    $lines[] = $itemName . ' (Rp ' . number_format($itemPrice ?? 0, 0, ',', '.') . ')';
                }

                if (!empty($names)) {
                    $extraData['service_items'] = $serviceItems;
                    $extraData['service_type'] = \Illuminate\Support\Str::limit(implode(', ', $names), 250);
                    $serviceBreakdownText = "Service Breakdown:\n" . implode("\n", $lines);
                } else {
                    unset($extraData['service_items']);
                }
            }
        } elseif ($request->filled('service_type')) {
            $extraData['service_type'] = $validated['service_type'];
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
        if (!empty($location)) {
            $extraData['workshop'] = $location;
        }
        if ($request->filled('expense_type')) {
            $extraData['category'] = $validated['expense_type'];
        }
        if ($request->filled('income_type')) {
            $extraData['income_type'] = $validated['income_type'];
        }

        // Determine final title
        $finalTitle = trim((string) ($validated['title'] ?? ''));
        if ($finalTitle === '') {
            if (!empty($serviceItems)) {
                $firstName = $serviceItems[0]['name'];
                $extraCount = count($serviceItems) - 1;
                $finalTitle = $extraCount > 0 ? "{$firstName} +{$extraCount}" : $firstName;
            } elseif (!empty($extraData['income_type'])) {
                $finalTitle = $extraData['income_type'];
            } elseif (!empty($extraData['category'])) {
                $finalTitle = $extraData['category'];
            } else {
                $finalTitle = $record->title ?: ucwords(str_replace('_', ' ', $record->type));
            }
        }

        // Update HistoryRecord
        $record->update([
            'date'        => $validated['date'],
            'title'       => $finalTitle,
            'cost'        => $validated['cost'],
            'odometer'    => $request->has('odometer') ? $validated['odometer'] : $record->odometer,
            'location'    => $location,
            'description' => $validated['description'],
            'extra_data'  => $extraData,
        ]);

        // Synchronize with related source model WITHOUT firing observers (prevents observers from overwriting our edits)
        if ($record->related_type && $record->related_id) {
            try {
                if (str_ends_with((string)$record->related_type, 'FuelFill')) {
                    FuelFill::withoutEvents(function () use ($record, $validated, $extraData, $location) {
                        $fuel = FuelFill::find($record->related_id);
                        if ($fuel) {
                            $fuelUpdate = [
                                'fill_date'      => $validated['date'],
                                'time'           => $extraData['time'] ?? $fuel->time,
                                'notes'          => $validated['description'],
                                'gas_station'    => $location,
                                'spbu'           => $location,
                                'payment_method' => $extraData['payment_method'] ?? $fuel->payment_method,
                                'driver'         => $extraData['driver_name'] ?? $fuel->driver,
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
                    });
                } elseif (str_ends_with((string)$record->related_type, 'Maintenance')) {
                    Maintenance::withoutEvents(function () use ($record, $validated, $extraData, $location, $serviceBreakdownText) {
                        $maintenance = Maintenance::find($record->related_id);
                        if ($maintenance) {
                            $maintenanceUpdate = [
                                'maintenance_date' => $validated['date'],
                                'service_date'     => $validated['date'],
                                'service_time'     => $extraData['time'] ?? $maintenance->service_time,
                                'notes'            => $validated['description'],
                                'cost'             => $validated['cost'],
                                'total_cost'       => $validated['cost'],
                                'workshop'         => $location,
                                'place'            => $location,
                                'payment_method'   => $extraData['payment_method'] ?? $maintenance->payment_method,
                                'user_id'          => $extraData['user_id'] ?? $maintenance->user_id,
                            ];
                            if ($serviceBreakdownText !== '') {
                                $maintenanceUpdate['description'] = $serviceBreakdownText;
                            }
                            if (isset($validated['odometer'])) {
                                $maintenanceUpdate['odometer'] = $validated['odometer'];
                            }
                            if (!empty($extraData['service_type'])) {
                                $maintenanceUpdate['service_type'] = $extraData['service_type'];
                            }
                            $maintenance->update($maintenanceUpdate);
                        }
                    });
                } elseif (str_ends_with((string)$record->related_type, 'Expense')) {
                    Expense::withoutEvents(function () use ($record, $validated, $extraData, $location, $finalTitle) {
                        $exp = Expense::find($record->related_id);
                        if ($exp) {
                            $expUpdate = [
                                'expense_date'   => $validated['date'],
                                'expense_time'   => $extraData['time'] ?? $exp->expense_time,
                                'amount'         => $validated['cost'],
                                'total_cost'     => $validated['cost'],
                                'place'          => $location,
                                'description'    => $finalTitle,
                                'notes'          => $validated['description'],
                                'payment_method' => $extraData['payment_method'] ?? $exp->payment_method,
                                'user_id'        => $extraData['user_id'] ?? $exp->user_id,
                            ];
                            if (!empty($extraData['category'])) {
                                $expUpdate['category'] = $extraData['category'];
                                $expUpdate['expense_type'] = $extraData['category'];
                            }
                            if (isset($validated['odometer'])) {
                                $expUpdate['odometer'] = $validated['odometer'];
                            }
                            $exp->update($expUpdate);
                        }
                    });
                } elseif (str_ends_with((string)$record->related_type, 'Income')) {
                    Income::withoutEvents(function () use ($record, $validated, $extraData, $finalTitle) {
                        $income = Income::find($record->related_id);
                        if ($income) {
                            $incomeUpdate = [
                                'income_date' => $validated['date'],
                                'income_time' => $extraData['time'] ?? $income->income_time,
                                'amount'      => $validated['cost'],
                                'type'        => $extraData['income_type'] ?? $finalTitle,
                                'notes'       => $validated['description'],
                                'description' => $validated['description'] ?? ($extraData['income_type'] ?? $finalTitle),
                                'user_id'     => $extraData['user_id'] ?? $income->user_id,
                            ];
                            if (isset($validated['odometer'])) {
                                $incomeUpdate['odometer'] = $validated['odometer'];
                            }
                            $income->update($incomeUpdate);
                        }
                    });
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
                if (str_ends_with((string)$record->related_type, 'FuelFill')) {
                    FuelFill::withoutEvents(fn() => FuelFill::where('id', $record->related_id)->delete());
                } elseif (str_ends_with((string)$record->related_type, 'Maintenance')) {
                    Maintenance::withoutEvents(fn() => Maintenance::where('id', $record->related_id)->delete());
                } elseif (str_ends_with((string)$record->related_type, 'Expense')) {
                    Expense::withoutEvents(fn() => Expense::where('id', $record->related_id)->delete());
                } elseif (str_ends_with((string)$record->related_type, 'Income')) {
                    Income::withoutEvents(fn() => Income::where('id', $record->related_id)->delete());
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
