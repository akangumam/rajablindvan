<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class LoginController extends Controller
{
    use ThrottlesLogins;

    protected int $maxAttempts = 5;      // max percobaan gagal
    protected int $decayMinutes = 15;    // durasi lockout (menit)

    /**
     * Get the login username to be used by the controller.
     */
    public function username()
    {
        return 'email';
    }
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        // Check if user exists — gunakan Auth::attempt langsung agar tidak bocor info email
        $user = User::where('email', $request->email)->first();

        // Check if user is active (boleh diinfokan agar user bisa hubungi admin)
        if ($user && !$user->is_active) {
            return back()->withErrors([
                'email' => 'Your account has been deactivated. Please contact administrator.',
            ])->withInput($request->only('email'));
        }

        // Attempt login — pesan generik agar tidak bocorkan apakah email terdaftar atau tidak
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $this->clearLoginAttempts($request);

            return redirect()->intended(route('dashboard'))
                ->with('success', 'Welcome back, ' . $user->name . '!');
        }

        $this->incrementLoginAttempts($request);

        return back()->withErrors([
            'email' => 'The provided credentials are incorrect.',
        ])->withInput($request->only('email'));
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'You have been logged out successfully.');
    }
}
