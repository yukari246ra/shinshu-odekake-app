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

    // ① 名前（必須）
    #[Validate("required", message: "スポット名は必須です。")]
    #[Validate("min:3", message: "スポット名は3文字以上で入力してください。")]
    public $name = "";

    // ② 写真（必須ではないが画像チェックあり）
    #[Validate("image", message: "画像ファイルを選択してください。")]
    public $image;

    // ③ 基本情報（住所／営業時間／定休日／電話番号）
    #[Validate("required", message: "住所は必須です。")]
    public $address = "";

    // 任意入力
    public $business_hours;
    public $closed_days;
    public $phone;

    // ④ 駐車場情報（任意）
    public $parking;

    // ⑤ 外部サイトリンク（任意）
    public $website_url;

    // ⑥ その他（カテゴリ・エリア・説明・利用シーン）※必須
    #[Validate("required", message: "カテゴリは必須です。")]
    public $category = "";

    #[Validate("required", message: "エリアは必須です。")]
    public $area = "";

    #[Validate("required", message: "説明は必須です。")]
    public $description = "";

    #[Validate("required", message: "利用シーンは必須です。")]
    public $scene = "";

    public function save()
    {
        $this->validate();

        // 画像保存
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

            'image_path' => $imagePath,

            // 任意入力の追加項目
            'business_hours' => $this->business_hours,
            'closed_days' => $this->closed_days,
            'phone' => $this->phone,
            'parking' => $this->parking,
            'website_url' => $this->website_url,
        ]);

        // 入力欄リセット
        $this->reset([
            'name',
            'category',
            'area',
            'address',
            'description',
            'scene',
            'image',
            'business_hours',
            'closed_days',
            'phone',
            'parking',
            'website_url',
        ]);

        session()->flash('status', 'スポットを登録しました！');

        return $this->redirect('/spots', navigate: true);
    }

    public function render()
    {
        return view('livewire.create-spot');
    }
}
