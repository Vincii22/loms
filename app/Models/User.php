<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'school_id',
        'organization_id',
        'course_id',
        'year_id',
        'image',
        'barcode_image',
        'password',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function year()
    {
        return $this->belongsTo(Year::class, 'year_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    public function finances()
    {
        return $this->hasMany(Finance::class, 'user_id' );
    }
    public function sanctions()
{
    return $this->hasMany(Sanction::class, 'student_id');
}

public function clearance()
{
    return $this->hasOne(Clearance::class);
}

public static function boot()
{
    parent::boot();

    // Automatically create a clearance record when a user is created
    static::created(function ($user) {
        $user->clearance()->create(['status' => 'eligible']);
    });
}


public function updateClearanceStatus()
{
    // Check if the user has any unresolved sanctions
    $hasUnresolvedSanctions = $this->sanctions()->where('resolved', false)->exists();

    if ($hasUnresolvedSanctions) {
        // If there are unresolved sanctions, set the status to 'not eligible'
        if ($this->clearance) {
            $this->clearance->update(['status' => 'not eligible']);
        } else {
            $this->clearance()->create(['status' => 'not eligible']);
        }
    } else {
        // If there are no unresolved sanctions, set the status to 'eligible'
        if ($this->clearance) {
            $this->clearance->update(['status' => 'eligible']);
        } else {
            $this->clearance()->create(['status' => 'eligible']);
        }
    }
}



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
