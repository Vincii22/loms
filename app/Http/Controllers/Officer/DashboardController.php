<?php

namespace App\Http\Controllers\Officer;

use App\Models\User;
use App\Models\Organization;
use App\Models\Course;
use App\Models\Year;
use App\Models\Activity;
use App\Models\Fees;
use App\Models\Sanction;
use App\Models\Clearance; // Import Clearance model
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Fetching data for the dashboard
        $totalActivities = Activity::count();
        $totalFees = Fees::count();
        $totalStudents = User::count();
        $organizationCounts = Organization::withCount('users')->get()->pluck('users_count', 'name')->toArray();
        $programCounts = Course::withCount('users')->get()->pluck('users_count', 'name')->toArray();
        $yearCounts = Year::withCount('users')->get()->pluck('users_count', 'name')->toArray();
        $totalSanctions = Sanction::count();

        // Fetch clearance counts
        $clearanceCounts = Clearance::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();


            // dd($clearanceCounts);

        $eligibleCount = $clearanceCounts['eligible'] ?? 0;
        $notEligibleCount = $clearanceCounts['not eligible'] ?? 0;
        $clearedCount = $clearanceCounts['cleared'] ?? 0;

        // Optional: Handle semester and year filters
        $semester = $request->input('semester');
        $year = $request->input('year');

        // Pass data to the view
        return view('officer.dashboard', [
            'totalStudents' => $totalStudents,
            'organizationCounts' => $organizationCounts,
            'programCounts' => $programCounts,
            'yearCounts' => $yearCounts,
            'totalActivities' => $totalActivities,
            'totalFees' => $totalFees,
            'totalSanctions' => $totalSanctions,
            'eligibleCount' => $eligibleCount,
            'notEligibleCount' => $notEligibleCount,
            'clearedCount' => $clearedCount,
        ]);
    }
}
