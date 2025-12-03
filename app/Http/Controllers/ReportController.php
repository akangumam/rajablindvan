<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rental;
use App\Models\Vehicle;
use App\Models\Customer;
use App\Models\FuelFill;
use App\Models\Maintenance;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FinancialReportExport;
use App\Exports\VehiclesExport;
use App\Exports\CustomersExport;
use App\Exports\RentalsExport;

class ReportController extends Controller
{
    private const TOTAL_AMOUNT_CHARGES = 'total_amount + additional_charges';
    
    /**
     * Show main report page with filters
     */
    public function index()
    {
        $query = Vehicle::where('is_active', true);
        
        // Apply global location filter
        $locationId = \App\Http\Middleware\LocationFilter::getLocationId();
        if ($locationId) {
            $query->where('location_id', $locationId);
        }
        
        $vehicles = $query->orderBy('name')->get();
        
        return view('reports.index', compact('vehicles'));
    }
    
    // ... (keep existing code)

    /**
     * Helper: Get filtered vehicles
     */
    private function getFilteredVehicles($filter, $ids = [])
    {
        $query = Vehicle::query();
        
        // Apply global location filter
        $locationId = \App\Http\Middleware\LocationFilter::getLocationId();
        if ($locationId) {
            $query->where('location_id', $locationId);
        }
        
        if ($filter === 'active') {
            $query->where('is_active', true);
        } elseif ($filter === 'inactive') {
            $query->where('is_active', false);
        } elseif ($filter === 'custom' && !empty($ids)) {
            $query->whereIn('id', $ids);
        }
        
        return $query->orderBy('name')->get();
    }
    
    /**
     * OLD ROUTES - Redirect to new page
     */
    public function dashboard() {
        return redirect()->route('reports.index');
    }
    
    public function rentals() {
        return redirect()->route('reports.index');
    }
    
    public function vehicles() {
        return redirect()->route('reports.index');
    }
    
    public function financial() {
        return redirect()->route('reports.index');
    }
    
    public function customers() {
        return redirect()->route('reports.index');
    }
    
    /**
     * Export methods (keep for backward compatibility)
     */
    public function exportFinancialExcel(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $vehicleId = $request->input('vehicle_id');

        $filename = 'laporan-keuangan-' . ($startDate ? $startDate : 'all') . '-to-' . ($endDate ? $endDate : 'now') . '.xlsx';
        
        return Excel::download(new FinancialReportExport($startDate, $endDate, $vehicleId), $filename);
    }

    public function exportVehiclesExcel()
    {
        $filename = 'data-kendaraan-' . date('Y-m-d') . '.xlsx';
        
        return Excel::download(new VehiclesExport(), $filename);
    }

    public function exportCustomersExcel()
    {
        $filename = 'data-pelanggan-' . date('Y-m-d') . '.xlsx';
        
        return Excel::download(new CustomersExport(), $filename);
    }

    public function exportRentalsExcel(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status');

        $filename = 'data-sewa-' . ($startDate ? $startDate : 'all') . '-to-' . ($endDate ? $endDate : 'now') . '.xlsx';
        
        return Excel::download(new RentalsExport($startDate, $endDate, $status), $filename);
    }
}
