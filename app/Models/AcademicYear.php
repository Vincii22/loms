<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    protected $fillable = ['school_year', 'semester_id', 'is_default'];

    protected $casts = [
        'is_default' => 'boolean',
    ];
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
