<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    use HasFactory;

    #region Eloquent Relationships

    public function drives(): HasMany
    {
        return $this->hasMany(Drive::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function refuels(): HasMany
    {
        return $this->hasMany(Refuel::class);
    }

    #endregion
}
