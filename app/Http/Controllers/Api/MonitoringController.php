<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MonitoringController extends Controller
{
    /**
     * Get vehicles with overdue STNK
     */
    public function stnkOverdue(Request $request)
    {
        $user = $request->user();
        $locationId = $user->isAdmin() ? null : $user->location_id;

        $query = Vehicle::with(['location:id,name'])
            ->whereDate('stnk_expiry_date', '<', Carbon::now())
            ->orderBy('stnk_expiry_date', 'asc');

        if ($locationId) {
            $query->where('location_id', $locationId);
        }

        $vehicles = $query->get()->map(function ($vehicle) {
            $daysOverdue = Carbon::now()->diffInDays($vehicle->stnk_expiry_date, false);

            return [
                'id' => $vehicle->id,
                'license_plate' => $vehicle->license_plate,
                'brand' => $vehicle->brand,
                'model' => $vehicle->model,
                'year' => $vehicle->year,
                'status' => $vehicle->status,
                'location_name' => $vehicle->location ? $vehicle->location->name : null,
                'stnk_expiry_date' => $vehicle->stnk_expiry_date?->format('Y-m-d'),
                'days_overdue' => abs($daysOverdue),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $vehicles,
            'message' => 'STNK overdue vehicles retrieved successfully',
        ], 200);
    }

    /**
     * Get vehicles with overdue KIR
     */
    public function kirOverdue(Request $request)
    {
        $user = $request->user();
        $locationId = $user->isAdmin() ? null : $user->location_id;

        $query = Vehicle::with(['location:id,name'])
            ->whereDate('kir_expiry_date', '<', Carbon::now())
            ->orderBy('kir_expiry_date', 'asc');

        if ($locationId) {
            $query->where('location_id', $locationId);
        }

        $vehicles = $query->get()->map(function ($vehicle) {
            $daysOverdue = Carbon::now()->diffInDays($vehicle->kir_expiry_date, false);

            return [
                'id' => $vehicle->id,
                'license_plate' => $vehicle->license_plate,
                'brand' => $vehicle->brand,
                'model' => $vehicle->model,
                'year' => $vehicle->year,
                'status' => $vehicle->status,
                'location_name' => $vehicle->location ? $vehicle->location->name : null,
                'kir_expiry_date' => $vehicle->kir_expiry_date?->format('Y-m-d'),
                'days_overdue' => abs($daysOverdue),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $vehicles,
            'message' => 'KIR overdue vehicles retrieved successfully',
        ], 200);
    }

    /**
     * Get vehicles with overdue GPS
     */
    public function gpsOverdue(Request $request)
    {
        $user = $request->user();
        $locationId = $user->isAdmin() ? null : $user->location_id;

        $query = Vehicle::with(['location:id,name'])
            ->whereDate('gps_expiry_date', '<', Carbon::now())
            ->orderBy('gps_expiry_date', 'asc');

        if ($locationId) {
            $query->where('location_id', $locationId);
        }

        $vehicles = $query->get()->map(function ($vehicle) {
            $daysOverdue = Carbon::now()->diffInDays($vehicle->gps_expiry_date, false);

            return [
                'id' => $vehicle->id,
                'license_plate' => $vehicle->license_plate,
                'brand' => $vehicle->brand,
                'model' => $vehicle->model,
                'year' => $vehicle->year,
                'status' => $vehicle->status,
                'location_name' => $vehicle->location ? $vehicle->location->name : null,
                'gps_expiry_date' => $vehicle->gps_expiry_date?->format('Y-m-d'),
                'days_overdue' => abs($daysOverdue),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $vehicles,
            'message' => 'GPS overdue vehicles retrieved successfully',
        ], 200);
    }
}
