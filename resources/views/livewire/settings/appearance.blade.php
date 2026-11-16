<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('外観')" :subheading="__('アカウントの表示設定を変更できます')">
        <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
            <flux:radio value="light" icon="sun">{{ __('ライト') }}</flux:radio>
            <flux:radio value="dark" icon="moon">{{ __('ダーク') }}</flux:radio>
            <flux:radio value="system" icon="computer-desktop">{{ __('システム設定') }}</flux:radio>
        </flux:radio.group>
    </x-settings.layout>
</section>