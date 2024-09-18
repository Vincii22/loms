<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Semester;
use App\Models\Clearance;

class ClearanceController extends Controller
{
    public function index(Request $request)
{
    $status = $request->input('status');
    $semesterId = $request->input('semester_id');
    $schoolYear = $request->input('filter_school_year');
    // Fetch available semesters from unique semester IDs in clearances
    $semesters = Semester::whereIn('id', Clearance::pluck('semester_id')->unique())->get();

    // Fetch distinct school years from clearances
    $schoolYears = Clearance::distinct()->pluck('school_year');

      // Fetch filtered and paginated clearance records
      $clearances = Clearance::when($status, function ($query, $status) {
        return $query->whereRaw('LOWER(status) = ?', [strtolower($status)]);
    })
    ->when($semesterId, function ($query, $semesterId) {
        return $query->where('semester_id', $semesterId);
    })
    ->when($schoolYear, function ($query, $schoolYear) {
        return $query->where('school_year', $schoolYear);
    })
    ->paginate(10); // Adjust the number per page as needed

    return view('officer.clearance.index', [
        'clearances' => $clearances,
        'semesters' => $semesters,
        'schoolYears' => $schoolYears,
    ]);
}



    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:not cleared,cleared',
            'semester_id' => 'required|exists:semesters,id',
            'school_year' => 'required|string',
        ]);

        $user = User::findOrFail($id);

        // Find or create clearance record
        $clearance = $user->clearances()->where([
            'semester_id' => $request->input('semester_id'),
            'school_year' => $request->input('school_year'),
        ])->first();

        if ($clearance) {
            $clearance->update(['status' => $request->status]);
        } else {
            Clearance::create([
                'user_id' => $id,
                'status' => $request->status,
                'semester_id' => $request->input('semester_id'),
                'school_year' => $request->input('school_year'),
            ]);
        }

        return redirect()->route('clearances.index')->with('success', 'Clearance status updated successfully!');
    }
}
