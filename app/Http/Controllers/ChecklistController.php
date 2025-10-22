<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    public function index()
    {
        $checklists = Checklist::with('vehicle')->latest('check_date')->paginate(20);
        return view('checklists.index', compact('checklists'));
    }

    public function create(Request $request)
    {
        $vehicles = Vehicle::active()->orderBy('name')->get();
        if ($request->has('vehicle_id')) {
            $vehicle = Vehicle::findOrFail($request->vehicle_id);
            return view('checklists.create', compact('vehicles', 'vehicle'));
        }
        return view('checklists.create', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'check_date' => 'required|date',
            'odometer' => 'nullable|numeric',
            'checklist_type' => 'required|string',
            'tire_pressure' => 'boolean',
            'tire_condition' => 'boolean',
            'brake_system' => 'boolean',
            'lights' => 'boolean',
            'fluids' => 'boolean',
            'battery' => 'boolean',
            'wipers' => 'boolean',
            'mirrors' => 'boolean',
            'horn' => 'boolean',
            'seat_belts' => 'boolean',
            'emergency_kit' => 'boolean',
            'documents' => 'boolean',
            'checked_by' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        Checklist::create($validated);
        return redirect()->route('checklists.index')->with('success', 'Checklist berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Checklist $checklist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Checklist $checklist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Checklist $checklist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Checklist $checklist)
    {
        //
    }
}
