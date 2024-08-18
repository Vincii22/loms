<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasFactory;

    public static function calculateTotalAmount($feeId)
    {
        $fee = Fees::find($feeId);

        if (!$fee) {
            return 0;
        }

        $totalUsers = User::count();
        return $totalUsers * $fee->default_amount;
    }
}
