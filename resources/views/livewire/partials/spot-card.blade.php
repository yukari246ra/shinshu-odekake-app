<div wire:key="{{ $prefix }}-{{ $spot->id }}" class="group">

    <div class="relative overflow-hidden rounded-2xl bg-slate-100 {{ isset($large) ? 'aspect-[16/10]' : 'aspect-[4/3]' }}">
        <a href="{{ route('spot', $spot) }}" wire:navigate class="block h-full">
            <img src="{{ $spot->image_url }}" alt="{{ $spot->name }}" loading="lazy"
                 class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
        </a>

        <span class="pointer-events-none absolute left-3 top-3 rounded-full bg-white/90 px-3 py-1 text-xs font-medium text-[#002C47] shadow">
            {{ $spot->category }}
        </span>

        <button type="button" wire:click="toggleFavorite({{ $spot->id }})"
                class="absolute right-3 top-3 rounded-full bg-white/90 p-2 shadow transition hover:scale-110"
                aria-label="お気に入り">
            @if (in_array($spot->id, $favoriteIds))
                <flux:icon.heart variant="solid" class="size-5 text-[var(--color-favorite)]" />
            @else
                <flux:icon.heart class="size-5 text-slate-500" />
            @endif
        </button>
    </div>

    <a href="{{ route('spot', $spot) }}" wire:navigate class="mt-3 block space-y-1">
        <div class="flex items-start justify-between gap-2">
            <h3 class="line-clamp-1 font-semibold text-[#002C47]">{{ $spot->name }}</h3>
            <span class="flex shrink-0 items-center gap-1 text-sm text-slate-500">
                <flux:icon.heart variant="mini" class="size-4" />
                {{ $spot->favorites_count }}
            </span>
        </div>
        <p class="flex items-center gap-1 text-sm text-slate-500">
            <flux:icon name="map-pin" class="size-4" />
            {{ $spot->area }}　/　{{ $spot->scene }}
        </p>
        @isset($large)
            <p class="line-clamp-2 text-sm leading-relaxed text-slate-600">{{ $spot->description }}</p>
        @endisset
    </a>
</div>