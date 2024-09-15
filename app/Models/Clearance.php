<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clearance extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'status',
        'semester_id',
        'school_year',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sanctions()
    {
        return $this->hasMany(Sanction::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

}
