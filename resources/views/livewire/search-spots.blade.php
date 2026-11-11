<div class="max-w-6xl mx-auto p-6 space-y-8">

    {{-- ▼ ページタイトル（h1） --}}
    <h1 class="text-2xl md:text-3xl font-bold text-heading flex items-center gap-2">
        <flux:icon name="magnifying-glass" class="w-6 h-6 text-accent" />
        絞り込み検索
    </h1>

    {{-- ▼ 検索フォーム（1枚のカードにまとめる） --}}
    <div class="border border-subtle rounded-lg p-6 shadow-sm bg-white dark:bg-zinc-800 space-y-6">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- 利用シーン --}}
            <div class="space-y-2">
                <label class="text-sm font-medium text-heading flex items-center gap-2">
                    <flux:icon name="sparkles" class="w-4 h-4" />
                    利用シーン
                </label>
                <flux:select wire:model.live="scene">
                    <option value="">指定しない</option>
                    <option value="家族">家族</option>
                    <option value="カップル">カップル</option>
                    <option value="友達">友達</option>
                    <option value="ひとり">ひとり</option>
                </flux:select>
            </div>

            {{-- エリア --}}
            <div class="space-y-2">
                <label class="text-sm font-medium text-heading flex items-center gap-2">
                    <flux:icon name="map-pin" class="w-4 h-4" />
                    エリア
                </label>
                <flux:select wire:model.live="area">
                    <option value="">指定しない</option>
                    <option value="北信">北信</option>
                    <option value="中信">中信</option>
                    <option value="東信">東信</option>
                    <option value="南信">南信</option>
                </flux:select>
            </div>

            {{-- カテゴリ --}}
            <div class="space-y-2">
                <label class="text-sm font-medium text-heading flex items-center gap-2">
                    <flux:icon name="tag" class="w-4 h-4" />
                    カテゴリ
                </label>
                <flux:select wire:model.live="category">
                    <option value="">指定しない</option>
                    <option value="レストラン">レストラン</option>
                    <option value="カフェ">カフェ</option>
                    <option value="公園">公園</option>
                    <option value="観光地">観光地</option>
                    <option value="ショッピング">ショッピング</option>
                    <option value="温泉">温泉</option>
                </flux:select>
            </div>

        </div>

        {{-- ▼ 件数とクリアボタン --}}
        <div class="flex items-center justify-between">
            <p class="text-sm text-heading">
                @if ($hasFilter)
                    {{ $results->count() }} 件のスポットが見つかりました
                @else
                    条件を選ぶと、ここに結果が表示されます
                @endif
            </p>

            <flux:button
                wire:click="resetFilters"
                class="h-10 rounded-lg ui-button--subtle"
            >
                条件をクリア
            </flux:button>
        </div>

    </div>

    {{-- ▼ 検索結果（トップと同じカードのグリッド） --}}
    @if ($hasFilter)
        @if ($results->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($results as $spot)
                    @include('livewire.partials.spot-card', [
                        'spot' => $spot,
                        'prefix' => 'search',
                    ])
                @endforeach
            </div>
        @else
            <p class="text-base text-heading py-12 text-center">
                条件に合うスポットが見つかりませんでした。条件を変えてみてください。
            </p>
        @endif
    @endif

</div>