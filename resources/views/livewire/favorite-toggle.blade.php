<div>
    <flux:button
        wire:click="toggle"
        variant="ghost"
        size="sm"
        class="flex items-center gap-1"
    >
        @if ($isFavorited)
            <flux:icon.heart class="w-5 h-5 text-red-500" />
            <span>お気に入り済み</span>
        @else
            <flux:icon.heart class="w-5 h-5 text-slate-500" />
            <span>お気に入り追加</span>
        @endif
    </flux:button>
</div>
