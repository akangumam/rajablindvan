<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    public function index(Request $request)
    {
        $vehicles = Vehicle::orderBy('name')->get();
        
        $selectedVehicle = null;
        $reminders = collect();
        
        if ($request->has('vehicle')) {
            $selectedVehicle = Vehicle::find($request->vehicle);
            if ($selectedVehicle) {
                $reminders = Reminder::where('vehicle_id', $selectedVehicle->id)
                    ->latest('due_date')
                    ->paginate(20);
            }
        }
        
        return view('reminders.index', compact('reminders', 'vehicles', 'selectedVehicle'));
    }

    public function create(Request $request)
    {
        $vehicles = Vehicle::orderBy('name')->get();
        $vehicle = null;
        
        if ($request->has('vehicle')) {
            $vehicle = Vehicle::find($request->vehicle);
        }
        
        return view('reminders.create', compact('vehicles', 'vehicle'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'title' => 'required|string',
            'category' => 'required|string',
            'due_date' => 'required|date',
            'due_odometer' => 'nullable|numeric',
            'advance_notice_days' => 'nullable|integer',
            'is_recurring' => 'boolean',
            'recurring_interval' => 'nullable|string',
            'estimated_cost' => 'nullable|numeric',
            'description' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        Reminder::create($validated);
        return redirect()->route('reminders.index')->with('success', 'Pengingat berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reminder $reminder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reminder $reminder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reminder $reminder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reminder $reminder)
    {
        //
    }
}
