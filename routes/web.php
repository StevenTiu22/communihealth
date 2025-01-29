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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Barangay Official Routes
    Route::middleware('role:barangay-official')->prefix('barangay-official')->group(function() {
        Route::get('/dashboard', [DashboardController::class, 'barangayOfficial'])->name('barangay-official.dashboard');
        Route::get('/users', [UserController::class, 'index'])->name('barangay-official.users');
        Route::get('/patients', [PatientController::class, 'index'])->name('barangay-official.patients');
        Route::get('/medicines', [MedicineController::class, 'index'])->name('barangay-official.medicines');
        Route::get('/schedules', [ScheduleController::class, 'index'])->name('barangay-official.schedules');
        Route::get('/audit-trail', [AuditTrailController::class, 'index'])->name('barangay-official.audit-trail');
        Route::get('/tb-prediction', [TbPredictionController::class, 'index'])->name('barangay-official.tb-prediction');
        Route::get('/disease-demographics', [DiseaseDemographicsController::class, 'index'])->name('barangay-official.disease-demographics');
        Route::get('/health-records', [HealthRecordController::class, 'index'])->name('barangay-official.health-records');
    });

    // BHW Routes
    Route::middleware('role:bhw')->prefix('bhw')->group(function() {
        Route::get('/dashboard', [DashboardController::class, 'bhw'])->name('bhw.dashboard');
        Route::get('/patients', [PatientController::class, 'index'])->name('bhw.patients');
        Route::get('/medicines', [MedicineController::class, 'index'])->name('bhw.medicines');
        Route::get('/schedules', [ScheduleController::class, 'index'])->name('bhw.schedules');
        Route::get('tb-prediction', [TbPredictionController::class, 'index'])->name('bhw.tb-prediction');
        Route::get('/disease-demographics', [DiseaseDemographicsController::class, 'index'])->name('bhw.disease-demographics');
        Route::get('/health-records', [HealthRecordController::class, 'index'])->name('bhw.health-records');
    });

    // Doctor Routes
    Route::middleware('role:doctor')->prefix('doctor')->group(function() {
        Route::get('/dashboard', [DashboardController::class, 'doctor'])->name('doctor.dashboard');
        Route::get('/patients', [PatientController::class, 'index'])->name('doctor.patients');
        Route::get('/medicines', [MedicineController::class, 'index'])->name('doctor.medicines');
        Route::get('/schedules', [ScheduleController::class, 'index'])->name('doctor.schedules');
        Route::get('/tb-prediction', [TbPredictionController::class, 'index'])->name('doctor.tb-prediction');
        Route::get('/disease-demographics', [DiseaseDemographicsController::class, 'index'])->name('doctor.disease-demographics');
        Route::get('/health-records', [HealthRecordController::class, 'index'])->name('doctor.health-records');
    });
});
