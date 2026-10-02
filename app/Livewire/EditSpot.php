<?php

namespace App\Livewire;

use App\Models\Spot;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

class EditSpot extends Component
{
    use WithFileUploads;

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

    // ▼ 新しい画像アップロード用
    public $image;

    // ▼ 追加項目（任意）
    public $business_hours;
    public $closed_days;
    public $phone;
    public $parking;
    public $website_url;

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

        // ▼ 追加項目の初期値
        $this->business_hours = $spot->business_hours;
        $this->closed_days = $spot->closed_days;
        $this->phone = $spot->phone;
        $this->parking = $spot->parking;
        $this->website_url = $spot->website_url;
    }

    public function update()
    {
        $this->validate();

        // ▼ 新しい画像がアップロードされた場合のみ更新
        if ($this->image) {
            $imagePath = $this->image->store('spots', 'public');
            $this->spot->image_path = $imagePath;
        }

        // ▼ テキスト項目を更新
        $this->spot->update([
            'name' => $this->name,
            'scene' => $this->scene,
            'area' => $this->area,
            'category' => $this->category,
            'address' => $this->address,
            'description' => $this->description,
            'image_path' => $this->spot->image_path,

            // ▼ 追加項目
            'business_hours' => $this->business_hours,
            'closed_days' => $this->closed_days,
            'phone' => $this->phone,
            'parking' => $this->parking,
            'website_url' => $this->website_url,
        ]);

        session()->flash('status', 'スポットを更新しました！');


        return $this->redirect('/spots', navigate: false);
    }

    public function delete()
    {
        $this->spot->delete();

        session()->flash('status', 'スポットを削除しました！');


        return $this->redirect('/spots', navigate: false);
    }

    public function render()
    {
        return view('livewire.edit-spot');
    }
}
