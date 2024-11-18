<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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
        'archived_at',

    ];
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'archived_at' => 'datetime',
    ];

    public function scopeNotArchived(Builder $query)
    {
        return $query->whereNull('archived_at');
    }

    // Check if the activity is archived
    public function isArchived()
    {
        return !is_null($this->archived_at);
    }
}
