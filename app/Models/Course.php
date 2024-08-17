<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model
{
    protected $table = 'courses';
    protected $fillable = ['name'];
    protected $primaryKey = 'id';

    public $timestamps = false;

    // public function user():BelongsTo {
    //     return $this->belongsTo(User::class);
    // }

    public function users()
{
    return $this->hasMany(User::class, 'course_id');
}

    use HasFactory;


}
