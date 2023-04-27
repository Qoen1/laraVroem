<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Refuel extends Model
{
    use HasFactory;

    #region Eloquent Relationships

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function drives(): HasMany
    {
        return $this->hasMany(Drive::class);
    }

    public function distance(){
        $drives = $this->drives;

        $distance = 0;
        foreach ($drives as $drive){
            $distance += $drive->distance();
        }

        return $distance;
    }
}
