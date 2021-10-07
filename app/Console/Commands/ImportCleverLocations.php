<?php

namespace App\Console\Commands;

use App\Models\Location;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportCleverLocations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:clever.locations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import clever locations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Http call to clever and get locations

        $locationResponse = Http::get("https://clever-app-prod.firebaseio.com/chargers/v3/locations.json");
        $availabilityResponse = Http::get("https://clever-app-prod.firebaseio.com/chargers/v3/availability.json")->json();

        foreach($locationResponse->object() as $location) {

            $newLocation = Location::create([
                'clever_id' => $location->id,
                'name' => $location->name,
            ]);
            dump($newLocation);
        };


        // Store locations in db


        return 0;
    }
}
