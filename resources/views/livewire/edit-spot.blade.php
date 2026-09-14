<div class="max-w-3xl mx-auto p-6">
    <flux:heading size="xl" level="1" class="mb-5">スポット編集ページ</flux:heading>

    @if (session('status'))
        <div class="mb-4 p-4 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 rounded">
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit="update" class="space-y-6">

        <!-- ▼ スポット名 -->
        <flux:input
            wire:model="name"
            label="スポット名"
            placeholder="例：安曇野ちひろ美術館"
        />

        <!-- ▼ 利用シーン -->
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

        <!-- ▼ エリア -->
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

        <!-- ▼ カテゴリ -->
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

        <!-- ▼ 住所 -->
        <flux:input
            wire:model="address"
            label="住所"
            placeholder="例：長野県安曇野市…"
        />

        <!-- ▼ 説明 -->
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

            <!-- ▼ 削除ボタン（Flux UIで形を揃える） -->
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
