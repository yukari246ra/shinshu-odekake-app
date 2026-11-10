@php
    $infos = [
        ['icon' => 'map-pin', 'label' => '住所',     'value' => $spot->address],
        ['icon' => 'clock',   'label' => '営業時間', 'value' => $spot->business_hours],
        ['icon' => 'calendar','label' => '定休日',   'value' => $spot->closed_days],
        ['icon' => 'truck',   'label' => '駐車場',   'value' => $spot->parking],
    ];
    $hasSecond = (bool) $spot->image_url_2;
@endphp

<div class="mx-auto max-w-5xl space-y-8">

    {{-- 戻るボタン --}}
    <flux:button
        href="{{ route('spots') }}"
        wire:navigate
        icon="arrow-left"
        class="h-10 rounded-lg ui-button--subtle"
    >
        一覧に戻る
    </flux:button>

    {{-- 写真（2枚あれば横に並べる。1枚なら大きく表示） --}}
    <div class="grid gap-3 {{ $hasSecond ? 'md:grid-cols-2' : '' }}">

        <div class="relative overflow-hidden rounded-3xl bg-slate-100 {{ $hasSecond ? 'aspect-[4/3]' : 'aspect-[16/9] md:aspect-[21/9]' }}">
            <img src="{{ $spot->image_url }}" alt="{{ $spot->name }}" class="h-full w-full object-cover">

            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/60 to-transparent p-5">
                <div class="flex flex-wrap gap-2">
                    @foreach ([$spot->category, $spot->area, $spot->scene] as $label)
                        @if ($label)
                            <span class="rounded-full bg-white/90 px-3 py-1 text-xs font-medium text-[#002C47] shadow">
                                {{ $label }}
                            </span>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        @if ($hasSecond)
            <div class="relative aspect-[4/3] overflow-hidden rounded-3xl bg-slate-100">
                <img src="{{ $spot->image_url_2 }}" alt="{{ $spot->name }}（2枚目）" class="h-full w-full object-cover">
            </div>
        @endif
    </div>

    {{-- タイトルとお気に入り --}}
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-[#002C47] md:text-3xl">{{ $spot->name }}</h1>
            <p class="mt-1 flex items-center gap-1 text-sm text-slate-500">
                <flux:icon name="map-pin" class="size-4" />
                {{ $spot->address }}
            </p>
        </div>

        @auth
            <livewire:favorite-toggle :spotId="$spot->id" />
        @endauth

        @guest
            <a href="{{ route('login') }}" class="flex items-center gap-2 text-sm text-[#007BBC] underline">
                <flux:icon name="heart" class="size-4" />
                お気に入り登録にはログインが必要です
            </a>
        @endguest
    </div>

    {{-- 2カラム（スマホでは縦に並ぶ） --}}
    <div class="grid gap-8 lg:grid-cols-3">

        {{-- 左：説明と地図 --}}
        <div class="space-y-8 lg:col-span-2">

            <section>
                <h2 class="mb-3 flex items-center gap-2 text-xl font-bold text-[#002C47]">
                    <flux:icon name="information-circle" class="size-5" />
                    このスポットについて
                </h2>
                <p class="leading-relaxed text-slate-700">{!! nl2br(e($spot->description)) !!}</p>
            </section>

            <section>
                <h2 class="mb-3 flex items-center gap-2 text-xl font-bold text-[#002C47]">
                    <flux:icon name="map" class="size-5" />
                    アクセス
                </h2>

                @if ($spot->address)
                    <div class="overflow-hidden rounded-2xl border border-slate-200">
                        <iframe
                            src="https://www.google.com/maps?q={{ urlencode($spot->address) }}&output=embed"
                            class="h-72 w-full"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="{{ $spot->name }}の地図"
                        ></iframe>
                    </div>

                    <a
                        href="https://www.google.com/maps/search/?api=1&query={{ urlencode($spot->address) }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="mt-3 inline-flex items-center gap-2 text-sm text-[#007BBC] underline"
                    >
                        <flux:icon name="arrow-top-right-on-square" class="size-4" />
                        Googleマップでルートを調べる
                    </a>
                @else
                    <p class="text-slate-500">住所が登録されていません。</p>
                @endif
            </section>
        </div>

        {{-- 右：基本情報カード --}}
        <aside>
            <div class="space-y-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:bg-zinc-800 lg:sticky lg:top-6">
                <h2 class="text-lg font-bold text-[#002C47]">基本情報</h2>

                <dl class="space-y-4">
                    @foreach ($infos as $info)
                        <div class="flex gap-3">
                            <flux:icon :name="$info['icon']" class="mt-0.5 size-5 shrink-0 text-[#008689]" />
                            <div>
                                <dt class="text-xs text-slate-500">{{ $info['label'] }}</dt>
                                <dd class="text-sm text-[#002C47]">{{ $info['value'] ?: '未登録' }}</dd>
                            </div>
                        </div>
                    @endforeach

                    {{-- 電話番号（スマホでタップして電話できる） --}}
                    <div class="flex gap-3">
                        <flux:icon name="phone" class="mt-0.5 size-5 shrink-0 text-[#008689]" />
                        <div>
                            <dt class="text-xs text-slate-500">電話番号</dt>
                            <dd class="text-sm text-[#002C47]">
                                @if ($spot->phone)
                                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $spot->phone) }}" class="text-[#007BBC] underline">
                                        {{ $spot->phone }}
                                    </a>
                                @else
                                    未登録
                                @endif
                            </dd>
                        </div>
                    </div>

                    {{-- 公式サイト --}}
                    <div class="flex gap-3">
                        <flux:icon name="globe-alt" class="mt-0.5 size-5 shrink-0 text-[#008689]" />
                        <div>
                            <dt class="text-xs text-slate-500">公式サイト</dt>
                            <dd class="text-sm">
                                @if ($spot->website_url && Str::startsWith($spot->website_url, ['http://', 'https://']))
                                    <a
                                        href="{{ $spot->website_url }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="text-[#007BBC] underline"
                                    >
                                        公式サイトを見る
                                    </a>
                                @else
                                    <span class="text-[#002C47]">未登録</span>
                                @endif
                            </dd>
                        </div>
                    </div>
                </dl>
            </div>
        </aside>
    </div>
</div>