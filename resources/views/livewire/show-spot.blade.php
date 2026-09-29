<div class="max-w-3xl mx-auto p-6">

    <!-- 戻るボタン -->
    <div class="mb-6">
        <flux:button href="{{ route('spots') }}" wire:navigate icon="arrow-left" variant="subtle">
            一覧に戻る
        </flux:button>
    </div>

    <!-- タイトル + お気に入り -->
    <div class="mb-8 border-b border-slate-200 pb-6 dark:border-slate-700">
        <flux:heading size="lg" level="1" class="font-bold mb-4">
            {{ $spot->name }}
        </flux:heading>

        <div class="mb-4">
            <livewire:favorite-toggle :spotId="$spot->id" />
        </div>

        <!-- ① 写真 -->
        @if ($spot->image_path)
            <img
                src="{{ asset('storage/' . $spot->image_path) }}"
                alt="{{ $spot->name }}"
                class="w-full max-h-96 object-cover rounded mb-6"
            >
        @endif

        <!-- エリア + 作成日 -->
        <div class="flex items-center text-sm text-slate-500 gap-4 mb-2">
            <div class="flex item-center gap-1">
                <flux:icon.map class="w-4 h-4" />
                <span>{{ $spot->area }}</span>
            </div>

            <div class="flex items-center gap-1">
                <flux:icon.calendar class="w-4 h-4" />
                <span>{{ $spot->created_at->format('y/m/d') }}</span>
            </div>
        </div>

        <!-- 利用シーン -->
        <div class="flex items-center text-sm text-slate-500 gap-1 mt-2">
            <flux:icon.sparkles class="w-4 h-4" />
            <span>利用シーン：{{ $spot->scene }}</span>
        </div>
    </div>

    <!-- ② 基本情報 -->
    <div class="space-y-6 text-slate-800 dark:text-slate-200">

        <div>
            <h2 class="font-semibold mb-1">住所</h2>
            <p>{{ $spot->address }}</p>
        </div>

        <div>
            <h2 class="font-semibold mb-1">営業時間</h2>
            <p>{{ $spot->business_hours ?? '未登録' }}</p>
        </div>

        <div>
            <h2 class="font-semibold mb-1">定休日</h2>
            <p>{{ $spot->closed_days ?? '未登録' }}</p>
        </div>

        <div>
            <h2 class="font-semibold mb-1">電話番号</h2>
            <p>{{ $spot->phone ?? '未登録' }}</p>
        </div>

        <!-- ③ 駐車場情報 -->
        <div>
            <h2 class="font-semibold mb-1">駐車場情報</h2>
            <p>{{ $spot->parking ?? '未登録' }}</p>
        </div>

        <!-- ④ 外部サイト -->
        <div>
            <h2 class="font-semibold mb-1">公式サイト</h2>
            @if ($spot->website_url)
                <a href="{{ $spot->website_url }}" target="_blank" class="text-blue-600 underline">
                    公式サイトを見る
                </a>
            @else
                <p>未登録</p>
            @endif
        </div>

        <!-- ⑤ GoogleMap -->
        <div>
            <h2 class="font-semibold mb-1">GoogleMapでルート案内</h2>
            <a
                href="https://www.google.com/maps/search/?api=1&query={{ urlencode($spot->address) }}"
                target="_blank"
                class="text-blue-600 underline"
            >
                GoogleMapでルート検索
            </a>
        </div>

        <!-- ⑥ 説明 -->
        <div>
            <h2 class="font-semibold mb-1">説明</h2>
            <p>{!! nl2br(e($spot->description)) !!}</p>
        </div>

    </div>
</div>
