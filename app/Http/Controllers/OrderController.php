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
    public function index()
    {
        $orders = Order::with(['vehicle', 'customer'])
            ->where('status', 'Active')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orders.index', compact('orders'));
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
            'status' => 'required|in:Active,Inactive',
        ]);

        $order->update($validated);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
