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
    public function create(int $id)
    {
        $car = Car::find($id);
        return view('drive.create',['previous_endOdometer' => $car->drives()->orderByDesc('created_at')->first()->end_odometer, 'car' => $car]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'car' => 'required|exists:cars,id',
            'begin' => 'numeric|between:0,99999999999999999999',
            'end' => 'numeric|gt:begin|between:0,99999999999999999999',
        ]);
        //save in variables
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

        return redirect('/drives')->with('success', 'Drive created');
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
