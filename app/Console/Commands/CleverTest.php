<?php

namespace App\Console\Commands;

use App\Models\Location;
use App\Models\LocationSubscriber;
use App\Models\User;
use App\Services\CleverService;
use Illuminate\Console\Command;

class CleverTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /** CleverService $cleverService */
    private $cleverService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CleverService $cleverService)
    {
        $this->cleverService = $cleverService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $allSubscribers = LocationSubscriber::all();
        $this->cleverService->getAvailability();
        
        foreach ($allSubscribers as $subscriber) {
            $available = $this->cleverService->getAvailableSlotsById($subscriber->location->clever_id, $subscriber->type);
            dump("There are currently $available spots left at " . $subscriber->location->name);
        }
        dd('');
        dd('test');


        $user = User::find(1);

        $location = Location::where('clever_id', 1253)->first();

        $locationSubscriber = LocationSubscriber::make(['type' => CleverService::CCS]);
        $locationSubscriber->location()->associate($location);
        $locationSubscriber->user()->associate($user);
        $locationSubscriber->save();


        dd($locationSubscriber);

        dd('done');
        $locationSubscribers = LocationSubscriber::all();

        foreach ($locationSubscribers as $subscriber) {
            dump($this->cleverService->getAvailableSlotsById($subscriber->location->clever_id, $subscriber->type));
        }
        return 0;
    }
}
