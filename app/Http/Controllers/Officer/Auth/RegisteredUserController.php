<?php

namespace App\Http\Controllers\Officer\Auth;

use App\Http\Controllers\Controller;
use App\Models\Officer;
use App\Models\Role;
use App\Models\Organization;
use App\Models\Course;
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
        $officers = Officer::with(['role'])->get();
         // Fetch available roles
         $roles = Role::whereDoesntHave('officers', function ($query) {
            $query->where('status', 'active');
        })->get();
        return view('officer.auth.register', compact('roles', 'officers'));
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
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:officers,email',
                function ($attribute, $value, $fail) {
                    // Check if the email ends with @dwc-legazpi.edu
                    if (!str_ends_with($value, '@dwc-legazpi.edu')) {
                        $fail('The :attribute must be a valid @dwc-legazpi.edu email address.');
                    }
                },
            ],
            'role_id' => ['required', 'exists:roles,id'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $role = Role::find($request->role_id);

        // Check if the role is available
        if ($role && !$role->isAvailable()) {
            return back()->withErrors(['role_id' => 'The selected role is already taken.']);
        }

        Officer::create([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => Hash::make($request->password),
            'status' => 'pending', // Set status to pending
        ]);

        return redirect()->route('registration.pending');
    }

}

