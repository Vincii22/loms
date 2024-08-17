<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Activity;
use Illuminate\Http\Request;

class StudentAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch the currently authenticated student
        $student = Auth::user();

        // Retrieve attendances for the authenticated student with related activity details
        $attendances = Attendance::with('activity')
            ->where('student_id', $student->id)
            ->paginate(10); // Adjust the number of items per page as needed

        return view('attendance.index', compact('attendances'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Fetch the currently authenticated student
        $student = Auth::user();

        // Retrieve a specific attendance record for the authenticated student
        $attendance = Attendance::where('id', $id)
            ->where('student_id', $student->id)
            ->with('activity')
            ->firstOrFail();

        return view('attendance.show', compact('attendance'));
    }
}
