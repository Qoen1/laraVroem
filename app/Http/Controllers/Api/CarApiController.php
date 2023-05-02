<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Drive;

class CarApiController extends Controller
{
    public function add(){
        request()->validate([
            'car_id' => 'required|integer|exists:cars,id',
            'endOdometer' => 'required',
        ]);

        $car = Car::find(request('car_id'));
        $beginOdometer = 0;
        if(\request('beginOdometer') !== null){
            $beginOdometer = request('beginOdometer');
        }
        else if(\request('beginOdometer') === null && $car->drives->count() > 0){
            $beginOdometer = $car->drives->last()->endOdometer;
        }
        $endOdometer = request('endOdometer');

        if($endOdometer < $beginOdometer){
            return response()->json(['message' => 'End odometer must be greater than begin odometer.'], 422);
        }

        $drive = new Drive();
        $drive->begin_odometer = $beginOdometer;
        $drive->end_odometer = $endOdometer;
        $drive->car()->associate($car);
        $drive->user()->associate(auth()->user());
        $drive->save();

        return ['message' => 'Drive added successfully.',
            'drive' => $drive,
        ];
    }
}
