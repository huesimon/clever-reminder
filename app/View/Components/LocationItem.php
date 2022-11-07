<?php

namespace App\View\Components;

use App\Models\Location;
use Illuminate\View\Component;

class LocationItem extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public Location $location)
    {
    }

    public function save2()
    {
        dd('asdadsd');
        $this->location->subscribers()->create([
            'user_id' => auth()->id(),
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.location-item');
    }
}
