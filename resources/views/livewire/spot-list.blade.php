<div class="space-y-4">

    <!-- ▼ フラッシュメッセージ -->
    @if (session('status'))
        <div class="p-4 bg-slate-200 text-slate-700 rounded border border-slate-300">
            {{ session('status') }}
        </div>
    @endif

    <flux:heading size="xl" level="1">スポット一覧ページ</flux:heading>

    <!-- ▼ フリーワード検索（リアルタイム） -->
    <div class="flex items-center mb-6 gap-4 mt-6">
        <flux:input
            wire:model.live="search"
            icon="magnifying-glass"
            class="w-64"
            placeholder="キーワードで検索（名前・説明・住所など）"
        />
    </div>

    <!-- ▼ 検索結果一覧 -->
    @foreach ($spots as $spot)
        <article class="p-4 shadow-lg rounded-lg flex gap-4 overflow-hidden">

            {{-- ▼ 右側に収まる写真（確実に表示されるサイズ） --}}
            @if ($spot->image_path)
                <img
                    src="{{ asset('storage/' . $spot->image_path) }}"
                    alt="{{ $spot->name }}"
                    class="w-48 h-36 object-cover rounded-lg flex-shrink-0"
                >
            @endif

            {{-- ▼ 左側のテキスト --}}
            <div class="flex-1">
                <a href="/spots/{{ $spot->id }}">

                    <flux:text class="mt-2">
                        {{ $spot->created_at->format('y/m/d') }}
                    </flux:text>

                    <flux:heading size="lg" level="2" class="mt-2">
                        {{ $spot->name }}
                    </flux:heading>

                    <flux:text class="mt-2">
                        {{ Str::limit($spot->description, 100) }}
                    </flux:text>

                    <flux:text class="mt-4">
                        カテゴリ: {{ $spot->category }} / エリア: {{ $spot->area }}
                    </flux:text>

                    <flux:text class="mt-4">
                        利用シーン: {{ $spot->scene }}
                    </flux:text>

                </a>
            </div>

        </article>
    @endforeach

</div>
