
<x-layouts.app.sidebar :title="$title ?? null">

    <flux:main class="!p-0">

        <header class="flex w-full flex-wrap items-center justify-between gap-3 border-b border-zinc-300 bg-[var(--color-subtle)] px-4 py-3 dark:border-zinc-700 dark:bg-[var(--color-strong)] sm:px-6 sm:py-4">

            <a href="{{ route('home') }}"
               class="flex shrink-0 items-center gap-2 whitespace-nowrap rounded-lg bg-[var(--color-accent)] px-3 py-2 text-base font-bold text-white sm:px-4 sm:text-xl">
                <flux:icon name="truck" class="h-5 w-5 shrink-0" />
                信州おでかけアプリ
            </a>

            <a href="{{ route('mypage') }}"
               class="flex shrink-0 items-center gap-2 whitespace-nowrap rounded-lg bg-[var(--color-accent)] px-3 py-2 text-sm font-medium text-white hover:bg-opacity-90 sm:px-4 sm:text-base">
                <flux:icon name="user" class="h-5 w-5 shrink-0" />
                マイページ
            </a>

        </header>

        <div class="p-6">
            {{ $slot }}
        </div>

    </flux:main>

</x-layouts.app.sidebar>
