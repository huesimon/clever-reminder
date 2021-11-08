<?php

namespace App\Http\Livewire;

use App\Models\Location;
use App\Models\LocationSubscriber;
use Livewire\Component;

class ChargeLocationItem extends Component
{
    public $location;
    public $plugType;

    public function render()
    {
        return view('livewire.charge-location-item');
    }

    public function save(Location $location)
    {
        $locationSub = LocationSubscriber::updateOrCreate([
            'location_id' => $location->id,
            'user_id' => auth()->user()->id,
            'type' => $this->plugType,
        ]);
    }
    public function delete(Location $location)
    {
        $locationSub = LocationSubscriber::where([
            'location_id' => $location->id,
            'user_id' => auth()->user()->id,
            'type' => $this->plugType,
        ])->first();

        $locationSub->delete();
    }
}
