<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Registered;
use App\Mail\WelcomeNewUser;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;

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
        Event::listen(Registered::class, function ($event) {
            Mail::to($event->user->email)->send(new WelcomeNewUser($event->user));
        });
    }
}
