<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login form.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle the incoming authentication request and
     * perform a role‑based redirect in Breeze/Fortify style.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Validate credentials
        $request->authenticate();

        // Prevent session fixation
        $request->session()->regenerate();

        $user = $request->user();   // or auth()->user()

        // Role‑aware destination
        $target = match ($user->role) {
            'admin' => route('dashboard'),
            'user'  => route('userdashboard'),
            default => route('welcome'),   // fallback for any other role
        };

        // If the user was trying to visit a protected page, honour it;
        // otherwise send them to the role‑specific dashboard.
        return redirect()->intended($target);
    }

    /**
     * Log the user out and invalidate the session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome');
    }
}
