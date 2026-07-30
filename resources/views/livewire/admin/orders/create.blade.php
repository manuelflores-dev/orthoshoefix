<div class="mx-auto flex w-full max-w-3xl flex-col gap-6">
    <div>
        <flux:heading size="xl">{{ __('New intake') }}</flux:heading>
        <flux:subheading>{{ __('Register shoes that just came into the shop') }}</flux:subheading>
    </div>

    <form wire:submit="save" class="flex flex-col gap-4">
        <flux:card>
            <flux:heading size="lg">{{ __('Customer') }}</flux:heading>
            <flux:text class="mt-1">{{ __('Pick an existing customer or add one first') }}</flux:text>

            <div class="mt-4 space-y-4">
                <flux:input
                    wire:model.live.debounce.300ms="clientSearch"
                    icon="magnifying-glass"
                    :label="__('Find a customer')"
                    :placeholder="__('Name, email or phone')"
                    clearable
                />

                <flux:select wire:model="user_id" :label="__('Customer')" :placeholder="__('Select a customer')">
                    @foreach ($this->clients as $client)
                        <flux:select.option :value="$client->id">
                            {{ $client->name }} — {{ $client->phone ?? $client->email }}
                        </flux:select.option>
                    @endforeach
                </flux:select>

                @if ($this->clients->isEmpty())
                    <flux:callout variant="warning" icon="user-plus" inline>
                        <flux:callout.text>
                            {{ __('No customers match that search.') }}
                            <flux:callout.link :href="route('admin.customers.index')" wire:navigate>
                                {{ __('Add a customer') }}
                            </flux:callout.link>
                        </flux:callout.text>
                    </flux:callout>
                @endif
            </div>
        </flux:card>

        <flux:card>
            <flux:heading size="lg">{{ __('Work requested') }}</flux:heading>

            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                <flux:select wire:model="service_type" :label="__('Service type')">
                    @foreach ($this->serviceOptions as $value => $label)
                        <flux:select.option :value="$value">{{ $label }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:select wire:model="shoe_type" :label="__('Shoe type')">
                    @foreach ($this->shoeOptions as $value => $label)
                        <flux:select.option :value="$value">{{ $label }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>

            <div class="mt-4">
                <flux:textarea
                    wire:model="description"
                    :label="__('Description')"
                    :placeholder="__('What needs to be done, measurements, prescription details…')"
                    rows="4"
                />
            </div>
        </flux:card>

        <flux:card>
            <flux:heading size="lg">{{ __('Schedule and quote') }}</flux:heading>

            <div class="mt-4 grid gap-4 sm:grid-cols-3">
                <flux:input wire:model="received_at" type="date" :label="__('Received on')" />
                <flux:input wire:model="estimated_delivery_at" type="date" :label="__('Estimated delivery')" />
                <flux:input
                    wire:model="estimated_price"
                    type="number"
                    step="0.01"
                    min="0"
                    :label="__('Estimated price')"
                    placeholder="0.00"
                    icon="currency-dollar"
                />
            </div>

            <div class="mt-4">
                <flux:textarea
                    wire:model="internal_notes"
                    :label="__('Internal notes')"
                    :placeholder="__('Optional, never shown to the customer')"
                    rows="3"
                />
            </div>
        </flux:card>

        <div class="flex flex-wrap justify-end gap-2">
            <flux:button variant="ghost" :href="route('admin.orders.index')" wire:navigate>
                {{ __('Cancel') }}
            </flux:button>

            <flux:button type="submit" variant="primary" icon="plus" wire:loading.attr="disabled">
                {{ __('Register order') }}
            </flux:button>
        </div>
    </form>
</div>
