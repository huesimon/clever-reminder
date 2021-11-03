<?php

namespace App\Console\Commands;

use App\Models\ChargePoint;
use App\Models\Connector;
use App\Models\Location;
use Facade\Ignition\DumpRecorder\Dump;
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
            // dd($location->openingHours->da);
            $newLocation = Location::create([
                'clever_id' => $location->id,
                'name' => $location->name,
                'line1' =>  $location->address->line1,
                'line2' =>  $location->address->line2,
                'lat' => $location->coordinates->lat,
                'long' => $location->coordinates->lng,
                'description' =>  $location?->description?->da ?? '',
                // 'image_url' =>  $location?->imageUrl,
                'image_url' =>  isset($location->imageUrl) ? $location->imageUrl : null,
                'is_future' => $location->isFuture,
                'is_open24' => $location->isOpen24,
                'is_remote_charging_supported' => $location->isRemoteChargingSupported,
                'is_roaming' => $location->isRoaming,
                'location_id' => $location->locationId,
                'opening_hours_dk' => $location->openingHours->da,
                'opening_hours_en' => $location->openingHours->en,
                'phone_number' => isset($location->phoneNumber) ? $location->phoneNumber : null
            ]);

            foreach ($location->chargePoints as $key => $chargePoint) {
                $newChargePoint = ChargePoint::make([
                    'clever_id' => $key,
                    'type' => $chargePoint->type,
                ]);
                $newChargePoint->location()->associate($newLocation);
                $newChargePoint->save();

                foreach ($chargePoint->connectors as $connector) {
                    $newConnector = Connector::make([
                        'connector_no' => $connector->connectorNo,
                        'clever_id' => $connector->id,
                        'kW' => $connector->kW,
                        'speed' => $connector->speed,
                        'type' => $connector->type,
                    ]);
                    $newConnector->chargePoint()->associate($newChargePoint);
                    $newConnector->save();
                    dump('saving connector');
                }

            }

        };


        // Store locations in db


        return 0;
    }
}
