<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Spot;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

#[Title("スポット作成ページ")]
class CreateSpot extends Component
{
    use WithFileUploads;

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

    #[Validate("required", message: "利用シーンは必須です。")]
    public $scene = "";

    // ▼ 追加：画像アップロード
    #[Validate("image", message: "画像ファイルを選択してください。")]
    public $image;

    public function save()
    {
        $this->validate();

        // ▼ 画像保存（storage/app/public/spots）
        $imagePath = $this->image
            ? $this->image->store('spots', 'public')
            : null;

        Spot::create([
            'name' => $this->name,
            'category' => $this->category,
            'area' => $this->area,
            'address' => $this->address,
            'description' => $this->description,
            'scene' => $this->scene,

            // ▼ 追加：画像パス保存
            'image_path' => $imagePath,
        ]);

        $this->reset([
            'name',
            'category',
            'area',
            'address',
            'description',
            'scene',
            'image',
        ]);

        session()->flash('status', 'スポットを登録しました！');

        return $this->redirect('/spots', navigate: true);
    }

    public function render()
    {
        return view('livewire.create-spot');
    }
}
