<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CarController as AdminCarController;
use App\Http\Controllers\CarController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profiel routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin auto-beheer (vervangt alle 6 de losse car-routes in 1 keer)
    // ->names('admin.cars') koppelt 'admin.cars.' voor de routenamen, zodat je in de view via route bijv:('admin.cars.index')
    Route::resource("/admin/cars", AdminCarController:: class)->names("admin.cars");
});

// Publieke routes voor bezoekers (alleen index en show)
Route::resource("cars", CarController:: class)->only([ "index", "show" ])->names("cars");


require __DIR__.'/auth.php';
