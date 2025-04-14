<?php

namespace App\Observers;

use App\Models\AcademicYear;
use App\Models\User;
use App\Models\Officer;
class AcademicYearObserver
{
    /**
     * Handle the AcademicYear "created" event.
     */
    public function created(AcademicYear $academicYear): void
    {
        //
    }

    /**
     * Handle the AcademicYear "updated" event.
     */
    public function updated(AcademicYear $academicYear)
    {
        if ($academicYear->is_default) {
            // Set all users and officers to inactive
            User::where('status', 'active')->update(['status' => 'inactive']);
            Officer::where('status', 'active')->update(['status' => 'inactive']);
        }
    }

    /**
     * Handle the AcademicYear "deleted" event.
     */
    public function deleted(AcademicYear $academicYear): void
    {
        //
    }

    /**
     * Handle the AcademicYear "restored" event.
     */
    public function restored(AcademicYear $academicYear): void
    {
        //
    }

    /**
     * Handle the AcademicYear "force deleted" event.
     */
    public function forceDeleted(AcademicYear $academicYear): void
    {
        //
    }
}
