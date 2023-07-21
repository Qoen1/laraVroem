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
    return view('dashboard', [
        'cars' => auth()->user()->cars,
        'drives' => DriveController::json(),
        'invites' => auth()->user()->carInvites,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('cars', CarController::class)->names(['index' => 'cars.index', 'create' => 'cars.create', 'show' => 'cars.show']);
    Route::get('/cars/{id}/share', [CarController::class, 'share'])->name('cars.share');
    Route::post('/cars/share', [CarController::class, 'createInvite'])->name('cars.createInvite');
    Route::post('/cars/acceptInvite', [CarController::class, 'acceptInvite'])->name('cars.acceptInvite');
    Route::post('/cars/declineInvite', [CarController::class, 'declineInvite'])->name('cars.declineInvite');
    Route::get('/cars/{id}/manage', [CarController::class, 'manage'])->name('cars.manage');

    Route::get('/drives/create/{id}', [DriveController::class, 'create'])->name('drives.create');
    Route::get('/drives', [DriveController::class, 'index'])->name('drives.index');
    Route::post('/drives', [DriveController::class, 'store'])->name('drives.store');

    Route::get('/refuels/create/{id}', [RefuelController::class, 'create'])->name('refuels.create');
    Route::post('/refuels', [RefuelController::class, 'store'])->name('refuels.store');
    Route::get('/refuels', [RefuelController::class, 'index'])->name('refuels.index');
    Route::get('/refuels/{id}', [RefuelController::class, 'show'])->name('refuels.show');
    Route::post('/refuels/addDrive', [RefuelController::class, 'add'])->name('refuels.addDrive');
    Route::post('/refuels/removeDrive', [RefuelController::class, 'remove'])->name('refuels.removeDrive');
    Route::get('/refuels/{id}/manage', [RefuelController::class, 'manage'])->name('refuels.manage');
});

require __DIR__.'/auth.php';
