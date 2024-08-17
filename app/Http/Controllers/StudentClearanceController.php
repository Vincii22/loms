<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Clearance;
use App\Models\User;
use Illuminate\Http\Request;
class StudentClearanceController extends Controller
{
    public function index()
    {
        // Fetch the current logged-in user's clearance record
        $clearance = Clearance::where('user_id', Auth::id())->first();

        return view('clearance.index', [
            'clearance' => $clearance,
        ]);
    }

    public function show(Clearance $clearance)
    {
        // Ensure the student can only view their own clearance
        if ($clearance->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('clearance.show', [
            'clearance' => $clearance,
        ]);
    }
}
