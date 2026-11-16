
<x-layouts.auth>
    <div class="flex flex-col gap-6">
        <x-auth-header
            :title="__('パスワードをお忘れですか？')"
            :description="__('パスワード再設定用のリンクをメールで受け取るため、メールアドレスを入力してください')"
        />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('メールアドレス')"
                type="email"
                required
                autofocus
                placeholder="email@example.com"
            />

            <flux:button variant="primary" type="submit" class="w-full" data-test="email-password-reset-link-button">
                {{ __('パスワード再設定メールを送信') }}
            </flux:button>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-400">
            <span>{{ __('または') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('ログイン画面に戻る') }}</flux:link>
        </div>
    </div>
</x-layouts.auth>
