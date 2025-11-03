<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rental;
use App\Models\Vehicle;
use App\Models\Customer;
use Carbon\Carbon;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rentals = Rental::with(['customer', 'vehicle'])
            ->latest('start_date')
            ->paginate(20);

        return view('rentals.index', compact('rentals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $customers = Customer::active()->orderBy('name')->get();
        $vehicles = Vehicle::active()->orderBy('name')->get();
        
        $selectedCustomer = null;
        $selectedVehicle = null;
        
        if ($request->customer) {
            $selectedCustomer = Customer::find($request->customer);
        }
        
        if ($request->vehicle) {
            $selectedVehicle = Vehicle::find($request->vehicle);
        }

        return view('rentals.create', compact('customers', 'vehicles', 'selectedCustomer', 'selectedVehicle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'rental_type' => 'required|in:daily,weekly,monthly',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'daily_rate' => 'required|numeric|min:0',
            'weekly_rate' => 'nullable|numeric|min:0',
            'monthly_rate' => 'nullable|numeric|min:0',
            'deposit' => 'required|numeric|min:0',
            'pickup_location' => 'nullable|string|max:255',
            'return_location' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        $vehicle = Vehicle::findOrFail($validated['vehicle_id']);
        
        // Check vehicle availability
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);
        
        if (!$vehicle->isAvailableForRental($startDate, $endDate)) {
            return back()->withErrors(['vehicle_id' => 'Kendaraan tidak tersedia pada tanggal tersebut.']);
        }

        // Calculate duration and total based on rental type
        $duration = $startDate->diffInDays($endDate) + 1;
        $validated['duration_days'] = $duration;
        
        $totalAmount = 0;
        switch ($validated['rental_type']) {
            case 'weekly':
                $weeks = ceil($duration / 7);
                $rate = $validated['weekly_rate'] ?? ($validated['daily_rate'] * 7);
                $totalAmount = $rate * $weeks;
                break;
            case 'monthly':
                $months = ceil($duration / 30);
                $rate = $validated['monthly_rate'] ?? ($validated['daily_rate'] * 30);
                $totalAmount = $rate * $months;
                break;
            default: // daily
                $totalAmount = $validated['daily_rate'] * $duration;
                break;
        }
        
        $validated['total_amount'] = $totalAmount;
        $validated['start_odometer'] = $vehicle->getLatestOdometer();
        $validated['rental_code'] = Rental::generateRentalCode();

        Rental::create($validated);

        return redirect()->route('rentals.index')
            ->with('success', 'Data rental berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rental $rental)
    {
        $rental->load(['customer', 'vehicle']);
        return view('rentals.show', compact('rental'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rental $rental)
    {
        if ($rental->status !== 'reserved') {
            return redirect()->route('rentals.show', $rental)
                ->with('error', 'Hanya rental dengan status reservasi yang dapat diedit.');
        }

        $customers = Customer::active()->orderBy('name')->get();
        $vehicles = Vehicle::active()->orderBy('name')->get();

        return view('rentals.edit', compact('rental', 'customers', 'vehicles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rental $rental)
    {
        if ($rental->status !== 'reserved') {
            return redirect()->route('rentals.show', $rental)
                ->with('error', 'Hanya rental dengan status reservasi yang dapat diedit.');
        }

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'rental_type' => 'required|in:daily,weekly,monthly',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'daily_rate' => 'required|numeric|min:0',
            'weekly_rate' => 'nullable|numeric|min:0',
            'monthly_rate' => 'nullable|numeric|min:0',
            'deposit' => 'required|numeric|min:0',
            'pickup_location' => 'nullable|string|max:255',
            'return_location' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        // Recalculate duration and total based on rental type
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);
        $duration = $startDate->diffInDays($endDate) + 1;
        
        $validated['duration_days'] = $duration;
        
        $totalAmount = 0;
        switch ($validated['rental_type']) {
            case 'weekly':
                $weeks = ceil($duration / 7);
                $rate = $validated['weekly_rate'] ?? ($validated['daily_rate'] * 7);
                $totalAmount = $rate * $weeks;
                break;
            case 'monthly':
                $months = ceil($duration / 30);
                $rate = $validated['monthly_rate'] ?? ($validated['daily_rate'] * 30);
                $totalAmount = $rate * $months;
                break;
            default: // daily
                $totalAmount = $validated['daily_rate'] * $duration;
                break;
        }
        
        $validated['total_amount'] = $totalAmount;

        $rental->update($validated);

        return redirect()->route('rentals.show', $rental)
            ->with('success', 'Data rental berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rental $rental)
    {
        // Only Administrator & Sales can delete
        if (!auth()->user()->canDeleteRecords()) {
            abort(403, 'Unauthorized action. Only Administrator and Sales can delete rentals.');
        }
        
        if ($rental->status === 'active') {
            return redirect()->route('rentals.index')
                ->with('error', 'Rental aktif tidak dapat dihapus!');
        }

        $rental->delete();

        return redirect()->route('rentals.index')
            ->with('success', 'Data rental berhasil dihapus!');
    }

    /**
     * Start rental
     */
    public function startRental(Request $request, Rental $rental)
    {
        if (!$rental->canBeStarted()) {
            return redirect()->route('rentals.show', $rental)
                ->with('error', 'Rental tidak dapat dimulai.');
        }

        $validated = $request->validate([
            'actual_start_odometer' => 'required|numeric|min:' . $rental->start_odometer,
        ], [
            'actual_start_odometer.min' => 'Odometer harus lebih besar atau sama dengan ' . number_format($rental->start_odometer) . ' km',
        ]);

        $rental->update([
            'status' => 'active',
            'actual_start_time' => now(),
            'start_odometer' => $validated['actual_start_odometer']
        ]);

        return redirect()->route('rentals.show', $rental)
            ->with('success', 'Rental berhasil dimulai!');
    }

    /**
     * Complete rental
     */
    public function completeRental(Request $request, Rental $rental)
    {
        if (!$rental->canBeCompleted()) {
            return redirect()->route('rentals.show', $rental)
                ->with('error', 'Rental tidak dapat diselesaikan.');
        }

        $validated = $request->validate([
            'end_odometer' => 'required|numeric|min:' . $rental->start_odometer,
            'additional_charges' => 'nullable|numeric|min:0',
            'additional_charges_notes' => 'nullable|string',
        ], [
            'end_odometer.min' => 'Odometer akhir harus lebih besar dari odometer awal (' . number_format($rental->start_odometer) . ' km)',
        ]);

        $rental->update([
            'status' => 'completed',
            'actual_end_time' => now(),
            'end_odometer' => $validated['end_odometer'],
            'additional_charges' => $validated['additional_charges'] ?? 0,
            'additional_charges_notes' => $validated['additional_charges_notes']
        ]);

        return redirect()->route('rentals.show', $rental)
            ->with('success', 'Rental berhasil diselesaikan!');
    }
}
