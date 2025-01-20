<?php

namespace App\Providers;

use App\Models\Store;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Gate::define('user-store', function (User $user) {
            return $user->store !== null;
        });

        Gate::define('owner-store', function (User $user, Store $store) {
            if ($user->store === null) {
                return false;
            }
            return $user->store->id === $store->id;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url') . "/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}
