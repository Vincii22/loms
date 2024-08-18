<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $table = 'semesters';

    protected $fillable = ['name'];
    protected $primaryKey = 'id';

    public $timestamps = false;



    public function finances()
    {
        return $this->hasMany(Finance::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
    use HasFactory;
}
