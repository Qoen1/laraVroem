<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Drive;
use App\Models\User;

class DriveApiController extends Controller
{
    public function add(){
        request()->validate([
            'car_id' => 'required|exists:cars,id',
            'beginOdometer' => 'required',
            'endOdometer' => 'required',
            'timestamp' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);
        $car = Car::find(request('car_id'));
        $beginOdometer = request('beginOdometer');
        $endOdometer = request('endOdometer');
        $timestamp = request('timestamp');
        $user = User::find(request('user_id'));

        if($endOdometer < $beginOdometer){
            return response()->json([
                'message' => 'End odometer must be greater than begin odometer.'
            ], 400);
        }

        $drive = new Drive();
        $drive->begin_odometer = $beginOdometer;
        $drive->end_odometer = $endOdometer;
        $drive->setCreatedAt($timestamp);
        $drive->car()->associate($car);
        $drive->user()->associate($user);
        $drive->save();

        return ['message' => 'Drive added successfully.',
            'drive' => $drive,
        ];
    }
}
