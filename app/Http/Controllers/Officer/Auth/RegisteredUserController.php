<?php

namespace App\Http\Controllers\Officer\Auth;

use App\Http\Controllers\Controller;
use App\Models\Officer;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Notifications\OfficerRegistrationPending; // Add this line

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $roles = Role::all(); // Fetch all roles from the database
        return view('officer.auth.register', compact('roles'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Officer::class],
            'role_id' => ['required', 'exists:roles,id'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $officer = Officer::create([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => Hash::make($request->password),
            'status' => 'pending', // Set status to pending
        ]);

        event(new Registered($officer));

        // Send notification to admin
        $officer->notify(new OfficerRegistrationPending($officer));

        // Optionally, send an email to the admin for approval

        // You might want to redirect to a page that informs the user their registration is pending approval
        return redirect()->route('registration.pending'); // Adjust this route as needed
    }
}
