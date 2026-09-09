<?php

namespace App\Livewire;

use App\Models\Spot;
use Livewire\Component;

class ShowSpot extends Component
{
    public Spot $spot;

    public function mount(Spot $spot){
        $this->spot = $spot;
    }

    public function render()
    {
        return view('livewire.show-spot')->title($this->spot->title);
    }
}
