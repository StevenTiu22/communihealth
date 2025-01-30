<?php

namespace App\Listeners;

use Carbon\Carbon;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogVerification
{
    /**
     * Handle the event.
     */
    public function handle(Verified $event): void
    {
        if ($event->user instanceof MustVerifyEmail) {
            $act = activity()
                ->causedBy($event->user)
                ->withProperties([
                    'old' => ['email_verified_at' => null],
                    'attributes' => ['email_verified_at' => Carbon::now()]
                ])
                ->event('updated')
                ->useLog('Successful Email Verification')
                ->log("User {$event->user->id} has verified their email address.");

            Log::info($act);
        }
    }
}
