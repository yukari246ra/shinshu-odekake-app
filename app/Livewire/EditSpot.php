<?php

namespace App\Livewire;

use App\Models\Spot;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

class EditSpot extends Component
{
    use WithFileUploads;

    public Spot $spot;

    #[Validate('required|min:3')]
    public $name = '';

    public array $scenes = [];

    #[Validate('required')]
    public $area = '';

    #[Validate('required')]
    public $category = '';

    #[Validate('required')]
    public $address = '';

    #[Validate('required')]
    public $description = '';

    // ▼ 新しい画像アップロード用（1枚目）
    #[Validate("nullable|image|max:2048", message: "画像は2MB以内で選択してください。")]
    public $image;

    // ▼ 新しい画像アップロード用（2枚目）
    #[Validate("nullable|image|max:2048", message: "2枚目の画像は2MB以内で選択してください。")]
    public $image2;

    // ▼ 追加項目（任意）
    public $business_hours;
    public $closed_days;
    public $phone;
    public $parking;

    // ▼ 位置情報（任意・天気表示に使用）
    public $latitude = '';
    public $longitude = '';

    // ▼ 外部サイトリンク（任意）※XSS対策済み
    #[Validate('nullable|url:http,https', message: 'URLは http:// または https:// で始まる形式で入力してください。')]
    public $website_url;

    public function rules(): array
    {
        return [
            'scenes' => ['required', 'array', 'min:1'],
            'scenes.*' => ['string', Rule::in(Spot::SCENES)],
            'latitude' => ['nullable', 'numeric', 'between:-90,90', 'required_with:longitude'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180', 'required_with:latitude'],
        ];
    }

    public function messages(): array
    {
        return [
            'scenes.required' => '利用シーンは1つ以上選択してください。',
            'scenes.min' => '利用シーンは1つ以上選択してください。',
            'scenes.*.in' => '利用シーンの値が正しくありません。',
            'latitude.numeric' => '緯度は数値で入力してください。',
            'latitude.between' => '緯度は -90 から 90 の間で入力してください。',
            'latitude.required_with' => '緯度と経度は両方入力してください。',
            'longitude.numeric' => '経度は数値で入力してください。',
            'longitude.between' => '経度は -180 から 180 の間で入力してください。',
            'longitude.required_with' => '緯度と経度は両方入力してください。',
        ];
    }

    public function mount(Spot $spot)
    {
        // ▼ 認可②：管理者以外は編集ページを開けない
        abort_unless(auth()->user()->role === 'admin', 403);

        $this->spot = $spot;

        // 初期値セット
        $this->name = $spot->name;
        $this->scenes = $this->currentScenes($spot);
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

        // ▼ 位置情報の初期値（未登録なら空欄、登録済みなら 36.3419 のような表示にする）
        $this->latitude = filled($spot->latitude) ? (string) (float) $spot->latitude : '';
        $this->longitude = filled($spot->longitude) ? (string) (float) $spot->longitude : '';
    }

    public function update()
    {
        $this->validate();

        DB::transaction(function () {
            // ▼ 新しい画像がアップロードされた場合のみ更新
            if ($this->image) {
                $this->spot->image_path = $this->image->store('spots', 'public');
            }

            if ($this->image2) {
                $this->spot->image_path_2 = $this->image2->store('spots', 'public');
            }

            // ▼ テキスト項目を更新
            $this->spot->update([
                'name' => $this->name,
                'area' => $this->area,
                'category' => $this->category,
                'address' => $this->address,
                'description' => $this->description,
                'image_path' => $this->spot->image_path,
                'image_path_2' => $this->spot->image_path_2,

                // ▼ 追加項目
                'business_hours' => $this->business_hours,
                'closed_days' => $this->closed_days,
                'phone' => $this->phone,
                'parking' => $this->parking,
                'website_url' => $this->website_url,

                // ▼ 空欄のときは空文字ではなく null で保存する
                'latitude' => filled($this->latitude) ? $this->latitude : null,
                'longitude' => filled($this->longitude) ? $this->longitude : null,
            ]);

            // spots.scene は互換性のため変更しない
            $this->spot->syncScenes($this->scenes);
        });

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

    // scene_spot を優先し、未登録の既存データだけ spots.scene を初期表示する
    private function currentScenes(Spot $spot): array
    {
        $scenes = $spot->sceneSpots()->pluck('scene')->all();

        if ($scenes === [] && filled($spot->scene)) {
            $scenes = [$spot->scene];
        }

        return array_values(array_intersect(Spot::SCENES, $scenes));
    }
}