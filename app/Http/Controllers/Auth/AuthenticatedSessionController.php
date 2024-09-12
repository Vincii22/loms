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
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

    // Check if the authenticated user's status is active
    $user = Auth::guard('web')->user();

    // If the user's status is active, bypass email verification
    if ($user->status === 'active' || !is_null($user->email_verified_at)) {
        $request->session()->regenerate();
        return redirect()->intended(route('dashboard', absolute: false));
    }

    // If the user's email is not verified and the status is not active
    Auth::guard('web')->logout();

    return redirect()->route('login')->withErrors([
        'email' => 'You need to verify your email before logging in.',
    ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
