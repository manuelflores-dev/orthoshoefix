<div class="flex w-full flex-col gap-6">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <flux:heading size="xl">{{ __('Portfolio') }}</flux:heading>
            <flux:subheading>{{ __('The before / after cases shown on the website') }}</flux:subheading>
        </div>

        <div class="flex gap-2">
            <flux:button :href="route('portfolio')" icon="arrow-top-right-on-square" variant="ghost" target="_blank">
                {{ __('View public page') }}
            </flux:button>

            <flux:button :href="route('admin.portfolio.create')" icon="plus" variant="primary" wire:navigate>
                {{ __('New case') }}
            </flux:button>
        </div>
    </div>

    @if ($this->items->isEmpty())
        <flux:card class="text-center">
            <flux:icon name="photo" variant="outline" class="mx-auto size-10 text-zinc-300 dark:text-zinc-600" />
            <flux:heading size="lg" class="mt-3">{{ __('No cases yet') }}</flux:heading>
            <flux:text class="mx-auto mt-1 max-w-md">
                {{ __('Add your best work with before and after photos. Published cases show up on the home page and on the portfolio page.') }}
            </flux:text>
            <flux:button class="mt-5" :href="route('admin.portfolio.create')" icon="plus" variant="primary" wire:navigate>
                {{ __('Add the first case') }}
            </flux:button>
        </flux:card>
    @else
        <div class="flex flex-col gap-3">
            @foreach ($this->items as $index => $item)
                <flux:card wire:key="item-{{ $item->id }}" size="sm">
                    <div class="flex flex-wrap items-start gap-4">
                        {{-- Thumbnails --}}
                        <div class="flex gap-1">
                            @forelse ($item->photos->take(4) as $photo)
                                <div class="size-16 overflow-hidden rounded-lg border border-zinc-200 dark:border-white/10">
                                    <img src="{{ $photo->url() }}" alt="" class="size-full object-cover" />
                                </div>
                            @empty
                                <div class="flex size-16 items-center justify-center rounded-lg border border-dashed border-zinc-300 dark:border-white/20">
                                    <flux:icon name="photo" variant="outline" class="size-5 text-zinc-400" />
                                </div>
                            @endforelse
                        </div>

                        {{-- Details --}}
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <a href="{{ route('admin.portfolio.edit', $item) }}" wire:navigate
                                   class="text-sm font-semibold text-zinc-900 hover:underline dark:text-white">
                                    {{ $item->title }}
                                </a>

                                @if ($item->is_published)
                                    <flux:badge color="green" size="sm" icon="check-circle">{{ __('Published') }}</flux:badge>
                                @else
                                    <flux:badge color="zinc" size="sm">{{ __('Draft') }}</flux:badge>
                                @endif
                            </div>

                            <flux:text size="sm" class="mt-1">
                                {{ $item->layout->label() }} ·
                                {{ trans_choice(':count photo|:count photos', $item->photos->count(), ['count' => $item->photos->count()]) }}
                            </flux:text>

                            @if (filled($item->tags))
                                <flux:text size="sm" class="mt-1 truncate">{{ implode(' · ', $item->tags) }}</flux:text>
                            @endif
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-1">
                            <flux:button size="sm" variant="ghost" icon="chevron-up" square
                                         :disabled="$index === 0"
                                         wire:click="move({{ $item->id }}, 'up')"
                                         :tooltip="__('Move up')" />

                            <flux:button size="sm" variant="ghost" icon="chevron-down" square
                                         :disabled="$index === $this->items->count() - 1"
                                         wire:click="move({{ $item->id }}, 'down')"
                                         :tooltip="__('Move down')" />

                            <flux:button size="sm" variant="ghost"
                                         :icon="$item->is_published ? 'eye-slash' : 'eye'"
                                         square
                                         wire:click="togglePublished({{ $item->id }})"
                                         :tooltip="$item->is_published ? __('Hide from website') : __('Publish')" />

                            <flux:button size="sm" variant="ghost" icon="pencil-square" square
                                         :href="route('admin.portfolio.edit', $item)" wire:navigate
                                         :tooltip="__('Edit')" />

                            <flux:button size="sm" variant="ghost" icon="trash" square
                                         wire:click="delete({{ $item->id }})"
                                         wire:confirm="{{ __('Delete this case and its photos?') }}"
                                         :tooltip="__('Delete')" />
                        </div>
                    </div>
                </flux:card>
            @endforeach
        </div>
    @endif
</div>
