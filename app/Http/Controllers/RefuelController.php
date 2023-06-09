<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Drive;
use App\Models\Refuel;
use Illuminate\Http\Request;

class RefuelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all = Refuel::all()->sortByDesc('created_at');

        $refuels = [];

        foreach ($all as $refuel) {
            $found = false;
            foreach($refuel->drives as $drive){
                if ($drive->user->id === auth()->user()->id) {
                    $found = true;
                }
            }
            if($found){
                $refuels[] = $refuel;
            }
        }

        return view('refuel.index', ['refuels' => $refuels]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(int $id)
    {
        $car = Car::find($id);
        return view('refuel.create', ['previous_endOdometer' => $car->drives()->orderByDesc('created_at')->first()->end_odometer, 'car' => $car]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'car' => 'required|exists:cars,id',
            'liters' => 'required|numeric|between:0,9999.99',
            'cost' => 'required|numeric|between:0,9999.99',
            'begin' => 'numeric|between:0,99999999999999999999',
            'end' => 'numeric|gt:begin|between:0,99999999999999999999',
        ]);
        //save in variables
        $car = Car::find($request['car']);
        $liters = $request['liters'];
        $cost = $request['cost'];
        $user = auth()->user();
        $car = Car::find($request['car']);
        $begin = $request['begin'];
        $end = $request['end'];
        $driver = auth()->user();

        //create drive
        $drive = new Drive();
        $drive->begin_odometer = $begin;
        $drive->end_odometer = $end;
        $drive->car()->associate($car);
        $drive->user()->associate($driver);
        $drive->save();

        //create refuel
        $drives = $car->drives()->where('refuel_id', '=', null)->get();
        $refuel = new Refuel();
        $refuel->car()->associate($car);
        $refuel->user()->associate($user);
        $refuel->liters = $liters;
        $refuel->cost = $cost;
        $refuel->save();
        foreach ($drives as $drive) {
            $drive->refuel()->associate($refuel);
            $drive->save();
        }

        return redirect()->back()->with('success', 'Refuel added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $refuel = Refuel::find($id);

        return view('refuel.details',['refuel' => $refuel, 'drives' => $refuel->drives]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
