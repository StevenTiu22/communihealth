<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Mail\VerifyMail;
use App\Notifications\VerifyEmailNotification;
use Carbon\Carbon;
use http\Client\Curl\User;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\EmailVerificationNotificationSentResponse;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Responses\VerifyEmailResponse;

class FortifyServiceProvider extends ServiceProvider
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
        // Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // Login & Logout
        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::authenticateUsing(function (Request $request) {
            $user = \App\Models\User::where('email', $request->email)
                ->orWhere('username', $request->email)
                ->first();

            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            }

            return null;
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(1000)->by($throttleKey);
        });

        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request): Response|RedirectResponse|JsonResponse
            {
                $path = route('disease-demographics.index');

                activity()
                    ->causedBy($request->user())
                    ->useLog('Successful Login')
                    ->log("User {$request->user()->username} has logged in.");

                return $request->wantsJson()
                    ? response()->json(['two_factor' => false])
                    : redirect()->intended($path);
            }
        });

        // Email Verification...
        Fortify::verifyEmailView(function () {
            return view('auth.verify-email');
        });

        $this->app->instance(EmailVerificationNotificationSentResponse::class, new class implements EmailVerificationNotificationSentResponse {
            public function toResponse($request): Response|RedirectResponse
            {
                activity()
                    ->causedBy($request->user())
                    ->useLog('Email Verification Notification Sent')
                    ->log("User {$request->user()->username} has requested an email verification link.");

                return $request->wantsJson()
                    ? response('', 204)
                    : back()->with('status', 'verification-link-sent');
            }
        });

        $this->app->instance(\Laravel\Fortify\Contracts\VerifyEmailResponse::class, new class implements \Laravel\Fortify\Contracts\VerifyEmailResponse {
            public function toResponse($request): Response|RedirectResponse
            {
                activity()
                    ->causedBy($request->user())
                    ->withProperties([
                        'old' => ['email_verified_at' => null],
                        'attributes' => ['email_verified_at' => Carbon::now()]
                    ])
                    ->useLog('Successful Email Verification')
                    ->log("User {$request->user()->id} has verified their email address.");

                return $request->wantsJson()
                    ? response('', 204)
                    : redirect()->intended(config('fortify.home') . '?verified=1');
            }
        });

        RateLimiter::for('verification', function (Request $request) {
            return Limit::perMinute(3)->by($request->user()->id ?: $request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
