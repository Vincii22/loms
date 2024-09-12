<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Officer;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
class OfficerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $officers = Officer::with(['role'])->get();
        $roles = Role::all();

        return view('admin.officers.index', compact('officers', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $officers = Officer::with(['role'])->get();
        $roles = Role::whereDoesntHave('officers', function ($query) {
            $query->where('status', 'active');
        })->get();
        return view('admin.officers.create', compact('officers', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:officers,email',
        'role' => 'required|string|in:president,vice-president,secretary', // Add all roles
    ]);

    // Check if the role is already taken
    $existingOfficer = Officer::where('role', $validated['role'])->first();

    if ($existingOfficer) {
        return redirect()->back()->withErrors(['role' => 'The selected role is already taken.']);
    }

    // Create the new officer if the role is available
    Officer::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'role' => $validated['role'],
        // other fields
    ]);

    return redirect()->route('admin.officers.index')->with('success', 'Officer created successfully.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $officer = Auth::officer(); // Ensure this isn't null
        return view('navigation', compact('officer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $officer = Officer::findOrFail($id);
        $roles = Role::all();

        return view('admin.officers.edit', compact('officer', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:officers,email,' . $id],
            'role_id' => ['required', 'exists:roles,id'],
            'image' => ['nullable', 'image', 'max:2048'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $officer = Officer::findOrFail($id);

        $role = Role::find($request->role_id);

        if ($role && !$role->isAvailable()) {
            return back()->withErrors(['role_id' => 'The selected role is already taken.']);
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('officer_images', 'public');
            $officer->image = $imagePath;
        }

        $officer->name = $request->name;
        $officer->email = $request->email;
        $officer->role_id = $request->role_id;

        if ($request->filled('password')) {
            $officer->password = Hash::make($request->password);
        }

        $officer->status = $request->status;

        $officer->save();

        return redirect()->route('officers.index')
                         ->with('success', 'Officer updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $officer = Officer::findOrFail($id);
        $officer->delete();

        return redirect()->route('officers.index')
                         ->with('success', 'Officer deleted successfully');
    }
}
