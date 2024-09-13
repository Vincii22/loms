<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Organization;
use App\Models\Course;
use App\Models\Year;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with(['organization', 'course', 'year'])->get();
        $organizations = Organization::all();
        $courses = Course::all();
        $years = Year::all();

        // foreach ($users as $user) {
        //     dd($user->organization, $user->course, $user->year);
        // }

        return view('admin.students.index', compact('users', 'organizations', 'courses', 'years'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $users = User::all();
        $organizations = Organization::all();
        $courses = Course::all();
        $years = Year::all();
        return view('admin.students.create',  compact('users', 'organizations', 'courses', 'years'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'school_id' => ['required', 'string', 'max:8'],
            'organization_id' => ['required', 'exists:organizations,id'],
            'course_id' => ['required', 'exists:courses,id'],
            'year_id' => ['required', 'exists:years,id'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $imagePath = $request->file('image') ? $request->file('image')->store('images', 'public') : null;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'school_id' => $request->school_id,
            'organization_id' => $request->organization_id,
            'course_id' => $request->course_id,
            'year_id' => $request->year_id,
            'image' => $imagePath,
            'status' => 'active', // Default status set to active
            'email_verified_at' => now(), // Bypass email verification
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('astudents.index')->with('success', 'Student created successfully with active status and no email verification.');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Auth::user(); // Ensure this isn't null
        return view('navigation', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $user = User::findOrFail($id);
        $organizations = Organization::all();
        $courses = Course::all();
        $years = Year::all();

        return view('admin.astudents.edit', compact('user', 'organizations', 'courses', 'years'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'school_id' => ['required', 'string', 'max:8'],
            'organization_id' => ['required', 'exists:organizations,id'],
            'course_id' => ['required', 'exists:courses,id'],
            'year_id' => ['required', 'exists:years,id'],
            'status' => ['required', 'in:active,inactive'], // Validate the status
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $imagePath = $request->hasFile('image') ? $request->file('image')->store('public/images') : $user->image;

        // Update user information
        $user->name = $request->name;
        $user->email = $request->email;
        $user->school_id = $request->school_id;
        $user->organization_id = $request->organization_id;
        $user->course_id = $request->course_id;
        $user->year_id = $request->year_id;
        $user->image = $imagePath;
        $user->status = $request->status; // Update the status

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('astudents.index')->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('astudents.index')->with('success', 'Student deleted successfully.');
    }
}
