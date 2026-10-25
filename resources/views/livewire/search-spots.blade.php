<div class="max-w-2xl mx-auto p-6 space-y-8">

    {{-- ▼ ページタイトル --}}
    <h1 class="text-2xl font-bold text-[#002C47] mb-6 flex items-center gap-2">
        <flux:icon name="magnifying-glass" class="w-6 h-6" />
        スポット検索
    </h1>

    {{-- ▼ 検索フォーム --}}
    <div class="grid gap-4">

        {{-- 利用シーン --}}
        <label class="text-sm font-medium text-[#002C47] flex items-center gap-2">
            <flux:icon name="sparkles" class="w-4 h-4" />
            利用シーン
        </label>
        <flux:select wire:model="scene" placeholder="選択してください">
            <option value="">選択してください</option>
            <option value="家族">家族</option>
            <option value="カップル">カップル</option>
            <option value="友達">友達</option>
            <option value="ひとり">ひとり</option>
        </flux:select>

        {{-- エリア --}}
        <label class="text-sm font-medium text-[#002C47] flex items-center gap-2">
            <flux:icon name="map-pin" class="w-4 h-4" />
            エリア
        </label>
        <flux:select wire:model="area" placeholder="選択してください">
            <option value="">選択してください</option>
            <option value="北信">北信</option>
            <option value="中信">中信</option>
            <option value="東信">東信</option>
            <option value="南信">南信</option>
        </flux:select>

        {{-- カテゴリ --}}
        <label class="text-sm font-medium text-[#002C47] flex items-center gap-2">
            <flux:icon name="tag" class="w-4 h-4" />
            カテゴリ
        </label>
        <flux:select wire:model="category" placeholder="選択してください">
            <option value="">選択してください</option>
            <option value="レストラン">レストラン</option>
            <option value="カフェ">カフェ</option>
            <option value="公園">公園</option>
            <option value="観光地">観光地</option>
            <option value="ショッピング">ショッピング</option>
            <option value="温泉">温泉</option>
        </flux:select>

        {{-- ▼ 検索ボタン --}}
        <div class="pt-4">
            <flux:button
                wire:click="search"
                class="w-full h-10 rounded-lg ui-button--subtle"
            >

                検索する
            </flux:button>
        </div>

    </div>

    {{-- ▼ 検索結果 --}}
    <div class="space-y-6">
        @foreach($results as $spot)
            <article class="border border-subtle rounded-lg p-4 shadow-sm bg-white dark:bg-zinc-800 flex gap-4 overflow-hidden">

                {{-- ▼ 写真 --}}
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

                        {{-- 日付 --}}
                        <flux:text class="mt-2 text-sm flex items-center gap-2">
                            <flux:icon name="calendar" class="w-4 h-4" />
                            {{ $spot->created_at->format('y/m/d') }}
                        </flux:text>

                        {{-- 見出し --}}
                        <flux:heading size="lg" level="2" class="mt-2 text-xl font-semibold text-[#002C47] flex items-center gap-2">
                            <flux:icon name="map" class="w-5 h-5" />
                            {{ $spot->name }}
                        </flux:heading>

                        {{-- 説明文 --}}
                        <flux:text class="mt-3 leading-relaxed flex items-center gap-2">
                            <flux:icon name="information-circle" class="w-4 h-4" />
                            {{ Str::limit($spot->description, 150) }}
                        </flux:text>

                        {{-- カテゴリ・エリア --}}
                        <flux:text class="mt-4 text-sm flex items-center gap-2">
                            <flux:icon name="tag" class="w-4 h-4" />
                            カテゴリ: {{ $spot->category }} / エリア: {{ $spot->area }}
                        </flux:text>

                        {{-- 利用シーン --}}
                        <flux:text class="mt-4 text-sm flex items-center gap-2">
                            <flux:icon name="sparkles" class="w-4 h-4" />
                            利用シーン: {{ $spot->scene }}
                        </flux:text>

                    </a>
                </div>

            </article>
        @endforeach
    </div>

</div>
