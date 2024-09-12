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
    public function approve($id)
    {
        Log::info("Approving user/officer with ID: $id");

        // Try to find the officer first, if an officer approval is requested
        $officer = Officer::find($id);
        if ($officer) {
            Log::info("Updating Officer: " . $officer->email);
            $officer->status = 'active';
            $officer->email_verified_at = now();
            $officer->save();
            $officer->notify(new OfficerRegistrationApproved($officer));
        } else {
            // If not an officer, try to find a user
            $user = User::find($id);
            if ($user) {
                Log::info("Updating User: " . $user->email);
                $user->status = 'active';
                $user->email_verified_at = now();
                $user->save();
                $user->notify(new UserRegistrationApproved($user));
            } else {
                Log::error("User/Officer with ID $id not found.");
                return redirect()->route('admin.pending_users')->with('error', 'User/Officer not found.');
            }
        }

        return redirect()->route('admin.pending_users')->with('success', 'User/Officer approved.');
    }

    /**
     * Reject a user or officer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->status = 'inactive'; // or delete the user if preferred
            $user->save();
        } else {
            $officer = Officer::findOrFail($id);
            $officer->status = 'inactive'; // or delete the officer if preferred
            $officer->save();
        }

        return redirect()->route('admin.pending_users')->with('success', 'User/Officer rejected.');
    }
}
