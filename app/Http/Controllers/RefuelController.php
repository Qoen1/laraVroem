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

        return view('refuel.details',['refuel' => $refuel, 'drives' => $refuel->drives()->orderBy('created_at', 'desc')->get()]);
    }

    public function remove(){
        \request()->validate([
            'refuel_id' => 'required|exists:refuels,id',
            'drive_id' => 'required|exists:drives,id',
        ]);
        $refuel = Refuel::find(\request('refuel_id'));
        $drive = Drive::find(\request('drive_id'));

        if($drive->refuel_id === $refuel->id){
            $drive->refuel()->dissociate();
            $drive->save();
            return redirect()->back()->with('success', 'Drive removed from refuel');
        }
        return redirect()->back()->with('error', 'Drive is not part of this refuel');
    }

    public function add(){
        \request()->validate([
            'refuel_id' => 'required|exists:refuels,id',
            'drive_id' => 'required|exists:drives,id',
        ]);
        $refuel = Refuel::find(\request('refuel_id'));
        $drive = Drive::find(\request('drive_id'));

        if($drive->refuel_id === null){
            $drive->refuel()->associate($refuel);
            $drive->save();
            return redirect()->back()->with('success', 'Drive added to refuel');
        }
        return redirect()->back()->with('error', 'Drive already has a refuel');
    }
}
