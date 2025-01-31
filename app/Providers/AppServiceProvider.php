<?php

namespace App\Providers;

use App\Listeners\LogVerifiedUser;
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
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->view('emails.verify-email', ['url' => $url])
                ->mailer('mailgun')
                ->subject('Verify Email Address')
                ->line("Welcome to " . config('app.name') . "!")
                ->line('Please click the button below to verify your email address.')
                ->action('Verify Email Address', $url)
                ->line('If you did not create an account, no further action is required.')
                ->line('If you’re having trouble clicking the "Verify Email Address" button, copy and paste the URL below into your web browser: ' . $url);
        });
    }
}
