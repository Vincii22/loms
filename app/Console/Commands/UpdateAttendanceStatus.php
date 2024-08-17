<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Attendance;

class UpdateAttendanceStatus extends Command
{
    protected $signature = 'attendance:update-status';
    protected $description = 'Update the status of attendance records based on time in and time out';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $attendances = Attendance::all();

        foreach ($attendances as $attendance) {
            if ($attendance->time_in && $attendance->time_out) {
                $attendance->status = 'Present';
            } else {
                $attendance->status = 'Absent';
            }
            $attendance->save();
        }

        $this->info('Attendance status updated successfully.');
    }
}
