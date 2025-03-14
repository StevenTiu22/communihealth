<?php

use App\Http\Controllers\AuditTrailController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiseaseDemographicsController;
use App\Http\Controllers\HealthRecordController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\MedicineTransactionController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\SchedulesController;
use App\Http\Controllers\TbPredictionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

$authMiddleware = [
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
];

// Shared Routes
Route::middleware([...$authMiddleware, 'role:barangay-official|bhw|doctor'])
    ->group(function () {
        Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
        Route::get('/health-records', [HealthRecordController::class, 'index'])->name('health-records.index');
        Route::get('/medicine-transactions', [MedicineTransactionController::class, 'index'])->name('medicine-transactions.index');
        Route::get('/medicines', [MedicineController::class, 'index'])->name('medicines.index');
        Route::get('/schedules', [SchedulesController::class, 'index'])->name('schedules.index');
        Route::post('/schedules', [SchedulesController::class, 'index'])->name('schedules.complete');
        Route::get('/disease-demographics', [DiseaseDemographicsController::class, 'index'])->name('disease-demographics.index');
        Route::get('/tb-prediction', [TbPredictionController::class, 'index'])->name('tb-prediction.index');
    });

// Barangay Official Routes
Route::middleware([...$authMiddleware, 'role:barangay-official'])
    ->prefix('barangay-official')
    ->group(function() {
        Route::get('/audit-trail', [AuditTrailController::class, 'index'])->name('audit-trail.index');
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
    });
