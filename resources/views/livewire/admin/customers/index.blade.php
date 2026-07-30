<div class="flex w-full flex-col gap-6">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <flux:heading size="xl">{{ __('Customers') }}</flux:heading>
            <flux:subheading>{{ __('Everyone who has brought shoes to the shop') }}</flux:subheading>
        </div>

        <flux:modal.trigger name="create-customer">
            <flux:button icon="user-plus" variant="primary">{{ __('Add customer') }}</flux:button>
        </flux:modal.trigger>
    </div>

    @if ($this->temporaryPassword)
        <flux:callout variant="success" icon="check-badge" :heading="__('Customer created')">
            <flux:callout.text>
                {{ __('Temporary password:') }}
                <span class="font-mono font-semibold">{{ $this->temporaryPassword }}</span>
                — {{ __('write it down and hand it to the customer, it will not be shown again.') }}
            </flux:callout.text>

            <x-slot name="actions">
                <flux:button size="sm" variant="ghost" wire:click="dismissTemporaryPassword">
                    {{ __('Dismiss') }}
                </flux:button>
            </x-slot>
        </flux:callout>
    @endif

    <flux:card>
        <flux:input
            wire:model.live.debounce.400ms="search"
            icon="magnifying-glass"
            :placeholder="__('Search by name, email or phone')"
            clearable
        />

        {{-- Desktop table --}}
        <div class="mt-4 hidden md:block">
            <flux:table :paginate="$this->customers">
                <flux:table.columns>
                    <flux:table.column>{{ __('Customer') }}</flux:table.column>
                    <flux:table.column>{{ __('Phone') }}</flux:table.column>
                    <flux:table.column align="end">{{ __('Orders') }}</flux:table.column>
                    <flux:table.column align="end">{{ __('Open') }}</flux:table.column>
                    <flux:table.column align="end">{{ __('Ready') }}</flux:table.column>
                    <flux:table.column align="end">{{ __('Actions') }}</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @forelse ($this->customers as $customer)
                        <flux:table.row :key="$customer->id">
                            <flux:table.cell variant="strong">
                                <div class="flex items-center gap-3">
                                    <flux:avatar size="sm" :name="$customer->name" :initials="$customer->initials()" />
                                    <div class="min-w-0">
                                        <div class="truncate">{{ $customer->name }}</div>
                                        <flux:text size="sm" class="truncate">{{ $customer->email }}</flux:text>
                                    </div>
                                </div>
                            </flux:table.cell>

                            <flux:table.cell>{{ $customer->phone ?? '—' }}</flux:table.cell>

                            <flux:table.cell align="end">{{ $customer->orders_count }}</flux:table.cell>

                            <flux:table.cell align="end">
                                @if ($customer->open_orders_count > 0)
                                    <flux:badge color="amber" size="sm">{{ $customer->open_orders_count }}</flux:badge>
                                @else
                                    —
                                @endif
                            </flux:table.cell>

                            <flux:table.cell align="end">
                                @if ($customer->ready_orders_count > 0)
                                    <flux:badge color="green" size="sm">{{ $customer->ready_orders_count }}</flux:badge>
                                @else
                                    —
                                @endif
                            </flux:table.cell>

                            <flux:table.cell align="end">
                                <div class="flex justify-end gap-1">
                                    <flux:button
                                        size="sm"
                                        variant="ghost"
                                        icon="clipboard-document-list"
                                        :href="route('admin.orders.index', ['q' => $customer->email])"
                                        wire:navigate
                                        :tooltip="__('View orders')"
                                        square
                                    />

                                    <flux:button
                                        size="sm"
                                        variant="ghost"
                                        icon="plus"
                                        :href="route('admin.orders.create', ['customer' => $customer->id])"
                                        wire:navigate
                                        :tooltip="__('New order')"
                                        square
                                    />
                                </div>
                            </flux:table.cell>
                        </flux:table.row>
                    @empty
                        <flux:table.row>
                            <flux:table.cell colspan="6">{{ __('No customers found.') }}</flux:table.cell>
                        </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>
        </div>

        {{-- Mobile list --}}
        <div class="mt-4 flex flex-col gap-3 md:hidden">
            @forelse ($this->customers as $customer)
                <div wire:key="mobile-customer-{{ $customer->id }}"
                     class="rounded-xl border border-zinc-200 p-3 dark:border-white/10">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <div class="truncate text-sm font-semibold text-zinc-900 dark:text-white">
                                {{ $customer->name }}
                            </div>
                            <flux:text size="sm" class="truncate">{{ $customer->email }}</flux:text>
                            <flux:text size="sm">{{ $customer->phone ?? '—' }}</flux:text>
                        </div>

                        @if ($customer->ready_orders_count > 0)
                            <flux:badge color="green" size="sm">{{ __('Ready') }}</flux:badge>
                        @endif
                    </div>

                    <div class="mt-3 flex items-center justify-between gap-2">
                        <flux:text size="sm">
                            {{ trans_choice(':count order|:count orders', $customer->orders_count, ['count' => $customer->orders_count]) }}
                        </flux:text>

                        <flux:button
                            size="sm"
                            variant="ghost"
                            icon="plus"
                            :href="route('admin.orders.create', ['customer' => $customer->id])"
                            wire:navigate
                        >
                            {{ __('New order') }}
                        </flux:button>
                    </div>
                </div>
            @empty
                <flux:text>{{ __('No customers found.') }}</flux:text>
            @endforelse

            <flux:pagination :paginator="$this->customers" />
        </div>
    </flux:card>

    {{-- Create customer --}}
    <flux:modal name="create-customer" class="w-full md:max-w-lg">
        <form wire:submit="createCustomer" class="space-y-5">
            <div>
                <flux:heading size="lg">{{ __('Add customer') }}</flux:heading>
                <flux:text class="mt-1">
                    {{ __('Register a walk-in customer so they can follow their order online.') }}
                </flux:text>
            </div>

            <flux:input wire:model="name" :label="__('Full name')" :placeholder="__('Jane Doe')" />

            <flux:input wire:model="email" type="email" :label="__('Email')" placeholder="jane@example.com" />

            <flux:input
                wire:model="phone"
                type="tel"
                inputmode="numeric"
                maxlength="10"
                :label="__('Phone number')"
                placeholder="e.g. 3135550123"
                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);"
            />

            <flux:switch
                wire:model.live="generatePassword"
                :label="__('Generate a temporary password')"
                :description="__('Turn this off to type a password yourself.')"
            />

            @unless ($generatePassword)
                <flux:input wire:model="password" type="password" :label="__('Password')" viewable />
            @endunless

            <div class="flex justify-end gap-2">
                <flux:modal.close>
                    <flux:button variant="ghost">{{ __('Cancel') }}</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="primary" wire:loading.attr="disabled">
                    {{ __('Create customer') }}
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>
