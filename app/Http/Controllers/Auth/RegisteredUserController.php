<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Organization;
use App\Models\Course;
use App\Models\Year;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Notifications\UserRegistrationPending; // Add this line

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $organizations = Organization::all(); // Fetch all organizations
        $courses = Course::all();
        $years = Year::all();
        return view('auth.register', compact('organizations', 'courses', 'years'));
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
                'unique:' . User::class,
                function ($attribute, $value, $fail) {
                    // Check if the email ends with @dwc-legazpi.edu
                    if (!str_ends_with($value, '@dwc-legazpi.edu')) {
                        $fail('The :attribute must be a valid @dwc-legazpi.edu email address.');
                    }
                },
            ],
            'school_id' => ['required', 'string', 'max:8'],
            'organization_id' => ['required', 'exists:organizations,id'],
            'course_id' => ['required', 'exists:courses,id'],
            'year_id' => ['required', 'exists:years,id'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'school_id' => $request->school_id,
            'organization_id' => $request->organization_id,
            'course_id' => $request->course_id,
            'year_id' => $request->year_id,
            'password' => Hash::make($request->password),
            'status' => 'pending', // Set status to pending
        ]);

        event(new Registered($user));

        // Send notification to admin
        $user->notify(new UserRegistrationPending($user));

        // Optionally, send an email to the admin for approval

        // You might want to redirect to a page that informs the user their registration is pending approval
        return redirect()->route('registration.pending'); // Adjust this route as needed
    }
}
