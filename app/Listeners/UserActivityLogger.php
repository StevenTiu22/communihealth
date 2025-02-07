<?php

namespace App\Listeners;

use App\Events\UserActivityEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserActivityLogger
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserActivityEvent $event): void
    {
        activity()
            ->causedBy($event->causer_id)
            ->withProperties([
                'action' => $event->action,
                'data' => $event->data,
                'timestamp' => $event->timestamp,
            ])
            ->log($event->action);
    }
}
