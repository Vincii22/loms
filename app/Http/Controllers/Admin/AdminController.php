<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        // Fetch all admins
        $admins = Admin::all();
        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        // Show the create form
        return view('admin.admins.create');
    }

    public function store(Request $request)
    {
       // Validate incoming request
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:admins',
        'password' => 'required|string|min:8|confirmed',
        'status' => 'required|in:active,inactive',  // Validate status
    ]);

    // Create a new admin user with status
    Admin::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'status' => $validated['status'],  // Save status
    ]);

    // Redirect to index page
    return redirect()->route('admins.index')->with('success', 'Admin created successfully.');
    }

    public function show($id)
    {
        // Not necessary for this CRUD (can be omitted if not needed)
    }

    public function edit($id)
    {
        // Find the admin by id
        $admin = Admin::findOrFail($id);
        return view('admin.admins.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
      // Validate the request
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:admins,email,' . $id,
        'password' => 'nullable|string|min:8|confirmed',
        'status' => 'required|in:active,inactive',  // Validate status
    ]);

    // Find the admin by id
    $admin = Admin::findOrFail($id);

    // Update admin details
    $admin->update([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => $validated['password'] ? Hash::make($validated['password']) : $admin->password,
        'status' => $validated['status'],  // Update status
    ]);

    // Redirect to index with success message
    return redirect()->route('admins.index')->with('success', 'Admin updated successfully.');
    }

    public function destroy($id)
    {
        // Delete the admin
        Admin::destroy($id);
        return redirect()->route('admins.index')->with('success', 'Admin deleted successfully.');
    }
}
