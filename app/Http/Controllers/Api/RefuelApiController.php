<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Refuel;
use App\Models\User;

class RefuelApiController extends Controller
{
    public function add(){
        request()->validate([
            'car_id' => 'required|integer|exists:cars,id',
            'liters' => 'required|numeric',
            'price' => 'required|numeric',
            'timestamp' => 'required|date',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $car = Car::find(request('car_id'));
        $amount = request('liters');
        $price = request('price');
        $timestamp = request('timestamp');
        $user = User::find(request('user_id'));

        $refuel = new Refuel();
        $refuel->liters = $amount;
        $refuel->cost = $price;
        $refuel->setCreatedAt($timestamp);
        $refuel->car()->associate($car);
        $refuel->user()->associate($user);
        $refuel->save();

        foreach ($car->drives()->where('refuel_id', '=', null)->get() as $drive) {
            $drive->refuel()->associate($refuel);
            $drive->save();
        }

        return ['message' => 'Refuel added successfully.',
            'refuel' => $refuel,
            'drives' => $refuel->drives()->get(),
        ];
    }
}
