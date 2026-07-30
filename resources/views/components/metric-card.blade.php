@props([
    'label',
    'value',
    'icon' => null,
    'color' => 'zinc',
    'hint' => null,
    'href' => null,
])

@php
    $tone = match ($color) {
        'green' => 'bg-green-100 text-green-700 dark:bg-green-400/15 dark:text-green-300',
        'amber' => 'bg-amber-100 text-amber-700 dark:bg-amber-400/15 dark:text-amber-300',
        'sky' => 'bg-sky-100 text-sky-700 dark:bg-sky-400/15 dark:text-sky-300',
        'red' => 'bg-red-100 text-red-700 dark:bg-red-400/15 dark:text-red-300',
        default => 'bg-zinc-100 text-zinc-700 dark:bg-white/10 dark:text-zinc-200',
    };
@endphp

<flux:card {{ $attributes->class('flex items-start gap-4') }}>
    @if ($icon)
        <div @class(['flex size-11 shrink-0 items-center justify-center rounded-xl', $tone])>
            <flux:icon :name="$icon" variant="outline" class="size-5" />
        </div>
    @endif

    <div class="min-w-0 flex-1">
        <flux:text>{{ $label }}</flux:text>

        <div class="mt-1 text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white">
            @if ($href)
                <a href="{{ $href }}" wire:navigate class="hover:underline">{{ $value }}</a>
            @else
                {{ $value }}
            @endif
        </div>

        @if ($hint)
            <flux:text size="sm" class="mt-1">{{ $hint }}</flux:text>
        @endif
    </div>
</flux:card>
