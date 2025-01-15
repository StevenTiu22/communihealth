<?php

use App\Http\Controllers\AuditTrailController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TBPredictionController;
use App\Http\Controllers\SchedulingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    });

    Route::prefix('audit-trail')->group(function () {
        Route::get('/', [AuditTrailController::class, 'index'])->name('audit-trail.index');
    });
});

Route::prefix('user-accounts')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user-accounts.index');
});

Route::prefix('patients')->group(function () {
    Route::get('/', [PatientController::class, 'index'])->name('patient-records.index');
});

Route::prefix('medicines')->group(function () {
    Route::get('/', [MedicineController::class, 'index'])->name('medicines.index');
});

Route::prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('profile');
});

Route::get('/scheduling', [SchedulingController::class, 'index'])->name('scheduling.index');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/appointments/schedule', App\Livewire\ScheduleAppointment::class)->name('appointments.schedule');
    Route::get('/appointments', App\Livewire\AppointmentList::class)->name('appointments.index');   
});

require_once __DIR__ . '/fortify.php';
