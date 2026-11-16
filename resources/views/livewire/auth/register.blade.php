
<x-layouts.auth>
    <div class="flex flex-col gap-6">
        <x-auth-header
            :title="__('アカウントを作成')"
            :description="__('以下の情報を入力してアカウントを作成してください')"
        />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Name -->
            <flux:input
                name="name"
                :label="__('名前')"
                type="text"
                required
                autofocus
                autocomplete="name"
                :placeholder="__('氏名を入力してください')"
            />

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('メールアドレス')"
                type="email"
                required
                autocomplete="email"
                placeholder="email@example.com"
            />

            <!-- Password -->
            <flux:input
                name="password"
                :label="__('パスワード')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('パスワード')"
                viewable
            />

            <!-- Confirm Password -->
            <flux:input
                name="password_confirmation"
                :label="__('パスワード（確認）')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('パスワードを再入力してください')"
                viewable
            />

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full">
                    {{ __('登録する') }}
                </flux:button>
            </div>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('すでにアカウントをお持ちですか？') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('ログイン') }}</flux:link>
        </div>
    </div>
</x-layouts.auth>
