<div class="max-w-3xl mx-auto p-6 space-y-8">

    {{-- ▼ ページタイトル（ジャンプ率：h1） --}}
    <h1 class="text-2xl md:text-3xl font-bold text-heading mb-6">
        スポット編集ページ
    </h1>

    {{-- ▼ フラッシュメッセージ --}}
    @if (session('status'))
        <div class="p-4 bg-slate-100 dark:bg-slate-800 text-heading rounded border border-subtle mb-6">
            {{ session('status') }}
        </div>
    @endif

    {{-- ▼ 編集フォーム --}}
    <form wire:submit="update" class="space-y-6">

        {{-- ① スポット名 --}}
        <flux:input
            wire:model="name"
            label="スポット名"
            placeholder="例：安曇野ちひろ美術館"
        />

        {{-- ② 既存画像 --}}
        @if ($spot->image_path)
            <div class="mt-4">
                <flux:text class="text-sm font-medium text-heading">現在の画像</flux:text>
                <img
                    src="{{ asset('storage/' . $spot->image_path) }}"
                    alt="現在の画像"
                    class="w-48 h-48 object-cover rounded-lg mt-2"
                >
            </div>
        @endif

        {{-- 新しい画像 --}}
        <flux:input
            type="file"
            wire:model="image"
            label="新しい画像（変更する場合のみ）"
            accept="image/*"
        />
        @error('image')
            <flux:text class="text-red-600">{{ $message }}</flux:text>
        @enderror

        {{-- 2枚目の画像 --}}
        @if ($spot->image_path_2)
            <div class="mt-4">
                <flux:text class="text-sm font-medium text-heading">現在の2枚目の画像</flux:text>
                <img
                    src="{{ asset('storage/' . $spot->image_path_2) }}"
                    alt="現在の2枚目の画像"
                    class="w-48 h-48 object-cover rounded-lg mt-2"
                >
            </div>
        @endif

        <flux:input
            type="file"
            wire:model="image2"
            label="2枚目の画像（追加・変更する場合のみ）"
            accept="image/*"
        />
        @error('image2')
            <flux:text class="text-red-600">{{ $message }}</flux:text>
        @enderror

        {{-- ③ 基本情報 --}}
        <flux:input wire:model="address" label="住所" placeholder="例：長野県安曇野市…" />

        {{-- ③-2 位置情報（任意・天気表示に使用） --}}
        <div class="space-y-3">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <flux:input
                    type="number"
                    step="any"
                    wire:model="latitude"
                    label="緯度（任意）"
                    placeholder="例：36.3419"
                />
                <flux:input
                    type="number"
                    step="any"
                    wire:model="longitude"
                    label="経度（任意）"
                    placeholder="例：137.9013"
                />
            </div>
            <flux:text class="text-sm">
                天気予報の表示に使います。Googleマップでスポットの場所を右クリックし、表示された数字（例：36.3419, 137.9013）をクリックしてコピーします。カンマの前が緯度、後ろが経度です。
            </flux:text>
            @error('latitude')
                <flux:text class="text-red-600">{{ $message }}</flux:text>
            @enderror
            @error('longitude')
                <flux:text class="text-red-600">{{ $message }}</flux:text>
            @enderror
        </div>

        <flux:input wire:model="business_hours" label="営業時間" placeholder="例：9:00〜17:00" />
        <flux:input wire:model="closed_days" label="定休日" placeholder="例：火曜日" />
        <flux:input wire:model="phone" label="電話番号" placeholder="例：0263-00-0000" />

        {{-- ④ 駐車場情報 --}}
        <flux:input wire:model="parking" label="駐車場情報" placeholder="例：あり（50台）" />

        {{-- ⑤ 外部サイト --}}
        <flux:input wire:model="website_url" label="公式サイトURL" placeholder="例：https://example.com" />

        {{-- ⑥ 利用シーン（複数選択） --}}
        <div class="space-y-2">
            <span class="text-sm font-medium text-heading">利用シーン</span>
            <div class="flex flex-wrap gap-x-6 gap-y-2">
                @foreach (\App\Models\Spot::SCENES as $sceneOption)
                    <label class="inline-flex items-center gap-2 text-sm text-heading">
                        <flux:checkbox wire:model="scenes" :value="$sceneOption" />
                        {{ $sceneOption }}
                    </label>
                @endforeach
            </div>
        </div>
        @error('scenes')
            <flux:text class="text-red-600">{{ $message }}</flux:text>
        @enderror
        @foreach ($errors->get('scenes.*') as $sceneErrors)
            @foreach ($sceneErrors as $message)
                <flux:text class="text-red-600">{{ $message }}</flux:text>
            @endforeach
        @endforeach

        <flux:select wire:model="area" label="エリア" placeholder="選択してください">
            <option value="">選択してください</option>
            <option value="北信">北信</option>
            <option value="中信">中信</option>
            <option value="東信">東信</option>
            <option value="南信">南信</option>
        </flux:select>

        <flux:select wire:model="category" label="カテゴリ" placeholder="選択してください">
            <option value="">選択してください</option>
            <option value="レストラン">レストラン</option>
            <option value="カフェ">カフェ</option>
            <option value="公園">公園</option>
            <option value="観光地">観光地</option>
            <option value="ショッピング">ショッピング</option>
            <option value="温泉">温泉</option>
        </flux:select>

        {{-- 説明 --}}
        <flux:textarea
            wire:model="description"
            label="説明"
            rows="5"
            placeholder="スポットの説明を入力"
        />

        {{-- ▼ ボタン（横並び） --}}
        <div class="flex justify-end items-center gap-3">

            {{-- キャンセル --}}
            <flux:button
                href="{{ route('spots') }}"
                wire:navigate
                class="h-10 rounded-lg ui-button--subtle"
            >
                キャンセル
            </flux:button>

            {{-- 更新 --}}
            <flux:button
                type="submit"
                variant="primary"
                class="h-10 rounded-lg"
            >
                更新する
            </flux:button>

            {{-- 削除 --}}
            <flux:button
                type="button"
                wire:click="delete"
                wire:confirm="本当に削除しますか？"
                variant="danger"
                class="h-10 rounded-lg"
            >
                削除する
            </flux:button>

        </div>

    </form>
</div>