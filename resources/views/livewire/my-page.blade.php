
<div class="max-w-6xl mx-auto p-6 space-y-8">

    {{-- ページタイトル --}}
    <h1 class="text-2xl md:text-3xl font-bold text-heading flex items-center gap-2">
        <flux:icon name="user-circle" class="w-7 h-7" />
        マイページ
    </h1>

    {{-- メニュー --}}
    <div class="max-w-xl mx-auto space-y-4">

        {{-- お気に入り一覧 --}}
        <a
            href="{{ route('mypage.favorites') }}"
            class="flex w-full min-h-14 items-center justify-center gap-3
                   rounded-lg bg-link px-5 py-4 text-base font-medium text-white
                   shadow-sm hover:opacity-90 transition"
        >
            <flux:icon name="heart" class="w-5 h-5" />
            お気に入り一覧
            <flux:icon name="chevron-right" class="w-4 h-4" />
        </a>

        {{-- ユーザー設定 --}}
        <a
            href="{{ route('profile.edit') }}"
            class="flex w-full min-h-14 items-center justify-center gap-3
                   rounded-lg bg-link px-5 py-4 text-base font-medium text-white
                   shadow-sm hover:opacity-90 transition"
        >
            <flux:icon name="user" class="w-5 h-5" />
            ユーザー設定
            <flux:icon name="chevron-right" class="w-4 h-4" />
        </a>

        {{-- サインアウト --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                type="submit"
                class="flex w-full min-h-14 items-center justify-center gap-3
                       rounded-lg bg-link px-5 py-4 text-base font-medium text-white
                       shadow-sm hover:opacity-90 transition"
            >
                <flux:icon name="arrow-right-start-on-rectangle" class="w-5 h-5" />
                サインアウト
            </button>
        </form>

    </div>

</div>
