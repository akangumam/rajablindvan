<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::with('rentals')
            ->orderBy('name')
            ->paginate(20);

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
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'user_type' => 'required|string|in:Pengelola,Sopir',
            'id_number' => 'nullable|string|max:20',
            'license_category' => 'nullable|string|max:10',
            'license_expiry' => 'nullable|date|after:today',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        // Combine first_name and last_name into name
        $fullName = trim($validated['first_name'] . ' ' . ($validated['last_name'] ?? ''));
        
        try {
            // Create User account
            $user = \App\Models\User::create([
                'name' => $fullName,
                'email' => $validated['email'],
                'password' => \Hash::make('password'), // Default password
                'user_type' => $validated['user_type'],
                'phone' => $validated['phone'],
            ]);
            
            // Create Customer record (for backward compatibility with rental system)
            $customerData = [
                'name' => $fullName,
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'] ?? null,
                'email' => $validated['email'],
                'user_type' => $validated['user_type'],
                'id_number' => $validated['id_number'] ?? null,
                'license_category' => $validated['license_category'] ?? null,
                'license_expiry' => $validated['license_expiry'] ?? null,
                'phone' => $validated['phone'],
                'address' => $validated['address'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'is_active' => true,
            ];
            
            Customer::create($customerData);
            
            $message = "User {$fullName} berhasil ditambahkan sebagai {$validated['user_type']}! Default password: 'password'";
            
            return redirect()->route('customers.index')
                ->with('success', $message);
                
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:customers,email,' . $customer->id,
            'id_number' => 'nullable|string|max:20',
            'license_category' => 'nullable|string|max:10',
            'license_expiry' => 'nullable|date',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        // Update name from first_name and last_name
        $validated['name'] = trim($validated['first_name'] . ' ' . ($validated['last_name'] ?? ''));

        $customer->update($validated);

        // Also update User if exists
        $user = \App\Models\User::where('email', $customer->email)->first();
        if ($user) {
            $user->update([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
            ]);
        }

        return redirect()->route('customers.index')
            ->with('success', 'Data pengguna berhasil diperbarui!');
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
