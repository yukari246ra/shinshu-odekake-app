@props([
    'title',
    'description',
])

<div class="flex w-full flex-col text-center">
    <flux:heading size="xl" class="text-[#203C6A]">{{ $title }}</flux:heading>
    <flux:subheading>{{ $description }}</flux:subheading>
</div>
