<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Location;
use Livewire\WithPagination;

class LocationSearch extends Component
{
    use WithPagination;
    public $search;
    // public $locations;
    public $myChargepoints = false;
    protected $paginationTheme = 'tailwind';
    public function render()
    {
        if ($this->myChargepoints) {
            $locations = auth()->user()->locations()->where('name', 'like', '%' . $this->search . '%')->paginate(4);
        } else {
            $locations = Location::where('name', 'like', '%' . $this->search . '%')->paginate(9);
        }
        return view('livewire.location-search', [
            'locations' => $locations,
        ]);
    }
}
