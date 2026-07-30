<div class="flex w-full flex-col gap-6">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <flux:heading size="xl">{{ __('Orders') }}</flux:heading>
            <flux:subheading>{{ __('Every repair and modification that went through the shop') }}</flux:subheading>
        </div>

        <flux:button :href="route('admin.orders.create')" icon="plus" variant="primary" wire:navigate>
            {{ __('New intake') }}
        </flux:button>
    </div>

    {{-- Filters --}}
    <flux:card>
        <div class="grid gap-3 md:grid-cols-2 xl:grid-cols-5">
            <div class="xl:col-span-2">
                <flux:input
                    wire:model.live.debounce.400ms="search"
                    icon="magnifying-glass"
                    :label="__('Search')"
                    :placeholder="__('Order number, customer, phone…')"
                    clearable
                />
            </div>

            <flux:select wire:model.live="status" :label="__('Status')">
                <flux:select.option value="">{{ __('All statuses') }}</flux:select.option>
                @foreach ($this->statusOptions as $value => $label)
                    <flux:select.option :value="$value">{{ $label }}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:select wire:model.live="service" :label="__('Service')">
                <flux:select.option value="">{{ __('All services') }}</flux:select.option>
                @foreach ($this->serviceOptions as $value => $label)
                    <flux:select.option :value="$value">{{ $label }}</flux:select.option>
                @endforeach
            </flux:select>

            <div class="grid grid-cols-2 gap-2">
                <flux:input wire:model.live="from" type="date" :label="__('From')" />
                <flux:input wire:model.live="to" type="date" :label="__('To')" />
            </div>
        </div>

        <div class="mt-3 flex items-center justify-between gap-3">
            <flux:text size="sm">
                {{ trans_choice(':count order|:count orders', $this->orders->total(), ['count' => $this->orders->total()]) }}
            </flux:text>

            @if ($this->hasFilters)
                <flux:button size="sm" variant="ghost" icon="arrow-path" wire:click="clearFilters">
                    {{ __('Clear filters') }}
                </flux:button>
            @endif
        </div>
    </flux:card>

    {{-- Desktop table --}}
    <flux:card class="hidden md:block">
        <flux:table :paginate="$this->orders">
            <flux:table.columns>
                <flux:table.column>{{ __('Order') }}</flux:table.column>
                <flux:table.column>{{ __('Customer') }}</flux:table.column>
                <flux:table.column class="hidden lg:table-cell">{{ __('Service') }}</flux:table.column>
                <flux:table.column class="hidden lg:table-cell">{{ __('Received') }}</flux:table.column>
                <flux:table.column class="hidden xl:table-cell">{{ __('Due') }}</flux:table.column>
                <flux:table.column align="end" class="hidden xl:table-cell">{{ __('Price') }}</flux:table.column>
                <flux:table.column>{{ __('Status') }}</flux:table.column>
                <flux:table.column align="end">{{ __('Actions') }}</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($this->orders as $order)
                    <flux:table.row :key="$order->id">
                        <flux:table.cell variant="strong">
                            <a href="{{ route('admin.orders.show', $order) }}" wire:navigate class="hover:underline">
                                {{ $order->order_number }}
                            </a>
                        </flux:table.cell>

                        <flux:table.cell>
                            <span class="block truncate">{{ $order->client->name }}</span>
                            <flux:text size="sm">{{ $order->contact_phone }}</flux:text>
                        </flux:table.cell>

                        <flux:table.cell class="hidden lg:table-cell">
                            <span class="block truncate">{{ $order->service_type->label() }}</span>
                            <flux:text size="sm">{{ $order->shoe_type->label() }}</flux:text>
                        </flux:table.cell>

                        <flux:table.cell class="hidden lg:table-cell">{{ $order->received_at->format('M j, Y') }}</flux:table.cell>

                        <flux:table.cell class="hidden xl:table-cell">
                            @if ($order->estimated_delivery_at)
                                <span @class(['text-red-600 dark:text-red-400' => $order->isOverdue()])>
                                    {{ $order->estimated_delivery_at->format('M j, Y') }}
                                </span>
                            @else
                                —
                            @endif
                        </flux:table.cell>

                        <flux:table.cell align="end" class="hidden xl:table-cell">
                            {{ $order->estimated_price !== null ? '$'.number_format((float) $order->estimated_price, 2) : '—' }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <x-order-status-badge :status="$order->status" size="sm" />
                        </flux:table.cell>

                        <flux:table.cell align="end">
                            <flux:dropdown position="bottom" align="end">
                                <flux:button size="sm" variant="ghost" icon="ellipsis-horizontal" square />

                                <flux:menu>
                                    <flux:menu.item icon="document-text" :href="route('admin.orders.show', $order)" wire:navigate>
                                        {{ __('Open detail') }}
                                    </flux:menu.item>

                                    <flux:menu.separator />

                                    @foreach ($this->statusOptions as $value => $label)
                                        @if ($value !== $order->status->value)
                                            <flux:menu.item
                                                wire:click="markAs({{ $order->id }}, '{{ $value }}')"
                                                :icon="\App\Enums\OrderStatus::from($value)->icon()"
                                            >
                                                {{ __('Mark as :status', ['status' => $label]) }}
                                            </flux:menu.item>
                                        @endif
                                    @endforeach
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="8">
                            {{ __('No orders match these filters.') }}
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>

    {{-- Mobile list --}}
    <div class="flex flex-col gap-3 md:hidden">
        @forelse ($this->orders as $order)
            <flux:card wire:key="mobile-{{ $order->id }}" size="sm">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <a href="{{ route('admin.orders.show', $order) }}" wire:navigate
                           class="text-sm font-semibold text-zinc-900 hover:underline dark:text-white">
                            {{ $order->order_number }}
                        </a>
                        <flux:text size="sm" class="mt-0.5 truncate">{{ $order->client->name }}</flux:text>
                    </div>

                    <x-order-status-badge :status="$order->status" size="sm" />
                </div>

                <flux:text class="mt-2">
                    {{ $order->service_type->label() }} · {{ $order->shoe_type->label() }}
                </flux:text>

                <div class="mt-3 flex items-center justify-between gap-2">
                    <flux:text size="sm">
                        {{ $order->received_at->format('M j') }}
                        @if ($order->estimated_delivery_at)
                            → {{ $order->estimated_delivery_at->format('M j') }}
                        @endif
                    </flux:text>

                    <flux:button size="sm" variant="ghost" :href="route('admin.orders.show', $order)" wire:navigate>
                        {{ __('Manage') }}
                    </flux:button>
                </div>
            </flux:card>
        @empty
            <flux:card size="sm">
                <flux:text>{{ __('No orders match these filters.') }}</flux:text>
            </flux:card>
        @endforelse

        <flux:pagination :paginator="$this->orders" />
    </div>
</div>
