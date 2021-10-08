<?php

namespace App\Jobs;

use App\Models\LocationSubscriber;
use App\Notifications\ChargePointSpotsAvailable;
use App\Services\CleverService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckChargePointSubscriptions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(CleverService $cleverService)
    {
        $allSubscribers = LocationSubscriber::all();
        $cleverService->getAvailability();
        
        foreach ($allSubscribers as $subscriber) {
            $available = $cleverService->getAvailableSlotsById($subscriber->location->clever_id, $subscriber->type);
            $subscriber->user->notify(new ChargePointSpotsAvailable($available, $subscriber->location->name));
        }
    }
}
