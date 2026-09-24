<div class="max-w-3xl mx-auto p-6">
    <div class="mb-6">
        <flux:button href="{{ route('spots') }}" wire:navigate icon="arrow-left" variant="subtle">
            一覧に戻る
        </flux:button>
    </div>

    <div class="mb-8 border-b border-slate-200 pb-6 dark:border-slate-700">
        <flux:heading size="lg" level="1" class="font-bold mb-4">
            {{ $spot->name }}
        </flux:heading>

        <!-- ▼ お気に入りボタン（追加） -->
        <div class="mb-4">
            <livewire:favorite-toggle :spotId="$spot->id" />
        </div>
        <!-- ▲ お気に入りボタンここまで -->

        <!-- ▼ 画像表示（追加） -->
        @if ($spot->image_path)
            <img
                src="{{ asset('storage/' . $spot->image_path) }}"
                alt="{{ $spot->name }}"
                class="w-full max-h-96 object-cover rounded mb-6"
            >
        @endif
        <!-- ▲ 画像表示ここまで -->

        <div class="flex items-center text-sm text-slate-500 gap-4 mb-2">
            <div class="flex item-center gap-1">
                <flux:icon.map class="w-4 h-4" />
                <span>{{ $spot->area }}</span>
            </div>

            <div class="flex items-center gap-1">
                <flux:icon.calendar class="w-4 h-4" />
                <span>{{ $spot->created_at->format('y/m/d') }}</span>
            </div>
        </div>

        <!-- ▼ 利用シーン -->
        <div class="flex items-center text-sm text-slate-500 gap-1 mt-2">
            <flux:icon.sparkles class="w-4 h-4" />
            <span>利用シーン：{{ $spot->scene }}</span>
        </div>
        <!-- ▲ 利用シーンここまで -->
    </div>

    <div class="text-lg leading-relaxed text-slate-800 dark:text-slate-200 mt-5">
        {!! nl2br(e($spot->description)) !!}
    </div>
</div>
