<?php

use App\Http\Controllers\Api\CarsApiController;
use App\Http\Controllers\Api\DriveApiController;
use App\Http\Controllers\Api\RefuelApiController;
use App\Models\Car;
use App\Models\Drive;
use App\Models\User;
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
Route::middleware('auth:sanctum')->group(function (){
    Route::get('/drives', [DriveApiController::class, 'index']);
    Route::get('/drives/{id}', [DriveApiController::class, 'show']);
    Route::post('/drives', [DriveApiController::class, 'store']);

    Route::get('/refuels', [RefuelApiController::class, 'index']);
    Route::get('/refuels/{id}', [RefuelApiController::class, 'show']);
    Route::post('/refuels', [RefuelApiController::class, 'store']);

    Route::get('/cars', [CarsApiController::class, 'index']);
    Route::get('/cars/{id}', [CarsApiController::class, 'show']);
    Route::post('/cars', [CarsApiController::class, 'store']);
});
