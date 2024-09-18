<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Officer;
use App\Models\Admin;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminDashboardController extends Controller
{
    public function index()
    {
        try {
            // Count totals for students, officers, and admins
            $totalStudents = User::count();  // Adjusted for students
            $totalOfficers = Officer::count();
            $totalAdmins = Admin::count();

            // Data for charts
            $organizationCounts = User::whereNotNull('organization_id')
                ->groupBy('organization_id')
                ->select('organization_id', DB::raw('count(*) as count'))
                ->pluck('count', 'organization_id')
                ->toArray();

            $programCounts = User::whereNotNull('course_id')
                ->groupBy('course_id')
                ->select('course_id', DB::raw('count(*) as count'))
                ->pluck('count', 'course_id')
                ->toArray();

            $yearCounts = User::whereNotNull('year_id')
                ->groupBy('year_id')
                ->select('year_id', DB::raw('count(*) as count'))
                ->pluck('count', 'year_id')
                ->toArray();

            // Fetch upcoming activities
            $activities = Activity::all();
            $pendingUsers = User::where('status', 'pending')->latest()->limit(3)->get();
            $pendingOfficers = Officer::where('status', 'pending')->latest()->limit(3)->get();

            return view('admin.dashboard', compact(
                'totalStudents',
                'totalOfficers',
                'totalAdmins',
                'organizationCounts',
                'programCounts',
                'yearCounts',
                'activities',
                'pendingUsers',
                'pendingOfficers',
            ));
        } catch (\Exception $e) {
            Log::error('Error in AdminDashboardController@index: ' . $e->getMessage());
            return back()->withErrors('An error occurred while loading the dashboard.');
        }
    }
}
