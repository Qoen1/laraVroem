<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\DriveController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RefuelController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard', ['cars' => auth()->user()->cars, 'drives' => DriveController::json()]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('cars', CarController::class)->names(['index' => 'cars', 'create' => 'cars.create', 'show' => 'cars.show']);

    Route::get('/drives/create/{car}', [DriveController::class, 'create'])->name('drives.create');
    Route::get('/drives', [DriveController::class, 'index'])->name('drives.index');
    Route::post('/drives', [DriveController::class, 'store'])->name('drives.store');

    Route::get('/refuels/create/{car}', [RefuelController::class, 'create'])->name('refuels.create');
    Route::post('/refuels', [RefuelController::class, 'store'])->name('refuels.store');
    Route::get('/refuels', [RefuelController::class, 'index'])->name('refuels.index');
    Route::get('/refuels/{refuel}', [RefuelController::class, 'show'])->name('refuels.show');
    Route::post('/refuels/addDrive', [RefuelController::class, 'add'])->name('refuels.addDrive');
    Route::post('/refuels/removeDrive', [RefuelController::class, 'remove'])->name('refuels.removeDrive');
});

require __DIR__.'/auth.php';
