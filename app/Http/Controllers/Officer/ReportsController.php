<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\Reports;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Finance;
use App\Models\User;
use App\Models\Semester;
use App\Models\Fees;
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
    public function attendanceStats(Request $request)
    {
        // Fetch activities and semesters for the filter dropdowns
        $activities = Activity::pluck('name', 'id');
        $semesters = Semester::pluck('name', 'id');

        // Fetch attendance data based on the request filters
        $attendances = Attendance::with('user', 'activity.semester')
            ->when($request->input('activity_id'), function($query) use ($request) {
                return $query->where('activity_id', $request->input('activity_id'));
            })
            ->when($request->input('semester'), function($query) use ($request) {
                return $query->whereHas('activity.semester', function($query) use ($request) {
                    $query->where('id', $request->input('semester'));
                });
            })
            ->when($request->input('school_year'), function($query) use ($request) {
                return $query->whereHas('activity', function($query) use ($request) {
                    $query->where('school_year', $request->input('school_year'));
                });
            })
            ->get();

        // Prepare data for charts
        // Count attendance per activity
        $attendanceCounts = $attendances->groupBy('activity_id')->map->count();
        $attendanceLabels = $attendanceCounts->keys()->map(function($activityId) use ($activities) {
            return $activities[$activityId] ?? 'Unknown Activity';
        })->toArray();
        $attendanceData = $attendanceCounts->values()->toArray();

        // Prepare data for activity distribution chart
        $activityDistribution = $attendances->groupBy('activity_id')->map->count();
        $activityLabels = $activityDistribution->keys()->map(function($activityId) use ($activities) {
            return $activities[$activityId] ?? 'Unknown Activity';
        })->toArray();
        $activityData = $activityDistribution->values()->toArray();

        // Prepare data for user attendance table
        $userAttendance = $attendances->groupBy('student_id')->map->count();
        $userLabels = $userAttendance->keys()->map(function($userId) use ($attendances) {
            return $attendances->firstWhere('student_id', $userId)->user->name ?? 'Unknown User';
        })->toArray();
        $userData = $userAttendance->values()->toArray();

        return view('officer.reports.attendance_statistics', compact(
            'attendanceLabels',
            'attendanceData',
            'activityLabels',
            'activityData',
            'userLabels',
            'userData',
            'activities',
            'semesters'
        ));
    }


    /**
     * Generate and display the finance report with optional filtering.
     */
    public function financeReport(Request $request)
    {
        $feeId = $request->input('fee_id');
        $semesterId = $request->input('semester');
        $schoolYear = $request->input('school_year');

        $query = Finance::query()
            ->join('users', 'finances.user_id', '=', 'users.id') // Change students to users
            ->join('fees', 'finances.fee_id', '=', 'fees.id')
            ->select(
                'finances.*',
                'users.name as student_name', // Change students to users
                'users.school_id', // Ensure `school_id` exists in the `users` table
                'fees.name as fee_name',
                'fees.semester_id',
                'fees.school_year'
            );

        if ($feeId) {
            $query->where('finances.fee_id', $feeId);
        }

        if ($semesterId) {
            $query->where('fees.semester_id', $semesterId);
        }

        if ($schoolYear) {
            $query->where('fees.school_year', $schoolYear);
        }

        $finances = $query->paginate(10);

        // Fetch fees for the filter dropdown
        $fees = Fees::pluck('name', 'id');

        // Fetch distinct semesters from fees for the filter dropdown
        $semesters = Fees::pluck('semester_id', 'semester_id')->unique();

        return view('officer.reports.finance', compact('finances', 'fees', 'semesters'));
    }

    /**
     * Generate and display the sanction report with optional filtering.
     */
    public function sanctionReport(Request $request)
    {
        // Capture filtering parameters from the request
        $semesterId = $request->input('semester');
        $schoolYear = $request->input('school_year');
        $resolvedStatus = $request->input('resolved'); // Optional filter for resolved status

        // Build the query
        $query = Sanction::with('student', 'semester') // eager load relationships
            ->when($semesterId, function ($q) use ($semesterId) {
                $q->where('semester_id', $semesterId);
            })
            ->when($schoolYear, function ($q) use ($schoolYear) {
                $q->where('school_year', $schoolYear);
            })
            ->when($resolvedStatus, function ($q) use ($resolvedStatus) {
                $q->where('resolved', $resolvedStatus);
            });

        // Fetch sanctions
        $sanctions = $query->paginate(10);

        // Fetch available semesters and school years for filters
        $semesters = Semester::pluck('name', 'id');
        $schoolYears = Sanction::distinct()->pluck('school_year', 'school_year');

        return view('officer.reports.sanction', compact('sanctions', 'semesters', 'schoolYears'));
    }

    /**
     * Generate and display the clearance report with optional filtering.
     */
    public function clearanceReport(Request $request)
    {
        $status = $request->input('status');
        $semesterId = $request->input('semester_id');
        $schoolYear = $request->input('school_year');

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

        return view('officer.reports.clearance', [
            'clearances' => $clearances,
            'semesters' => $semesters,
            'schoolYears' => $schoolYears,
        ]);
    }
    public function clearanceStats(Request $request)
    {
        $semesterId = $request->input('semester_id');
        $schoolYear = $request->input('school_year');

        // Fetch available semesters and school years
        $semesters = Semester::whereIn('id', Clearance::pluck('semester_id')->unique())->get();
        $schoolYears = Clearance::distinct()->pluck('school_year');

        // Fetch clearance statistics
        $clearances = Clearance::when($semesterId, function ($query, $semesterId) {
            return $query->where('semester_id', $semesterId);
        })
        ->when($schoolYear, function ($query, $schoolYear) {
            return $query->where('school_year', $schoolYear);
        })
        ->get();

        // Prepare data for Status Distribution Chart
        $statusCounts = $clearances->groupBy('status')->map->count();
        $statusLabels = $statusCounts->keys();
        $statusData = $statusCounts->values();

        // Prepare data for Clearances by Semester Chart
        $semesterData = $semesters->map(function ($semester) use ($clearances) {
            return $clearances->where('semester_id', $semester->id)->count();
        });

        // Prepare data for Clearances by School Year Chart
        $yearData = $schoolYears->map(function ($year) use ($clearances) {
            return $clearances->where('school_year', $year)->count();
        });

        // Prepare data for Top 5 Users by Clearances Chart
        $topUsers = $clearances->groupBy('user_id')
            ->map(function ($items, $userId) {
                return [
                    'name' => User::find($userId)->name,
                    'clearances_count' => $items->count(),
                ];
            })
            ->sortByDesc('clearances_count')
            ->take(5);
        $topUsersData = $topUsers->pluck('clearances_count');

        // Prepare user clearances data for the table
        $userClearances = $clearances->groupBy('user_id')->map(function ($items, $userId) {
            return [
                'name' => User::find($userId)->name,
                'status' => $items->pluck('status')->unique()->implode(', ')
            ];
        });

        return view('officer.reports.clearance_statistics', [
            'semesters' => $semesters,
            'schoolYears' => $schoolYears,
            'statusLabels' => $statusLabels,
            'statusData' => $statusData,
            'semesterData' => $semesterData,
            'yearData' => $yearData,
            'topUsers' => $topUsers,
            'topUsersData' => $topUsersData,
            'userClearances' => $userClearances,
        ]);
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
