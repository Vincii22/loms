<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Activity;
use App\Models\Sanction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $attendance = Attendance::findOrFail($id);
        $students = User::all();
        $activities = Activity::all();

        return view('officer.attendance.edit', compact('attendance', 'students', 'activities'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'activity_id' => 'required|exists:activities,id',
            'edit_type' => 'required|in:time_in,time_out',
            'time_value' => 'required|date_format:H:i',
        ]);

        $attendance = Attendance::findOrFail($id);

        $originalStatus = $attendance->status;

        if ($request->edit_type === 'time_in') {
            $attendance->time_in = $request->time_value;
        } elseif ($request->edit_type === 'time_out') {
            $attendance->time_out = $request->time_value;
        }

        $attendance->status = ($attendance->time_in && $attendance->time_out) ? 'Completed' : 'In Progress';
        $attendance->save();

        // Update sanctions if status has changed from 'Absent' to 'Present'
        if ($originalStatus === 'Absent' && $attendance->status === 'Completed') {
            $this->updateSanctionsToResolved($attendance->student_id);
        }

        return redirect()->route('attendance.index', ['filter_activity' => $attendance->activity_id])
                         ->with('success', 'Attendance updated successfully.');
    }

    public function markAttendanceByBarcode(Request $request)
    {
        $scannedId = $request->input('scanned_id');
        $filterActivity = $request->input('filter_activity');

        $currentTime = Carbon::now('Asia/Manila')->format('H:i:s');
        $activity = Activity::find($filterActivity);

        if (!$activity) {
            return redirect()->back()->with('error', 'Activity not found');
        }

        $activityStartTime = Carbon::parse($activity->start_time)->format('H:i:s');
        $activityEndTime = Carbon::parse($activity->end_time)->format('H:i:s');
        $thirtyMinutesAfterStart = Carbon::parse($activity->start_time)->addMinutes(1)->format('H:i:s');

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
                $originalStatus = $attendance->status;

                if ($currentTime < $thirtyMinutesAfterStart && is_null($attendance->time_in)) {
                    $attendance->time_in = $currentTime;
                    $attendance->status = 'In Progress';
                } elseif ($currentTime >= $thirtyMinutesAfterStart && is_null($attendance->time_out)) {
                    $attendance->time_out = $currentTime;
                    $attendance->status = 'Completed';
                } elseif ($currentTime > $activityEndTime && is_null($attendance->time_out)) {
                    throw new \Exception('Activity has ended. No more attendance can be recorded.');
                }
                $attendance->officer_id = Auth::id();  // Store the officer ID
                $attendance->save();

                // Update sanctions if status has changed from 'Absent' to 'Present'
                if ($originalStatus === 'Absent' && $attendance->status === 'Completed') {
                    $this->updateSanctionsToResolved($attendance->student_id);
                }
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

            $attendance = Attendance::create([
                'student_id' => $user->id,
                'activity_id' => $filterActivity,
                'time_in' => $currentTime,
                'status' => 'In Progress',
                'officer_id' => Auth::id(),  // Store the officer ID
            ]);

            return redirect()->route('attendance.index', ['filter_activity' => $filterActivity])
                             ->with('success', 'Attendance marked successfully.');
        }
    }

    protected function updateSanctionsToResolved($studentId)
    {
        Log::info("Updating sanctions for student ID: {$studentId}");

        // Fetch and update sanctions for the student related to 'Absence from%'
        $sanctions = Sanction::where('student_id', $studentId)
            ->where('type', 'LIKE', 'Absence from%')
            ->where('resolved', 'not resolved')
            ->get();

        foreach ($sanctions as $sanction) {
            $sanction->resolved = 'resolved';
            $sanction->save();
            Log::info("Sanction updated to resolved for student ID: {$studentId}, Sanction ID: {$sanction->id}");
        }
    }


}
