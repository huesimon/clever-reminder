<?php

namespace App\Listeners;

use App\Events\MoreSpotsAvailable;
use App\Models\Availability;
use App\Models\Connector;
use App\Models\Location;
use App\Models\LocationSubscriber;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendMoreSpotsAvailableNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(MoreSpotsAvailable $event)
    {

        $plugType = Connector::getPlugType($event->plugType);
        $locationSubscribers = LocationSubscriber::where('location_id', $event->available->location->id)
            ->where('type', $plugType)->get();

    }
}
