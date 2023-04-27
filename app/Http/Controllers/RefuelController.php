<?php

namespace App\Http\Controllers;

use App\Models\Refuel;
use Illuminate\Http\Request;

class RefuelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all = Refuel::all();

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
