<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home route
Route::get('/', function () {
    return view('welcome');
});

// Dashboard (auth + verified)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes (only when logged in)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Breeze/Jetstream authentication routes
require __DIR__.'/auth.php';

// Students CRUD routes (only when logged in)
Route::middleware(['auth'])->group(function () {
    Route::resource('students', StudentController::class);
});


//classes task 
Route::resource('classes', ClassController::class)->middleware('auth');
