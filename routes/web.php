<?php

use App\Http\Controllers\DashboardController;
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

Route::middleware(['auth'])->group(function(){
    Route::get('/email/verify', [EmailVerificationController::class, 'index'])->name('verification.notice');
    Route::post('/email/send-verification', [EmailVerificationController::class, 'store'])->name('verification.send');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Barangay Official Routes
    Route::middleware(['role:barangay-official'])->group(function() {
        Route::get('/dashboard/barangay-official', [DashboardController::class, 'barangayOfficial'])->name('dashboard.barangay-official');
    });

    // BHW Routes
    Route::middleware(['role:bhw'])->group(function() {
        Route::get('/dashboard/bhw', [DashboardController::class, 'bhw'])->name('dashboard.bhw');
    });

    // Doctor Routes
    Route::middleware(['role:doctor'])->group(function() {
        Route::get('/dashboard/doctor', [DashboardController::class, 'doctor'])->name('dashboard.doctor');
    });
});
