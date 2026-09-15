<div class="space-y-6">

    {{-- ▼ 検索フォーム --}}
    <div class="space-y-4">

        {{-- 利用シーン --}}
        <flux:select wire:model="scene" label="利用シーン">
            <option value="">選択してください</option>
            <option value="家族">家族</option>
            <option value="カップル">カップル</option>
            <option value="友達">友達</option>
            <option value="ひとり">ひとり</option>
        </flux:select>

        {{-- エリア --}}
        <flux:select wire:model="area" label="エリア">
            <option value="">選択してください</option>
            <option value="北信">北信</option>
            <option value="中信">中信</option>
            <option value="東信">東信</option>
            <option value="南信">南信</option>
        </flux:select>

        {{-- カテゴリ --}}
        <flux:select wire:model="category" label="カテゴリ">
            <option value="">選択してください</option>
            <option value="レストラン">レストラン</option>
            <option value="カフェ">カフェ</option>
            <option value="公園">公園</option>
            <option value="観光地">観光地</option>
            <option value="ショッピング">ショッピング</option>
            <option value="温泉">温泉</option>
        </flux:select>

        <flux:button wire:click="search" class="w-full">
            検索する
        </flux:button>
    </div>

    {{-- ▼ 検索結果 --}}
    <div class="space-y-4">
        @foreach($results as $spot)
            <article class="p-4 shadow-lg">
                <a href="/spots/{{ $spot->id }}">
                    <flux:text class="mt-4">{{ $spot->created_at->format('y/m/d') }}</flux:text>
                    <flux:heading size="lg" level="2">{{ $spot->name }}</flux:heading>

                    <flux:text class="mt-2">
                        {{ Str::limit($spot->description, 100) }}
                    </flux:text>

                    <flux:text class="mt-4">
                        カテゴリ: {{ $spot->category }} / エリア: {{ $spot->area }}
                    </flux:text>

                    <flux:text class="mt-4">
                        利用シーン: {{ $spot->scene }}
                    </flux:text>
                </a>
            </article>
        @endforeach
    </div>

</div>
