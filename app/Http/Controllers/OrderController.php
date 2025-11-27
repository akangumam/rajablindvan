<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Vehicle;
use App\Models\Customer;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with(['vehicle', 'customer']);
        
        // Filter by status (default: Active)
        $status = $request->get('status', 'Active');
        if ($status !== 'All') {
            $query->where('status', $status);
        }

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('vehicle', function($vehicleQuery) use ($search) {
                    $vehicleQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('license_plate', 'like', "%{$search}%");
                })
                ->orWhereHas('customer', function($customerQuery) use ($search) {
                    $customerQuery->where('name', 'like', "%{$search}%")
                                 ->orWhere('company_name', 'like', "%{$search}%");
                });
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        // Handle relationship sorting
        if ($sortBy === 'vehicle_name') {
            $query->join('vehicles', 'orders.vehicle_id', '=', 'vehicles.id')
                  ->orderBy('vehicles.name', $sortOrder)
                  ->select('orders.*');
        } elseif ($sortBy === 'license_plate') {
            $query->join('vehicles', 'orders.vehicle_id', '=', 'vehicles.id')
                  ->orderBy('vehicles.license_plate', $sortOrder)
                  ->select('orders.*');
        } elseif ($sortBy === 'year') {
            $query->join('vehicles', 'orders.vehicle_id', '=', 'vehicles.id')
                  ->orderBy('vehicles.year', $sortOrder)
                  ->select('orders.*');
        } elseif ($sortBy === 'customer_name') {
            $query->join('customers', 'orders.customer_id', '=', 'customers.id')
                  ->orderBy('customers.name', $sortOrder)
                  ->select('orders.*');
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        $orders = $query->get();

        return view('orders.index', compact('orders', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vehicles = Vehicle::all(); // Get all vehicles
        $customers = Customer::all();
        return view('orders.create', compact('vehicles', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'customer_id' => 'required|exists:customers,id',
            'rental_type' => 'required|in:Sewa Harian,Sewa Bulanan',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Order::create($validated);

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $vehicles = Vehicle::all(); // Get all vehicles
        $customers = Customer::all();
        return view('orders.edit', compact('order', 'vehicles', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'customer_id' => 'required|exists:customers,id',
            'rental_type' => 'required|in:Sewa Harian,Sewa Bulanan',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:Active,Completed,Cancelled',
        ]);

        $order->update($validated);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    /**
     * Mark order as completed
     */
    public function complete(Order $order)
    {
        $order->update([
            'status' => 'Completed',
            'completed_at' => now()
        ]);

        return redirect()->route('orders.index')->with('success', 'Order marked as completed successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        // Only Administrator & Sales can delete
        if (!auth()->user()->canDeleteRecords()) {
            abort(403, 'Unauthorized action. Only Administrator and Sales can delete orders.');
        }
        
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
