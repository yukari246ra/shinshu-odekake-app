<div class="max-w-lg mx-auto p-6">

    <!-- タイトル -->
    <h1 class="text-2xl font-bold mb-6 text-center">マイページ</h1>

    <!-- メニュー -->
    <div class="space-y-3">

        <!-- お気に入り一覧 -->
        <a
            href="{{ route('mypage.favorites') }}"
            class="block w-full text-center py-3 bg-white dark:bg-zinc-800 shadow rounded-lg font-medium hover:bg-zinc-100 dark:hover:bg-zinc-700"
        >
            お気に入り一覧
        </a>

        <!-- ユーザー設定 -->
        <a
            href="{{ route('profile.edit') }}"
            class="block w-full text-center py-3 bg-white dark:bg-zinc-800 shadow rounded-lg font-medium hover:bg-zinc-100 dark:hover:bg-zinc-700"
        >
            ユーザー設定
        </a>

        <!-- サインアウト -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                type="submit"
                class="block w-full text-center py-3 bg-white dark:bg-zinc-800 shadow rounded-lg font-medium hover:bg-zinc-100 dark:hover:bg-zinc-700"
            >
                サインアウト
            </button>
        </form>

    </div>

</div>
