<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CheckChargerSpots extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clever:check.spots';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $availabilityResponse = collect(Http::get("https://clever-app-prod.firebaseio.com/chargers/v3/availability.json")->json());
        // dd($availabilityResponse);

        foreach ($availabilityResponse as $location) {
            $type = 'ccs';
            dd($location);
        }

        dd($availabilityResponse);

        return Command::SUCCESS;
    }
}
