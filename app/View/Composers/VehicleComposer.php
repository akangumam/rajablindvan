<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\Vehicle;
use App\Http\Middleware\LocationFilter;

class VehicleComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $user = auth()->user();
        $locationId = LocationFilter::getLocationId();
        
        // Build query based on user permissions
        $query = Vehicle::where('is_active', true)
                        ->with('location')
                        ->orderBy('name', 'asc');
        
        // Apply location filter
        if ($locationId) {
            $query->where('location_id', $locationId);
        }
        
        $allVehicles = $query->get();
        
        // Get current vehicle ID from request or session
        $currentVehicleId = request()->get('vehicle_id') ?? session('selected_vehicle_id');
        
        // If no vehicle selected, select the first one
        if (!$currentVehicleId && $allVehicles->count() > 0) {
            $currentVehicleId = $allVehicles->first()->id;
        }

        // Validate that currentVehicleId exists in the accessible vehicles list
        // This prevents 404s if the session holds an ID that is no longer valid or accessible
        if ($currentVehicleId && $allVehicles->count() > 0 && !$allVehicles->contains('id', $currentVehicleId)) {
            $currentVehicleId = $allVehicles->first()->id;
            // Update session to reflect the fallback
            session(['selected_vehicle_id' => $currentVehicleId]);
        }
        
        // Get current vehicle object
        $currentVehicle = $allVehicles->firstWhere('id', $currentVehicleId);
        
        $view->with(compact('allVehicles', 'currentVehicle', 'currentVehicleId'));
    }
}
