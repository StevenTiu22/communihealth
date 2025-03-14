<?php

namespace App\Providers;

use App\Events\UserActivityEvent;
use App\Listeners\LogVerifiedUser;
use App\Listeners\UserActivityLogger;
use Carbon\Carbon;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(UserActivityEvent::class, UserActivityLogger::class);
    }
}
