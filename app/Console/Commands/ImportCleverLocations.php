<?php

namespace App\Console\Commands;

use App\Models\ChargePoint;
use App\Models\Connector;
use App\Models\Location;
use Facade\Ignition\DumpRecorder\Dump;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        Log::info("Import started: " . now()->format('Y-m-d H:i:s'));
        // Http call to clever and get locations

        $locationResponse = Http::get("https://clever-app-prod.firebaseio.com/chargers/v3/locations.json");
        $originalLocations = Location::all()->count();
        $originalChargePoints = ChargePoint::all()->count();
        $originalConnectors = Connector::all()->count();

        foreach($locationResponse->object() as $location) {
            $newLocation = Location::updateOrCreate(
                [
                    'clever_id' => $location->id,
                ],
                [
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

            if ($newLocation->wasChanged()) {
                Log::info("location $location->name was updated");
            }

            foreach ($location->chargePoints as $key => $chargePoint) {
                $newChargePoint = ChargePoint::firstOrNew([
                    'clever_id' => $key,
                ], [
                    'type' => $chargePoint->type,
                ]);
                $newChargePoint->update([
                    'type' => $chargePoint->type,
                ]);
                $newChargePoint->location()->associate($newLocation);

                if ($newChargePoint->wasChanged()) {
                    Log::info("chargepoint  $newChargePoint->clever_id was updated");
                }
                $newChargePoint->save();

                foreach ($chargePoint->connectors as $connector) {
                    $newConnector = Connector::firstOrNew([
                        'clever_id' => $connector->id,
                    ], [
                        'connector_no' => $connector->connectorNo,
                        'kW' => $connector->kW,
                        'speed' => $connector->speed,
                        'type' => $connector->type,
                    ]);
                    $newConnector->update([
                        'connector_no' => $connector->connectorNo,
                        'kW' => $connector->kW,
                        'speed' => $connector->speed,
                        'type' => $connector->type,
                    ]);
                    $newConnector->chargePoint()->associate($newChargePoint);
                    if ($newConnector->wasChanged()) {
                        Log::info("connector  $newConnector->clever_id was updated");
                    }

                    $newConnector->save();
                }

            }

        };


        $newLocations = Location::all()->count();
        $newChargePoints = ChargePoint::all()->count();
        $newConnectors = Connector::all()->count();

        if ($newLocations > $originalLocations) {
            Log::info("new locations: ". $newLocations - $originalLocations);
        }
        if ($newChargePoints > $originalChargePoints) {
            Log::info("new chargepoints: " . $newChargePoints - $originalChargePoints);
        }
        if ($newConnectors > $originalConnectors) {
            Log::info("new connectors: " . $newConnectors - $originalConnectors);
        }

        Log::info("Import stopped: " . now()->format('Y-m-d H:i:s'));


        return Command::SUCCESS;
    }
}
