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
                $query = Reminder::where('vehicle_id', $selectedVehicle->id);
                
                // Search functionality
                if ($request->has('search') && $request->search != '') {
                    $searchTerm = $request->search;
                    $query->where(function($q) use ($searchTerm) {
                        $q->where('title', 'like', '%' . $searchTerm . '%')
                          ->orWhere('category', 'like', '%' . $searchTerm . '%')
                          ->orWhere('notes', 'like', '%' . $searchTerm . '%')
                          ->orWhere('description', 'like', '%' . $searchTerm . '%');
                    });
                }
                
                $reminders = $query->latest('due_date')->paginate(20);
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
        
        return redirect()
            ->route('reminders.index', ['vehicle' => $request->vehicle_id])
            ->with('success', 'Reminder successfully added!');
    }

    public function show(Reminder $reminder)
    {
        return view('reminders.show', compact('reminder'));
    }

    public function edit(Reminder $reminder)
    {
        return view('reminders.edit', compact('reminder'));
    }

    public function update(Request $request, Reminder $reminder)
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
            'notes' => 'nullable|string',
            'is_completed' => 'boolean'
        ]);

        // Set completed_date if marked as completed
        if ($request->has('is_completed') && $request->is_completed) {
            $validated['completed_date'] = now();
        } else {
            $validated['completed_date'] = null;
        }

        $reminder->update($validated);
        
        return redirect()
            ->route('reminders.index', ['vehicle' => $reminder->vehicle_id])
            ->with('success', 'Reminder successfully updated!');
    }

    public function destroy(Reminder $reminder)
    {
        $vehicleId = $reminder->vehicle_id;
        $reminder->delete();
        
        return redirect()
            ->route('reminders.index', ['vehicle' => $vehicleId])
            ->with('success', 'Reminder successfully deleted!');
    }
}
