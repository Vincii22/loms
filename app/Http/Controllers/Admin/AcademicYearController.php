<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Semester;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Officer;
class AcademicYearController extends Controller
{
    public function index()
    {
        $academicYears = AcademicYear::with('semester')->get();
        return view('admin.academic_years.index', compact('academicYears'));
    }

    public function create()
    {
        $semesters = Semester::all();
        return view('admin.academic_years.create', compact('semesters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'school_year' => 'required|string',
            'semester_id' => 'required|exists:semesters,id',
        ]);

        if ($request->has('is_default') && $request->is_default) {
            AcademicYear::where('is_default', true)->update(['is_default' => false]);


        }

        AcademicYear::create($request->all());

        return redirect()->route('academic_years.index')->with('success', 'Academic Year created successfully.');
    }

    public function edit(AcademicYear $academicYear)
    {
        $semesters = Semester::all();
        return view('admin.academic_years.edit', compact('academicYear', 'semesters'));
    }

    public function update(Request $request, AcademicYear $academicYear)
    {
        $validatedData = $request->validate([
            'school_year' => 'required|string|max:255',
            'semester_id' => 'required|exists:semesters,id',
            'is_default' => 'nullable|boolean',


        ]);

        // Ensure only one academic year can be the default
        if ($request->has('is_default') && $request->is_default) {
            AcademicYear::where('is_default', true)->update(['is_default' => false]);

            $this->deactivateAccounts();
        }

        // Convert checkbox value to 1 (true) if checked, 0 (false) if not
        $validatedData['is_default'] = $request->has('is_default') ? 1 : 0;

        $academicYear->update($validatedData);

        return redirect()->route('academic_years.index')->with('success', 'Academic Year updated successfully.');
    }

    public function destroy(AcademicYear $academicYear)
    {
        $academicYear->delete();
        return redirect()->route('academic_years.index')->with('success', 'Academic Year deleted successfully.');
    }

    private function deactivateAccounts()
{
    // Set all users to inactive
    User::where('status', 'active')->update(['status' => 'inactive']);

    // Set all officers to inactive
    Officer::where('status', 'active')->update(['status' => 'inactive']);
}
}
