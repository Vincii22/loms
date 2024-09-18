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
        'officer_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fee()
    {
        return $this->belongsTo(Fees::class, 'fee_id');
    }

    public function officer()
    {
        return $this->belongsTo(Officer::class); // Add this line
    }
 // Automatically update sanctions when status is updated
 public static function boot()
 {
     parent::boot();

     static::updated(function ($finance) {
         if ($finance->isDirty('status')) {
             if ($finance->status === 'Paid') {
                 // Update sanctions if status changes to Paid
                 $finance->resolveSanctionsForPaidStatus();
             } elseif ($finance->status === 'Not Paid') {
                 // Create sanctions if status changes to Not Paid
                 $finance->createSanctionsForUnpaidStatus();
             }
         }
     });
 }

 protected function resolveSanctionsForPaidStatus()
 {
     Sanction::where('student_id', $this->user_id)
         ->where('type', 'Unpaid Fees - ' . optional($this->fee)->name)
         ->where('resolved', 'not resolved')
         ->update(['resolved' => 'resolved']);
 }

 protected function createSanctionsForUnpaidStatus()
 {
     $existingSanction = Sanction::where('student_id', $this->user_id)
                                 ->where('type', 'Unpaid Fees - ' . optional($this->fee)->name)
                                 ->where('resolved', 'not resolved')
                                 ->first();

     if (!$existingSanction) {
         $unpaidFeesCount = $this->user->finances()->where('status', 'Not Paid')->count();
         $fineAmount = $unpaidFeesCount * 100; // Example fine calculation

         Sanction::create([
             'student_id' => $this->user_id,
             'type' => 'Unpaid Fees - ' . optional($this->fee)->name,
             'fine_amount' => $fineAmount,
             'required_action' => 'Pay outstanding fees',
             'resolved' => 'not resolved',
         ]);
     }
 }

 public static function addNewUsersToFinance($feeId)
 {
     $students = User::where('status', 'active')->get(); // Fetch all active users

     foreach ($students as $student) {
         // Check if the finance record already exists for this user and fee
         $financeExists = self::where('user_id', $student->id)
             ->where('fee_id', $feeId)
             ->exists();

         if (!$financeExists) {
             // Create finance record with default amount and 'Not Paid' status
             self::create([
                 'user_id' => $student->id,
                 'fee_id' => $feeId,
                 'default_amount' => 100, // Example default amount
                 'status' => 'Not Paid',
                 'officer_id' => null, // Set as needed
             ]);
         }
     }
 }


}
