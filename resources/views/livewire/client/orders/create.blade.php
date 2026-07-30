<div class="mx-auto flex w-full max-w-2xl flex-col gap-6">
    <div>
        <flux:heading size="xl">{{ __('Request a service') }}</flux:heading>
        <flux:subheading>{{ __('Tell us what your shoes need. We will confirm the price and the pickup date.') }}</flux:subheading>
    </div>

    <form wire:submit="save" class="flex flex-col gap-4">
        <flux:card>
            <flux:heading size="lg">{{ __('What do you need?') }}</flux:heading>

            <flux:radio.group wire:model="service_type" class="mt-4 max-sm:flex-col" variant="cards">
                @foreach ($this->serviceTypes as $type)
                    <flux:radio
                        :value="$type->value"
                        :label="$type->label()"
                        :description="$type->description()"
                        :icon="$type->icon()"
                    />
                @endforeach
            </flux:radio.group>

            <div class="mt-4 grid gap-4">
                <flux:select wire:model="shoe_type" :label="__('Type of shoe')">
                    @foreach ($this->shoeOptions as $value => $label)
                        <flux:select.option :value="$value">{{ $label }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:textarea
                    wire:model="description"
                    :label="__('Describe the problem or the modification')"
                    :placeholder="__('e.g. The left heel is worn out, and my podiatrist asked for a 10 mm lift on that side.')"
                    rows="5"
                />
            </div>
        </flux:card>

        <flux:card>
            <flux:heading size="lg">{{ __('Photos') }}</flux:heading>
            <flux:text class="mt-1">
                {{ __('Optional, but they help us quote faster. Up to :count photos, 5 MB each.', ['count' => \App\Livewire\Client\Orders\Create::MAX_PHOTOS]) }}
            </flux:text>

            <div class="mt-4">
                <flux:input type="file" wire:model="photos" accept="image/*" multiple />

                <div wire:loading wire:target="photos" class="mt-2">
                    <flux:text size="sm">{{ __('Uploading…') }}</flux:text>
                </div>

                @error('photos')
                    <flux:text size="sm" class="mt-2 text-red-600 dark:text-red-400">{{ $message }}</flux:text>
                @enderror

                @error('photos.*')
                    <flux:text size="sm" class="mt-2 text-red-600 dark:text-red-400">{{ $message }}</flux:text>
                @enderror

                @if (filled($photos))
                    <div class="mt-4 grid grid-cols-3 gap-3 sm:grid-cols-4">
                        @foreach ($photos as $index => $photo)
                            <div wire:key="photo-{{ $index }}" class="relative">
                                <div class="aspect-square overflow-hidden rounded-lg border border-zinc-200 dark:border-white/10">
                                    <img src="{{ $photo->temporaryUrl() }}" alt="" class="size-full object-cover" />
                                </div>

                                <flux:button
                                    class="absolute -end-2 -top-2"
                                    size="xs"
                                    variant="danger"
                                    icon="x-mark"
                                    wire:click="removePhoto({{ $index }})"
                                    square
                                />
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </flux:card>

        <flux:card>
            <flux:heading size="lg">{{ __('How can we reach you?') }}</flux:heading>

            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                <flux:input wire:model="contact_name" :label="__('Name')" />

                <flux:input
                    wire:model="contact_phone"
                    type="tel"
                    inputmode="numeric"
                    maxlength="10"
                    :label="__('Phone number')"
                    placeholder="e.g. 3135550123"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);"
                />

                <div class="sm:col-span-2">
                    <flux:input wire:model="contact_email" type="email" :label="__('Email')" />
                </div>
            </div>
        </flux:card>

        <div class="flex flex-wrap justify-end gap-2">
            <flux:button variant="ghost" :href="route('orders.index')" wire:navigate>
                {{ __('Cancel') }}
            </flux:button>

            <flux:button
                type="submit"
                variant="primary"
                icon="paper-airplane"
                wire:loading.attr="disabled"
                wire:target="save, photos"
            >
                {{ __('Send request') }}
            </flux:button>
        </div>
    </form>
</div>
