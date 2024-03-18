<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Drive;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DriveApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return auth()->user()->drives;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        //TODO: fix
        request()->validate([
            'car_id' => 'required|exists:cars,id',
            'beginOdometer' => 'numeric|between:0,99999999999999999999',
            'endOdometer' => 'numeric|gt:beginOdometer|between:0,99999999999999999999'
        ]);

        $user = auth()->user();
        $car = $user->cars()->find(request('car_id'));
        $beginOdometer = request('beginOdometer');
        $endOdometer = request('endOdometer');

        if($car === null){
            abort(403);
        }

        $drive = new Drive();
        $drive->begin_odometer = $beginOdometer;
        $drive->end_odometer = $endOdometer;
        $drive->setCreatedAt(Carbon::now());
        $drive->car()->associate($car);
        $drive->user()->associate($user);
        $drive->save();

        return ['message' => 'Drive added successfully.',
            'drive' => $drive,
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $drive = Drive::with('car')
            ->where('user_id', '=', auth()->user()->id)
            ->find($id);

        if($drive == null){
            abort(404);
        }
        return $drive;
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
