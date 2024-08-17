<?php

namespace App\Http\Controllers\Officer;

use App\Models\Finance;
use App\Models\Attendance;
use App\Models\Sanction;
use App\Models\Clearance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function dashboard()
    {
        $totalPaid = Finance::where('status', 'Paid')->sum('default_amount');
        $totalNotPaid = Finance::where('status', 'Not Paid')->sum('default_amount');

        $totalPresent = Attendance::where('status', 'Present')->count();
        $totalAbsent = Attendance::where('status', 'Absent')->count();

        $totalSanctions = Sanction::count();
        $resolvedSanctions = Sanction::where('resolved', true)->count();
        $unresolvedSanctions = Sanction::where('resolved', false)->count();

        $totalCleared = Clearance::where('status', 'cleared')->count();
        $notEligible = Clearance::where('status', 'not eligible')->count();
        $eligibleNotCleared = Clearance::where('status', 'eligible')->count();

        return view('officer.dashboard', compact('totalPaid', 'totalNotPaid', 'totalPresent', 'totalAbsent', 'totalSanctions', 'resolvedSanctions', 'unresolvedSanctions', 'totalCleared', 'notEligible', 'eligibleNotCleared'));
    }
}
