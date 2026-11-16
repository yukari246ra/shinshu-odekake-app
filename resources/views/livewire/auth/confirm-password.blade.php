
<x-layouts.auth>
    <div class="flex flex-col gap-6">
        <x-auth-header
            :title="__('パスワードの確認')"
            :description="__('セキュリティ保護のため、続行する前にパスワードを入力してください')"
        />

        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.confirm.store') }}" class="flex flex-col gap-6">
            @csrf

            <flux:input
                name="password"
                :label="__('パスワード')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('パスワード')"
                viewable
            />

            <flux:button variant="primary" type="submit" class="w-full" data-test="confirm-password-button">
                {{ __('確認する') }}
            </flux:button>
        </form>
    </div>
</x-layouts.auth>
