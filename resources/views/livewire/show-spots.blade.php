<div class="space-y-4">
    <flux:heading size="xl" level="1">スポット一覧ページ</flux:heading>

    <div class="flex justify-between items-center mb-6 gap-4 mt-6">
        <flux:input wire:model.live="search" icon="magnifying-glass" class="w-64" placeholder="スポット名で検索"/>

        @auth
            <flux:button href="{{ route('spots.create') }}" wire:navigate variant="primary">
                新規スポット作成
            </flux:button>
        @endauth
    </div>

    @foreach ($spots as $spot)
        <article class="p-4 shadow-lg">
            <a href="/spots/{{ $spot->id }}">
                <flux:text class="mt-4">{{ $spot->created_at->format('y/m/d') }}</flux:text>
                <flux:heading size="lg" level="2">{{ $spot->name }}</flux:heading>

                <flux:text class="mt-2">
                    {{ Str::limit($spot->description, 100) }}
                </flux:text>

                <flux:text class="mt-4">
                    カテゴリ: {{ $spot->category }} / エリア: {{ $spot->area }}
                </flux:text>

                <!-- ▼ 追加：利用シーン -->
                <flux:text class="mt-4">
                    利用シーン: {{ $spot->scene }}
                </flux:text>
                <!-- ▲ 追加ここまで -->
            </a>
        </article>
    @endforeach
</div>
