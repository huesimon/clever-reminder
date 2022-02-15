<?php

namespace App\Providers;

use App\Models\Location;
use App\Events\LessSpotsAvailable;
use App\Events\MoreSpotsAvailable;
use App\Observers\LocationObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        LessSpotsAvailable::class => [
            \App\Listeners\SendLessSpotsAvailableNotification::class,
        ],
        MoreSpotsAvailable::class => [
            \App\Listeners\SendMoreSpotsAvailableNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Location::observe(LocationObserver::class);
    }
}
