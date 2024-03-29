<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_name',
    ];

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    #region Eloquent Relationships

    public function drives(): HasMany
    {
        return $this->hasMany(Drive::class);
    }

    public function refuels(): HasMany
    {
        return $this->hasMany(Refuel::class);
    }

    public function cars(): BelongsToMany
    {
        return $this->belongsToMany(Car::class)->wherePivotNotNull('activated_at');
    }

    public function carInvites(): BelongsToMany
    {
        return $this->belongsToMany(Car::class)->wherePivotNull('activated_at');
    }

    public function role(): BelongsTo{
        return $this->belongsTo(Role::class);
    }
    #endregion
}
