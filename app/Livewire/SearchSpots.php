<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Spot;

class SearchSpots extends Component
{
    public $scene = '';
    public $area = '';
    public $category = '';
    public $results = [];

    public function search()
    {
        $query = Spot::query();

        if ($this->scene !== '') {
            $query->where('scene', $this->scene);
        }

        if ($this->area !== '') {
            $query->where('area', $this->area);
        }

        if ($this->category !== '') {
            $query->where('category', $this->category);
        }

        $this->results = $query->get();
    }

    public function render()
    {
        return view('livewire.search-spots');
    }
}
