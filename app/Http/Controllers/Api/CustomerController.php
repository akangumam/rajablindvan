<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Get list of all active customers for dropdown selection
     */
    public function index(Request $request)
    {
        $query = Customer::select('id', 'name', 'company_name', 'phone')
            ->orderBy('name', 'asc');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%");
            });
        }

        $customers = $query->get();

        return response()->json([
            'success' => true,
            'data' => $customers
        ]);
    }
}
