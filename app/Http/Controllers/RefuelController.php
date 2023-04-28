<?php

namespace App\Http\Controllers;

use App\Models\Car;
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
    public function create()
    {
        $cars = auth()->user()->cars;
        return view('refuel.create', ['cars' => $cars]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'car' => 'required|exists:cars,id',
            'liters' => 'required|numeric',
            'cost' => 'required|numeric',
        ]);

        $car = Car::find($request['car']);
        $liters = $request['liters'];
        $cost = $request['cost'];
        $user = auth()->user();

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

        return redirect()->action([RefuelController::class, 'show'], ['refuel' => $refuel, 'drives' => $refuel->drives])->with('success', 'Refuel added successfully');
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
