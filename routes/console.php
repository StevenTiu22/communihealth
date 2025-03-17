<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Jobs\UpdateTBArimaModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::job(new UpdateTBArimaModel)
    ->monthlyOn(1, '01:00')
    ->timezone('Asia/Manila')
    ->name('update-tb-arima-model')
    ->withoutOverlapping()
    ->onFailure(function () {
        Log::error('Failed to update TB ARIMA model');
    })
    ->onSuccess(function () {
        Log::info('Successfully updated TB ARIMA model');
    });
