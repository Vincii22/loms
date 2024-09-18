<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Attendance;
use App\Models\Fees;
use App\Models\Finance;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        // Update attendance for all activities
        $activities = \App\Models\Activity::all();

        foreach ($activities as $activity) {
            Attendance::addNewUsersToAttendance($activity->id);
        }

         // Update finance for all fees
         $fees = Fees::all(); // Assuming there's a Fee model
         foreach ($fees as $fee) {
             Finance::addNewUsersToFinance($fee->id);
         }
    }
}
