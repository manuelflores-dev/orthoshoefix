<div class="mx-auto flex w-full max-w-3xl flex-col gap-6">
    <div class="flex items-center gap-2">
        <flux:button size="sm" variant="ghost" icon="arrow-left" :href="route('admin.portfolio.index')" wire:navigate square />
        <flux:heading size="xl">{{ $this->item ? __('Edit case') : __('New case') }}</flux:heading>

        @if ($this->item?->is_published)
            <flux:badge color="green" icon="check-circle">{{ __('Published') }}</flux:badge>
        @endif
    </div>

    <form wire:submit="save" class="flex flex-col gap-4">
        <flux:card>
            <flux:heading size="lg">{{ __('The case') }}</flux:heading>

            <div class="mt-4 space-y-4">
                <flux:input wire:model="title" :label="__('Title')"
                            :placeholder="__('e.g. New Balance — 1.5 inch sole lift')" />

                <flux:textarea wire:model="summary" :label="__('Description')" rows="3"
                               :placeholder="__('What the customer needed and what you did.')" />

                <div class="grid gap-4 sm:grid-cols-2">
                    <flux:select wire:model.live="layout" :label="__('Photo layout')">
                        @foreach ($this->layoutOptions as $value => $label)
                            <flux:select.option :value="$value">{{ $label }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input wire:model="badge" :label="__('Ribbon')" :placeholder="__('e.g. Real Case')"
                                :description="__('Optional, shown above the title.')" />
                </div>

                <flux:input wire:model="tagList" :label="__('Tags')"
                            :placeholder="__('Leg Length, 1.5 inch Lift, Rx Required')"
                            :description="__('Separated by commas, up to 6.')" />

                <flux:switch wire:model="is_published" :label="__('Show on the website')"
                             :description="__('Needs at least one photo.')" />
            </div>
        </flux:card>

        <flux:card>
            <flux:heading size="lg">{{ __('Photos') }}</flux:heading>
            <flux:text class="mt-1">
                {{ __('This layout uses :count photos, in this order. Up to 5 MB each.', ['count' => $this->photoLimit]) }}
            </flux:text>

            {{-- Attached photos --}}
            @if ($this->item && $this->item->photos->isNotEmpty())
                <div class="mt-4 flex flex-col gap-3">
                    @foreach ($this->item->photos as $index => $photo)
                        <div wire:key="photo-{{ $photo->id }}"
                             class="flex flex-wrap items-start gap-3 rounded-xl border border-zinc-200 p-3 dark:border-white/10">
                            <div class="size-20 shrink-0 overflow-hidden rounded-lg">
                                <img src="{{ $photo->url() }}" alt="" class="size-full object-cover" />
                            </div>

                            <div class="min-w-0 flex-1 space-y-2">
                                <flux:input size="sm" wire:model="photoDetails.{{ $photo->id }}.label"
                                            :placeholder="__('Label, e.g. BEFORE or Final Result')" />
                                <flux:input size="sm" wire:model="photoDetails.{{ $photo->id }}.caption"
                                            :placeholder="__('Caption, e.g. Measurements and Rx')" />
                            </div>

                            <div class="flex items-center gap-1">
                                <flux:button size="sm" variant="ghost" icon="check" square
                                             wire:click="savePhotoDetails({{ $photo->id }})"
                                             :tooltip="__('Save caption')" />
                                <flux:button size="sm" variant="ghost" icon="chevron-up" square
                                             :disabled="$index === 0"
                                             wire:click="movePhoto({{ $photo->id }}, 'up')"
                                             :tooltip="__('Move up')" />
                                <flux:button size="sm" variant="ghost" icon="chevron-down" square
                                             :disabled="$index === $this->item->photos->count() - 1"
                                             wire:click="movePhoto({{ $photo->id }}, 'down')"
                                             :tooltip="__('Move down')" />
                                <flux:button size="sm" variant="ghost" icon="trash" square
                                             wire:click="deletePhoto({{ $photo->id }})"
                                             wire:confirm="{{ __('Remove this photo?') }}"
                                             :tooltip="__('Remove')" />
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- New photos --}}
            <div class="mt-4">
                <flux:input type="file" wire:model="uploads" accept="image/*" multiple
                            :label="__('Add photos')" />

                <div wire:loading wire:target="uploads" class="mt-2">
                    <flux:text size="sm">{{ __('Uploading…') }}</flux:text>
                </div>

                @error('uploads')
                    <flux:text size="sm" class="mt-2 text-red-600 dark:text-red-400">{{ $message }}</flux:text>
                @enderror

                @error('uploads.*')
                    <flux:text size="sm" class="mt-2 text-red-600 dark:text-red-400">{{ $message }}</flux:text>
                @enderror

                @if (filled($uploads))
                    <div class="mt-3 grid grid-cols-3 gap-3 sm:grid-cols-4">
                        @foreach ($uploads as $index => $upload)
                            <div wire:key="upload-{{ $index }}" class="relative">
                                <div class="aspect-square overflow-hidden rounded-lg border border-zinc-200 dark:border-white/10">
                                    <img src="{{ $upload->temporaryUrl() }}" alt="" class="size-full object-cover" />
                                </div>
                                <flux:button class="absolute -end-2 -top-2" size="xs" variant="danger"
                                             icon="x-mark" square wire:click="removeUpload({{ $index }})" />
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </flux:card>

        <div class="flex flex-wrap justify-end gap-2">
            <flux:button variant="ghost" :href="route('admin.portfolio.index')" wire:navigate>
                {{ __('Back') }}
            </flux:button>

            <flux:button type="submit" variant="primary" wire:loading.attr="disabled" wire:target="save, uploads">
                {{ __('Save case') }}
            </flux:button>
        </div>
    </form>

    {{-- Live preview --}}
    @if ($this->item?->photos->isNotEmpty())
        <div>
            <flux:heading size="lg" class="mb-3">{{ __('Preview') }}</flux:heading>

            <div class="rounded-2xl bg-slate-100 p-4">
                @if ($this->item->layout->isWide())
                    <x-portfolio.process-card :item="$this->item" />
                @else
                    <x-portfolio.before-after-card :item="$this->item" />
                @endif
            </div>
        </div>
    @endif
</div>
