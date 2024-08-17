<?php

namespace App\Http\Controllers\Officer;

use App\Models\Fees;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fees = Fees::all();
        return view('officer.fees.index', compact('fees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('officer.fees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'default_amount' => 'required|numeric|min:0',
        ]);

        Fees::create([
            'name' => $request->input('name'),
            'default_amount' => $request->input('default_amount'),
        ]);

        return redirect()->route('fees.index')->with('success', 'Fee created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Fees $fee)
    {
        $finances = $fee->finances()->with('user')->get();
        $fees = Fees::all(); // Fetch all fees for the filter dropdown

        return view('officer.finances.index', compact('fee', 'finances', 'fees'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fees $fee)
    {
        return view('officer.fees.edit', compact('fee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fees $fees)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'default_amount' => 'required|numeric|min:0',
        ]);

        $fees->update([
            'name' => $request->input('name'),
            'default_amount' => $request->input('default_amount'),
        ]);

        return redirect()->route('fees.index')->with('success', 'Fee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fees $fees)
    {
        $fees->delete();
        return redirect()->route('fees.index')->with('success', 'Fee deleted successfully.');
    }
}
