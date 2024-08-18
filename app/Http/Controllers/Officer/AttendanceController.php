<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Activity;
use App\Models\Organization;
use App\Models\Course;
use App\Models\Year;
use App\Models\User;
use App\Models\Sanction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class AttendanceController extends Controller
{

    public function index(Request $request)
    {
     // Get filter inputs
     $searchName = $request->input('search_name');
     $searchSchoolId = $request->input('search_school_id');
     $filterOrganization = $request->input('filter_organization');
     $filterCourse = $request->input('filter_course');
     $filterYear = $request->input('filter_year');
     $filterActivity = $request->input('filter_activity');

     $query = Attendance::with('user', 'activity')
         ->when($searchName, function ($query, $searchName) {
             return $query->whereHas('user', function ($query) use ($searchName) {
                 $query->where('name', 'like', '%' . $searchName . '%');
             });
         })
         ->when($searchSchoolId, function ($query, $searchSchoolId) {
             return $query->whereHas('user', function ($query) use ($searchSchoolId) {
                 $query->where('school_id', 'like', '%' . $searchSchoolId . '%');
             });
         })
         ->when($filterOrganization, function ($query, $filterOrganization) {
             return $query->whereHas('user.organization', function ($query) use ($filterOrganization) {
                 $query->where('id', $filterOrganization);
             });
         })
         ->when($filterCourse, function ($query, $filterCourse) {
             return $query->whereHas('user.course', function ($query) use ($filterCourse) {
                 $query->where('id', $filterCourse);
             });
         })
         ->when($filterYear, function ($query, $filterYear) {
             return $query->whereHas('user.year', function ($query) use ($filterYear) {
                 $query->where('id', $filterYear);
             });
         })
         ->when($filterActivity, function ($query, $filterActivity) {
             return $query->where('activity_id', $filterActivity);
         });

     // Paginate the results
     $attendances = $query->paginate(10);

     // Fetch all organizations, courses, years, and activities for filtering options
     $organizations = Organization::all();
     $courses = Course::all();
     $years = Year::all();
     $activities = Activity::all();

     return view('officer.attendance.index', compact('attendances', 'organizations', 'courses', 'years', 'activities'));
     }




    public function create()
    {
        $students = User::all();
        $activities = Activity::all();
        return view('officer.attendance.create', compact('students', 'activities'));
  }

        public function store(Request $request)
        {
            $request->validate([
                'student_id' => 'required|exists:users,id', // Check if the student exists
                'activity_id' => 'required|exists:activities,id',
                'time_in' => 'nullable|date_format:H:i',
                'time_out' => 'nullable|date_format:H:i',
            ]);

            // Determine the status based on time_in and time_out
            if ($request->time_in && $request->time_out) {
                $status = 'Present';
            } else {
                $status = 'Absent';
            }

            // Create the attendance record
            Attendance::create([
                'student_id' => $request->student_id,
                'activity_id' => $request->activity_id,
                'time_in' => $request->time_in,
                'time_out' => $request->time_out,
                'status' => $status,
            ]);

            // Redirect with a success message
            return redirect()->route('attendance.index')->with('success', 'Attendance record added successfully.');
        }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        $students = User::all();
        $activities = Activity::all();
        return view('officer.attendance.edit', compact('attendance', 'students', 'activities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
       // Validate the request data
    $request->validate([
        'student_id' => 'required|exists:users,id', // Check if the student exists
        'activity_id' => 'required|exists:activities,id',
        'time_in' => 'nullable|date_format:H:i',
        'time_out' => 'nullable|date_format:H:i',
    ]);

    $attendance = Attendance::findOrFail($id);

    // Determine the status based on time_in and time_out
    if ($request->has('time_in') && $request->has('time_out')) {
        $status = 'Present';
    } else {
        $status = 'Absent';
    }

    // Update the attendance record
    $attendance->update([
        'student_id' => $request->student_id,
        'activity_id' => $request->activity_id,
        'time_in' => $request->time_in,
        'time_out' => $request->time_out,
        'status' => $status,
    ]);

    // Redirect with a success message
    return redirect()->route('attendance.index')->with('success', 'Attendance record updated successfully.');
}


    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()->route('attendance.index')->with('success', 'Attendance deleted successfully.');
    }




    public function markAttendance(Request $request)
    {
        // Mark attendance logic here...

        // After marking attendance, check for absences and add sanctions
        $this->checkAndSanctionAbsentees();
    }

    protected function checkAndSanctionAbsentees()
    {
        $absentStudents = User::whereDoesntHave('attendances', function ($query) {
            // Assuming attendances have a date column and a present/absent flag
            $query->whereDate('date', now()->toDateString())->where('status', 'absent');
        })->get();

        foreach ($absentStudents as $student) {
            // Check if the student is already sanctioned for this absence
            $existingSanction = Sanction::where('student_id', $student->id)
                ->where('type', 'attendance')
                ->where('resolved', false)
                ->first();

            if (!$existingSanction) {
                Sanction::create([
                    'student_id' => $student->id,
                    'type' => 'attendance',
                    'description' => 'Absent from class',
                    'fine_amount' => 0, // Set fine amount if applicable
                    'required_action' => 'Attend make-up classes', // Set required action
                    'resolved' => false,
                ]);
            }
        }
    }
}

