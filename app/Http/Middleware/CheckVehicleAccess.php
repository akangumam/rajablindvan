<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckVehicleAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = auth()->user();

        // Pengelola has access to all vehicles
        if ($user->isPengelola()) {
            return $next($request);
        }

        // For Sopir, check if they have access to the requested vehicle
        $vehicleId = $request->route('vehicle') 
                    ?? $request->input('vehicle_id')
                    ?? $request->route('fuel_fill')?->vehicle_id
                    ?? $request->route('maintenance')?->vehicle_id;

        if ($vehicleId && !$user->hasAccessToVehicle($vehicleId)) {
            abort(403, 'Anda tidak memiliki akses ke kendaraan ini.');
        }

        return $next($request);
    }
}
