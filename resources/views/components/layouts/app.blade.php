<x-layouts.app.sidebar :title="$title ?? null">

    <!-- ▼ 共通ヘッダー（全画面に表示） -->
    <header class="w-full flex items-center justify-between px-6 py-4 bg-[var(--color-subtle)] dark:bg-[var(--color-strong)] border-b border-zinc-300 dark:border-zinc-700">

        <!-- 左：アプリ名（HOMEリンク）＋ 地図アイコン -->
        <a href="{{ route('home') }}" class="flex items-center gap-2 text-xl font-bold rounded bg-[var(--color-accent)] text-white px-4 py-2">
            <flux:icon name="truck" class="w-5 h-5" />
            信州おでかけアプリ
        </a>

        <!-- 右：マイページボタン ＋ ユーザーアイコン -->
        <a href="{{ route('mypage') }}"
           class="flex items-center gap-2 px-4 py-2 rounded bg-[var(--color-accent)] text-white font-medium hover:bg-opacity-90">
            <flux:icon name="user" class="w-5 h-5" />
            マイページ
        </a>

    </header>

    <flux:main>
        {{ $slot }}
    </flux:main>

</x-layouts.app.sidebar>
