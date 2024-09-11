<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Activity;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

        $activities = Activity::all();

        return view('officer.attendance.index', compact('attendances', 'activities', 'filterActivity'));
    }

    public function edit($id)
    {
        // Fetch the attendance record by ID
        $attendance = Attendance::findOrFail($id);

        // Fetch other necessary data for the form
        $students = User::all();
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
        $attendance->status = ($attendance->time_in && $attendance->time_out) ? 'Completed' : 'In Progress';
        $attendance->save();

        return redirect()->route('attendance.index', ['filter_activity' => $attendance->activity_id])
                         ->with('success', 'Attendance updated successfully.');
    }

    public function markAttendanceByBarcode(Request $request)
    {
        $scannedId = $request->input('scanned_id');
        $filterActivity = $request->input('filter_activity');

        $currentTime = Carbon::now('Asia/Manila')->format('H:i:s'); // Only time
        $activity = Activity::find($filterActivity);

        if (!$activity) {
            return redirect()->back()->with('error', 'Activity not found');
        }

        $activityStartTime = Carbon::parse($activity->start_time)->format('H:i:s'); // Only time
        $activityEndTime = Carbon::parse($activity->end_time)->format('H:i:s'); // Only time
        $thirtyMinutesAfterStart = Carbon::parse($activity->start_time)->addMinutes(2)->format('H:i:s'); // Only time

        $user = User::where('school_id', $scannedId)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        $attendance = Attendance::where('student_id', $user->id)
            ->where('activity_id', $filterActivity)
            ->whereDate('created_at', Carbon::today())
            ->first();

        if ($attendance) {
            DB::transaction(function () use ($attendance, $currentTime, $thirtyMinutesAfterStart, $activityEndTime) {
                if ($currentTime < $thirtyMinutesAfterStart && is_null($attendance->time_in)) {
                    // Record Time In
                    $attendance->time_in = $currentTime; // Only time
                    $attendance->status = 'In Progress';
                } elseif ($currentTime >= $thirtyMinutesAfterStart && is_null($attendance->time_out)) {
                    // Record Time Out
                    $attendance->time_out = $currentTime; // Only time
                    $attendance->status = 'Completed';
                } elseif ($currentTime > $activityEndTime && is_null($attendance->time_out)) {
                    // Time out window is closed
                    return redirect()->route('attendance.index', ['filter_activity' => $attendance->activity_id])
                                     ->with('error', 'Activity has ended. No more attendance can be recorded.');
                }
                $attendance->save();
            });

            return redirect()->route('attendance.index', ['filter_activity' => $filterActivity])
                             ->with('success', 'Attendance marked successfully.');
        } else {
            if ($currentTime < $activityStartTime) {
                return redirect()->route('attendance.index', ['filter_activity' => $filterActivity])
                                 ->with('error', 'Activity has not started yet.');
            } elseif ($currentTime > $activityEndTime) {
                return redirect()->route('attendance.index', ['filter_activity' => $filterActivity])
                                 ->with('error', 'Attendance recording is no longer available.');
            }

            // Create new attendance record with Time In
            $attendance = Attendance::create([
                'student_id' => $user->id,
                'activity_id' => $filterActivity,
                'time_in' => $currentTime, // Only time
                'status' => 'In Progress',
            ]);

            return redirect()->route('attendance.index', ['filter_activity' => $filterActivity])
                             ->with('success', 'Attendance marked successfully.');
        }
    }


}
