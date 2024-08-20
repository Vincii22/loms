<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sanction extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'type',
        'description',
        'fine_amount',
        'required_action',
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
}
