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
        return $this->hasOne(Clearance::class);
    }

    // Automatically create a clearance record when a user is created
    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            $user->clearance()->create(['status' => 'eligible']);
        });
    }

    // Update clearance status based on unresolved sanctions
    public function updateClearanceStatus()
    {
        $clearance = $this->clearance()->first();

        if ($clearance) {
            $hasUnresolvedSanctions = Sanction::where('student_id', $this->id)
                ->where('resolved', false)
                ->exists();

            $newStatus = $hasUnresolvedSanctions ? 'not cleared' : 'cleared';

            // Log status changes
            Log::info("Updating clearance status for user ID {$this->id}: {$clearance->status} -> {$newStatus}");

            $clearance->status = $newStatus;
            $clearance->save();
        } else {
            Log::info("No clearance record found for user ID {$this->id}");
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
