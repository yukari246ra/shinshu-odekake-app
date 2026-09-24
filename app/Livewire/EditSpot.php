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

    // ▼ 追加：新しい画像アップロード用
    #[Validate('image', message: '画像ファイルを選択してください。')]
    public $image;

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

        // ▼ 新しい画像がアップロードされた場合
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
            'image_path' => $this->spot->image_path, // 画像があれば更新
        ]);

        session()->flash('status', 'スポットを更新しました！');

        return $this->redirect('/spots', navigate: true);
    }

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
