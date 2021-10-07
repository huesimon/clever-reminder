<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CleverService
{
    const TYPE2 = 'iec_type_2';
    const CHADEMO = 'chademo';
    const CCS = 'ccs';
    const AVAILABLE = 'available';
    const FUNCTIONAL = 'functional';
    CONST TOTAL = 'total';



    public function getLocations() : Object
    {
        return Http::get("https://clever-app-prod.firebaseio.com/chargers/v3/locations.json")->object();
    }

    public function getAvailability() : array
    {
        return Http::get("https://clever-app-prod.firebaseio.com/chargers/v3/availability.json")->json();
    }

    public function getChargePointById($id)
    {
       $availabilityResponse = $this->getAvailability();

       return $availabilityResponse[$id];
    }

    public function getAvailableSlotsById($id, $type)
    {
        $chargePoint = $this->getChargePointById($id);
        $availableSlots =  0;

        foreach($chargePoint[self::AVAILABLE][$type] as $amount) {
            $availableSlots += $amount;
        }

        return $availableSlots;
    }

    public function getRemainingSlotsById($id, $type)
    {
        $chargePoint = $this->getChargePointById($id);

        $total = 0;
        foreach($chargePoint[self::TOTAL][$type] as $amount) {
            $total += $amount;
        }
        $totalAvailable = 0;
        foreach($chargePoint[self::AVAILABLE][$type] as $amount) {
            $totalAvailable += $amount;
        }

        return $total - $totalAvailable;
    }


}
