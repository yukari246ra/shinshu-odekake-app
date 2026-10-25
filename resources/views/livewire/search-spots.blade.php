<div class="max-w-2xl mx-auto p-6 space-y-8">

    {{-- ▼ ページタイトル（ジャンプ率：h1） --}}
    <h1 class="text-2xl font-bold text-[#002C47] mb-6">
        スポット検索
    </h1>

    {{-- ▼ 検索フォーム --}}
    <div class="grid gap-4">

        {{-- 利用シーン --}}
        <label class="text-sm font-medium text-[#002C47]">利用シーン</label>
        <flux:select wire:model="scene" placeholder="選択してください">
            <option value="">選択してください</option>
            <option value="家族">家族</option>
            <option value="カップル">カップル</option>
            <option value="友達">友達</option>
            <option value="ひとり">ひとり</option>
        </flux:select>

        {{-- エリア --}}
        <label class="text-sm font-medium text-[#002C47]">エリア</label>
        <flux:select wire:model="area" placeholder="選択してください">
            <option value="">選択してください</option>
            <option value="北信">北信</option>
            <option value="中信">中信</option>
            <option value="東信">東信</option>
            <option value="南信">南信</option>
        </flux:select>

        {{-- カテゴリ --}}
        <label class="text-sm font-medium text-[#002C47]">カテゴリ</label>
        <flux:select wire:model="category" placeholder="選択してください">
            <option value="">選択してください</option>
            <option value="レストラン">レストラン</option>
            <option value="カフェ">カフェ</option>
            <option value="公園">公園</option>
            <option value="観光地">観光地</option>
            <option value="ショッピング">ショッピング</option>
            <option value="温泉">温泉</option>
        </flux:select>

        {{-- ▼ 検索ボタン（統一：h-10 / rounded-lg） --}}
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

                        <flux:text class="mt-2 text-sm">
                            {{ $spot->created_at->format('y/m/d') }}
                        </flux:text>

                        {{-- ▼ 見出し（ジャンプ率：h2 → text-xl） --}}
                        <flux:heading size="lg" level="2" class="mt-2 text-xl font-semibold text-[#002C47]">
                            {{ $spot->name }}
                        </flux:heading>

                        <flux:text class="mt-3 leading-relaxed">
                            {{ Str::limit($spot->description, 150) }}
                        </flux:text>

                        <flux:text class="mt-4 text-sm">
                            カテゴリ: {{ $spot->category }} / エリア: {{ $spot->area }}
                        </flux:text>

                        <flux:text class="mt-4 text-sm">
                            利用シーン: {{ $spot->scene }}
                        </flux:text>

                    </a>
                </div>

            </article>
        @endforeach
    </div>

</div>
