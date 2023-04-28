<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Drive;
use Illuminate\Http\Request;

class DriveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drives = request()->user()->drives()->orderBy('created_at', 'desc')->get();
        return view('drive.index', ['drives' => $drives]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('drive.create', ['cars' => request()->user()->cars]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'car' => 'required|exists:cars,id',
            'begin' => 'numeric',
            'end' => 'required|numeric',
        ]);
        //save in variables
        $car = Car::find($request['car']);
        $begin = $request['begin'];
        $end = $request['end'];
        $driver = auth()->user();

        //validate begin and end
        if($begin > $end){
            return redirect()->back()->withErrors(['begin' => 'Begin must be smaller than end']);
        }

        //create drive
        $drive = new Drive();
        //if the $begin > 0, set begin_odometer to $begin. otherwise set begin_odometer to the last drive's end_odometer
        if($begin > 0){
            $drive->begin_odometer = $begin;
        } else {
            $lastDrive = $car->drives()->orderBy('created_at', 'desc')->first();
            if($lastDrive){
                $drive->begin_odometer = $lastDrive->end_odometer;
            } else {
                $drive->begin_odometer = 0;
            }
        }
        $drive->end_odometer = $end;
        $drive->car()->associate($car);
        $drive->user()->associate($driver);
        $drive->save();

        redirect()->action([DriveController::class, 'index'])->with('success', 'Drive created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
