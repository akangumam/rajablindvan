<?php

namespace App\Http\Controllers;

use App\Models\Investor;
use App\Models\Vehicle;
use App\Models\Rental;
use App\Models\FuelFill;
use App\Models\Maintenance;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvestorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $investors = Investor::withCount('vehicles')
            ->orderBy('name')
            ->paginate(15);

        return view('investors.index', compact('investors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('investors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'id_number' => 'nullable|string|max:50',
            'investment_percentage' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        $investor = Investor::create($validated);

        return redirect()->route('investors.show', $investor)
            ->with('success', 'Investor berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $investor = Investor::with('vehicles')->findOrFail($id);
        
        // Get date range for filtering
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));
        
        $vehicleIds = $investor->vehicles->pluck('id');

        // Calculate income from rentals
        $rentalsQuery = Rental::whereIn('vehicle_id', $vehicleIds)
            ->where('status', 'completed');
        
        if ($startDate && $endDate) {
            $rentalsQuery->whereBetween('start_date', [$startDate, $endDate]);
        }
        
        $rentals = $rentalsQuery->with('vehicle', 'customer')->get();
        $totalIncome = $rentals->sum('total_price');

        // Calculate expenses
        $fuelFills = FuelFill::whereIn('vehicle_id', $vehicleIds)
            ->when($startDate && $endDate, function($q) use ($startDate, $endDate) {
                return $q->whereBetween('fill_date', [$startDate, $endDate]);
            })
            ->with('vehicle')
            ->get();
        
        $maintenances = Maintenance::whereIn('vehicle_id', $vehicleIds)
            ->when($startDate && $endDate, function($q) use ($startDate, $endDate) {
                return $q->whereBetween('maintenance_date', [$startDate, $endDate]);
            })
            ->with('vehicle')
            ->get();
        
        $expenses = Expense::whereIn('vehicle_id', $vehicleIds)
            ->when($startDate && $endDate, function($q) use ($startDate, $endDate) {
                return $q->whereBetween('date', [$startDate, $endDate]);
            })
            ->with('vehicle')
            ->get();

        $totalExpenses = $fuelFills->sum('total_price') + 
                        $maintenances->sum('cost') + 
                        $expenses->sum('amount');

        $netProfit = $totalIncome - $totalExpenses;
        $investorShare = $netProfit * ($investor->investment_percentage / 100);

        return view('investors.show', compact(
            'investor',
            'rentals',
            'fuelFills',
            'maintenances',
            'expenses',
            'totalIncome',
            'totalExpenses',
            'netProfit',
            'investorShare',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $investor = Investor::findOrFail($id);
        return view('investors.edit', compact('investor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $investor = Investor::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'id_number' => 'nullable|string|max:50',
            'investment_percentage' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        $investor->update($validated);

        return redirect()->route('investors.show', $investor)
            ->with('success', 'Data investor berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $investor = Investor::findOrFail($id);
        
        // Check if investor has vehicles
        if ($investor->vehicles()->count() > 0) {
            return redirect()->route('investors.index')
                ->with('error', 'Tidak dapat menghapus investor yang masih memiliki kendaraan!');
        }

        $investor->delete();

        return redirect()->route('investors.index')
            ->with('success', 'Investor berhasil dihapus!');
    }

    /**
     * Generate PDF report for investor
     */
    public function generateReport(string $id, Request $request)
    {
        $investor = Investor::with('vehicles')->findOrFail($id);
        
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));
        
        $vehicleIds = $investor->vehicles->pluck('id');

        // Get all data for report
        $rentals = Rental::whereIn('vehicle_id', $vehicleIds)
            ->where('status', 'completed')
            ->whereBetween('start_date', [$startDate, $endDate])
            ->with('vehicle', 'customer')
            ->get();

        $fuelFills = FuelFill::whereIn('vehicle_id', $vehicleIds)
            ->whereBetween('fill_date', [$startDate, $endDate])
            ->with('vehicle')
            ->get();
        
        $maintenances = Maintenance::whereIn('vehicle_id', $vehicleIds)
            ->whereBetween('maintenance_date', [$startDate, $endDate])
            ->with('vehicle')
            ->get();
        
        $expenses = Expense::whereIn('vehicle_id', $vehicleIds)
            ->whereBetween('date', [$startDate, $endDate])
            ->with('vehicle')
            ->get();

        $totalIncome = $rentals->sum('total_price');
        $totalExpenses = $fuelFills->sum('total_price') + $maintenances->sum('cost') + $expenses->sum('amount');
        $netProfit = $totalIncome - $totalExpenses;
        $investorShare = $netProfit * ($investor->investment_percentage / 100);

        // Generate PDF (using DomPDF)
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('investors.report-pdf', compact(
            'investor',
            'rentals',
            'fuelFills',
            'maintenances',
            'expenses',
            'totalIncome',
            'totalExpenses',
            'netProfit',
            'investorShare',
            'startDate',
            'endDate'
        ));

        return $pdf->download('investor-report-' . $investor->name . '-' . date('Y-m-d') . '.pdf');
    }
}

