<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\MailController;



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
// Email verification route (public)
Route::get('/students/verify/{token}', [StudentController::class, 'verify'])->name('students.verify');

//classes task 
Route::resource('classes', ClassController::class)->middleware('auth');


//mail task

//Route::get('/send-mail', [MailController::class, 'sendMail']);
Route::get('/send-mail', function () {
    \Illuminate\Support\Facades\Mail::to('sidra@codekernal.com')
        ->send(new \App\Mail\WelcomeMail());
    return "Mail sent!";
});
