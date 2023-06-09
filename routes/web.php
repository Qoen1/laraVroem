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
    return view('dashboard', ['cars' => auth()->user()->cars]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('refuels', RefuelController::class)->name('index','refuels');
    Route::resource('cars', CarController::class)->name('index','cars');

    Route::get('/drives/create/{id}', [DriveController::class, 'create'])->name('drives.create');
    Route::get('/drives', [DriveController::class, 'index'])->name('drives');
    Route::post('/drives', [DriveController::class, 'store'])->name('drives.store');
});

require __DIR__.'/auth.php';
