<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
class Attendance extends Model
{

    use HasFactory;


    protected $fillable = [
        'student_id',
        'activity_id',
        'time_in',
        'time_out',
        'status',
        'officer_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Define the relationship with the Activity model
    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }

    public function officer()
    {
        return $this->belongsTo(Officer::class, 'officer_id');
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($attendance) {
            if ($attendance->time_in && $attendance->time_out) {
                $attendance->status = 'Present';
            } else {
                $attendance->status = 'Absent';
            }

              // Update sanctions if the status is changing from 'Absent' to 'Present'
              if ($attendance->isDirty('status') && $attendance->status === 'Present') {
                $attendance->updateSanctionsToResolved();
            }
        });
    }

    public function updateSanctionsToResolved()
    {
        $activity = $this->activity;
        Log::info("Updating sanctions for student ID: {$this->student_id} with status: {$this->status}");

        // Fetch and update sanctions for the student related to 'Absence from%'
        $sanctions = Sanction::where('student_id', $this->student_id)
            ->where('type', 'LIKE', 'Absence from%')
            ->where('semester_id', $activity->semester_id) // Check for the same semester
            ->where('school_year', $activity->school_year) // Check for the same school_year
            ->where('resolved', 'not resolved')
            ->get();

        foreach ($sanctions as $sanction) {
            $sanction->resolved = 'resolved';
            $sanction->save();
            Log::info("Sanction updated to resolved for student ID: {$this->student_id}, Sanction ID: {$sanction->id}");
        }
    }

    public static function addNewUsersToAttendance($activityId)
{
    $students = User::where('status', 'active')->get(); // Fetch all active users

    foreach ($students as $student) {
        // Check if the attendance record already exists for this user and activity
        $attendanceExists = self::where('student_id', $student->id)
            ->where('activity_id', $activityId)
            ->exists();

        if (!$attendanceExists) {
            // Create attendance record with 'Absent' status
            self::create([
                'student_id' => $student->id,
                'activity_id' => $activityId,
                'status' => 'Absent',
            ]);
        }
    }
}

}


