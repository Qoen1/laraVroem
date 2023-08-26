<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    //TODO: add car admin who has CRUD access to all data in that car (change refuels and drives, and invite/ban users)
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

    public function totalFuel(){
        return $this->refuels()->sum('liters');
    }

    public function totalFuelCost(){
        return $this->refuels()->sum('cost');
    }

    public function trackedDistanceInValidRefuel(){
        $drives = $this->drives()->with('refuel')->get();

        $distance = 0;

        foreach ($drives as $drive) {
            if($drive->refuel === null || $drive->refuel->liters > 0){
                $distance += $drive->distance();
            }
        }

        return $distance;
    }

    public function averageKilometersPerLiter(){
        return $this->refuels->count() ? $this->trackedDistanceInValidRefuel() / $this->totalFuel() : 0;
    }

    public function averageFuelCost(){
        return $this->refuels->count() ? $this->totalFuelCost() / $this->totalFuel() : 0;
    }

    public function averageCostPerKilometer(){
        return $this->refuels->count() ? $this->totalFuelCost() / $this->trackedDistanceInValidRefuel() : 0;
    }

    public function drivesPerUser(){
        $users = $this->users;
        $drives = $this->drives;

        $drivesPerUser = [];

        foreach ($users as $user) {
            $drivesPerUser[$user->name] = [];
        }

        foreach ($drives as $drive) {
            $drivesPerUser[$drive->user->name][] = $drive;
        }

        $final = [];

        foreach ($users as $user) {
            $final[] = [
                'user' => $user,
                'drives' => $drivesPerUser[$user->name],
            ];
        }

        return $final;
    }

    #region Eloquent Relationships

    public function drives(): HasMany
    {
        return $this->hasMany(Drive::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'car_user','car_id','user_id')->wherePivotNotNull('activated_at');
    }

    public function invitedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'car_user','car_id','user_id')->wherePivotNull('activated_at');
    }

    public function refuels(): HasMany
    {
        return $this->hasMany(Refuel::class);
    }

    #endregion
}
