<?php

namespace App\Http\Livewire;

use App\Models\Location;
use App\Models\LocationSubscriber;
use Livewire\Component;

class CleverSubscription extends Component
{
    public $search;
    public $plugType;
    public $location;

    public function render()
    {
        return view('livewire.clever-subscription', [
            'locations' => Location::where('name', 'like', '%' . $this->search . '%')->with(['chargepoints', 'connectors'])->get(),
        ]);
    }

    public function save(Location $location)
    {
        $locationSub = LocationSubscriber::create([
            'location_id' => $location->id,
            'user_id' => auth()->user()->id,
            'type' => $this->plugType,
        ]);
        dd($locationSub);
    }
}
