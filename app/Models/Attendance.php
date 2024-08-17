<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{

    use HasFactory;


    protected $fillable = [
        'student_id',
        'activity_id',
        'time_in',
        'time_out',
        'status',
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
}
