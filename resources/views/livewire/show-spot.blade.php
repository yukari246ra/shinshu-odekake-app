@php
    $infos = [
        ['icon' => 'map-pin', 'label' => '住所',     'value' => $spot->address],
        ['icon' => 'clock',   'label' => '営業時間', 'value' => $spot->business_hours],
        ['icon' => 'calendar','label' => '定休日',   'value' => $spot->closed_days],
        ['icon' => 'truck',   'label' => '駐車場',   'value' => $spot->parking],
    ];
    $hasSecond = (bool) $spot->image_url_2;

    // 緯度・経度が両方登録されているか
    $hasCoordinates = filled($spot->latitude) && filled($spot->longitude);

    // 周辺の駐車場を探すGoogleマップのリンク（座標があれば座標、なければ住所で検索）
    $parkingUrl = null;
    if ($hasCoordinates) {
        $parkingUrl = 'https://www.google.com/maps/search/' . rawurlencode('駐車場')
            . '/@' . $spot->latitude . ',' . $spot->longitude . ',16z';
    } elseif ($spot->address) {
        $parkingUrl = 'https://www.google.com/maps/search/?api=1&query=' . urlencode('駐車場 ' . $spot->address);
    }

    // 気温を「-1℃」のような表示にする（値がないときは「－」）
    // 整数にそろえるので、-0.2 を四捨五入しても「-0℃」ではなく「0℃」になる
    $formatTemp = fn ($value) => $value === null ? '－' : ((int) round($value)) . '℃';

    // 天気コード（WMO）に合う絵文字
    $weatherEmoji = fn ($code) => match (true) {
        $code === 0, $code === 1 => '☀️',
        $code === 2 => '⛅',
        $code === 3 => '☁️',
        $code === 45, $code === 48 => '🌫️',
        $code !== null && $code >= 51 && $code <= 57 => '🌦️',
        $code !== null && $code >= 61 && $code <= 67 => '🌧️',
        $code !== null && $code >= 71 && $code <= 77 => '❄️',
        $code !== null && $code >= 80 && $code <= 82 => '🌦️',
        $code === 85, $code === 86 => '❄️',
        $code !== null && $code >= 95 => '⛈️',
        default => '🌡️',
    };
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
                    @foreach (array_filter([$spot->category, $spot->area]) as $label)
                        <span class="rounded-full bg-white/90 px-3 py-1 text-xs font-medium text-heading shadow">
                            {{ $label }}
                        </span>
                    @endforeach
                    @foreach ($spot->sceneNames() as $sceneName)
                        <span class="rounded-full bg-white/90 px-3 py-1 text-xs font-medium text-heading shadow">
                            {{ $sceneName }}
                        </span>
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
            <h1 class="text-2xl md:text-3xl font-bold text-heading">{{ $spot->name }}</h1>
            <p class="mt-1 flex items-center gap-1 text-sm text-slate-500">
                <flux:icon name="map-pin" class="size-4" />
                {{ $spot->address }}
            </p>
        </div>

        @auth
            <livewire:favorite-toggle :spotId="$spot->id" />
        @endauth

        @guest
            <a href="{{ route('login') }}" class="flex items-center gap-2 text-sm text-link underline">
                <flux:icon name="heart" class="size-4" />
                お気に入り登録にはログインが必要です
            </a>
        @endguest
    </div>

    {{-- 2カラム（スマホでは縦に並ぶ） --}}
    <div class="grid gap-8 lg:grid-cols-3">

        {{-- 左：説明・地図・駐車場・週間天気 --}}
        <div class="space-y-8 lg:col-span-2">

            <section>
                <h2 class="mb-3 flex items-center gap-2 text-xl font-bold text-heading">
                    <flux:icon name="information-circle" class="size-5" />
                    このスポットについて
                </h2>
                <p class="leading-relaxed text-slate-700">{!! nl2br(e($spot->description)) !!}</p>
            </section>

            <section>
                <h2 class="mb-3 flex items-center gap-2 text-xl font-bold text-heading">
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

                    <div class="mt-3 flex flex-wrap gap-x-6 gap-y-2">
                        <a
                            href="https://www.google.com/maps/search/?api=1&query={{ urlencode($spot->address) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-2 text-sm text-link underline"
                        >
                            <flux:icon name="arrow-top-right-on-square" class="size-4" />
                            Googleマップでルートを調べる
                        </a>

                        {{-- 周辺の駐車場（Googleマップで検索） --}}
                        @if ($parkingUrl)
                            <a
                                href="{{ $parkingUrl }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 text-sm text-link underline"
                            >
                                <flux:icon name="truck" class="size-4" />
                                周辺の駐車場を探す
                            </a>
                        @endif
                    </div>
                @else
                    <p class="text-slate-500">住所が登録されていません。</p>
                @endif
            </section>

            {{-- 週間天気予報（ページ表示のあとに読み込む） --}}
            <section @if ($hasCoordinates) wire:init="loadWeather" @endif>
                <h2 class="mb-3 flex items-center gap-2 text-xl font-bold text-heading">
                    <flux:icon name="sun" class="size-5" />
                    週間天気予報
                </h2>

                @if (! $hasCoordinates)
                    {{-- 緯度・経度が未登録 --}}
                    <p class="rounded-2xl border border-slate-200 bg-white p-5 text-sm text-slate-500 dark:bg-zinc-800">
                        このスポットは位置情報が未登録のため、天気を表示できません。
                    </p>
                @elseif (! $weatherLoaded)
                    {{-- 読み込み中 --}}
                    <p class="animate-pulse rounded-2xl border border-slate-200 bg-white p-5 text-sm text-slate-500 dark:bg-zinc-800">
                        天気を読み込み中…
                    </p>
                @elseif ($weather === null || empty($weather['daily']))
                    {{-- 取得に失敗 --}}
                    <p class="rounded-2xl border border-slate-200 bg-white p-5 text-sm text-slate-500 dark:bg-zinc-800">
                        天気情報を取得できませんでした。時間をおいてもう一度お試しください。
                    </p>
                @else
                    <div class="space-y-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:bg-zinc-800">

                        {{-- 現在の気温 --}}
                        <p class="flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-slate-600">
                            <span class="text-2xl" aria-hidden="true">{{ $weatherEmoji($weather['weather_code'] ?? null) }}</span>
                            <span>いまの気温</span>
                            <span class="text-xl font-bold text-heading">{{ $formatTemp($weather['temperature']) }}</span>
                            <span class="text-xs text-slate-500">体感 {{ $formatTemp($weather['apparent_temperature']) }}・{{ $weather['weather_label'] }}</span>
                        </p>

                        {{-- 7日分（スマホは4列で折り返し、広い画面では横に7列） --}}
                        <ul class="grid grid-cols-4 gap-2 sm:grid-cols-7">
                            @foreach ($weather['daily'] as $day)
                                @php
                                    $date = \Carbon\Carbon::parse($day['date'])->locale('ja');
                                    $isToday = $loop->first;
                                @endphp
                                <li class="rounded-xl p-2 text-center {{ $isToday ? 'border-2 border-accent bg-white dark:bg-zinc-800' : 'bg-slate-50 dark:bg-zinc-700' }}">
                                    <p class="text-xs text-slate-500">{{ $isToday ? '今日' : $date->isoFormat('M/D') }}</p>
                                    <p class="text-xs text-slate-500">({{ $date->isoFormat('ddd') }})</p>
                                    <p class="my-1 text-2xl" aria-hidden="true" title="{{ $day['weather_label'] }}">{{ $weatherEmoji($day['weather_code'] ?? null) }}</p>
                                    <p class="sr-only">{{ $day['weather_label'] }}</p>
                                    <p class="text-sm font-bold text-heading">{{ $formatTemp($day['temperature_max']) }}</p>
                                    <p class="text-xs text-slate-500">{{ $formatTemp($day['temperature_min']) }}</p>
                                    <p class="mt-1 text-xs text-link">
                                        {{ $day['precipitation_probability'] === null ? '－' : $day['precipitation_probability'] . '%' }}
                                    </p>
                                </li>
                            @endforeach
                        </ul>

                        <p class="text-xs leading-relaxed text-slate-500">
                            各日の上段が最高気温、下段が最低気温、青い数字が降水確率（その日の最大値）です。予報モデルによる値で、現地の観測値とは異なる場合があります。
                        </p>
                        <p class="text-xs text-slate-500">
                            天気データ：
                            <a
                                href="https://open-meteo.com/"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="text-link underline"
                            >Open-Meteo</a>
                        </p>
                    </div>
                @endif
            </section>
        </div>

        {{-- 右：基本情報カードと口コミ --}}
        <aside>
            <div class="space-y-8">

                {{-- 基本情報カード --}}
                <div class="space-y-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:bg-zinc-800">
                    <h2 class="text-xl font-bold text-heading">基本情報</h2>

                    <dl class="space-y-4">
                        @foreach ($infos as $info)
                            <div class="flex gap-3">
                                <flux:icon :name="$info['icon']" class="mt-0.5 size-5 shrink-0 text-accent" />
                                <div>
                                    <dt class="text-xs text-slate-500">{{ $info['label'] }}</dt>
                                    <dd class="text-sm text-heading">{{ $info['value'] ?: '未登録' }}</dd>
                                </div>
                            </div>
                        @endforeach

                        {{-- 電話番号（スマホでタップして電話できる） --}}
                        <div class="flex gap-3">
                            <flux:icon name="phone" class="mt-0.5 size-5 shrink-0 text-accent" />
                            <div>
                                <dt class="text-xs text-slate-500">電話番号</dt>
                                <dd class="text-sm text-heading">
                                    @if ($spot->phone)
                                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $spot->phone) }}" class="text-link underline">
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
                            <flux:icon name="globe-alt" class="mt-0.5 size-5 shrink-0 text-accent" />
                            <div>
                                <dt class="text-xs text-slate-500">公式サイト</dt>
                                <dd class="text-sm">
                                    @if ($spot->website_url && Str::startsWith($spot->website_url, ['http://', 'https://']))
                                        <a
                                            href="{{ $spot->website_url }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="text-link underline"
                                        >
                                            公式サイトを見る
                                        </a>
                                    @else
                                        <span class="text-heading">未登録</span>
                                    @endif
                                </dd>
                            </div>
                        </div>
                    </dl>
                </div>

                {{-- 口コミ（一覧・投稿・編集・削除） --}}
                <livewire:spot-reviews :spotId="$spot->id" :key="'reviews-' . $spot->id" />

            </div>
        </aside>
    </div>
    {{-- 同じエリアのスポット --}}
    @if ($sameArea->isNotEmpty())
        <section class="space-y-4 border-t border-slate-200 pt-8">
            <h2 class="text-xl font-bold text-heading">
                同じエリア（{{ $spot->area }}）のスポット
            </h2>
            <div class="grid grid-cols-2 gap-4 md:grid-cols-4 md:gap-6">
                @foreach ($sameArea as $related)
                    @include('livewire.partials.spot-card', ['spot' => $related, 'prefix' => 'area'])
                @endforeach
            </div>
        </section>
    @endif

    {{-- 同じカテゴリのスポット --}}
    @if ($sameCategory->isNotEmpty())
        <section class="space-y-4">
            <h2 class="text-xl font-bold text-heading">
                同じカテゴリ（{{ $spot->category }}）のスポット
            </h2>
            <div class="grid grid-cols-2 gap-4 md:grid-cols-4 md:gap-6">
                @foreach ($sameCategory as $related)
                    @include('livewire.partials.spot-card', ['spot' => $related, 'prefix' => 'cat'])
                @endforeach
            </div>
        </section>
    @endif

</div>