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
        <article class="p-4 shadow-lg">
            <a href="/spots/{{ $spot->id }}">
                <flux:text class="mt-4">{{ $spot->created_at->format('y/m/d') }}</flux:text>

                <flux:heading size="lg" level="2">
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
        </article>
    @endforeach

</div>
