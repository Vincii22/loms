<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fees extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'default_amount'];

    public function finances()
    {
        return $this->hasMany(Finance::class, 'fee_id');
    }
}
