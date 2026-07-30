@php($order = $this->order)

<div class="mx-auto flex w-full max-w-3xl flex-col gap-4" wire:poll.30s="refreshOrder">
    <div class="flex items-center gap-2">
        <flux:button size="sm" variant="ghost" icon="arrow-left" :href="route('orders.index')" wire:navigate square />
        <flux:heading size="xl">{{ $order->order_number }}</flux:heading>
    </div>

    @if ($order->isReadyForPickup())
        <flux:callout variant="success" icon="check-badge" :heading="__('Your shoes are ready!')">
            <flux:callout.text>
                {{ __('Come by the shop to pick them up. We are holding them for you since :date.', [
                    'date' => $order->ready_at?->format('F j') ?? today()->format('F j'),
                ]) }}
            </flux:callout.text>
        </flux:callout>
    @endif

    {{-- Tracker --}}
    <flux:card>
        <x-order-tracker :order="$order" :steps="$this->steps" />
    </flux:card>

    {{-- Order summary --}}
    <flux:card>
        <flux:heading size="lg">{{ __('Order details') }}</flux:heading>

        <dl class="mt-4 grid gap-4 sm:grid-cols-2">
            <div>
                <dt><flux:text size="sm">{{ __('Service') }}</flux:text></dt>
                <dd class="mt-1 flex items-center gap-2 text-sm font-medium text-zinc-900 dark:text-white">
                    <flux:icon :name="$order->service_type->icon()" variant="outline" class="size-4" />
                    {{ $order->service_type->label() }}
                </dd>
            </div>

            <div>
                <dt><flux:text size="sm">{{ __('Shoe type') }}</flux:text></dt>
                <dd class="mt-1 text-sm font-medium text-zinc-900 dark:text-white">
                    {{ $order->shoe_type->label() }}
                </dd>
            </div>

            <div>
                <dt><flux:text size="sm">{{ __('Dropped off') }}</flux:text></dt>
                <dd class="mt-1 text-sm font-medium text-zinc-900 dark:text-white">
                    {{ $order->received_at->format('F j, Y') }}
                </dd>
            </div>

            <div>
                <dt><flux:text size="sm">{{ __('Estimated pickup') }}</flux:text></dt>
                <dd class="mt-1 text-sm font-medium text-zinc-900 dark:text-white">
                    {{ $order->estimated_delivery_at?->format('F j, Y') ?? __('We will confirm soon') }}
                </dd>
            </div>

            <div>
                <dt><flux:text size="sm">{{ __('Estimated price') }}</flux:text></dt>
                <dd class="mt-1 text-sm font-medium text-zinc-900 dark:text-white">
                    {{ $order->estimated_price !== null ? '$'.number_format((float) $order->estimated_price, 2) : __('Quote pending') }}
                </dd>
            </div>

            <div>
                <dt><flux:text size="sm">{{ __('Contact') }}</flux:text></dt>
                <dd class="mt-1 text-sm font-medium text-zinc-900 dark:text-white">
                    {{ $order->contact_phone ?? $order->contact_email }}
                </dd>
            </div>
        </dl>

        <flux:separator class="my-5" variant="subtle" />

        <flux:text size="sm">{{ __('What you asked for') }}</flux:text>
        <p class="mt-2 whitespace-pre-line text-sm text-zinc-700 dark:text-zinc-200">{{ $order->description }}</p>

        @if ($order->photos->isNotEmpty())
            <flux:separator class="my-5" variant="subtle" />

            <flux:text size="sm">{{ __('Photos you sent') }}</flux:text>
            <div class="mt-2 grid grid-cols-2 gap-3 sm:grid-cols-4">
                @foreach ($order->photos as $photo)
                    <a href="{{ $photo->url() }}" target="_blank" rel="noopener"
                       class="block aspect-square overflow-hidden rounded-lg border border-zinc-200 dark:border-white/10">
                        <img src="{{ $photo->url() }}" alt="{{ $photo->original_name ?? __('Order photo') }}"
                             class="size-full object-cover" />
                    </a>
                @endforeach
            </div>
        @endif
    </flux:card>

    {{-- History --}}
    <flux:card>
        <flux:heading size="lg">{{ __('Progress updates') }}</flux:heading>

        <div class="mt-5">
            <x-order-timeline :events="$order->statusEvents" />
        </div>
    </flux:card>

    <flux:text size="sm" class="text-center">
        {{ __('This page updates automatically — keep it open or check back any time.') }}
    </flux:text>
</div>
