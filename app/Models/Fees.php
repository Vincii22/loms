<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Fees extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'default_amount',
        'semester_id',
        'school_year',
    ];

    public function finances()
    {
        return $this->hasMany(Finance::class, 'fee_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($fee) {
            // Log the fee deletion
            Log::info("Fee deleted: {$fee->id}");

            // Delete related sanctions for unpaid fees
            Sanction::where('type', 'LIKE', 'Unpaid Fees - %')
                ->whereHas('finance', function ($query) use ($fee) {
                    $query->where('fee_id', $fee->id);
                })
                ->delete();
        });
    }
}
