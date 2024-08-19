<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Finance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'fee_id',
        'default_amount',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fee()
    {
        return $this->belongsTo(Fees::class, 'fee_id');
    }

}
