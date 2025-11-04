<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LocationFilter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Store selected location in session if provided in URL
        if ($request->has('location_id')) {
            $locationId = $request->get('location_id');
            
            // If empty string or null, clear the session (Semua Lokasi)
            if ($locationId === '' || $locationId === null) {
                session()->forget('selected_location_id');
            } else {
                // Store the selected location
                session(['selected_location_id' => $locationId]);
            }
        }

        return $next($request);
    }

    /**
     * Get the location ID for filtering queries
     * Returns null for super admin when "Semua Lokasi" is selected
     * Returns user's location_id for staff
     */
    public static function getLocationId(): ?int
    {
        $user = auth()->user();
        
        // Super admin can select location
        if ($user && $user->isSuperAdmin()) {
            // Get location from session, return null if not set (Semua Lokasi)
            $locationId = session('selected_location_id', null);
            
            // Convert empty string to null
            if ($locationId === '' || $locationId === null) {
                return null;
            }
            
            return (int) $locationId;
        }
        
        // Staff can only see their own location
        return $user ? $user->location_id : null;
    }

    /**
     * Check if user can access all locations
     */
    public static function canAccessAllLocations(): bool
    {
        $user = auth()->user();
        return $user && $user->isSuperAdmin();
    }
}
