<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Drive;
use App\Models\Refuel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RefuelApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return auth()->user()->refuels;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        request()->validate([
            'car_id' => 'required|integer|exists:cars,id',
            'liters' => 'required|numeric|between:0,99999999999999999999',
            'price' => 'required|numeric|between:0,99999999999999999999',
            'beginOdometer' => 'numeric|between:0,99999999999999999999',
            'endOdometer' => 'numeric|gt:beginOdometer|between:0,99999999999999999999',
        ]);

        $user = auth()->user();
        $car = $user->cars()->find(request('car_id'));
        $amount = request('liters');
        $timestamp = Carbon::now();
        $price = request('price');
        $beginOdometer = request('beginOdometer');
        $endOdometer = request('endOdometer');

        if($car === null){
            abort(403);
        }

        $drive = new Drive();
        $drive->begin_odometer = $beginOdometer;
        $drive->end_odometer = $endOdometer;
        $drive->setCreatedAt($timestamp);
        $drive->car()->associate($car);
        $drive->user()->associate($user);
        $drive->save();

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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $refuels = Refuel::with(['drives.user', 'user', 'car'])
            ->where('user_id', '=', auth()->user()->id)
            ->find($id);

        if($refuels == null){
            abort(404);
        }
        return $refuels;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
