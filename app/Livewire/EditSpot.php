<?php

namespace App\Livewire;

use App\Models\Spot;
use Livewire\Component;
use Livewire\Attributes\Validate;

class EditSpot extends Component
{
    public Spot $spot;

    #[Validate('required|min:3')]
    public $name = '';

    #[Validate('required')]
    public $scene = '';

    #[Validate('required')]
    public $area = '';

    #[Validate('required')]
    public $category = '';

    #[Validate('required')]
    public $address = '';

    #[Validate('required')]
    public $description = '';

    public function mount(Spot $spot)
    {
        $this->spot = $spot;

        // 初期値セット
        $this->name = $spot->name;
        $this->scene = $spot->scene;
        $this->area = $spot->area;
        $this->category = $spot->category;
        $this->address = $spot->address;
        $this->description = $spot->description;
    }

    public function update()
    {
        $this->validate();

        $this->spot->update([
            'name' => $this->name,
            'scene' => $this->scene,
            'area' => $this->area,
            'category' => $this->category,
            'address' => $this->address,
            'description' => $this->description,
        ]);

        session()->flash('status', 'スポットを更新しました！');

        return $this->redirect('/spots', navigate: true);
    }

    // ★★★ ここを追加 ★★★
    public function delete()
    {
        $this->spot->delete();

        session()->flash('status', 'スポットを削除しました！');

        return $this->redirect('/spots', navigate: true);
    }

    public function render()
    {
        return view('livewire.edit-spot');
    }
}
