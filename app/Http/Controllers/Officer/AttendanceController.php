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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $searchName = $request->input('search_name');
        $searchSchoolId = $request->input('search_school_id');
        $filterActivity = $request->input('filter_activity');

        $attendancesQuery = Attendance::with('user', 'activity')
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
            ->when($filterActivity, function ($query, $filterActivity) {
                return $query->where('activity_id', $filterActivity);
            });

        $attendances = $attendancesQuery->paginate(10);

        $organizations = Organization::all();
        $courses = Course::all();
        $years = Year::all();
        $activities = Activity::all();

        return view('officer.attendance.index', compact('attendances', 'organizations', 'courses', 'years', 'activities', 'filterActivity'));
    }

    public function edit($id)
{
    // Fetch the attendance record by ID
    $attendance = Attendance::findOrFail($id);

    // Fetch other necessary data for the form
    $students = User::all(); // Adjust according to your needs
    $activities = Activity::all();

    return view('officer.attendance.edit', compact('attendance', 'students', 'activities'));
}

public function update(Request $request, $id)
{
    // Validate the request
    $request->validate([
        'student_id' => 'required|exists:users,id',
        'activity_id' => 'required|exists:activities,id',
        'edit_type' => 'required|in:time_in,time_out',
        'time_value' => 'required|date_format:H:i',
    ]);

    // Find the attendance record by ID
    $attendance = Attendance::findOrFail($id);

    // Update attendance record based on the type
    if ($request->edit_type === 'time_in') {
        $attendance->time_in = $request->time_value;
    } elseif ($request->edit_type === 'time_out') {
        $attendance->time_out = $request->time_value;
    }

    // Update status
    $attendance->status = ($attendance->time_in && $attendance->time_out) ? 'Present' : 'Absent';
    $attendance->save();

    return redirect()->route('attendance.index', ['filter_activity' => $attendance->activity_id])
                     ->with('success', 'Attendance updated successfully.');
}
    public function show(Request $request)
{
    $scannedId = $request->input('scanned_id');

    $user = User::where('school_id', $scannedId)
        ->with('course', 'year', 'organization') // Eager load related models
        ->first();

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    return response()->json([
        'user' => [
            'name' => $user->name,
            'image' => $user->image,
            'course' => $user->course->name,
            'year' => $user->year->name,
            'organization' => $user->organization->name,
            'school_id' => $user->school_id,
        ]
    ]);
}

public function markAttendanceByBarcode(Request $request)
{
    $scannedId = $request->input('scanned_id');
    $filterActivity = $request->input('filter_activity');
    $timeType = $request->input('time_type');

    try {
        if (!in_array($timeType, ['time_in', 'time_out'])) {
            return response()->json(['message' => 'Invalid time type'], 400);
        }

        $user = User::where('school_id', $scannedId)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $currentTime = Carbon::now('Asia/Manila')->format('H:i'); // Set the timezone here

        return response()->json([
            'user' => [
                'name' => $user->name,
                'image' => $user->image,
                'course' => $user->course->name,
                'year' => $user->year->name,
                'organization' => $user->organization->name,
                'school_id' => $user->school_id,
                'current_time' => $currentTime
            ]
        ]);

    } catch (\Exception $e) {
        return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
    }
}


public function confirmAttendance(Request $request)
{
    $scannedId = $request->input('scanned_id');
    $filterActivity = $request->input('filter_activity');
    $timeType = $request->input('time_type');

    $user = User::where('school_id', $scannedId)->first();

    if (!$user) {
        return redirect()->back()->with('error', 'User not found');
    }

    $currentTime = Carbon::now('Asia/Manila')->format('H:i');

    DB::transaction(function () use ($user, $filterActivity, $timeType, $currentTime) {
        $attendance = Attendance::where('student_id', $user->id)
            ->where('activity_id', $filterActivity)
            ->whereDate('created_at', Carbon::today())
            ->first();

        if ($attendance) {
            // Update attendance logic
            if ($timeType === 'time_in') {
                $attendance->time_in = $currentTime;
            } elseif ($timeType === 'time_out') {
                $attendance->time_out = $currentTime;
            }

            $attendance->status = ($attendance->time_in && $attendance->time_out) ? 'Present' : 'Absent';
            $attendance->save();

            // Ensure method is called
            Log::info("Calling removeSanctionsIfPresent for attendance ID: {$attendance->id}");
            $attendance->removeSanctionsIfPresent();

        } else {
            // Create new attendance logic
            $attendance = Attendance::create([
                'student_id' => $user->id,
                'activity_id' => $filterActivity,
                'time_in' => $timeType === 'time_in' ? $currentTime : null,
                'time_out' => $timeType === 'time_out' ? $currentTime : null,
                'status' => $timeType === 'time_out' ? 'Present' : 'Absent',
            ]);

            // Ensure method is called
            Log::info("Calling removeSanctionsIfPresent for new attendance ID: {$attendance->id}");
            $attendance->removeSanctionsIfPresent();
        }
    });


    return redirect()->route('attendance.index', ['filter_activity' => $filterActivity])
        ->with('success', 'Attendance marked successfully.');
}



}
