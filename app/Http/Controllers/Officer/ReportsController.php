<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\Reports;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Finance;
use App\Models\User;
use App\Models\Semester;
use App\Models\Activity;
use App\Models\Clearance;
use App\Models\Sanction;
use Barryvdh\DomPDF\Facade as PDF;


class ReportsController extends Controller
{
    /**
     * Display a listing of the reports.
     */
    public function index()
    {
        return view('officer.reports.index');
    }

    /**
     * Generate and display the attendance report with optional filtering.
     */
    public function attendanceReport(Request $request)
    {
        $activityId = $request->input('activity_id');
        $semesterId = $request->input('semester');
        $schoolYear = $request->input('school_year');

        $query = Attendance::query();

        if ($activityId) {
            $query->where('activity_id', $activityId);
        }

        if ($semesterId) {
            $query->whereHas('activity', function ($q) use ($semesterId) {
                $q->where('semester_id', $semesterId);
            });
        }

        if ($schoolYear) {
            $query->whereHas('activity', function ($q) use ($schoolYear) {
                $q->where('school_year', $schoolYear);
            });
        }

        $attendances = $query->paginate(10);

        // Fetch distinct semesters from activities for the filter dropdown
        $semesters = Activity::pluck('semester_id', 'semester_id')->unique();

        // Fetch activities for the filter dropdown
        $activities = Activity::pluck('name', 'id');

        return view('officer.reports.attendance', compact('attendances', 'activities', 'semesters'));
    }

    /**
     * Generate and display the finance report with optional filtering.
     */
    public function financeReport(Request $request)
    {
        $dateRange = $request->input('date_range');

        $query = Finance::query();

        if ($dateRange) {
            [$startDate, $endDate] = explode(' to ', $dateRange);
            $query->whereBetween('date', [$startDate, $endDate]);
        }

        $finances = $query->get();

        return view('officer.reports.finance', compact('finances'));
    }

    /**
     * Generate and display the sanction report with optional filtering.
     */
    public function sanctionReport(Request $request)
    {
        $dateRange = $request->input('date_range');

        $query = Sanction::query();

        if ($dateRange) {
            [$startDate, $endDate] = explode(' to ', $dateRange);
            $query->whereBetween('date', [$startDate, $endDate]);
        }

        $sanctions = $query->get();

        return view('officer.reports.sanction', compact('sanctions'));
    }

    /**
     * Generate and display the clearance report with optional filtering.
     */
    public function clearanceReport(Request $request)
    {
        $dateRange = $request->input('date_range');

        $query = Clearance::query();

        if ($dateRange) {
            [$startDate, $endDate] = explode(' to ', $dateRange);
            $query->whereBetween('date', [$startDate, $endDate]);
        }

        $clearances = $query->get();

        return view('officer.reports.clearance', compact('clearances'));
    }

    /**
     * Generate and display the student report with optional filtering.
     */
    public function studentReport(Request $request)
    {
        $dateRange = $request->input('date_range');

        $query = User::query();

        if ($dateRange) {
            [$startDate, $endDate] = explode(' to ', $dateRange);
            $query->whereBetween('date_of_admission', [$startDate, $endDate]);
        }

        $students = $query->get();

        return view('officer.reports.student', compact('students'));
    }
}
