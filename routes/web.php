<?php

use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\MedicineController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/patients', [PatientController::class, 'index'])->name('patients');
Route::get('/users', [UserController::class, 'index'])->name('users');
Route::get('/medicines', [MedicineController::class, 'index'])->name('medicines');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function(){
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth'])->group(function(){
   Route::get('/email/verify', function(){
         return view('auth.verify-email');
    })->name('verification.notice');

   Route::post('/email/send-verification', [EmailVerificationController::class, 'store'])->name('verification.send');
});
