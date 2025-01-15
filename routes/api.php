<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
=======
>>>>>>> 6e27fc8f819ab12cb9a87b13b18e6246c488fc80

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
<<<<<<< HEAD

Route::post('admin/user-accounts/', [RegisteredUserController::class, 'store'])->name('user-accounts.store');
=======
>>>>>>> 6e27fc8f819ab12cb9a87b13b18e6246c488fc80
