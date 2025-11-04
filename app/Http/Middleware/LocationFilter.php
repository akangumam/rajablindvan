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
        // Store selected location in session if provided
        if ($request->has('location_id')) {
            session(['selected_location_id' => $request->location_id]);
        }

        return $next($request);
    }

    /**
     * Get the location ID for filtering queries
     * Returns null for super admin (to show all)
     * Returns user's location_id for staff
     */
    public static function getLocationId(): ?int
    {
        $user = auth()->user();
        
        // Super admin can select location
        if ($user && $user->isSuperAdmin()) {
            // Check if location is selected in session
            return session('selected_location_id', null);
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
