<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Spot;

class ShowSpots extends Component
{
    public function render()
    {
        return view('livewire.show-spots', [
            'spots' => Spot::all(),
        ]);
    }
}
