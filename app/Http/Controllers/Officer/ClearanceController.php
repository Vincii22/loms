<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sanction;
use App\Models\Semester;
use App\Models\Clearance;

class ClearanceController extends Controller
{
    public function index(Request $request)
{
    $searchName = $request->input('search_name');
    $searchSchoolId = $request->input('search_school_id');
    $status = $request->input('status');
    $semesterId = $request->input('semester_id');
    $schoolYear = $request->input('school_year');

    // Fetch available semesters
    $semesters = Semester::all();

    // Fetch distinct school years from sanctions
    $schoolYears = Sanction::distinct()->pluck('school_year');

    // Find all clearance records where the associated user does not exist
    $orphanClearances = Clearance::whereNotIn('user_id', User::pluck('id'))->get();

    // Delete these orphan clearance records
    foreach ($orphanClearances as $clearance) {
        $clearance->delete();
    }
    $clearances = User::whereHas('clearance')
        ->when($searchName, function ($query, $searchName) {
            return $query->where('name', 'like', "%{$searchName}%");
        })
        ->when($searchSchoolId, function ($query, $searchSchoolId) {
            return $query->where('school_id', 'like', "%{$searchSchoolId}%");
        })
        ->when($status, function ($query, $status) {
            return $query->whereHas('clearance', function ($query) use ($status) {
                $query->whereRaw('LOWER(status) = ?', [strtolower($status)]);
            });
        })
        ->when($semesterId, function ($query, $semesterId) {
            return $query->whereHas('clearance', function ($query) use ($semesterId) {
                $query->where('semester_id', $semesterId);
            });
        })
        ->when($schoolYear, function ($query, $schoolYear) {
            return $query->whereHas('clearance', function ($query) use ($schoolYear) {
                $query->where('school_year', $schoolYear);
            });
        })
        ->paginate(10);

    return view('officer.clearance.index', [
        'clearances' => $clearances,
        'semesters' => $semesters,
        'schoolYears' => $schoolYears, // Pass school years to the view
    ]);
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'semester_id' => 'nullable|exists:semesters,id', // Validate semester_id if provided
            'school_year' => 'nullable|string', // Validate school_year if provided
        ]);

        $user = User::findOrFail($id);
        $clearance = $user->clearance;

        if ($clearance) {
            $clearance->update([
                'status' => $request->status,
                'semester_id' => $request->semester_id, // Update semester_id
                'school_year' => $request->school_year, // Update school_year
            ]);
        } else {
            Clearance::create([
                'user_id' => $id,
                'status' => $request->status,
                'semester_id' => $request->semester_id, // Create with semester_id
                'school_year' => $request->school_year, // Create with school_year
            ]);
        }

        return redirect()->route('clearances.index')->with('success', 'Clearance status updated successfully!');
    }
}
