<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Spot;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
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

    // ② 写真（1枚目）
    #[Validate("nullable|image|max:2048", message: "画像は2MB以内で選択してください。")]
    public $image;

    // ②-2 写真（2枚目・任意）
    #[Validate("nullable|image|max:2048", message: "2枚目の画像は2MB以内で選択してください。")]
    public $image2;

    // ③ 基本情報（住所／営業時間／定休日／電話番号）
    #[Validate("required", message: "住所は必須です。")]
    public $address = "";

    // 任意入力
    public $business_hours;
    public $closed_days;
    public $phone;

    // ④ 駐車場情報（任意）
    public $parking;

    // ⑤ 外部サイトリンク（任意）※XSS対策済み
    #[Validate('nullable|url:http,https', message: 'URLは http:// または https:// で始まる形式で入力してください。')]
    public $website_url;

    // ⑥ その他（カテゴリ・エリア・説明・利用シーン）※必須
    #[Validate("required", message: "カテゴリは必須です。")]
    public $category = "";

    #[Validate("required", message: "エリアは必須です。")]
    public $area = "";

    #[Validate("required", message: "説明は必須です。")]
    public $description = "";

    public array $scenes = [];

    public function rules(): array
    {
        return [
            'scenes' => ['required', 'array', 'min:1'],
            'scenes.*' => ['string', Rule::in(Spot::SCENES)],
        ];
    }

    public function messages(): array
    {
        return [
            'scenes.required' => '利用シーンは1つ以上選択してください。',
            'scenes.min' => '利用シーンは1つ以上選択してください。',
            'scenes.*.in' => '利用シーンの値が正しくありません。',
        ];
    }

    public function save()
    {
        $this->validate();

        // 画像保存
        $imagePath = $this->image
            ? $this->image->store('spots', 'public')
            : null;

        $imagePath2 = $this->image2
            ? $this->image2->store('spots', 'public')
            : null;

        $spot = DB::transaction(function () use ($imagePath, $imagePath2) {
            $spot = Spot::create([
                'name' => $this->name,
                'category' => $this->category,
                'area' => $this->area,
                'address' => $this->address,
                'description' => $this->description,

                'image_path' => $imagePath,
                'image_path_2' => $imagePath2,

                // 任意入力の追加項目
                'business_hours' => $this->business_hours,
                'closed_days' => $this->closed_days,
                'phone' => $this->phone,
                'parking' => $this->parking,
                'website_url' => $this->website_url,
            ]);

            $spot->syncScenes($this->scenes);

            return $spot;
        });

        // 入力欄リセット
        $this->reset([
            'name',
            'category',
            'area',
            'address',
            'description',
            'scenes',
            'image',
            'image2',
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