@props(['item'])

@php
    $photos = $item->photos;
    $last = $photos->count() - 1;
@endphp

<div class="reveal rounded-2xl overflow-hidden shadow-xl border border-zinc-100 bg-white mb-8">
    <!-- Header -->
    <div class="px-8 pt-7 pb-4 border-b border-zinc-100">
        <div class="flex flex-wrap items-center gap-3">
            @if (filled($item->badge))
                <span class="inline-block bg-amber-500 text-white text-xs font-bold uppercase tracking-widest px-3 py-1 rounded">{{ $item->badge }}</span>
            @endif
            <h4 class="text-xl font-bold text-blue-950 font-['Playfair_Display']">{{ $item->title }}</h4>
        </div>
        @if (filled($item->summary))
            <p class="text-slate-500 text-sm mt-2">{{ $item->summary }}</p>
        @endif
    </div>

    <!-- Photo strip -->
    <div class="grid grid-cols-2 md:grid-cols-4 h-auto md:h-80">
        @foreach ($photos as $index => $photo)
            @php
                $isLast = $index === $last;
                $badgeTone = match ($index) {
                    0 => 'bg-white text-blue-950',
                    1 => 'bg-blue-800 text-white',
                    2 => 'bg-blue-900 text-white',
                    default => 'bg-amber-500 text-white',
                };
            @endphp

            <div class="relative overflow-hidden border-r border-b md:border-b-0 border-white/30 group">
                <img src="{{ $photo->url() }}" alt="{{ $photo->label ?? __('Step :n', ['n' => $index + 1]) }}"
                     class="w-full h-64 md:h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">

                <div class="absolute inset-0 bg-gradient-to-t {{ $isLast ? 'from-amber-900/80' : 'from-blue-950/85' }} via-blue-950/10 to-transparent"></div>

                <div class="absolute top-3 left-3">
                    <span class="{{ $badgeTone }} text-xs font-extrabold w-8 h-8 rounded-full flex items-center justify-center shadow-md text-base">{{ $index + 1 }}</span>
                </div>

                @if ($isLast && $photos->count() > 1)
                    <div class="absolute top-3 right-3">
                        <span class="bg-amber-500 text-white text-xs font-bold px-2 py-1 rounded shadow">AFTER ✓</span>
                    </div>
                @endif

                <div class="absolute bottom-0 left-0 right-0 p-4">
                    @if (filled($photo->label))
                        <div class="text-white font-bold text-sm">{{ $photo->label }}</div>
                    @endif
                    @if (filled($photo->caption))
                        <div class="{{ $isLast ? 'text-amber-200' : 'text-blue-200' }} text-xs">{{ $photo->caption }}</div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Tags -->
    @if (filled($item->tags))
        <div class="px-8 py-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <x-portfolio.tags :tags="$item->tags" />
            <div class="text-slate-400 text-xs font-medium whitespace-nowrap">📍 Michigan Studio</div>
        </div>
    @endif
</div>
