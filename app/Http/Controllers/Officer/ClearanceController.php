<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Clearance;
use App\Models\Organization;
use App\Models\Course;
use App\Models\Year;

class ClearanceController extends Controller
{
    public function index(Request $request)
    {
        $searchName = $request->input('search_name');
        $searchSchoolId = $request->input('search_school_id');
        $filterOrganization = $request->input('filter_organization');
        $filterCourse = $request->input('filter_course');
        $filterYear = $request->input('filter_year');
        $status = $request->input('status');

        $clearances = User::with(['clearance', 'organization', 'course', 'year'])
            ->when($searchName, function ($query, $searchName) {
                return $query->where('name', 'like', "%{$searchName}%");
            })
            ->when($searchSchoolId, function ($query, $searchSchoolId) {
                return $query->where('school_id', 'like', "%{$searchSchoolId}%");
            })
            ->when($filterOrganization, function ($query, $filterOrganization) {
                return $query->where('organization_id', $filterOrganization);
            })
            ->when($filterCourse, function ($query, $filterCourse) {
                return $query->where('course_id', $filterCourse);
            })
            ->when($filterYear, function ($query, $filterYear) {
                return $query->where('year_id', $filterYear);
            })
            ->when($status, function ($query, $status) {
                return $query->whereHas('clearance', function ($query) use ($status) {
                    $query->where('status', $status);
                });
            })
            ->paginate(10);

        $organizations = Organization::all();
        $courses = Course::all();
        $years = Year::all();

        return view('officer.clearance.index', [
            'clearances' => $clearances,
            'organizations' => $organizations,
            'courses' => $courses,
            'years' => $years
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:eligible,not eligible,cleared',
        ]);

        $user = User::findOrFail($id);
        $clearance = $user->clearance;

        if ($clearance) {
            $clearance->update(['status' => $request->status]);
        } else {
            Clearance::create([
                'user_id' => $id,
                'status' => $request->status,
            ]);
        }

        return redirect()->route('clearance.index')->with('success', 'Clearance status updated successfully!');
    }
}
