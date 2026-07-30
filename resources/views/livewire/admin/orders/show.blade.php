@php($order = $this->order)

<div class="flex w-full flex-col gap-6">
    {{-- Header --}}
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div class="min-w-0">
            <div class="flex items-center gap-2">
                <flux:button
                    size="sm"
                    variant="ghost"
                    icon="arrow-left"
                    :href="route('admin.orders.index')"
                    wire:navigate
                    square
                />
                <flux:heading size="xl">{{ $order->order_number }}</flux:heading>
                <x-order-status-badge :status="$order->status" />
            </div>

            <flux:subheading class="mt-1">
                {{ __('Taken in on :date', ['date' => $order->received_at->format('F j, Y')]) }}
                @if ($order->createdBy)
                    · {{ __('by :name', ['name' => $order->createdBy->name]) }}
                @else
                    · {{ __('submitted online by the customer') }}
                @endif
            </flux:subheading>
        </div>

        <div class="flex flex-wrap gap-2">
            @if ($order->status->next())
                <flux:button
                    variant="primary"
                    :icon="$order->status->next()->icon()"
                    wire:click="advance"
                    wire:loading.attr="disabled"
                >
                    {{ __('Move to :status', ['status' => $order->status->next()->label()]) }}
                </flux:button>
            @endif

            @if (! $order->status->isFinal())
                <flux:button
                    variant="subtle"
                    icon="x-circle"
                    wire:click="cancel"
                    wire:confirm="{{ __('Cancel this order? The customer will see it as cancelled.') }}"
                >
                    {{ __('Cancel order') }}
                </flux:button>
            @endif
        </div>
    </div>

    @if ($order->isOverdue())
        <flux:callout variant="warning" icon="clock" :heading="__('Past the promised date')">
            <flux:callout.text>
                {{ __('This order was promised for :date.', ['date' => $order->estimated_delivery_at->format('F j, Y')]) }}
            </flux:callout.text>
        </flux:callout>
    @endif

    <div class="grid gap-4 lg:grid-cols-3">
        {{-- Order details --}}
        <div class="flex flex-col gap-4 lg:col-span-2">
            <flux:card>
                <flux:heading size="lg">{{ __('Service request') }}</flux:heading>

                <dl class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div>
                        <dt><flux:text size="sm">{{ __('Service type') }}</flux:text></dt>
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
                        <dt><flux:text size="sm">{{ __('Estimated delivery') }}</flux:text></dt>
                        <dd class="mt-1 text-sm font-medium text-zinc-900 dark:text-white">
                            {{ $order->estimated_delivery_at?->format('F j, Y') ?? __('Not set') }}
                        </dd>
                    </div>

                    <div>
                        <dt><flux:text size="sm">{{ __('Estimated price') }}</flux:text></dt>
                        <dd class="mt-1 text-sm font-medium text-zinc-900 dark:text-white">
                            {{ $order->estimated_price !== null ? '$'.number_format((float) $order->estimated_price, 2) : __('Not quoted') }}
                        </dd>
                    </div>
                </dl>

                <flux:separator class="my-5" variant="subtle" />

                <flux:text size="sm">{{ __('What the customer asked for') }}</flux:text>
                <p class="mt-2 whitespace-pre-line text-sm text-zinc-700 dark:text-zinc-200">{{ $order->description }}</p>

                @if ($order->photos->isNotEmpty())
                    <flux:separator class="my-5" variant="subtle" />

                    <flux:text size="sm">{{ __('Reference photos') }}</flux:text>
                    <div class="mt-2 grid grid-cols-2 gap-3 sm:grid-cols-4">
                        @foreach ($order->photos as $photo)
                            <a href="{{ $photo->url() }}" target="_blank" rel="noopener"
                               class="group relative block aspect-square overflow-hidden rounded-lg border border-zinc-200 dark:border-white/10">
                                <img
                                    src="{{ $photo->url() }}"
                                    alt="{{ $photo->original_name ?? __('Order photo') }}"
                                    class="size-full object-cover transition group-hover:scale-105"
                                />
                            </a>
                        @endforeach
                    </div>
                @endif
            </flux:card>

            {{-- Status history --}}
            <flux:card>
                <flux:heading size="lg">{{ __('Status history') }}</flux:heading>
                <flux:text class="mt-1">{{ __('Every change with its timestamp') }}</flux:text>

                <div class="mt-5">
                    <x-order-timeline :events="$order->statusEvents" :show-actor="true" />
                </div>
            </flux:card>
        </div>

        {{-- Management panel --}}
        <div class="flex flex-col gap-4">
            <flux:card>
                <flux:heading size="lg">{{ __('Customer') }}</flux:heading>

                <div class="mt-4 flex items-center gap-3">
                    <flux:avatar :name="$order->client->name" :initials="$order->client->initials()" />

                    <div class="min-w-0">
                        <div class="truncate text-sm font-medium text-zinc-900 dark:text-white">
                            {{ $order->client->name }}
                        </div>
                        <flux:text size="sm" class="truncate">{{ $order->client->email }}</flux:text>
                    </div>
                </div>

                <dl class="mt-4 space-y-2 text-sm">
                    <div class="flex items-center justify-between gap-3">
                        <dt><flux:text size="sm">{{ __('Contact name') }}</flux:text></dt>
                        <dd class="truncate text-zinc-900 dark:text-white">{{ $order->contact_name }}</dd>
                    </div>

                    <div class="flex items-center justify-between gap-3">
                        <dt><flux:text size="sm">{{ __('Phone') }}</flux:text></dt>
                        <dd class="text-zinc-900 dark:text-white">{{ $order->contact_phone ?? '—' }}</dd>
                    </div>

                    <div class="flex items-center justify-between gap-3">
                        <dt><flux:text size="sm">{{ __('Email') }}</flux:text></dt>
                        <dd class="truncate text-zinc-900 dark:text-white">{{ $order->contact_email ?? '—' }}</dd>
                    </div>
                </dl>

                <flux:button
                    class="mt-4 w-full"
                    size="sm"
                    variant="ghost"
                    icon="plus"
                    :href="route('admin.orders.create', ['customer' => $order->user_id])"
                    wire:navigate
                >
                    {{ __('New order for this customer') }}
                </flux:button>
            </flux:card>

            <flux:card>
                <flux:heading size="lg">{{ __('Workshop') }}</flux:heading>
                <flux:text class="mt-1">{{ __('Only the shop can see this') }}</flux:text>

                <form wire:submit="save" class="mt-4 space-y-4">
                    <flux:select wire:model="status" :label="__('Status')">
                        @foreach ($this->statusOptions as $value => $label)
                            <flux:select.option :value="$value">{{ $label }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input
                        wire:model="estimated_price"
                        type="number"
                        step="0.01"
                        min="0"
                        :label="__('Estimated price')"
                        placeholder="0.00"
                        icon="currency-dollar"
                    />

                    <flux:input
                        wire:model="estimated_delivery_at"
                        type="date"
                        :label="__('Estimated delivery')"
                    />

                    <flux:textarea
                        wire:model="internal_notes"
                        :label="__('Internal notes')"
                        :placeholder="__('Materials used, measurements, reminders…')"
                        rows="4"
                    />

                    <flux:input
                        wire:model="statusNote"
                        :label="__('Note for this update')"
                        :placeholder="__('Optional, saved in the history')"
                    />

                    <flux:button type="submit" variant="primary" class="w-full" wire:loading.attr="disabled">
                        {{ __('Save changes') }}
                    </flux:button>
                </form>
            </flux:card>
        </div>
    </div>
</div>
