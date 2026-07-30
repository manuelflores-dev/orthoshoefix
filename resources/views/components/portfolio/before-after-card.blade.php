@props(['item', 'delay' => null])

@php
    $photos = $item->photos;
    $before = $photos->first();
    $after = $photos->skip(1)->first();
@endphp

<div class="reveal {{ $delay }} rounded-2xl overflow-hidden shadow-lg border border-zinc-100 bg-white">
    <div class="flex h-64 md:h-72 w-full">
        <div class="{{ $after ? 'w-1/2 border-r-2 border-white' : 'w-full' }} relative overflow-hidden">
            <img src="{{ $before->url() }}" alt="{{ $before->label ?? __('Before the modification') }}"
                 class="w-full h-full object-cover object-center">
            <span class="absolute top-3 left-3 bg-white/90 text-blue-950 text-xs font-bold px-3 py-1 rounded shadow">
                {{ $before->label ?? 'BEFORE' }}
            </span>
        </div>

        @if ($after)
            <div class="w-1/2 relative overflow-hidden">
                <img src="{{ $after->url() }}" alt="{{ $after->label ?? __('After the modification') }}"
                     class="w-full h-full object-cover object-center">
                <span class="absolute top-3 right-3 bg-blue-950 text-white text-xs font-bold px-3 py-1 rounded shadow">
                    {{ $after->label ?? 'AFTER' }}
                </span>
            </div>
        @endif
    </div>

    <div class="p-6">
        <h4 class="text-xl font-bold text-blue-950 mb-1 font-['Playfair_Display']">{{ $item->title }}</h4>

        @if (filled($item->summary))
            <p class="text-slate-600 text-sm leading-relaxed">{{ $item->summary }}</p>
        @endif

        @if (filled($item->tags))
            <div class="mt-4">
                <x-portfolio.tags :tags="$item->tags" />
            </div>
        @endif
    </div>
</div>
