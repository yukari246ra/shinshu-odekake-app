<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
        <div class="bg-[#F0F8F8] flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10 dark:bg-neutral-950">
            <div class="flex w-full max-w-md flex-col gap-6">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                    <span class="mb-1 flex h-12 w-12 items-center justify-center rounded-xl bg-white shadow-sm">
                        <x-app-logo-icon class="size-9 fill-current text-[#26AFA4] dark:text-[#26AFA4]" />
                    </span>
                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                </a>

                <div class="flex flex-col gap-6 rounded-2xl border border-[#D5E9E9] bg-white p-6 shadow-lg shadow-[#203C6A]/5 sm:p-8">
                    {{ $slot }}
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
