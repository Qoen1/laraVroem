<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    use HasFactory;

    public function trackedDistance(){
        $drives = $this->drives;

        $distance = 0;

        foreach ($drives as $drive) {
            $distance += $drive->distance();
        }

        return $distance;
    }

    public function totalDistance(){
        return $this->drives()->max('end_odometer');
    }

    #region Eloquent Relationships

    public function drives(): HasMany
    {
        return $this->hasMany(Drive::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(Car::class,'car_user','car_id','user_id');
    }

    public function refuels(): HasMany
    {
        return $this->hasMany(Refuel::class);
    }

    #endregion
}
