<div class="max-w-6xl mx-auto p-6 space-y-8">

    {{-- ▼ ページタイトル（h1） --}}
    <h1 class="text-2xl md:text-3xl font-bold text-heading flex items-center gap-2">
        <flux:icon name="heart" class="w-6 h-6 text-favorite" />
        お気に入りスポット
    </h1>

    @if ($spots->isEmpty())

        {{-- ▼ お気に入りが0件のとき --}}
        <div class="border border-subtle rounded-lg p-10 shadow-sm bg-white dark:bg-zinc-800 text-center space-y-4">
            <p class="text-base text-heading">お気に入りはまだありません。</p>
            <p class="text-sm text-heading">
                気になるスポットのハートを押すと、ここに追加されます。
            </p>
            <a
                href="/spots"
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg bg-link text-white hover:opacity-90"
            >
                <flux:icon name="map-pin" class="w-4 h-4" />
                スポット一覧を見る
            </a>
        </div>

    @else

        <p class="text-sm text-heading">全 {{ $spots->count() }} 件</p>

        {{-- ▼ カードのグリッド（トップと同じカードを使い回す） --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($spots as $spot)
                @include('livewire.partials.spot-card', [
                    'spot' => $spot,
                    'prefix' => 'fav',
                ])
            @endforeach
        </div>

    @endif

</div>