<?php

namespace App\Http\Controllers\Officer;

use App\Models\Fees;
use App\Models\Semester;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fees = Fees::with('semester')->get();
        return view('officer.fees.index', compact('fees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $semesters = Semester::all();
        return view('officer.fees.create', compact('semesters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'default_amount' => 'required|numeric|min:0',
            'semester_id' => 'nullable|exists:semesters,id',
            'school_year' => 'nullable|string|max:255',
        ]);

        Fees::create($request->all());

        return redirect()->route('fees.index')->with('success', 'Fee created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fees $fee)
    {
        $semesters = Semester::all();
        return view('officer.fees.edit', compact('fee', 'semesters'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fees $fee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'default_amount' => 'required|numeric|min:0',
            'semester_id' => 'nullable|exists:semesters,id',
            'school_year' => 'nullable|string|max:255',
        ]);

        $fee->update($request->all());

        return redirect()->route('fees.index')->with('success', 'Fee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fees $fee)
    {
        $fee->delete();
        return redirect()->route('fees.index')->with('success', 'Fee deleted successfully.');
    }
}
