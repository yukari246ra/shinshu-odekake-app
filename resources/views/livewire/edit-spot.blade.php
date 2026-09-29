<div class="max-w-3xl mx-auto p-6">
    <flux:heading size="xl" level="1" class="mb-5">スポット編集ページ</flux:heading>

    @if (session('status'))
        <div class="mb-4 p-4 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 rounded">
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit="update" class="space-y-6">

        <!-- ① スポット名 -->
        <flux:input
            wire:model="name"
            label="スポット名"
            placeholder="例：安曇野ちひろ美術館"
        />

        <!-- ② 写真（既存 → 新しい画像） -->
        @if ($spot->image_path)
            <div class="mt-4">
                <flux:text class="font-semibold">現在の画像</flux:text>
                <img
                    src="{{ asset('storage/' . $spot->image_path) }}"
                    alt="現在の画像"
                    class="w-48 h-48 object-cover rounded mt-2"
                >
            </div>
        @endif

        <flux:input
            type="file"
            wire:model="image"
            label="新しい画像（変更する場合のみ）"
            accept="image/*"
        />
        @error('image')
            <flux:text class="text-red-600">{{ $message }}</flux:text>
        @enderror

        <!-- ③ 基本情報 -->
        <flux:input
            wire:model="address"
            label="住所"
            placeholder="例：長野県安曇野市…"
        />

        <flux:input
            wire:model="business_hours"
            label="営業時間"
            placeholder="例：9:00〜17:00"
        />

        <flux:input
            wire:model="closed_days"
            label="定休日"
            placeholder="例：火曜日"
        />

        <flux:input
            wire:model="phone"
            label="電話番号"
            placeholder="例：0263-00-0000"
        />

        <!-- ④ 駐車場情報 -->
        <flux:input
            wire:model="parking"
            label="駐車場情報"
            placeholder="例：あり（50台）"
        />

        <!-- ⑤ 外部サイトリンク -->
        <flux:input
            wire:model="website_url"
            label="公式サイトURL"
            placeholder="例：https://example.com"
        />

        <!-- ⑥ その他（カテゴリ・エリア・説明・利用シーン） -->
        <flux:select
            wire:model="scene"
            label="利用シーン"
            placeholder="選択してください"
        >
            <option value="">選択してください</option>
            <option value="家族">家族</option>
            <option value="カップル">カップル</option>
            <option value="友達">友達</option>
            <option value="ひとり">ひとり</option>
        </flux:select>

        <flux:select
            wire:model="area"
            label="エリア"
            placeholder="選択してください"
        >
            <option value="">選択してください</option>
            <option value="北信">北信</option>
            <option value="中信">中信</option>
            <option value="東信">東信</option>
            <option value="南信">南信</option>
        </flux:select>

        <flux:select
            wire:model="category"
            label="カテゴリ"
            placeholder="選択してください"
        >
            <option value="">選択してください</option>
            <option value="レストラン">レストラン</option>
            <option value="カフェ">カフェ</option>
            <option value="公園">公園</option>
            <option value="観光地">観光地</option>
            <option value="ショッピング">ショッピング</option>
            <option value="温泉">温泉</option>
        </flux:select>

        <flux:textarea
            wire:model="description"
            label="説明"
            rows="5"
            placeholder="スポットの説明を入力"
        />

        <!-- ▼ ボタン（横並び3つ） -->
        <div class="flex justify-end items-center gap-2">
            <flux:button href="{{ route('spots') }}" wire:navigate>
                キャンセル
            </flux:button>

            <flux:button type="submit" variant="primary">
                更新する
            </flux:button>

            <form method="POST" action="{{ route('spots.delete', $spot->id) }}">
                @csrf
                @method('DELETE')

                <flux:button
                    wire:click="delete"
                    variant="danger"
                    onclick="return confirm('本当に削除しますか？');"
                >
                    削除する
                </flux:button>
            </form>
        </div>
    </form>
</div>
