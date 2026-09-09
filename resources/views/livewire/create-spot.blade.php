<div class="max-w-3xl mx-auto p-6">
    <flux:heading size="xl" level="1" class="mb-5">スポット作成ページ</flux:heading>

    @if (session('status'))
        <div class="mb-4 p-4 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 rounded">
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit="save" class="space-y-6">

        <flux:input
            wire:model="name"
            label="スポット名"
            placeholder="例：安曇野ちひろ美術館"
        />

        <flux:input
            wire:model="category"
            label="カテゴリ"
            placeholder="例：美術館・博物館"
        />

        <flux:input
            wire:model="area"
            label="エリア"
            placeholder="例：安曇野市"
        />

        <flux:input
            wire:model="address"
            label="住所"
            placeholder="例：長野県安曇野市…"
        />

        <flux:textarea
            wire:model="description"
            label="説明"
            rows="5"
            placeholder="スポットの説明を入力"
        />

        <div class="flex justify-end">
            <flux:button type="submit" variant="primary">
                登録する
            </flux:button>
        </div>
    </form>
</div>
