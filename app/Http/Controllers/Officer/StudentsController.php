<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Organization;
use App\Models\Course;
use App\Models\Year;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class StudentsController extends Controller
{
    public function index(Request $request)
{
    // Retrieve all possible filter options from the request
    $name = $request->input('name');
    $school_id = $request->input('school_id');
    $organization = $request->input('organization');
    $course = $request->input('course');
    $sort_year = $request->input('sort_year');

    // Start building the query for users
    $query = User::query();

    // Apply filters if they are set
    if ($name) {
        $query->where('name', 'like', '%' . $name . '%');
    }

    if ($school_id) {
        $query->where('school_id', 'like', '%' . $school_id . '%');
    }

    if ($organization) {
        $query->whereHas('organization', function ($q) use ($organization) {
            $q->where('name', $organization);
        });
    }

    if ($course) {
        $query->whereHas('course', function ($q) use ($course) {
            $q->where('name', $course);
        });
    }

    // Apply sorting by year if set
    if ($sort_year) {
        $query->orderBy('year_id', $sort_year);
    }

    // Fetch users with pagination
    $users = $query->paginate(10);

    // Fetch necessary data for the filter options
    $organizations = Organization::all();
    $courses = Course::all();

    // Check if the request is AJAX and return the partial view
    if ($request->ajax()) {
        return response()->json([
            'html' => view('officer.partials.student_table', compact('users'))->render(),
            'pagination' => view('officer.partials.pagination', compact('users'))->render(),
        ]);
    }

    // If not AJAX, return the main view
    return view('officer.students.index', compact('users', 'organizations', 'courses'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $users = User::all();
        $organizations = Organization::all(); // Fetch all organizations
        $courses = Course::all();
        $years = Year::all();
        return view('officer.students.create',  compact('users', 'organizations', 'courses', 'years'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'organization_id' => ['required', 'exists:organizations,id'],
            'course_id' => ['required', 'exists:courses,id'],
            'year_id' => ['required', 'exists:years,id'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'organization_id' => $request->organization_id,
            'course_id' => $request->course_id,
            'year_id' => $request->year_id,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('students.index')
                         ->with('success', 'Student created successfully');
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

        return view('officer/students.edit', compact('user', 'organizations', 'courses', 'years'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $user = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'organization_id' => ['required', 'exists:organizations,id'],
            'course_id' => ['required', 'exists:courses,id'],
            'year_id' => ['required', 'exists:years,id'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images'); // Store image and get path
        }

        // Update user information
        $user->name = $request->name;
        $user->email = $request->email;
        $user->organization_id = $request->organization_id;
        $user->course_id = $request->course_id;
        $user->year_id = $request->year_id;
        $user->image = $imagePath;

        // Check if password is provided, if so, hash and update
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
