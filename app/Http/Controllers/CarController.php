<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarUser;
use App\Models\Refuel;
use App\Models\User;
use App\Rules\Ownership;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('car.index', ['cars' => auth()->user()->cars()->orderBy('created_at', 'desc')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('car.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'license_plate' => 'required|string',
        ]);

        $name = $request['name'];
        $license_plate = $request['license_plate'];
        $user = auth()->user();

        $car = new Car();
        $car->name = $name;
        $car->license_plate = $license_plate;
        $car->save();

        $user->cars()->attach($car, ['activated_at' => now()]);

        return redirect()->route('cars')->with('success', 'Car created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $carId)
    {
        if(Car::where('id', '=', $carId)->count() === 0){
            abort(404);
        }else if(\request()->user()->cars()->where('id', '=', $carId)->count() === 0){
            abort(403);
        }

        $car = Car::find($carId);
        $refuels = $car->refuels()->orderBy('created_at', 'desc')->get();
        $drives = $car->drives()->where('refuel_id', '=', null)->orderBy('created_at', 'desc')->get();

        return view('car.details',[
            'refuels' => $refuels,
            'car' => $car,
            'drives' => $drives,
            'graph' => $this->drivesPerUserGraph($car),
        ]);
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
        //TODO: delete car
    }

    public function share(int $id){
//        ddd($id);
        validator(\request()->route()->parameters())->validate([
            'id' => 'required|exists:cars,id',
        ]);
        return view('car.share', ['car' => $id]);
    }

    public function  createInvite(){
        \request()->validate([
            'invitee' => 'required|email|exists:users,email',
            'car_id' => 'required|exists:cars,id',
        ]);
        //TODO: check if the user is not yet assigned to the car

        //TODO:create invite
        $car = Car::find(\request('car_id'));
        $user = User::where('email', \request('invitee'))->first();
        $car->users()->attach($user, ['activated_at' => null]);
        $car->save();

        return redirect('dashboard')->with('success', 'Invite sent successfully.');
    }

    public function manage(int $id){
        $car = Car::find($id);
        $refuels = $car->refuels()->orderBy('created_at', 'desc')->get();
        $drives = $car->drives()->where('refuel_id', '=', null)->orderBy('created_at', 'desc')->get();

//        ddd($this->drivesPerUserGraph($car));

        return view('car.manage',[
            'refuels' => $refuels,
            'car' => $car,
            'drives' => $drives,
            'graph' => $this->drivesPerUserGraph($car),
            'users' => $car->users,
        ]);
    }

    public function  acceptInvite(){
        \request()->validate([
            'car_id' => 'required|exists:cars,id',
        ]);
        $car = Car::find(\request('car_id'));
        $user = auth()->user();

        if($user->cars()->where('id', $car->id)->exists()){
            return redirect()->route('cars')->with('error', 'You cannot decline an invite for a car you are already a member of.');
        }else{
            $user->carInvites()->updateExistingPivot($car, ['activated_at' => now()]);
            $user->save();
        }
        return redirect('dashboard')->with('success', 'Invite accepted successfully.');

    }

    public function  declineInvite(){
        \request()->validate([
            'car_id' => 'required|exists:cars,id',
        ]);
        $car = Car::find(\request('car_id'));
        $user = auth()->user();
        if($user->cars()->where('id', $car->id)->exists()){
            return redirect()->route('cars')->with('error', 'You cannot decline an invite for a car you are already a member of.');
        }else{
            $user->carInvites()->detach($car);
            $user->save();
        }
        return redirect('dashboard')->with('success', 'Invite declined successfully.');
    }

    public function removeUser(){
        //TODO: remove user from car and figure out what to do with his drives and refuels. note: the user cannot delete himself

    }

    private function drivesPerUserGraph(Car $car){
        $drivesPerUser = $car->drivesPerUser();

        $currentYear = date('Y');
        $currentMonth = date('m');

        $twoYearsAgoYear = $currentYear - 2;
        $twoYearsAgoMonth = $currentMonth;

        $monthsArray = [];

        while ($twoYearsAgoYear < $currentYear || ($twoYearsAgoYear == $currentYear && $twoYearsAgoMonth <= $currentMonth)) {
            $formattedMonth = sprintf('%02d', $twoYearsAgoMonth);
            $formattedYearMonth = $twoYearsAgoYear . '-' . $formattedMonth;

            $monthsArray[] = $formattedYearMonth;

            $twoYearsAgoMonth++;
            if ($twoYearsAgoMonth > 12) {
                $twoYearsAgoMonth = 1;
                $twoYearsAgoYear++;
            }
        }

        foreach ($monthsArray as $month) {
            $record = [
                'month' => $month,
                'users' => [],
            ];
            foreach ($drivesPerUser as $user) {
                $distance = 0;

                foreach ($user['drives'] as $drive) {
                    if($drive->created_at->format('Y-m') == $month){
                        $distance += $drive->distance();
                    }
                }

                $record['users'][] = [
                    'id' => $user['user']->id,
                    'name' => $user['user']->name,
                    'kilometers' => $distance,
                ];
            }
            $final[] = $record;
        }

        return $final;
    }
}
