<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Drive extends Model
{
    use HasFactory;

    public function distance(): int
    {
        return $this->end_odometer = $this->begin_odometer;
    }

    #region Eloquent Relationships

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function refuel(): BelongsTo
    {
        return $this->belongsTo(Refuel::class);
    }

    #endregion
}
