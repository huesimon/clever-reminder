<?php

namespace App\View\Components;

use App\Models\Location;
use App\Models\Connector;
use Illuminate\View\Component;

class ChargeLocationItem extends Component
{
    public $location;
    public $available;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Location $location)
    {
        $this->location = $location;

        // dd($this->available);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        // dd($this->available->available_ccs_ultra);
        // dd($this->location->availability->available_iec_type_2_regular);
        return view('components.charge-location-item');
    }
}
