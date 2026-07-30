<div class="flex w-full flex-col gap-6" wire:poll.60s>
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <flux:heading size="xl">{{ __('Workshop dashboard') }}</flux:heading>
            <flux:subheading>{{ __('Today is :date', ['date' => today()->format('l, F j, Y')]) }}</flux:subheading>
        </div>

        <div class="flex gap-2">
            <flux:button :href="route('admin.customers.index')" icon="users" variant="ghost" wire:navigate>
                {{ __('Customers') }}
            </flux:button>

            <flux:button :href="route('admin.orders.create')" icon="plus" variant="primary" wire:navigate>
                {{ __('New intake') }}
            </flux:button>
        </div>
    </div>

    {{-- Metrics --}}
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-metric-card
            :label="__('Active orders')"
            :value="$this->metrics['active']"
            icon="wrench-screwdriver"
            color="amber"
            :hint="__('Received and in process')"
            :href="route('admin.orders.index', ['status' => \App\Enums\OrderStatus::InProcess->value])"
        />

        <x-metric-card
            :label="__('Ready for pickup')"
            :value="$this->metrics['ready']"
            icon="check-badge"
            color="green"
            :hint="__('Waiting for the customer')"
            :href="route('admin.orders.index', ['status' => \App\Enums\OrderStatus::Ready->value])"
        />

        <x-metric-card
            :label="__('Completed this month')"
            :value="$this->metrics['delivered_this_month']"
            icon="truck"
            color="sky"
            :hint="now()->format('F Y')"
            :href="route('admin.orders.index', ['status' => \App\Enums\OrderStatus::Delivered->value])"
        />

        <x-metric-card
            :label="__('Revenue this month')"
            :value="'$'.number_format($this->metrics['revenue_this_month'], 2)"
            icon="banknotes"
            color="zinc"
            :hint="__('Delivered orders')"
        />
    </div>

    <div class="grid gap-4 lg:grid-cols-3">
        {{-- Pipeline --}}
        <flux:card class="lg:col-span-1">
            <flux:heading size="lg">{{ __('Pipeline') }}</flux:heading>
            <flux:text class="mt-1">{{ __('Orders currently in each stage') }}</flux:text>

            <div class="mt-4 space-y-3">
                @foreach (\App\Enums\OrderStatus::pipeline() as $status)
                    <a
                        href="{{ route('admin.orders.index', ['status' => $status->value]) }}"
                        wire:navigate
                        class="flex items-center justify-between gap-3 rounded-lg px-2 py-1.5 hover:bg-zinc-50 dark:hover:bg-white/5"
                    >
                        <x-order-status-badge :status="$status" size="sm" />

                        <span class="text-sm font-semibold text-zinc-900 dark:text-white">
                            {{ $this->pipeline[$status->value] }}
                        </span>
                    </a>
                @endforeach
            </div>

            @if ($this->metrics['overdue'] > 0)
                <flux:callout variant="warning" icon="clock" class="mt-4" inline>
                    <flux:callout.text>
                        {{ trans_choice(':count order is past its promised date|:count orders are past their promised date', $this->metrics['overdue'], ['count' => $this->metrics['overdue']]) }}
                    </flux:callout.text>
                </flux:callout>
            @endif
        </flux:card>

        {{-- Ready for pickup --}}
        <flux:card class="lg:col-span-2">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <flux:heading size="lg">{{ __('Ready for pickup') }}</flux:heading>
                    <flux:text class="mt-1">{{ __('Call the customer or hand them over') }}</flux:text>
                </div>

                <flux:badge color="green">{{ $this->metrics['ready'] }}</flux:badge>
            </div>

            <div class="mt-4 divide-y divide-zinc-100 dark:divide-white/10">
                @forelse ($this->readyOrders as $order)
                    <div class="flex flex-wrap items-center justify-between gap-3 py-3">
                        <div class="min-w-0">
                            <a
                                href="{{ route('admin.orders.show', $order) }}"
                                wire:navigate
                                class="text-sm font-medium text-zinc-900 hover:underline dark:text-white"
                            >
                                {{ $order->order_number }} · {{ $order->client->name }}
                            </a>

                            <flux:text size="sm" class="mt-0.5">
                                {{ $order->shoe_type->label() }} — {{ $order->service_type->label() }}
                                @if ($order->ready_at)
                                    · {{ __('ready :time', ['time' => $order->ready_at->diffForHumans()]) }}
                                @endif
                            </flux:text>
                        </div>

                        <flux:button
                            size="sm"
                            variant="ghost"
                            icon="truck"
                            :href="route('admin.orders.show', $order)"
                            wire:navigate
                        >
                            {{ __('Open') }}
                        </flux:button>
                    </div>
                @empty
                    <div class="py-8 text-center">
                        <flux:icon name="check-circle" variant="outline" class="mx-auto size-8 text-zinc-300 dark:text-zinc-600" />
                        <flux:text class="mt-2">{{ __('Nothing waiting for pickup right now.') }}</flux:text>
                    </div>
                @endforelse
            </div>
        </flux:card>
    </div>

    {{-- Latest intake --}}
    <flux:card>
        <div class="flex items-center justify-between gap-4">
            <flux:heading size="lg">{{ __('Latest intake') }}</flux:heading>

            <flux:button size="sm" variant="ghost" :href="route('admin.orders.index')" wire:navigate>
                {{ __('View all orders') }}
            </flux:button>
        </div>

        <div class="mt-4">
            <flux:table>
                <flux:table.columns>
                    <flux:table.column>{{ __('Order') }}</flux:table.column>
                    <flux:table.column>{{ __('Customer') }}</flux:table.column>
                    <flux:table.column class="hidden sm:table-cell">{{ __('Service') }}</flux:table.column>
                    <flux:table.column class="hidden md:table-cell">{{ __('Received') }}</flux:table.column>
                    <flux:table.column>{{ __('Status') }}</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @forelse ($this->recentOrders as $order)
                        <flux:table.row :key="$order->id">
                            <flux:table.cell variant="strong">
                                <a href="{{ route('admin.orders.show', $order) }}" wire:navigate class="hover:underline">
                                    {{ $order->order_number }}
                                </a>
                            </flux:table.cell>

                            <flux:table.cell>{{ $order->client->name }}</flux:table.cell>

                            <flux:table.cell class="hidden sm:table-cell">
                                {{ $order->service_type->label() }}
                            </flux:table.cell>

                            <flux:table.cell class="hidden md:table-cell">
                                {{ $order->received_at->format('M j, Y') }}
                            </flux:table.cell>

                            <flux:table.cell>
                                <x-order-status-badge :status="$order->status" size="sm" />
                            </flux:table.cell>
                        </flux:table.row>
                    @empty
                        <flux:table.row>
                            <flux:table.cell colspan="5">
                                {{ __('No orders registered yet.') }}
                            </flux:table.cell>
                        </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>
        </div>
    </flux:card>
</div>
