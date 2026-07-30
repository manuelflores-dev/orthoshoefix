<div class="mx-auto flex w-full max-w-3xl flex-col gap-6" wire:poll.30s="refreshOrders">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <flux:heading size="xl">{{ __('My orders') }}</flux:heading>
            <flux:subheading>{{ __('Follow your shoes from the workbench to the counter') }}</flux:subheading>
        </div>

        <flux:button :href="route('orders.create')" icon="plus" variant="primary" wire:navigate>
            {{ __('Request a service') }}
        </flux:button>
    </div>

    {{-- Ready for pickup highlight --}}
    @if ($this->readyOrders->isNotEmpty())
        <flux:callout variant="success" icon="check-badge" :heading="__('Ready for pickup!')">
            <flux:callout.text>
                {{ trans_choice(
                    ':count order is finished and waiting for you at the shop.|:count orders are finished and waiting for you at the shop.',
                    $this->readyOrders->count(),
                    ['count' => $this->readyOrders->count()],
                ) }}
            </flux:callout.text>
        </flux:callout>
    @endif

    @forelse ($this->orders as $order)
        @php
            $accent = match ($order->status->color()) {
                'green' => 'border-green-300 dark:border-green-400/40',
                'amber' => 'border-amber-300 dark:border-amber-400/40',
                'sky' => 'border-sky-300 dark:border-sky-400/40',
                'red' => 'border-red-300 dark:border-red-400/40',
                default => 'border-zinc-200 dark:border-white/10',
            };
        @endphp

        <a
            href="{{ route('orders.show', $order) }}"
            wire:navigate
            wire:key="order-{{ $order->id }}"
            @class(['block rounded-xl border bg-white p-5 transition hover:shadow-sm dark:bg-white/5', $accent])
        >
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <div class="text-sm font-semibold text-zinc-900 dark:text-white">
                        {{ $order->service_type->label() }}
                    </div>
                    <flux:text size="sm" class="mt-0.5">
                        {{ $order->order_number }} · {{ $order->shoe_type->label() }}
                    </flux:text>
                </div>

                <x-order-status-badge :status="$order->status" size="sm" />
            </div>

            <flux:text class="mt-3 line-clamp-2">{{ $order->description }}</flux:text>

            <div class="mt-4">
                <flux:progress :value="$order->progress()" :color="$order->status->color()" />
            </div>

            <div class="mt-3 flex flex-wrap items-center justify-between gap-2">
                <flux:text size="sm">
                    {{ __('Dropped off :date', ['date' => $order->received_at->format('M j, Y')]) }}
                    @if ($order->estimated_delivery_at && $order->status->isOpen())
                        · {{ __('estimated :date', ['date' => $order->estimated_delivery_at->format('M j')]) }}
                    @endif
                </flux:text>

                <flux:text size="sm">
                    {{ $order->estimated_price !== null ? '$'.number_format((float) $order->estimated_price, 2) : __('Quote pending') }}
                </flux:text>
            </div>
        </a>
    @empty
        <flux:card class="text-center">
            <flux:icon name="shopping-bag" variant="outline" class="mx-auto size-10 text-zinc-300 dark:text-zinc-600" />

            <flux:heading size="lg" class="mt-3">{{ __('No orders yet') }}</flux:heading>
            <flux:text class="mx-auto mt-1 max-w-sm">
                {{ __('Tell us what your shoes need and we will take it from there.') }}
            </flux:text>

            <flux:button class="mt-5" :href="route('orders.create')" icon="plus" variant="primary" wire:navigate>
                {{ __('Request a service') }}
            </flux:button>
        </flux:card>
    @endforelse
</div>
