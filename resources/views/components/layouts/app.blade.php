<x-layouts.app.sidebar :title="$title ?? null">

    <!-- ▼ 共通ヘッダー（全画面に表示） -->
    <header class="w-full flex items-center justify-between px-6 py-4 bg-zinc-100 dark:bg-zinc-800 border-b border-zinc-300 dark:border-zinc-700">

        <!-- 左：アプリ名（HOMEリンク） -->
        <a href="{{ route('home') }}" class="text-xl font-bold text-zinc-900 dark:text-zinc-100">
            信州おでかけアプリ
        </a>

        <!-- 右：マイページボタン -->
        <a href="{{ route('mypage') }}"
           class="px-4 py-2 rounded bg-zinc-900 text-white dark:bg-zinc-200 dark:text-zinc-900 font-medium">
            マイページ
        </a>

    </header>

    <flux:main>
        {{ $slot }}
    </flux:main>

</x-layouts.app.sidebar>
