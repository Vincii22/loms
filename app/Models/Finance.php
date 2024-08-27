<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
    // Automatically remove sanctions when status is updated
    public static function boot()
    {
        parent::boot();

        static::updated(function ($finance) {
            if ($finance->isDirty('status')) {
                if ($finance->status === 'Paid') {
                    // Remove sanctions if status changes to Paid
                    $finance->removeSanctionsForPaidStatus();
                } elseif ($finance->status === 'Not Paid') {
                    // Create sanctions if status changes to Not Paid
                    $finance->createSanctionsForUnpaidStatus();
                }
            }
        });
    }

    protected function removeSanctionsForPaidStatus()
    {
        Sanction::where('student_id', $this->user_id)
            ->where('type', 'finance')
            ->delete();
    }

    protected function createSanctionsForUnpaidStatus()
    {
        $existingSanction = Sanction::where('student_id', $this->user_id)
                                    ->where('type', 'finance')
                                    ->where('resolved', false)
                                    ->first();

        if (!$existingSanction) {
            $unpaidFeesCount = $this->user->finances()->where('status', 'Not Paid')->count();
            $fineAmount = $unpaidFeesCount * 100; // Example fine calculation

            Sanction::create([
                'student_id' => $this->user_id,
                'type' => 'finance',
                'fine_amount' => $fineAmount,
                'required_action' => 'Pay outstanding fees',
                'resolved' => false,
            ]);
        }
    }

}
