<?php

namespace App\Http\Livewire;

use App\Models\Location;
use Livewire\Component;

class CleverSubscription extends Component
{
    public $search;

    public function render()
    {
        return view('livewire.clever-subscription', [
            'locations' => Location::where('name', 'like', '%' . $this->search . '%')->get(),
        ]);
    }

    public function save(Location $location)
    {

    }
}
