<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Customer::with('rentals');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                  ->orWhere('pic_name', 'like', "%{$search}%")
                  ->orWhere('contact_number', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        $customers = $query->orderBy('name')->paginate(20);

        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string',
            'pic_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
        ]);

        try {
            // Create Customer record
            $customerData = [
                'name' => $validated['company_name'], // Use company name as main name
                'company_name' => $validated['company_name'],
                'company_address' => $validated['company_address'],
                'pic_name' => $validated['pic_name'],
                'contact_number' => $validated['contact_number'],
                'phone' => $validated['contact_number'], // Use contact_number as phone for compatibility
                'is_active' => true,
            ];
            
            Customer::create($customerData);
            
            return redirect()->route('customers.index')
                ->with('success', 'Customer berhasil ditambahkan!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $customer->load(['rentals.vehicle']);
        
        $stats = [
            'total_rentals' => $customer->getTotalRentals(),
            'total_spent' => $customer->getTotalSpent(),
            'active_rentals' => $customer->getActiveRentals()->count(),
        ];

        return view('customers.show', compact('customer', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string',
            'pic_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
        ]);

        // Update customer data
        $customer->update([
            'name' => $validated['company_name'],
            'company_name' => $validated['company_name'],
            'company_address' => $validated['company_address'],
            'pic_name' => $validated['pic_name'],
            'contact_number' => $validated['contact_number'],
            'phone' => $validated['contact_number'],
        ]);

        return redirect()->route('customers.index')
            ->with('success', 'Data customer berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        // Check if customer has active rentals
        if ($customer->getActiveRentals()->count() > 0) {
            return redirect()->route('customers.index')
                ->with('error', 'Customer tidak dapat dihapus karena masih memiliki rental aktif!');
        }

        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Data customer berhasil dihapus!');
    }
}
