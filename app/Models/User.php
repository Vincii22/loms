<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
class User extends Authenticatable implements MustVerifyEmailContract
{
    use HasFactory, Notifiable;

    // Existing fillable attributes
    protected $fillable = [
        'name',
        'email',
        'school_id',
        'organization_id',
        'course_id',
        'year_id',
        'image',
        'barcode_image',
        'status',
        'email_verified_at',
        'password',
    ];

    // Relationships
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class, 'year_id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    public function finances(): HasMany
    {
        return $this->hasMany(Finance::class, 'user_id');
    }

    public function sanctions(): HasMany
    {
        return $this->hasMany(Sanction::class, 'student_id');
    }

    public function clearance(): HasOne
    {
        return $this->hasOne(Clearance::class, 'user_id');
    }

    // Update clearance status based on unresolved sanctions
    public function updateClearanceStatus()
    {
   // Get all the sanctions for the student
   $sanctions = Sanction::where('student_id', $this->id)->get();

   // Check if the student has any unresolved sanctions
   $hasSanctions = $sanctions->isNotEmpty();

   // Fetch the student's clearance record
   $clearance = $this->clearance()->where('semester_id', $sanctions->pluck('semester_id')->first())
                                  ->where('school_year', $sanctions->pluck('school_year')->first())
                                  ->first();

   if ($clearance) {
       // Update the status based on whether there are unresolved sanctions
       $clearance->status = $hasSanctions ? 'not cleared' : 'cleared';
       $clearance->save();
   } else {
       // If no clearance record exists, create one with the appropriate status
       if ($sanctions->isNotEmpty()) {
           $this->clearance()->create([
               'status' => $hasSanctions ? 'not cleared' : 'cleared',
               'semester_id' => $sanctions->pluck('semester_id')->first(),
               'school_year' => $sanctions->pluck('school_year')->first(),
           ]);
       }
    }
    }

    // Hidden attributes
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Cast attributes
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
