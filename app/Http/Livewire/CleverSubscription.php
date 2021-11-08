<?php

namespace App\Http\Livewire;

use App\Models\ChargePoint;
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
        $locations = Location::where(function ($query) {
                $query->where('line1', 'like', '%' . $this->search . '%')
                    ->orWhere('name', 'like', '%' . $this->search . '%')
                    ->orWhere('line2', 'like', '%' . $this->search . '%');
                })
                ->with(['connectors', 'availability',])
                ->whereHas('connectors', function ($query) {
                    if ($this->plugType) {
                        $query->where('connectors.type', $this->plugType);
                    }
                })->get();
        return view('livewire.clever-subscription', [
            'locations' =>
            $locations
        ]);
    }
}
