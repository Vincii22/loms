<?php

namespace App\Http\Controllers\Officer\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\OfficerLoginRequest;
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
        return view('officer.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(OfficerLoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        // Check if the authenticated officer's status is active
        $officer = Auth::guard('officer')->user();

        // If the officer's status is active, bypass email verification
        if ($officer->status === 'active' || !is_null($officer->email_verified_at)) {
            $request->session()->regenerate();
            return redirect()->intended(route('officer.dashboard', absolute: false));
        }

        // If the officer's email is not verified and the status is not active
        Auth::guard('officer')->logout();

        return redirect()->route('officer.login')->withErrors([
            'email' => 'You need to verify your email before logging in.',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('officer')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
