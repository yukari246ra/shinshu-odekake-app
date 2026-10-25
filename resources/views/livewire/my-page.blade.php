<div class="max-w-lg mx-auto p-6 space-y-8">

    {{-- ▼ ページタイトル（ジャンプ率：h1） --}}
    <h1 class="text-2xl font-bold text-center text-[#002C47] mb-6">
        マイページ
    </h1>

    {{-- ▼ メニュー（カード統一：rounded-lg / border-subtle / p-4） --}}
    <div class="space-y-4">

        {{-- お気に入り一覧 --}}
        <a
            href="{{ route('mypage.favorites') }}"
            class="block w-full text-center h-10 flex items-center justify-center
                   rounded-lg bg-[var(--color-subtle)] text-[#002C47] font-medium shadow-sm
                   hover:bg-zinc-100 dark:hover:bg-zinc-700"
        >
            お気に入り一覧
        </a>

        {{-- ユーザー設定 --}}
        <a
            href="{{ route('profile.edit') }}"
            class="block w-full text-center h-10 flex items-center justify-center
                   rounded-lg bg-[var(--color-subtle)] text-[#002C47] font-medium shadow-sm
                   hover:bg-zinc-100 dark:hover:bg-zinc-700"
        >
            ユーザー設定
        </a>

        {{-- サインアウト --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                type="submit"
                class="block w-full text-center h-10 flex items-center justify-center
                       rounded-lg bg-[var(--color-subtle)] text-[#002C47] font-medium shadow-sm
                       hover:bg-zinc-100 dark:hover:bg-zinc-700"
            >
                サインアウト
            </button>
        </form>

    </div>

</div>
