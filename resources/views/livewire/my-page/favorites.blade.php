<div class="max-w-3xl mx-auto p-6">

    {{-- ▼ ページタイトル --}}
    <h1 class="text-2xl font-bold mb-6 text-[#002C47] flex items-center gap-2">
        <flux:icon name="user" class="w-6 h-6" />
        マイページ
    </h1>

    <div class="mb-8">

        {{-- ▼ セクションタイトル --}}
        <h2 class="text-xl font-semibold mb-4 text-[#002C47] flex items-center gap-2">
            <flux:icon name="heart" class="w-5 h-5" />
            お気に入りスポット
        </h2>

        @if ($favorites->isEmpty())
            <p class="text-slate-500">お気に入りはまだありません。</p>
        @else
            <div class="grid grid-cols-1 gap-4">
                @foreach ($favorites as $favorite)
                    <div class="p-4 border rounded-xl shadow-sm bg-white dark:bg-zinc-800">

                        <div class="flex items-center gap-4">

                            {{-- ▼ 写真 --}}
                            @if ($favorite->spot->image_path)
                                <img
                                    src="{{ asset('storage/' . $favorite->spot->image_path) }}"
                                    class="w-24 h-24 object-cover rounded"
                                >
                            @endif

                            {{-- ▼ テキスト --}}
                            <div class="flex-1">

                                {{-- スポット名 --}}
                                <div class="font-bold text-lg text-[#002C47] flex items-center gap-2">
                                    <flux:icon name="map" class="w-5 h-5" />
                                    {{ $favorite->spot->name }}
                                </div>

                                {{-- エリア / シーン --}}
                                <div class="text-sm text-slate-500 flex items-center gap-3 mt-1">

                                    <span class="flex items-center gap-1">
                                        <flux:icon name="map-pin" class="w-4 h-4" />
                                        {{ $favorite->spot->area }}
                                    </span>

                                    <span class="flex items-center gap-1">
                                        <flux:icon name="sparkles" class="w-4 h-4" />
                                        {{ $favorite->spot->scene }}
                                    </span>

                                </div>

                                {{-- 詳細ボタン --}}
                                <a
                                    href="{{ route('spot', $favorite->spot->id) }}"
                                    class="inline-flex items-center gap-2 mt-2 px-3 py-1 text-sm rounded bg-blue-600 text-white hover:bg-blue-700"
                                >
                                    <flux:icon name="arrow-right" class="w-4 h-4" />
                                    詳細を見る
                                </a>

                            </div>

                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
