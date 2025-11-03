<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'title' => ['nullable', 'string', 'max:255'],
                'user_type' => ['required', 'in:admin,manager,driver'],
                'status' => ['required', 'in:active,inactive'],
            ]);

            // Combine first and last name for the name field
            $validated['name'] = trim($validated['first_name'] . ' ' . $validated['last_name']);
            
            // Generate default password: 'password' (can be changed later by admin)
            $validated['password'] = Hash::make('password');
            
            // Set default is_active based on status
            $validated['is_active'] = ($validated['status'] ?? 'active') == 'active';

            $user = User::create($validated);

            return redirect()->route('users.index')
                ->with('success', 'User "' . $user->name . '" has been created successfully with default password: "password".');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create user. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // If first_name and last_name are empty, split from name field
        if (empty($user->first_name) && empty($user->last_name) && !empty($user->name)) {
            $nameParts = explode(' ', $user->name, 2);
            $user->first_name = $nameParts[0] ?? '';
            $user->last_name = $nameParts[1] ?? '';
        }
        
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
                'title' => ['nullable', 'string', 'max:255'],
                'user_type' => ['required', 'in:admin,manager,driver'],
                'status' => ['required', 'in:active,inactive'],
            ]);

            // Combine first and last name for the name field
            $validated['name'] = trim($validated['first_name'] . ' ' . $validated['last_name']);
            
            // Set is_active based on status
            $validated['is_active'] = ($validated['status'] ?? 'active') == 'active';

            $user->update($validated);

            return redirect()->route('users.index')
                ->with('success', 'User "' . $user->name . '" has been updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update user. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            // Prevent deleting current user
            if ($user->id === auth()->id()) {
                return redirect()->route('users.index')
                    ->with('error', 'You cannot delete your own account.');
            }

            // Prevent deleting Administrator (protection)
            if ($user->role === 'super_admin') {
                return redirect()->route('users.index')
                    ->with('error', 'Administrator account cannot be deleted for security reasons.');
            }

            $userName = $user->name;
            $user->delete();

            return redirect()->route('users.index')
                ->with('success', 'User "' . $userName . '" has been deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete user. Please try again.');
        }
    }

    /**
     * Show reset password form for specific user
     */
    public function showResetPasswordForm(User $user)
    {
        // Only Administrator can reset password
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        return view('users.reset-password', compact('user'));
    }

    /**
     * Reset password for specific user (Administrator feature)
     */
    public function resetPassword(Request $request, User $user)
    {
        // Only Administrator can reset password
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        // TODO: Send email notification to user (when email is configured)
        // Mail::to($user->email)->send(new PasswordResetByAdmin($user));

        return redirect()->route('users.show', $user)
            ->with('success', 'Password for user "' . $user->name . '" has been reset successfully.');
    }
}
