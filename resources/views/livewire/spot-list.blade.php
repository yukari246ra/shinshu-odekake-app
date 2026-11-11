<div class="max-w-6xl mx-auto p-6 space-y-8">

    {{-- ▼ ページタイトル（h1） --}}
    <h1 class="text-2xl md:text-3xl font-bold text-heading flex items-center gap-2">
        <flux:icon name="map-pin" class="w-6 h-6 text-accent" />
        スポット一覧
    </h1>

    {{-- ▼ フラッシュメッセージ --}}
    @if (session('status'))
        <div class="p-4 bg-slate-200 text-slate-700 rounded border border-subtle flex items-center gap-2">
            <flux:icon name="information-circle" class="w-5 h-5" />
            {{ session('status') }}
        </div>
    @endif

    {{-- ▼ フリーワード検索 --}}
    <div class="flex items-center gap-4">
        <flux:input
            wire:model.live="search"
            icon="magnifying-glass"
            class="w-full md:max-w-md"
            placeholder="キーワードで検索（名前・説明・住所など）"
        />
        <p class="text-sm text-heading whitespace-nowrap">
            全 {{ $spots->total() }} 件
        </p>
    </div>

    {{-- ▼ カードのグリッド（トップと同じカードを使い回す） --}}
    @if ($spots->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($spots as $spot)
                @include('livewire.partials.spot-card', [
                    'spot' => $spot,
                    'prefix' => 'list',
                ])
            @endforeach
        </div>
    @else
        <p class="text-base text-heading py-12 text-center">
            条件に合うスポットが見つかりませんでした。
        </p>
    @endif

    {{-- ▼ ページネーション（残す） --}}
    <div class="flex justify-end">
        {{ $spots->links() }}
    </div>

</div>