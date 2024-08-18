<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_time',
        'end_time',
        'location',
        'semester_id',
        'school_year',
        'image',
    ];
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
