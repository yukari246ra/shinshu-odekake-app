<section class="mt-10 space-y-6">
    <div class="relative mb-5">
        <flux:heading>{{ __('アカウントを削除') }}</flux:heading>
        <flux:subheading>{{ __('アカウントとすべての関連データを削除します') }}</flux:subheading>
    </div>

    <flux:modal.trigger name="confirm-user-deletion">
        <flux:button variant="danger" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
            {{ __('アカウントを削除') }}
        </flux:button>
    </flux:modal.trigger>

    <flux:modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable class="max-w-lg">
        <form method="POST" wire:submit="deleteUser" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('本当にアカウントを削除しますか？') }}</flux:heading>

                <flux:subheading>
                    {{ __('アカウントを削除すると、すべての関連データが完全に削除されます。アカウントを完全に削除するには、確認のためパスワードを入力してください。') }}
                </flux:subheading>
            </div>

            <flux:input wire:model="password" :label="__('パスワード')" type="password" />

            <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                <flux:modal.close>
                    <flux:button variant="filled">{{ __('キャンセル') }}</flux:button>
                </flux:modal.close>

                <flux:button variant="danger" type="submit">{{ __('アカウントを削除') }}</flux:button>
            </div>
        </form>
    </flux:modal>
</section>