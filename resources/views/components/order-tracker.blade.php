@props([
    'order',
    'steps',
])

<div>
    <div class="flex items-center justify-between gap-4">
        <flux:heading size="lg">{{ __('Status') }}</flux:heading>
        <x-order-status-badge :status="$order->status" />
    </div>

    <flux:text class="mt-1">{{ $order->status->description() }}</flux:text>

    <div class="mt-4">
        <flux:progress :value="$order->progress()" :color="$order->status->color()" />
    </div>

    <ol class="mt-5 grid grid-cols-2 gap-3 sm:grid-cols-4">
        @foreach ($steps as $step)
            @php
                $reached = $step['reached'];
                $current = $step['current'];
            @endphp

            <li @class([
                'rounded-xl border p-3',
                'border-zinc-200 bg-white dark:border-white/10 dark:bg-white/5' => ! $current,
                'border-zinc-900 bg-zinc-900 text-white dark:border-white dark:bg-white dark:text-zinc-900' => $current,
            ])>
                <div class="flex items-center gap-2">
                    <flux:icon
                        :name="$reached && ! $current ? 'check-circle' : $step['status']->icon()"
                        variant="outline"
                        @class([
                            'size-5 shrink-0',
                            'text-zinc-400 dark:text-zinc-500' => ! $reached,
                            'text-green-600 dark:text-green-400' => $reached && ! $current,
                        ])
                    />

                    <span @class([
                        'text-xs font-medium leading-tight',
                        'text-zinc-500 dark:text-zinc-400' => ! $reached && ! $current,
                    ])>
                        {{ $step['status']->label() }}
                    </span>
                </div>

                <div @class([
                    'mt-2 text-xs',
                    'text-zinc-500 dark:text-zinc-400' => ! $current,
                    'text-white/70 dark:text-zinc-900/70' => $current,
                ])>
                    {{ $step['at']?->format('M j, g:i A') ?? '—' }}
                </div>
            </li>
        @endforeach
    </ol>
</div>
