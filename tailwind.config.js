import flux from './vendor/livewire/flux/tailwind.config.js'

export default {
  presets: [flux],
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    './vendor/livewire/flux/**/*.blade.php',
    './vendor/livewire/flux-pro/**/*.blade.php',
  ],
  safelist: [
    "text-[var(--color-text)]",
    "bg-[var(--color-subtle-2)]",
    "border-[var(--color-subtle)]",
    "bg-[var(--color-strong)]",
    "text-[var(--color-accent)]",
  ],
}
