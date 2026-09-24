<div class="max-w-3xl mx-auto p-6">
    <flux:heading size="xl" level="1" class="mb-5">スポット作成ページ</flux:heading>

    @if (session('status'))
        <div class="mb-4 p-4 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 rounded">
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit="save" class="space-y-6">

        <!-- ▼ スポット名（最上部） -->
        <flux:input
            wire:model="name"
            label="スポット名"
            placeholder="例：安曇野ちひろ美術館"
        />
        @error('name')
            <flux:text class="text-red-600">{{ $message }}</flux:text>
        @enderror
        <!-- ▲ スポット名ここまで -->


        <!-- ▼ 利用シーン（①） -->
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
        @error('scene')
            <flux:text class="text-red-600">{{ $message }}</flux:text>
        @enderror
        <!-- ▲ 利用シーンここまで -->


        <!-- ▼ エリア（②） -->
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
        @error('area')
            <flux:text class="text-red-600">{{ $message }}</flux:text>
        @enderror
        <!-- ▲ エリアここまで -->


        <!-- ▼ カテゴリ（③） -->
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
        @error('category')
            <flux:text class="text-red-600">{{ $message }}</flux:text>
        @enderror
        <!-- ▲ カテゴリここまで -->


        <!-- ▼ 住所 -->
        <flux:input
            wire:model="address"
            label="住所"
            placeholder="例：長野県安曇野市…"
        />
        @error('address')
            <flux:text class="text-red-600">{{ $message }}</flux:text>
        @enderror


        <!-- ▼ 画像アップロード（追加） -->
        <flux:input
            type="file"
            wire:model="image"
            label="画像"
            accept="image/*"
        />
        @error('image')
            <flux:text class="text-red-600">{{ $message }}</flux:text>
        @enderror
        <!-- ▲ 画像アップロードここまで -->


        <!-- ▼ 説明 -->
        <flux:textarea
            wire:model="description"
            label="説明"
            rows="5"
            placeholder="スポットの説明を入力"
        />
        @error('description')
            <flux:text class="text-red-600">{{ $message }}</flux:text>
        @enderror


        <div class="flex justify-end">
            <flux:button type="submit" variant="primary">
                登録する
            </flux:button>
        </div>
    </form>
</div>
