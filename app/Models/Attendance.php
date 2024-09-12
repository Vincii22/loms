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
        });
    }

    public function removeSanctionsIfPresent()
    {
        Log::info("Removing sanctions for student ID: {$this->student_id} with status: {$this->status}");

        if ($this->status === 'Present') {
            $deleted = Sanction::where('student_id', $this->student_id)
                ->where('type', 'LIKE', 'Absence from%')
                ->delete();

            Log::info("Sanctions removed for student ID: {$this->student_id}. Records deleted: {$deleted}");
        }
    }
}


