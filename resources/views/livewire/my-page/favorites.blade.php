<div class="max-w-3xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-6">
        マイページ
    </h1>

    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-4">
            お気に入りスポット
        </h2>

        @if ($favorites->isEmpty())
            <p class="text-slate-500">お気に入りはまだありません。</p>
        @else
            <div class="grid grid-cols-1 gap-4">
                @foreach ($favorites as $favorite)
                    <div class="p-4 border rounded-xl shadow-sm bg-white dark:bg-zinc-800">

                        <div class="flex items-center gap-4">

                            @if ($favorite->spot->image_path)
                                <img
                                    src="{{ asset('storage/' . $favorite->spot->image_path) }}"
                                    class="w-24 h-24 object-cover rounded"
                                >
                            @endif

                            <div class="flex-1">
                                <div class="font-bold text-lg">
                                    {{ $favorite->spot->name }}
                                </div>

                                <div class="text-sm text-slate-500">
                                    {{ $favorite->spot->area }} / {{ $favorite->spot->scene }}
                                </div>

                                <a
                                    href="{{ route('spot', $favorite->spot->id) }}"
                                    class="inline-block mt-2 px-3 py-1 text-sm rounded bg-blue-600 text-white hover:bg-blue-700"
                                >
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
