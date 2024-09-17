<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Officer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Notifications\UserRegistrationApproved;
use App\Notifications\OfficerRegistrationApproved;
use Illuminate\Support\Facades\Log;
class AdminAuthController extends Controller
{
    /**
     * Display a list of pending users and officers.
     */
    public function index()
    {
        $pendingUsers = User::where('status', 'pending')->paginate(10);
        $pendingOfficers = Officer::where('status', 'pending')->paginate(10);
        return view('admin.adminAuth.pending_users', compact('pendingUsers', 'pendingOfficers'));
    }

    /**
     * Approve a user or officer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approveUser($id)
    {
        Log::info("Approving User with ID: $id");

        $user = User::findOrFail($id);
        $user->status = 'active';
        $user->email_verified_at = now();
        $user->save();
        $user->notify(new UserRegistrationApproved($user));

        return redirect()->route('admin.pending_users')->with('success', 'User approved.');
    }

    /**
     * Approve an officer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approveOfficer($id)
    {
        Log::info("Approving Officer with ID: $id");

        $officer = Officer::findOrFail($id);
        $officer->status = 'active';
        $officer->email_verified_at = now();
        $officer->save();
        $officer->notify(new OfficerRegistrationApproved($officer));

        return redirect()->route('admin.pending_officers')->with('success', 'Officer approved.');
    }

    /**
     * Reject a user or officer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rejectUser($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'inactive'; // Or delete the user if necessary
        $user->save();
        return redirect()->route('admin.pending_users')->with('success', 'User rejected.');
    }

    public function rejectOfficer($id)
    {
        $officer = Officer::findOrFail($id);
        $officer->status = 'inactive'; // Or delete the officer if necessary
        $officer->save();
        return redirect()->route('admin.pending_users')->with('success', 'Officer rejected.');
    }
}
