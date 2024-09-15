<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clearance;

class Sanction extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'type',
        'fine_amount',
        'required_action',
        'semester_id',
        'school_year',
        'resolved',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function activity()
{
    return $this->belongsTo(Activity::class);
}

    public function fee()
{
    return $this->belongsTo(Fees::class, 'fee_id');
}

public function attendance()
{
    return $this->belongsTo(Attendance::class, 'attendance_id');
}

public function finance()
{
    return $this->belongsTo(Finance::class, 'student_id', 'user_id');
}

public function semester()
{
    return $this->belongsTo(Semester::class);
}


public static function boot()
{
    parent::boot();

    static::created(function ($sanction) {
        // Fetch the student and their clearance
        $clearance = Clearance::firstOrCreate(
            [
                'user_id' => $sanction->student_id,
                'semester_id' => $sanction->semester_id,
                'school_year' => $sanction->school_year,
            ],
            ['status' => 'not cleared'] // Initial status when a sanction is added
        );

        // Trigger status update based on unresolved sanctions
        $sanction->student->updateClearanceStatus();
    });

    static::updated(function ($sanction) {
        // Ensure the student's clearance status is updated
        $sanction->student->updateClearanceStatus();
    });
}

}
