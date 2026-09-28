<div class="max-w-md mx-auto p-6">

    <!-- タイトル -->
    <h1 class="text-2xl font-bold mb-6 text-center">マイページ</h1>

    <!-- アプリ名（控えめにする） -->
    <div class="bg-zinc-100 dark:bg-zinc-700 text-center py-2 rounded-lg mb-4">
        <span class="text-base font-medium">信州おでかけアプリ</span>
    </div>

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

    <!-- 戻る -->
    <div class="mt-6 text-center">
        <a href="{{ route('home') }}" class="text-blue-600 hover:underline">
            ← 戻る
        </a>
    </div>

</div>
