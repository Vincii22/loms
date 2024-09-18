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

    public function clearances(): HasMany
    {
        return $this->hasMany(Clearance::class, 'user_id');
    }
    public function updateClearanceStatus()
    {
        // Fetch the student's clearances
        $clearances = $this->clearances;

        foreach ($clearances as $clearance) {
            $semester = $clearance->semester_id;
            $schoolYear = $clearance->school_year;

            // Fetch sanctions for the student for the given semester and school year
            $sanctions = Sanction::where([
                ['student_id', $this->id],
                ['semester_id', $semester],
                ['school_year', $schoolYear]
            ])->get();

            // Log sanctions found for this user in the current semester and school year
            Log::info("Sanctions for user: " . $this->id . ", semester: " . $semester . ", schoolYear: " . $schoolYear);
            Log::info($sanctions->toArray());  // Output sanctions array to the logs

            // Check if there are no sanctions for the student in this semester and school year
            if ($sanctions->isEmpty()) {
                // No sanctions found, set clearance status to 'cleared'
                Log::info("No sanctions found for user: " . $this->id . ", semester: " . $semester . ", schoolYear: " . $schoolYear);
                $clearance->status = 'cleared';
            } else {
                // Sanctions exist, check if any of them are unresolved
                $hasUnresolvedSanctions = $sanctions->contains(function ($sanction) {
                    return $sanction->resolved === 'not resolved';
                });

                // Update clearance status based on unresolved sanctions
                if ($hasUnresolvedSanctions) {
                    Log::info("Unresolved sanctions found for user: " . $this->id);
                    $clearance->status = 'not cleared';
                } else {
                    Log::info("All sanctions resolved for user: " . $this->id);
                    $clearance->status = 'cleared';
                }
            }

            // Save the updated clearance status
            $clearance->save();
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
