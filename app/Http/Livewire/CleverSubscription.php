<?php

namespace App\Http\Livewire;

use App\Models\Connector;
use App\Models\Location;
use App\Models\LocationSubscriber;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class CleverSubscription extends Component
{
    public $search;
    public $plugType = null;
    // public $location;
    public $connectorTypes = Connector::TYPES;

    public function render()
    {
        // dd(Location::where('name', 'like', '%' . $this->search . '%')->with(['chargepoints', 'connectors'])->get()->first());
        return view('livewire.clever-subscription', [
            // 'locations' => Location::where('name', 'like', '%' . $this->search . '%')->with(['chargepoints', 'connectors'])->get(),
            'locations' =>
            Location::where('name', 'like', '%' . $this->search . '%')
            ->whereHas('connectors', function($query) {
                if($this->plugType) {
                    $query->where('connectors.type', $this->plugType);
                }
            })->get(),
        ]);
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
