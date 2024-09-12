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
        $roles = Role::all();
        return view('admin.officers.create', compact('officers', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . Officer::class],
        'role_id' => ['required', 'exists:roles,id'],
        'image' => ['nullable', 'image', 'max:2048'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $imagePath = $request->file('image') ? $request->file('image')->store('officer_images', 'public') : null;

    $officer = Officer::create([
        'name' => $request->name,
        'email' => $request->email,
        'role_id' => $request->role_id,
        'image' => $imagePath,
        'password' => Hash::make($request->password),
        'status' => 'active', // Automatically set status to active
        'email_verified_at' => now(), // Bypass email verification by marking as verified
    ]);

    return redirect()->route('officers.index')
                     ->with('success', 'Officer created successfully with active status and without email verification.');
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
            'status' => ['required', 'in:active,inactive'], // Validate the status input
        ]);

        $officer = Officer::findOrFail($id);

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

        $officer->status = $request->status; // Update the status

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
