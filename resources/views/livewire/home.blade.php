<div class="mx-auto max-w-6xl space-y-10">

    {{-- ヒーロー --}}
    <section class="relative h-72 overflow-hidden rounded-3xl bg-gradient-to-br from-accent to-heading md:h-96">
        <img src="{{ asset('images/hero-shinshu.jpg') }}" alt=""
             class="absolute inset-0 h-full w-full object-cover"
             onerror="this.style.display='none'">
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>

        <div class="relative flex h-full flex-col items-center justify-center px-4 text-center text-white">
            <h1 class="text-2xl md:text-3xl font-bold">次の週末は、信州へ。</h1>
            <p class="mt-2 text-sm md:text-base">景色・温泉・グルメ。お気に入りのスポットを見つけよう。</p>

            <div class="mt-6 w-full max-w-xl">
                <flux:input
                    wire:model.live.debounce.300ms="keyword"
                    icon="magnifying-glass"
                    placeholder="スポット名・キーワードで探す"
                    class="!rounded-full"
                />
            </div>
        </div>
    </section>

    {{-- カテゴリ・エリア --}}
    <section class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-heading">カテゴリから探す</h2>

            @if ($category !== '' || $area !== '' || $keyword !== '')
                <button type="button" wire:click="resetFilters"
                        class="text-sm text-link underline">
                    絞り込みを解除
                </button>
            @endif
        </div>

        <div class="flex gap-3 overflow-x-auto pb-2">
            @foreach ($categories as $name => $emoji)
                <button type="button" wire:click="selectCategory('{{ $name }}')"
                        class="flex shrink-0 items-center gap-2 rounded-full border px-5 py-2.5 text-sm font-medium transition
                               {{ $category === $name
                                    ? 'border-accent bg-accent text-white'
                                    : 'border-slate-300 bg-white text-heading hover:border-accent dark:bg-zinc-800' }}">
                    <span class="text-lg">{{ $emoji }}</span>
                    {{ $name }}
                </button>
            @endforeach
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <span class="text-sm font-medium text-heading">エリア</span>
            @foreach ($areas as $name)
                <button type="button" wire:click="selectArea('{{ $name }}')"
                        class="rounded-full border px-4 py-1.5 text-sm transition
                               {{ $area === $name
                                    ? 'border-heading bg-heading text-white'
                                    : 'border-slate-300 bg-white text-heading hover:border-heading dark:bg-zinc-800' }}">
                    {{ $name }}
                </button>
            @endforeach
        </div>
    </section>

    {{-- みんなのおすすめ（4カラム） --}}
    <section class="space-y-4">
        <div class="flex items-end justify-between">
            <h2 class="text-xl font-bold text-heading">
                {{ $category !== '' ? "{$category}のおすすめ" : 'みんなのおすすめ' }}
            </h2>
            <a href="{{ route('spots') }}" wire:navigate class="text-sm text-link underline">
                すべて見る
            </a>
        </div>

        @if ($recommended->isEmpty())
            <p class="rounded-2xl border border-dashed border-slate-300 p-8 text-center text-slate-500">
                条件に合うスポットがありません。絞り込みを解除してみてください。
            </p>
        @else
            <div class="grid grid-cols-2 gap-4 md:grid-cols-3 md:gap-6 xl:grid-cols-4">
                @foreach ($recommended as $spot)
                    @include('livewire.partials.spot-card', ['spot' => $spot, 'prefix' => 'rec'])
                @endforeach
            </div>
        @endif
    </section>

    {{-- 新着スポット（3カラム） --}}
    @if ($latest->isNotEmpty())
        <section class="space-y-4">
            <h2 class="text-xl font-bold text-heading">新着スポット</h2>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($latest as $spot)
                    @include('livewire.partials.spot-card', ['spot' => $spot, 'prefix' => 'new', 'large' => true])
                @endforeach
            </div>
        </section>
    @endif
</div>