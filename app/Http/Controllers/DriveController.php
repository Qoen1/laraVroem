<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Drive;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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

        return redirect()->back()->with('success', 'Drive created');
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

    public static function json()
    {
        date_default_timezone_set('UTC');

// Get the current year and month
        $currentYear = date('Y');
        $currentMonth = date('m');

// Calculate the year and month two years ago
        $twoYearsAgoYear = $currentYear - 2;
        $twoYearsAgoMonth = $currentMonth;

// Initialize an empty array to store the months
        $monthsArray = [];

// Loop through the months starting from two years ago until the current month
        while ($twoYearsAgoYear < $currentYear || ($twoYearsAgoYear == $currentYear && $twoYearsAgoMonth <= $currentMonth)) {
            // Format the year and month
            $formattedMonth = sprintf('%02d', $twoYearsAgoMonth);
            $formattedYearMonth = $twoYearsAgoYear . '-' . $formattedMonth;

            // Add the formatted year and month to the array
            $monthsArray[] = $formattedYearMonth;

            // Move to the next month
            $twoYearsAgoMonth++;
            if ($twoYearsAgoMonth > 12) {
                $twoYearsAgoMonth = 1;
                $twoYearsAgoYear++;
            }
        }

        $drives = auth()->user()->drives;


        $final = [];

        foreach ($monthsArray as $month) {
            $temp = array_values($drives->where(function ($query) use ($month) {
                return (new \DateTime($query->created_at))->format('Y-m') === $month;
            })->toArray());

            array_push($final, [
                'month' => $month,
                'value' => $temp,
            ]);
        }

//        $drives = $drives->groupBy(function ($record) {
//            return Carbon::parse($record->created_at)->format('Y-m') ===;
//        })->toArray();
//        $keys = array_keys($drives);
//        $values = array_values($drives);
//        $drives = array_map(function ($key, $value) {
//            return [
//                'month' => $key,
//                'value' => $value,
//            ];
//        }, $keys, $values);
//        ddd((new Collection($final))->pluck('value')->toArray());
//        ddd($final);

        return $final;
    }
}
