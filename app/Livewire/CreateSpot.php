<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Spot;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;

#[Title("スポット作成ページ")]
class CreateSpot extends Component
{
    #[Validate("required", message: "スポット名は必須です。")]
    #[Validate("min:3", message: "スポット名は3文字以上で入力してください。")]
    public $name = "";

    #[Validate("required", message: "カテゴリは必須です。")]
    public $category = "";

    #[Validate("required", message: "エリアは必須です。")]
    public $area = "";

    #[Validate("required", message: "住所は必須です。")]
    public $address = "";

    #[Validate("required", message: "説明は必須です。")]
    public $description = "";

    // ▼ 追加：利用シーン（scene）
    #[Validate("required", message: "利用シーンは必須です。")]
    public $scene = "";

    public function save()
    {
        $this->validate();

        Spot::create([
            'name' => $this->name,
            'category' => $this->category,
            'area' => $this->area,
            'address' => $this->address,
            'description' => $this->description,

            // ▼ 追加：scene を保存
            'scene' => $this->scene,
        ]);

        // ▼ reset に scene を追加
        $this->reset([
            'name',
            'category',
            'area',
            'address',
            'description',
            'scene',
        ]);

        session()->flash('status', 'スポットを登録しました！');

        return $this->redirect('/spots', navigate: true);
    }

    public function render()
    {
        return view('livewire.create-spot');
    }
}
