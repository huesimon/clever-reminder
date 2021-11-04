<?php

namespace App\Console\Commands;

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
        $availabilityResponse = collect(Http::get("https://clever-app-prod.firebaseio.com/chargers/v3/availability.json")->json());
        // dd($availabilityResponse);

        foreach ($availabilityResponse as $locationId => $available) {
            $type = 'ccs';
            // dd($key);
            // Location::findOrFail(123123213213);
            try {
                Location::findByOrFail('clever_id', $locationId);
            } catch (\Throwable $th) {
                continue;
            }
            $newAvailable = Availability::firstOrNew([
                'location_id' => $locationId,
            ], [
                $this->getDataArray($available),
            ]);
            // dd($locationId);
            $newAvailable->fill($this->getDataArray($available));
            $newAvailable->location()->associate($locationId);
            // $originals = $newAvailable->getOriginal();

            // dd(
            //     $newAvailable->wasChanged(),
            //     $newAvailable->getDirty(),
            // );
            // dd($newAvailable->id, $newAvailable->getDirty());
            if ($newAvailable->id) {
                foreach ($newAvailable->getDirty() as $key => $newestValue) {
                    if ($key == 'location_id') {
                        continue;
                    }
                    // dd($key, $value, $originals[$key]);
                    // dd($newAvailable->getDirty(), $newAvailable->getOriginal('available_chademo_fast'));

                    // dump($value, $key);
                    // dd($newestValue, $key, $newAvailable->getOriginal($key));
                    if ($newestValue > $newAvailable->getOriginal($key)) {
                        dump("New value $newestValue for $key is higher than original value " . $newAvailable->getOriginal($key));
                        // dump('**************', $newAvailable->getOriginal($key), "*********************");
                        // dd('');
                    } else {
                        dump("New value $newestValue for $key is lower than original value " . $newAvailable->getOriginal($key));
                    }
                }
            }


            try {
                // dd($newAvailable->location);
                $newAvailable->save();
            } catch (\Exception $e) {
                // throw $e;
                Log::info($e->getMessage());
                dd($newAvailable, "this failed");
                // continue;
            }
        }

        return Command::SUCCESS;
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
