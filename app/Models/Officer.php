<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;

class Officer extends Authenticatable implements MustVerifyEmailContract
{
    use HasFactory, Notifiable, MustVerifyEmailTrait;

    // Existing fillable attributes
    protected $fillable = [
        'name',
        'email',
        'role_id',
        'image',
        'status',
        'email_verified_at',
        'password',
    ];

    // Relationships
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'officer_id');
    }

    public function finances(): HasMany
    {
        return $this->hasMany(Finance::class);
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

    public static function boot()
    {
        parent::boot();

        static::saving(function ($officer) {
            // Check if the role is available only if the officer is being activated
            if ($officer->status === 'active') {
                $role = Role::find($officer->role_id);

                if ($role && !$role->isAvailable()) {
                    // You can handle the error differently here if needed
                    // For example, you could set a custom attribute to show an error message
                    throw new \Exception('The selected role is already taken.');
                }
            }
        });
    }
}
