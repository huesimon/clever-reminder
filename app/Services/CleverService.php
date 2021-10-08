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

    private $availabilityResponse;

    private $locationResponse;

    public function getLocations() : Object
    {
        $this->locationResponse =  Http::get("https://clever-app-prod.firebaseio.com/chargers/v3/locations.json")->object();
        return $this->locationResponse;
    }

    public function getAvailability() : array
    {
        $this->availabilityResponse =  Http::get("https://clever-app-prod.firebaseio.com/chargers/v3/availability.json")->json();
        return $this->availabilityResponse;
    }

    public function getChargePointById($id)
    {
       return $this->availabilityResponse[$id];
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
