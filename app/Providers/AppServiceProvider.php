<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        Gate::define('barangay-official', function(User $user) {
            return $user->hasRole('barangay-official');
        });

        Gate::define('bhw', function(User $user) {
            return $user->hasRole('bhw');
        });

        Gate::define('doctor', function(User $user) {
            return $user->hasRole('doctor');
        });
    }
}
