<?php

namespace App\Console\Commands;

use App\Events\LessSpotsAvailable;
use App\Events\MoreSpotsAvailable;
use App\Models\Availability;
use App\Models\Location;
use Facade\Ignition\DumpRecorder\Dump;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        Log::info("Availability search started: " . now()->format('Y-m-d H:i:s'));
        $availabilityResponse = collect(Http::get("https://clever-app-prod.firebaseio.com/chargers/v3/availability.json")->json());
        // $availabilityResponse = collect(Http::get("http://127.0.0.1:8000/a.json")->json());
        foreach ($availabilityResponse as $cleverLocationId => $available) {
            try {
                $foundLocation = Location::findByOrFail('clever_id', $cleverLocationId);
            } catch (\Throwable $th) {
                // Some locations are not found in locations.json from clever
                continue;
            }
            $newAvailable = Availability::firstOrNew([
                'location_id' => $cleverLocationId,
            ], $this->getDataArray($available));

            $newAvailable->fill($this->getDataArray($available));
            $newAvailable->location()->associate($cleverLocationId);

            if ($newAvailable->id) {
                foreach ($newAvailable->getDirty() as $plugType => $newestValue) {
                    if ($newestValue > $newAvailable->getOriginal($plugType)) {
                        $this->debug($newAvailable, 'more');
                        event(new MoreSpotsAvailable($newAvailable, $plugType));

                        // Log::info("New value $newestValue for $plugType is higher than original value " . $newAvailable->getOriginal($plugType));
                    } else {
                        $this->debug($newAvailable, 'less');
                        event(new LessSpotsAvailable($newAvailable, $plugType));
                        // Log::info("New value $newestValue for $plugType is lower than original value " . $newAvailable->getOriginal($plugType));
                    }
                }
            }
            // This block is needed because some locations are not in the locations.json
            // Not sure if there is an easier way to fix this
            try {
                $newAvailable->save();
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }
        Log::info("Availability search stopped: " . now()->format('Y-m-d H:i:s'));
        return Command::SUCCESS;
    }

    private function debug($newAvailable, $moreOrLess)
    {
        $debugLocations = collect(
            [
                ['id' => 1297],
                ['id' => 1253],
                ['id' => 1272]
            ]);
        if ($debugLocations->firstWhere('id', $newAvailable->location_id)) {
            Log::debug(json_encode(
                [
                    'value' => $moreOrLess,
                    $newAvailable->getDirty(),
                    'original' => $newAvailable->getOriginal(),
                ]
            ));
        }
    }
    private function getDataArray($available) {
        return [
            'available_ccs_fast' => $available['available']['ccs']['fast'],
            'available_ccs_ultra' => $available['available']['ccs']['ultra'],
            'available_chademo_fast' => $available['available']['chademo']['fast'],
            'available_chademo_ultra' => $available['available']['chademo']['ultra'],
            'available_iec_type_2_fast' => $available['available']['iec_type_2']['fast'],
            'available_iec_type_2_regular' =>  $available['available']['iec_type_2']['regular'],

            'functional_ccs_fast' => $available['functional']['ccs']['fast'],
            'functional_ccs_ultra' => $available['functional']['ccs']['ultra'],
            'functional_chademo_fast' => $available['functional']['chademo']['fast'],
            'functional_chademo_ultra' => $available['functional']['chademo']['ultra'],
            'functional_iec_type_2_fast' => $available['functional']['iec_type_2']['fast'],
            'functional_iec_type_2_regular' =>  $available['functional']['iec_type_2']['regular'],

            'total_ccs_fast' => $available['total']['ccs']['fast'],
            'total_ccs_ultra' => $available['total']['ccs']['ultra'],
            'total_chademo_fast' => $available['total']['chademo']['fast'],
            'total_chademo_ultra' => $available['total']['chademo']['ultra'],
            'total_iec_type_2_fast' => $available['total']['iec_type_2']['fast'],
            'total_iec_type_2_regular' =>  $available['total']['iec_type_2']['regular'],
        ];
    }

}
