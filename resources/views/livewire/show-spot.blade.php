<div class="max-w-3xl mx-auto p-6 space-y-8">

    {{-- ▼ 戻るボタン --}}
    <div class="mb-6">
        <flux:button
            href="{{ route('spots') }}"
            wire:navigate
            icon="arrow-left"
            class="h-10 rounded-lg ui-button--subtle"
        >
            一覧に戻る
        </flux:button>
    </div>

    {{-- ▼ タイトル + お気に入り --}}
    <div class="mb-8 border-b border-subtle pb-6">

        {{-- h1（ジャンプ率：text-2xl） --}}
        <h1 class="text-2xl font-bold mb-4 text-[#002C47] flex items-center gap-2">
            <flux:icon name="map" class="w-6 h-6" />
            {{ $spot->name }}
        </h1>

        <div class="mb-4">
            @auth
                <livewire:favorite-toggle :spotId="$spot->id" />
            @endauth

            @guest
                <a href="{{ route('login') }}" class="text-blue-600 underline flex items-center gap-2">
                    <flux:icon name="heart" class="w-4 h-4" />
                    お気に入り登録にはログインが必要です
                </a>
            @endguest
        </div>

        {{-- ▼ 写真 --}}
        @if ($spot->image_path)
            <img
                src="{{ asset('storage/' . $spot->image_path) }}"
                alt="{{ $spot->name }}"
                class="w-full max-h-96 object-cover rounded-lg mb-6"
            >
        @endif

        {{-- ▼ エリア + 作成日 --}}
        <div class="flex items-center text-sm text-[#002C47] gap-4 mb-2">

            <div class="flex items-center gap-1">
                <flux:icon name="map-pin" class="w-4 h-4" />
                <span>{{ $spot->area }}</span>
            </div>

            <div class="flex items-center gap-1">
                <flux:icon name="calendar" class="w-4 h-4" />
                <span>{{ $spot->created_at->format('y/m/d') }}</span>
            </div>

        </div>

        {{-- ▼ 利用シーン --}}
        <div class="flex items-center text-sm text-[#002C47] gap-1 mt-2">
            <flux:icon name="sparkles" class="w-4 h-4" />
            <span>利用シーン：{{ $spot->scene }}</span>
        </div>
    </div>

    {{-- ▼ 基本情報（h2 → text-xl） --}}
    <div class="space-y-6 text-[#002C47]">

        <div>
            <h2 class="text-xl font-semibold mb-1 flex items-center gap-2">
                <flux:icon name="map" class="w-5 h-5" />
                住所
            </h2>
            <p class="leading-relaxed">{{ $spot->address }}</p>
        </div>

        <div>
            <h2 class="text-xl font-semibold mb-1 flex items-center gap-2">
                <flux:icon name="clock" class="w-5 h-5" />
                営業時間
            </h2>
            <p class="leading-relaxed">{{ $spot->business_hours ?? '未登録' }}</p>
        </div>

        <div>
            <h2 class="text-xl font-semibold mb-1 flex items-center gap-2">
                <flux:icon name="calendar" class="w-5 h-5" />
                定休日
            </h2>
            <p class="leading-relaxed">{{ $spot->closed_days ?? '未登録' }}</p>
        </div>

        <div>
            <h2 class="text-xl font-semibold mb-1 flex items-center gap-2">
                <flux:icon name="phone" class="w-5 h-5" />
                電話番号
            </h2>
            <p class="leading-relaxed">{{ $spot->phone ?? '未登録' }}</p>
        </div>

        {{-- ▼ 駐車場情報（car → truck に修正） --}}
        <div>
            <h2 class="text-xl font-semibold mb-1 flex items-center gap-2">
                <flux:icon name="truck" class="w-5 h-5" />
                駐車場情報
            </h2>
            <p class="leading-relaxed">{{ $spot->parking ?? '未登録' }}</p>
        </div>

        {{-- ▼ 外部サイト --}}
        <div>
            <h2 class="text-xl font-semibold mb-1 flex items-center gap-2">
                <flux:icon name="globe-alt" class="w-5 h-5" />
                公式サイト
            </h2>

            @if ($spot->website_url)
                <a
                    href="{{ $spot->website_url }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="text-blue-600 underline flex items-center gap-2"
                >
                    <flux:icon name="arrow-top-right-on-square" class="w-4 h-4" />
                    公式サイトを見る
                </a>
            @else
                <p class="leading-relaxed">未登録</p>
            @endif
        </div>

        {{-- ▼ GoogleMap --}}
        <div>
            <h2 class="text-xl font-semibold mb-1 flex items-center gap-2">
                <flux:icon name="map" class="w-5 h-5" />
                GoogleMapでルート案内
            </h2>

            <a
                href="https://www.google.com/maps/search/?api=1&query={{ urlencode($spot->address) }}"
                target="_blank"
                rel="noopener noreferrer"
                class="text-blue-600 underline flex items-center gap-2"
            >
                <flux:icon name="arrow-top-right-on-square" class="w-4 h-4" />
                GoogleMapでルート検索
            </a>
        </div>

        {{-- ▼ 説明 --}}
        <div>
            <h2 class="text-xl font-semibold mb-1 flex items-center gap-2">
                <flux:icon name="information-circle" class="w-5 h-5" />
                説明
            </h2>
            <p class="leading-relaxed">{!! nl2br(e($spot->description)) !!}</p>
        </div>

    </div>
</div>
