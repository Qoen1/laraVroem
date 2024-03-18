<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class CarsApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return auth()->user()->cars;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'licensePlate' => 'required|string'
        ]);

        $car = new Car();
        $car->name = $request['name'];
        $car->license_plate = $request['licensePlate'];
        $car->users()->attach(auth()->user());
        $car->save();

        return $car;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cars = Car::with(['drives', 'refuels', 'users'])
            ->where('user_id', '=', auth()->user()->id)
            ->find($id);

        if($cars == null){
            abort(404);
        }
        return $cars;
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
