
<x-layouts.auth>
    <div class="flex flex-col gap-6">
        <x-auth-header
            :title="__('アカウントにログイン')"
            :description="__('メールアドレスとパスワードを入力してください')"
        />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('メールアドレス')"
                :value="old('email')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="email@example.com"
            />

            <!-- Password -->
            <div class="relative">
                <flux:input
                    name="password"
                    :label="__('パスワード')"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('パスワード')"
                    viewable
                />

                @if (Route::has('password.request'))
                    <flux:link class="absolute top-0 text-sm end-0" :href="route('password.request')" wire:navigate>
                        {{ __('パスワードをお忘れですか？') }}
                    </flux:link>
                @endif
            </div>

            <!-- Remember Me -->
            <flux:checkbox name="remember" :label="__('ログイン状態を保持する')" :checked="old('remember')" />

            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full" data-test="login-button">
                    {{ __('ログイン') }}
                </flux:button>
            </div>
        </form>

        @if (Route::has('register'))
            <div class="space-x-1 text-sm text-center rtl:space-x-reverse text-zinc-600 dark:text-zinc-400">
                <span>{{ __('アカウントをお持ちでない方はこちら') }}</span>
                <flux:link :href="route('register')" wire:navigate>{{ __('新規登録') }}</flux:link>
            </div>
        @endif
    </div>
</x-layouts.auth>
