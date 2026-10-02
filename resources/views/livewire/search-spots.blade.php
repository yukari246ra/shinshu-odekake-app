<div class="max-w-2xl mx-auto p-6 space-y-8">

    {{-- ▼ 検索フォーム（幅広） --}}
    <div class="space-y-6">

        {{-- 利用シーン --}}
        <flux:select wire:model="scene" label="利用シーン" class="w-full">
            <option value="">選択してください</option>
            <option value="家族">家族</option>
            <option value="カップル">カップル</option>
            <option value="友達">友達</option>
            <option value="ひとり">ひとり</option>
        </flux:select>

        {{-- エリア --}}
        <flux:select wire:model="area" label="エリア" class="w-full">
            <option value="">選択してください</option>
            <option value="北信">北信</option>
            <option value="中信">中信</option>
            <option value="東信">東信</option>
            <option value="南信">南信</option>
        </flux:select>

        {{-- カテゴリ --}}
        <flux:select wire:model="category" label="カテゴリ" class="w-full">
            <option value="">選択してください</option>
            <option value="レストラン">レストラン</option>
            <option value="カフェ">カフェ</option>
            <option value="公園">公園</option>
            <option value="観光地">観光地</option>
            <option value="ショッピング">ショッピング</option>
            <option value="温泉">温泉</option>
        </flux:select>

        {{-- ▼ 検索ボタン --}}
        <div class="pt-6">
            <flux:button wire:click="search" class="w-full py-3">
                検索する
            </flux:button>
        </div>

    </div>

    {{-- ▼ 検索結果（写真付き） --}}
    <div class="space-y-6">
        @foreach($results as $spot)
            <article class="p-6 shadow-lg rounded-lg bg-white dark:bg-zinc-800 flex gap-4 overflow-hidden">

                {{-- ▼ 写真（右側に収まるサイズ） --}}
                @if ($spot->image_path)
                    <img
                        src="{{ asset('storage/' . $spot->image_path) }}"
                        alt="{{ $spot->name }}"
                        class="w-48 h-36 object-cover rounded-lg flex-shrink-0"
                    >
                @endif

                {{-- ▼ テキスト --}}
                <div class="flex-1">
                    <a href="/spots/{{ $spot->id }}">

                        <flux:text class="mt-2">
                            {{ $spot->created_at->format('y/m/d') }}
                        </flux:text>

                        <flux:heading size="lg" level="2" class="mt-2">
                            {{ $spot->name }}
                        </flux:heading>

                        <flux:text class="mt-3">
                            {{ Str::limit($spot->description, 150) }}
                        </flux:text>

                        <flux:text class="mt-4">
                            カテゴリ: {{ $spot->category }} / エリア: {{ $spot->area }}
                        </flux:text>

                        <flux:text class="mt-4">
                            利用シーン: {{ $spot->scene }}
                        </flux:text>

                    </a>
                </div>

            </article>
        @endforeach
    </div>

</div>
