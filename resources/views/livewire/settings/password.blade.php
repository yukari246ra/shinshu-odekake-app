<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('パスワードを変更')" :subheading="__('安全性を保つため、推測されにくい長いパスワードを設定してください')">
        <form method="POST" wire:submit="updatePassword" class="mt-6 space-y-6">
            <flux:input
                wire:model="current_password"
                :label="__('現在のパスワード')"
                type="password"
                required
                autocomplete="current-password"
            />
            <flux:input
                wire:model="password"
                :label="__('新しいパスワード')"
                type="password"
                required
                autocomplete="new-password"
            />
            <flux:input
                wire:model="password_confirmation"
                :label="__('新しいパスワード（確認）')"
                type="password"
                required
                autocomplete="new-password"
            />

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('保存') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="password-updated">
                    {{ __('保存しました。') }}
                </x-action-message>
            </div>
        </form>
    </x-settings.layout>
</section>