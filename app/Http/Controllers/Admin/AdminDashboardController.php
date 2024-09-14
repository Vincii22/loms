<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Officer;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalStudents = User::count();
        $totalOfficers = Officer::count();
        $totalAdmins = User::where('is_admin', true)->count(); // or however you determine admins
        $pendingApprovals = User::where('status', 'pending')->count() + Officer::where('status', 'pending')->count();

        // Data for charts
        $organizationCounts = User::select('organization_id', ('count(*) as count'))
            ->groupBy('organization_id')
            ->pluck('count', 'organization_id')
            ->toArray();

        $programCounts = User::select('course_id', ('count(*) as count'))
            ->groupBy('course_id')
            ->pluck('count', 'course_id')
            ->toArray();

        $yearCounts = User::select('year_id', ('count(*) as count'))
            ->groupBy('year_id')
            ->pluck('count', 'year_id')
            ->toArray();

        return view('admin.dashboard', compact(
            'totalStudents',
            'totalOfficers',
            'totalAdmins',
            'pendingApprovals',
            'organizationCounts',
            'programCounts',
            'yearCounts'
        ));
    }
}
