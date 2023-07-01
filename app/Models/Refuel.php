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

    #endregion

    public function distance(){
        $drives = $this->drives;

        $distance = 0;
        foreach ($drives as $drive){
            $distance += $drive->distance();
        }

        return $distance;
    }

    public function userDriven(User $user){
        $drives = $this->drives;

        $distance = 0;
        foreach ($drives as $drive){
            if($drive->user->id === $user->id){
                $distance += $drive->distance();
            }
        }

        return $distance;
    }

    public function percentageDriven(User $user){
        return $this->userDriven($user) / $this->distance() * 100;
    }

    public function amountToPay(User $user){
        return $this->percentageDriven($user) / 100 * $this->cost;
    }
}
