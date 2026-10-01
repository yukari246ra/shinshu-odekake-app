<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Spot;

class SpotList extends Component
{
    public $search = '';
    public $scene = '';
    public $area = '';
    public $category = '';

    public function render()
    {
        $spots = Spot::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                      ->orWhere('description', 'like', "%{$this->search}%")
                      ->orWhere('address', 'like', "%{$this->search}%")
                      ->orWhere('scene', 'like', "%{$this->search}%")
                      ->orWhere('area', 'like', "%{$this->search}%")
                      ->orWhere('category', 'like', "%{$this->search}%");
                });
            })
            ->when($this->scene !== '', fn($q) => $q->where('scene', $this->scene))
            ->when($this->area !== '', fn($q) => $q->where('area', $this->area))
            ->when($this->category !== '', fn($q) => $q->where('category', $this->category))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.spot-list', [
            'spots' => $spots,
        ]);
    }
}