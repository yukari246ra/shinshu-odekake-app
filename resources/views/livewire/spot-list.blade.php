<div class="max-w-3xl mx-auto p-6 space-y-8">

    {{-- ▼ ページタイトル（ジャンプ率：h1） --}}
    <h1 class="text-2xl font-bold text-[#002C47] mb-6 flex items-center gap-2">
        <flux:icon name="map-pin" class="w-6 h-6" />
        スポット一覧
    </h1>

    {{-- ▼ フラッシュメッセージ --}}
    @if (session('status'))
        <div class="p-4 bg-slate-200 text-slate-700 rounded border border-subtle flex items-center gap-2">
            <flux:icon name="information-circle" class="w-5 h-5" />
            {{ session('status') }}
        </div>
    @endif

    {{-- ▼ フリーワード検索（統一：gap-4 / h-10） --}}
    <div class="flex items-center gap-4 mb-6">
        <flux:input
            wire:model.live="search"
            icon="magnifying-glass"
            class="w-64 h-10"
            placeholder="キーワードで検索（名前・説明・住所など）"
        />
    </div>

    {{-- ▼ 検索結果一覧 --}}
    <div class="space-y-6">
        @foreach ($spots as $spot)
            <article class="border border-subtle rounded-lg p-4 shadow-sm bg-white dark:bg-zinc-800 flex gap-4 overflow-hidden">

                {{-- ▼ 写真 --}}
                @if ($spot->image_path)
                    <img
                        src="{{ asset('storage/' . $spot->image_path) }}"
                        alt="{{ $spot->name }}"
                        class="w-48 h-36 object-cover rounded-lg flex-shrink-0"
                    >
                @endif

                {{-- ▼ テキスト --}}
                <div class="flex-1">
                    <a href="/spots/{{ $spot->id }}">

                        {{-- 日付 --}}
                        <flux:text class="mt-2 text-sm flex items-center gap-2">
                            <flux:icon name="calendar" class="w-4 h-4" />
                            {{ $spot->created_at->format('y/m/d') }}
                        </flux:text>

                        {{-- ▼ 見出し（ジャンプ率：h2 → text-xl） --}}
                        <flux:heading size="lg" level="2" class="mt-2 text-xl font-semibold text-[#002C47] flex items-center gap-2">
                            <flux:icon name="map" class="w-5 h-5" />
                            {{ $spot->name }}
                        </flux:heading>

                        {{-- 説明文（読みやすさ：leading-relaxed） --}}
                        <flux:text class="mt-3 leading-relaxed flex items-center gap-2">
                            <flux:icon name="information-circle" class="w-4 h-4" />
                            {{ Str::limit($spot->description, 100) }}
                        </flux:text>

                        {{-- カテゴリ・エリア --}}
                        <flux:text class="mt-4 text-sm flex items-center gap-2">
                            <flux:icon name="tag" class="w-4 h-4" />
                            カテゴリ: {{ $spot->category }} / エリア: {{ $spot->area }}
                        </flux:text>

                        {{-- 利用シーン --}}
                        <flux:text class="mt-2 text-sm flex items-center gap-2">
                            <flux:icon name="sparkles" class="w-4 h-4" />
                            利用シーン: {{ $spot->scene }}
                        </flux:text>

                    </a>
                </div>

            </article>
        @endforeach
    </div>

</div>
