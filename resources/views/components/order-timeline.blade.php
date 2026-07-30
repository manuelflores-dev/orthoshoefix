@props([
    'events',
    'showActor' => false,
])

<ol class="space-y-5 border-s border-zinc-200 ps-6 dark:border-white/10">
    @forelse ($events as $event)
        @php
            // Literal classes so Tailwind can pick them up at build time.
            $dot = match ($event->to_status->color()) {
                'sky' => 'bg-sky-500',
                'amber' => 'bg-amber-500',
                'green' => 'bg-green-500',
                'red' => 'bg-red-500',
                default => 'bg-zinc-400',
            };
        @endphp

        <li class="relative">
            <span @class(['absolute -start-[31px] mt-1.5 flex size-3 rounded-full ring-4 ring-white dark:ring-zinc-800', $dot])></span>

            <div class="flex flex-wrap items-center gap-2">
                <x-order-status-badge :status="$event->to_status" size="sm" />

                <flux:text size="sm">
                    {{ $event->created_at->format('M j, Y · g:i A') }}
                </flux:text>
            </div>

            @if ($showActor && $event->changedBy)
                <flux:text size="sm" class="mt-1">
                    {{ __('by :name', ['name' => $event->changedBy->name]) }}
                </flux:text>
            @endif

            @if (filled($event->note))
                <flux:text class="mt-1 text-zinc-600 dark:text-zinc-300">
                    {{ $event->note }}
                </flux:text>
            @endif
        </li>
    @empty
        <li>
            <flux:text>{{ __('No updates yet.') }}</flux:text>
        </li>
    @endforelse
</ol>
