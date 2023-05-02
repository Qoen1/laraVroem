<?php

use App\Http\Controllers\Api\DriveApiController;
use App\Http\Controllers\Api\RefuelApiController;
use App\Models\Car;
use App\Models\Drive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->group(function (){
    Route::middleware('role:admin')->group(function (){
        Route::get('/cars', function (){
            return Car::all();
        });
        Route::post('/addDrive', [DriveApiController::class, 'add']);
        Route::post('/addRefuel', [RefuelApiController::class, 'add']);
    });
});
