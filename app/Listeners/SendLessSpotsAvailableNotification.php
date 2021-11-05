<?php

namespace App\Listeners;

use App\Events\LessSpotsAvailable;
use App\Models\Availability;
use App\Models\Connector;
use App\Models\LocationSubscriber;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendLessSpotsAvailableNotification
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
    public function handle(LessSpotsAvailable $event)
    {
        $plugType = Connector::getPlugType($event->plugType);
        $locationSubscribers = LocationSubscriber::where('location_id', $event->available->location->id)
            ->where('type', $plugType)->get();

        foreach ($locationSubscribers as $locationSubscriber) {
            dump($locationSubscriber->user->email);
        }

    }
}
